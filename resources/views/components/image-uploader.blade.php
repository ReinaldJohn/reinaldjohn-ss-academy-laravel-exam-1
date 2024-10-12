@props(['disabled' => false, 'preview' => null])

<div x-data="{
    photoName: null,
    photoPreview: @json($preview),
    init() {
        if (!this.photoPreview) {
            this.photoPreview = '{{ asset('storage/default-avatar.png') }}';
        } else {
            if (!this.photoPreview.startsWith('http') && !this.photoPreview.startsWith('https')) {
                this.photoPreview = '{{ asset('storage') }}' + '/' + this.photoPreview;
            }
        }
    }
}" class="mt-1 flex items-center">

    <!-- Hidden file input field -->
    <input type="file" {{ $attributes->merge(['class' => 'hidden']) }} x-ref="photo"
        @change="
            photoName = $refs.photo.files[0].name;
            const reader = new FileReader();
            reader.onload = (e) => {
                photoPreview = e.target.result; // Update preview to the newly selected image
            };
            reader.readAsDataURL($refs.photo.files[0]);
        ">

    <!-- Image Preview -->
    <div class="mr-4">
        <template x-if="photoPreview">
            <img :src="photoPreview" alt="Profile Picture Preview" class="h-16 w-16 rounded-full object-cover">
        </template>
    </div>

    <!-- Select Photo Button -->
    <button type="button"
        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        @click.prevent="$refs.photo.click()">
        {{ __('Select Photo') }}
    </button>
</div>
