<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Delete User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">

                    <section x-data="userDeleteForm()">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Delete a User') }}
                            </h2>
                        </header>

                        <!-- Success and Error Messages -->
                        <div x-show="successMessage" x-transition x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)"
                            class="text-sm text-green-600 dark:text-green-400" x-cloak>
                            <p x-text="successMessage"></p>
                        </div>

                        <div x-show="errorMessage" x-transition x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)"
                            class="text-sm text-red-600 dark:text-red-400" x-cloak>
                            <p x-text="errorMessage"></p>
                        </div>

                        <!-- Form submission through Alpine.js -->
                        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
                            @csrf

                            <!-- Select User -->
                            <div>
                                <x-input-label for="user" :value="__('Name')" />
                                <x-dropdown-options id="user" name="user_id" :options="$fullnames" :selected="old('user', null)"
                                    x-model="selectedUserId" @change="fetchUser"
                                    placeholder="{{ __('Select a User') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <x-danger-button>{{ __('Delete') }}</x-danger-button>
                            </div>
                        </form>
                    </section>
                    <script>
                        function userDeleteForm() {
                            return {
                                selectedUserId: '',
                                errors: {},
                                successMessage: '',
                                errorMessage: '',
                                async fetchUser() {
                                    if (this.selectedUserId) {
                                        try {
                                            const response = await fetch(`/fetch-user-info?id=${this.selectedUserId}`);
                                            const data = await response.json();
                                            this.userData = {
                                                id: this.selectedUserId,

                                            };
                                        } catch (error) {
                                            console.error('Error fetching user data:', error);
                                        }
                                    } else {
                                        this.resetUserData();
                                    }
                                },
                                resetUserData() {
                                    this.userData = {
                                        id: '',
                                    };
                                },
                                async submitForm() {
                                    this.errors = {};
                                    if (!this.selectedUserId) {
                                        this.errorMessage = "Please select a user.";
                                        return;
                                    }

                                    const url = `{{ route('users.manage-users.destroy', ['manage_user' => '__ID__']) }}`.replace(
                                        '__ID__', this.selectedUserId);

                                    try {
                                        const response = await fetch(url, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                    'content'),
                                                'Accept': 'application/json',
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({
                                                user_id: this.selectedUserId
                                            })
                                        });

                                        if (!response.ok) {
                                            const data = await response.json();
                                            this.errorMessage = data.message || 'An error occurred while deleting the user.';
                                        } else {
                                            this.successMessage = 'User deleted successfully!';
                                            this.resetUserData();
                                            location.reload();
                                        }
                                    } catch (error) {
                                        console.error('Error deleting user:', error);
                                        this.errorMessage = 'An error occurred. Please try again.';
                                    }
                                }
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
