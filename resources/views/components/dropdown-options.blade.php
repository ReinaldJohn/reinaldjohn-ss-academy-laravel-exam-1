@props(['options' => [], 'selected' => null, 'disabled' => false, 'placeholder' => ''])

<select @disabled($disabled)
    {{ $attributes->merge(['class' => 'block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
    <!-- Placeholder option -->
    @if ($placeholder)
        <option value="" disabled @if (is_null($selected)) selected @endif>{{ $placeholder }}</option>
    @endif

    <!-- Loop through options -->
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" @if ($value == $selected) selected @endif>{{ $label }}
        </option>
    @endforeach
</select>
