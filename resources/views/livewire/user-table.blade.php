<div>
    <div class="p-6">
        <div class="mb-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Daftar User</h1>
            <input 
                wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="Cari berdasarkan nama..." 
                class="px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 uppercase text-sm font-semibold text-gray-700">
                    <tr>
                        <th class="p-4 border-b">Nama</th>
                        <th class="p-4 border-b">Email</th>
                        <th class="p-4 border-b">Jabatan</th>
                        <th class="p-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 border-b">{{ $user->name }}</td>
                            <td class="p-4 border-b">{{ $user->email }}</td>
                            <td class="p-4 border-b">{{ $user->position }}</td>
                            <td class="p-4 border-b">
                                <button 
                                    wire:click="edit({{ $user->id }})" 
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                >
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500 italic">Tidak ada user ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Modal Edit --}}
    @if($editingUserId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Edit User</h2>
                <form wire:submit="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input 
                            wire:model="editingName" 
                            type="text" 
                            class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500"
                        >
                        @error('editingName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input 
                            wire:model="editingEmail" 
                            type="email" 
                            class="w-full px-3 py-2 border rounded focus:ring-2 focus:ring-blue-500"
                        >
                        @error('editingEmail') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-3 font-medium">
                        <button 
                            type="button" 
                            wire:click="cancelEdit" 
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
