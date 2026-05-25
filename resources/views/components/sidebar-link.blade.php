@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-4 py-3 text-sm font-bold bg-saemape-gold text-blue-900 rounded-xl shadow-lg transform scale-105 transition-all duration-300'
            : 'flex items-center gap-3 px-4 py-3 text-sm font-medium text-blue-100 hover:bg-white/10 hover:text-saemape-gold rounded-xl transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="{{ $icon }} w-5"></i>
    <span>{{ $slot }}</span>
</a>