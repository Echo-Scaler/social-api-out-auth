@props(['type' => 'success', 'message' => null])

@php
    $variants = [
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-100',
        'error' => 'bg-red-50 text-red-800 border-red-100',
        'info' => 'bg-blue-50 text-blue-800 border-blue-100',
    ];

    $icons = [
        'success' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'error' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'info' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    ];
@endphp

<div {{ $attributes->merge(['class' => "flex p-4 border rounded-xl " . ($variants[(string) $type] ?? $variants['success'])]) }}>
    <div class="flex-shrink-0">
        {!! $icons[(string) $type] ?? $icons['success'] !!}
    </div>
    <div class="ml-3 font-medium">
        {{ $message ?? $slot }}
    </div>
</div>
