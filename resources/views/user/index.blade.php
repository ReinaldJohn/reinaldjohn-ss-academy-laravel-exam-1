<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Single User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <h2 class="text-lg font-semibold mb-4">User</h2>
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
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class=" hover:bg-gray-500">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <img src="{{ $user->photo ? (filter_var($user->photo, FILTER_VALIDATE_URL) ? $user->photo : asset('storage/' . $user->photo)) : asset('path/to/default/image.jpg') }}"
                                            alt="Profile Picture" width="50" height="50" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{ $user->prefixname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->firstname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->middlename }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->lastname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->suffixname }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $user->created_at->format('F, j Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
