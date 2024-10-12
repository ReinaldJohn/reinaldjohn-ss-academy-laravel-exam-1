<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Create a User') }}
                            </h2>
                        </header>

                        @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
                        @endif

                        @if (session('error'))
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
                        @endif

                        <form method="post" action="{{ route('users.manage-users.store') }}"
                            enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            <!-- Prefix Name -->
                            <div>
                                <x-input-label for="prefix-name" :value="__('Prefix Name (Optional)')" />
                                <x-dropdown-options id="prefix-name" name="prefix-name" :options="['Mr.' => 'Mr.', 'Mrs.' => 'Mrs.', 'Ms.' => 'Ms.']"
                                    class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('prefix-name')" />
                            </div>

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first-name" :value="__('First Name')" />
                                <x-text-input id="first-name" name="first-name" type="text" class="mt-1 block w-full"
                                    required autofocus autocomplete="first-name" />
                                <x-input-error class="mt-2" :messages="$errors->get('first-name')" />
                            </div>

                            <!-- Middle Name -->
                            <div>
                                <x-input-label for="middle-name" :value="__('Middle Name (Optional)')" />
                                <x-text-input id="middle-name" name="middle-name" type="text"
                                    class="mt-1 block w-full" autofocus autocomplete="middle-name" />
                                <x-input-error class="mt-2" :messages="$errors->get('middle-name')" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last-name" :value="__('Last Name')" />
                                <x-text-input id="last-name" name="last-name" type="text" class="mt-1 block w-full"
                                    required autofocus autocomplete="last-name" />
                                <x-input-error class="mt-2" :messages="$errors->get('last-name')" />
                            </div>

                            <!-- Suffix Name -->
                            <div>
                                <x-input-label for="suffix-name" :value="__('Suffix Name (Optional)')" />
                                <x-text-input id="suffix-name" name="suffix-name" type="text"
                                    class="mt-1 block w-full" autofocus autocomplete="suffix-name" />
                                <x-input-error class="mt-2" :messages="$errors->get('suffix-name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- User Name -->
                            <div>
                                <x-input-label for="user-name" :value="__('User Name')" />
                                <x-text-input id="user-name" name="user-name" type="text" class="mt-1 block w-full"
                                    autofocus autocomplete="user-name" />
                                <x-input-error class="mt-2" :messages="$errors->get('user-name')" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                    autofocus autocomplete="password" maxlength="50" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                    class="mt-1 block w-full" required autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>

                            <!-- Photo -->
                            <div>
                                <x-input-label for="profile-pic" :value="__('Profile Picture')" />
                                <x-image-uploader name="profile-pic" :preview="null" />
                                <x-input-error class="mt-2" :messages="$errors->get('profile-pic')" />
                            </div>

                            <!-- Access Type -->
                            <div>
                                <x-input-label for="access-type" :value="__('Access Type')" />
                                <x-dropdown-options id="access-type" name="access-type" :options="['admin' => 'Admin', 'user' => 'User']"
                                    :selected="old('role', 'user')" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('access-type')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
