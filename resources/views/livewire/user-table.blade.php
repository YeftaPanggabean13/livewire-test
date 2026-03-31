<div>
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">User </h1>
            <p class="mt-1 text-sm text-gray-500">Manage users</p>
        </div>
        <div class="flex items-center gap-3">
            
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-100 shadow-sm animate-[fadeIn_0.5s_ease-in-out]">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Container -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">

        <!-- Toolbar (Search & Filters) -->
        <div class="border-b border-gray-100 p-4 sm:flex sm:items-center sm:justify-between gap-4 bg-white">
            <div class="relative max-w-md w-full">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <!-- Connected to Livewire. EXACT SAME wire:model property as provided. -->
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="block w-full rounded-lg border-0 py-2.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition shadow-sm"
                    placeholder="Search users by name, email, or role...">
            </div>

            <div class="mt-4 sm:mt-0 flex items-center gap-3">
                <!-- Visual Role Filter -->
                <select wire:model.live="roleFilter"
                    class="block w-full sm:w-48 rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm transition shadow-sm bg-white cursor-pointer hover:bg-gray-50 focus:outline-none">
                    <option value="">All Roles</option>
                    <option value="manager">Manager</option>
                    <option value="developer">Developer</option>
                    <option value="designer">Designer</option>
                    <option value="qa">QA</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col"
                            class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            User</th>
                        <th scope="col"
                            class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Role</th>
                        <th scope="col"
                            class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Email</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($users as $user)
                        @php
                            // Derive user initials setup
                            $nameParts = explode(' ', trim($user->name));
                            $initials = collect($nameParts)->filter()->map(fn($s) => mb_strtoupper(mb_substr($s, 0, 1)))->take(2)->join('');

                            // Badges & Tag Styles Layout Setup
                            $role = strtolower($user->position ?? '');
                            $badgeClasses = match (true) {
                                str_contains($role, 'manager') => 'bg-purple-50 text-purple-700 ring-purple-600/20',
                                str_contains($role, 'developer') => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                str_contains($role, 'designer') => 'bg-pink-50 text-pink-700 ring-pink-600/20',
                                str_contains($role, 'qa') => 'bg-orange-50 text-orange-700 ring-orange-600/20',
                                default => 'bg-gray-50 text-gray-600 ring-gray-500/20',
                            };

                            // Dynamic Avatar Background Color
                            $avatarColors = match (true) {
                                $user->id % 5 == 0 => 'bg-purple-100 text-purple-700',
                                $user->id % 5 == 1 => 'bg-blue-100 text-blue-700',
                                $user->id % 5 == 2 => 'bg-emerald-100 text-emerald-700',
                                $user->id % 5 == 3 => 'bg-orange-100 text-orange-700',
                                default => 'bg-pink-100 text-pink-700',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200 group">
                            <!-- User Hierarchy Column -->
                            <td class="whitespace-nowrap py-4 pl-6 pr-3">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 rounded-full {{ $avatarColors }} flex items-center justify-center text-sm font-semibold ring-1 ring-inset ring-black/5 shadow-sm">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                                            {{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <!-- Role Column -->
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClasses }}">
                                    {{ $user->position ?: 'Staff' }}
                                </span>
                            </td>
                            <!-- Email Column -->
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
                            <!-- Actions Column -->
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="edit({{ $user->id }})"
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 opacity-0 group-hover:opacity-100 focus:opacity-100"
                                        title="Edit user">
                                        <span class="sr-only">Edit {{ $user->name }}</span>
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <button type="button"
                                        class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-md transition-all opacity-0 group-hover:opacity-100 focus:opacity-100 focus:outline-none"
                                        title="More options">
                                        <span class="sr-only">Options for {{ $user->name }}</span>
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 px-6 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-50 rounded-full p-4 mb-4 ring-1 ring-gray-100 shadow-sm">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-semibold text-gray-900">No users found</h3>
                                    <p class="mt-1 text-sm text-gray-500 max-w-sm">Get started by creating a new user or try
                                        adjusting your search filters to find what you're looking for.</p>
                                    <button type="button"
                                        class="mt-6 inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                        Add New User
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Area -->
        @if($users->hasPages())
            <div class="border-t border-gray-100 px-6 py-4 bg-gray-50/50">
                <style>
                    /* Polishing Tailwind default pagination to fit the sleek theme */
                    nav[role="navigation"] p.text-sm {
                        color: #6b7280;
                        font-weight: 500;
                    }
                </style>
                <div class="pagination-wrapper">
                    {{ $users->links() }}
                </div>
            </div>
        @else
            <!-- Display User Count Summary if pagination is not split -->
            @if($users->count() > 0)
                <div class="border-t border-gray-100 px-6 py-4 bg-gray-50/50 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-medium text-gray-900">{{ $users->count() }}</span> users
                    </p>
                </div>
            @endif
        @endif
    </div>

    {{-- Modal Edit (Premium Style) --}}
    @if($editingUserId)
        <div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" wire:click="cancelEdit"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal Panel -->
                    <div
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">
                        <!-- Header -->
                        <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between bg-white">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Edit User Details
                            </h3>
                            <button type="button" wire:click="cancelEdit"
                                class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-full p-1 transition-colors focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Body -->
                        <form wire:submit="save" id="edit-user-form">
                            <div class="px-6 py-5 bg-white space-y-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full
                                        Name</label>
                                    <div class="mt-2">
                                        <input type="text" wire:model="editingName" id="name"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition">
                                    </div>
                                    @error('editingName') <p
                                        class="mt-2 text-sm text-red-500 font-medium flex items-center gap-1.5"><svg
                                            class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                    </svg>{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                        Address</label>
                                    <div class="mt-2">
                                        <input type="email" wire:model="editingEmail" id="email"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition">
                                    </div>
                                    @error('editingEmail') <p
                                        class="mt-2 text-sm text-red-500 font-medium flex items-center gap-1.5"><svg
                                            class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                    </svg>{{ $message }}</p> @enderror
                                </div>

                                <div class="rounded-lg bg-blue-50/80 p-4 mt-4 border border-blue-100">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h1.25v2.5H9a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-.25v-2.5A.75.75 0 0011 9H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1 md:flex md:justify-between">
                                            <p class="text-xs text-blue-700 font-medium">Please review these details closely
                                                before saving, as email changes require verification.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Footer -->
                        <div
                            class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-100 rounded-b-2xl">
                            <button type="button" wire:click="cancelEdit"
                                class="inline-flex justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" form="edit-user-form"
                                class="inline-flex justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>