<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $editingUserId = null;
    public $editingName = '';
    public $editingEmail = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->editingUserId = $user->id;
        $this->editingName = $user->name;
        $this->editingEmail = $user->email;
    }

    public function cancelEdit()
    {
        $this->reset(['editingUserId', 'editingName', 'editingEmail']);
    }

    public function save()
    {
        $this->validate([
            'editingName' => 'required|min:3',
            'editingEmail' => 'required|email|unique:users,email,' . $this->editingUserId,
        ]);

        $user = User::findOrFail($this->editingUserId);
        $user->update([
            'name' => $this->editingName,
            'email' => $this->editingEmail,
        ]);

        $this->cancelEdit();

        session()->flash('message', 'User updated successfully.');
    }

    public function render()
    {
        $query = User::query();

        // Search logic
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%');
            });
        }

        // Filter logic
        if ($this->roleFilter) {
            $query->where('position', 'like', '%' . $this->roleFilter . '%');
        }

        return view('livewire.user-table', [
            'users' => $query->paginate(10),
        ]);
    }
}
