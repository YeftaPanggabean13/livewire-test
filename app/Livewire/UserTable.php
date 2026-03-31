<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $editingUserId = null;
    public $editingName = '';
    public $editingEmail = '';

    public function updatingSearch()
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
        return view('livewire.user-table', [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->paginate(10),
        ]);
    }
}
