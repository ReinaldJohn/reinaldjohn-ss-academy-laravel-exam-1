<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trashed Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <h2 class="text-lg font-semibold mb-4">Trashed Users</h2>
                        @if ($users->count() != 0)
                            <div x-data="userActions">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="text-center text-xs font-medium uppercase tracking-wider">
                                            <th scope="col" class="px-6 py-3">Profile Picture</th>
                                            <th scope="col" class="px-6 py-3">Prefix Name</th>
                                            <th scope="col" class="px-6 py-3">Firstname</th>
                                            <th scope="col" class="px-6 py-3">Middlename</th>
                                            <th scope="col" class="px-6 py-3">Lastname</th>
                                            <th scope="col" class="px-6 py-3">Suffixname</th>
                                            <th scope="col" class="px-6 py-3">Username</th>
                                            <th scope="col" class="px-6 py-3">Email Address</th>
                                            <th scope="col" class="px-6 py-3">Created At</th>
                                            <th scope="col" class="px-6 py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($users as $user)
                                            <tr class="hover:bg-gray-500">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <img src="{{ $user->photo ? (filter_var($user->photo, FILTER_VALIDATE_URL) ? $user->photo : asset('storage/' . $user->photo)) : asset('path/to/default/image.jpg') }}"
                                                        alt="Profile Picture" width="50" height="50" />
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    {{ $user->prefixname }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->firstname }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->middlename }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->lastname }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->suffixname }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->username }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    {{ $user->created_at->format('F, j Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <div class="flex align-middle gap-2">
                                                        <!-- Restore Button with Alpine.js trigger -->
                                                        <button @click="restoreUser({{ $user->id }})"
                                                            class="text-sky-500 cursor-pointer">
                                                            <i class="fa-solid fa-trash-can-arrow-up"></i> Restore
                                                        </button>

                                                        <!-- Delete Button with Alpine.js trigger -->
                                                        <button @click="confirmDelete({{ $user->id }})"
                                                            class="text-red-500 cursor-pointer">
                                                            <i class="fa-solid fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No trashed users found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('userActions', () => ({
                async restoreUser(userId) {
                    try {
                        const url =
                            `{{ route('users.users.restore', ['user' => '__ID__']) }}`
                            .replace(
                                '__ID__', userId);

                        const response = await axios.patch(url, {}, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            }
                        });

                        if (response.status === 200) {
                            alert('User restored successfully.');
                            location.reload(); // Refresh the page after successful restore
                        } else {
                            throw new Error('Failed to restore the user.');
                        }
                    } catch (error) {
                        alert(error.response?.data?.message || error.message);
                    }
                },

                async confirmDelete(userId) {
                    if (confirm('Are you sure you want to permanently delete this user?')) {
                        try {
                            // Use Axios to send a DELETE request for permanently deleting the user

                            const url =
                                `{{ route('users.users.force-delete', ['user' => '__ID__']) }}`
                                .replace(
                                    '__ID__', userId);

                            const response = await axios.delete(url, {
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                }
                            });

                            if (response.status === 200) {
                                alert('User permanently deleted.');
                                location.reload(); // Refresh the page after successful delete
                            } else {
                                throw new Error('Failed to delete the user.');
                            }
                        } catch (error) {
                            alert(error.response?.data?.message || error.message);
                        }
                    }
                },
            }));
        });
    </script>
</x-app-layout>
