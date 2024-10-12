<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section x-data="userEditForm()">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Edit a User') }}
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
                        <form @submit.prevent="submitForm" class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf

                            <!-- Select User -->
                            <div>
                                <x-input-label for="user" :value="__('Name')" />
                                <x-dropdown-options id="user" name="user_id" :options="$fullnames" :selected="old('user', null)"
                                    x-model="selectedUserId" @change="fetchUser"
                                    placeholder="{{ __('Select a User') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                            </div>

                            <!-- Prefix Name -->
                            <div>
                                <x-input-label for="prefix_name" :value="__('Prefix Name (Optional)')" />
                                <x-dropdown-options id="prefix_name" name="prefix_name" :options="['Mr.' => 'Mr.', 'Mrs.' => 'Mrs.', 'Ms.' => 'Ms.']"
                                    x-model="userData.prefixname" placeholder="{{ __('Select Prefix') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('prefix_name')" />
                            </div>

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" name="first_name" x-model="userData.firstname"
                                    type="text" class="mt-1 block w-full" autofocus autocomplete="first_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <!-- Middle Name -->
                            <div>
                                <x-input-label for="middle_name" :value="__('Middle Name (Optional)')" />
                                <x-text-input id="middle_name" name="middle_name" x-model="userData.middlename"
                                    type="text" class="mt-1 block w-full" autofocus autocomplete="middle_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" name="last_name" x-model="userData.lastname" type="text"
                                    class="mt-1 block w-full" autofocus autocomplete="last_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>

                            <!-- Suffix Name -->
                            <div>
                                <x-input-label for="suffix_name" :value="__('Suffix Name (Optional)')" />
                                <x-text-input id="suffix_name" name="suffix_name" x-model="userData.suffixname"
                                    type="text" class="mt-1 block w-full" autofocus autocomplete="suffix_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('suffix_name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" name="email" x-model="userData.email" type="email"
                                    class="mt-1 block w-full" autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- User Name -->
                            <div>
                                <x-input-label for="user_name" :value="__('User Name')" />
                                <x-text-input id="user_name" name="user_name" x-model="userData.username" type="text"
                                    class="mt-1 block w-full" autofocus autocomplete="user_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('user_name')" />
                            </div>

                            <!-- Profile Picture Section -->
                            <div class="flex items-start space-x-4">
                                <!-- Current Profile Picture -->
                                <div class="mr-4">
                                    <template x-if="userData.photoUrl">
                                        <img :src="userData.photoUrl" alt="Current Profile Picture"
                                            class="h-16 w-16 rounded-full object-cover">
                                    </template>
                                    <template x-if="!userData.photoUrl">
                                        <img src="{{ asset('storage/default-avatar.png') }}" alt="Default Avatar"
                                            class="h-16 w-16 rounded-full object-cover">
                                    </template>
                                </div>
                                <!-- Image Uploader -->
                                <div>
                                    <x-input-label for="profile_pic" :value="__('Select New Profile Picture')" />
                                    <input type="file" name="profile_pic" @change="handleFileUpload"
                                        x-ref="profilePicUploader"
                                        class="mt-1 block w-full text-gray-900 dark:text-gray-100">
                                    <x-input-error class="mt-2" :messages="$errors->get('profile_pic')" />
                                </div>
                            </div>

                            <!-- Access Type Dropdown -->
                            <div>
                                <x-input-label for="access_type" :value="__('Access Type')" />
                                <x-dropdown-options id="access_type" name="access_type" :options="['admin' => 'Admin', 'user' => 'User']"
                                    x-model="userData.type" placeholder="{{ __('Select Access Type') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('access_type')" />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Update') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                    <script>
                        function userEditForm() {
                            return {
                                selectedUserId: '',
                                userData: {
                                    id: '',
                                    prefixname: '',
                                    firstname: '',
                                    middlename: '',
                                    lastname: '',
                                    suffixname: '',
                                    email: '',
                                    username: '',
                                    type: 'user',
                                    profilePic: null,
                                    photoUrl: ''
                                },
                                errors: {},
                                successMessage: '',
                                errorMessage: '',
                                async fetchUser() {
                                    if (this.selectedUserId) {
                                        try {
                                            const response = await fetch(`/fetch-user-info?id=${this.selectedUserId}`);
                                            const data = await response.json();

                                            let photoUrl = '';
                                            if (data.photo) {
                                                if (data.photo.startsWith('http')) {

                                                    photoUrl = data.photo;
                                                } else {

                                                    photoUrl = `/storage/${data.photo}`;
                                                }
                                            } else {

                                                photoUrl = '{{ asset('storage/default-avatar.png') }}';
                                            }
                                            this.userData = {
                                                id: this.selectedUserId,
                                                prefixname: data.prefixname || '',
                                                firstname: data.firstname || '',
                                                middlename: data.middlename || '',
                                                lastname: data.lastname || '',
                                                suffixname: data.suffixname || '',
                                                email: data.email || '',
                                                username: data.username || '',
                                                type: data.type || 'user',
                                                photoUrl: photoUrl
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
                                        prefixname: '',
                                        firstname: '',
                                        middlename: '',
                                        lastname: '',
                                        suffixname: '',
                                        email: '',
                                        username: '',
                                        type: 'user',
                                        profilePic: null,
                                        photoUrl: '{{ asset('storage/default-avatar.png') }}'

                                    };
                                },
                                handleFileUpload(event) {
                                    this.userData.profilePic = event.target.files[0];
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.userData.photoUrl = e.target.result;
                                    };
                                    reader.readAsDataURL(this.userData.profilePic);
                                },
                                async submitForm() {
                                    this.errors = {};
                                    if (!this.selectedUserId) {
                                        this.errorMessage = "Please select a user.";
                                        return;
                                    }
                                    const formData = new FormData();
                                    formData.append('_method', 'PATCH');
                                    formData.append('prefixname', this.userData.prefixname);
                                    formData.append('firstname', this.userData.firstname);
                                    formData.append('middlename', this.userData.middlename);
                                    formData.append('lastname', this.userData.lastname);
                                    formData.append('suffixname', this.userData.suffixname);
                                    formData.append('email', this.userData.email);
                                    formData.append('username', this.userData.username);
                                    formData.append('type', this.userData.type);
                                    if (this.userData.profilePic) {
                                        formData.append('profile_pic', this.userData.profilePic);
                                    }
                                    const url = `{{ route('users.manage-users.update', ['manage_user' => '__ID__']) }}`.replace(
                                        '__ID__', this
                                        .selectedUserId);

                                    try {
                                        const response = await axios.post(url, formData, {
                                            headers: {
                                                'Content-Type': 'multipart/form-data',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                    'content')
                                            }
                                        });

                                        if (response.status === 200) {
                                            this.successMessage = 'User updated successfully!';
                                            this.resetUserData();
                                            location.reload();
                                        }
                                    } catch (error) {
                                        if (error.response && error.response.status === 422) {
                                            this.errors = error.response.data.errors || {};
                                        } else {
                                            console.error('Error updating user:', error);
                                            this.errorMessage = 'An error occurred. Please try again.';
                                        }
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
