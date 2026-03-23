@props(['label' => null, 'name', 'type' => 'text', 'value' => null, 'placeholder' => ''])

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-900 shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none sm:text-sm placeholder-gray-400']) }}
        >
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
    @enderror
</div>
