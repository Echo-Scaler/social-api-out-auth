@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-gray-100 overflow-hidden']) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-50">
            {{ $footer }}
        </div>
    @endif
</div>
