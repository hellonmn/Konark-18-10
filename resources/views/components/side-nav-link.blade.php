@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center p-2 rounded-lg text-white bg-gray-700 group'
            : 'flex items-center p-2 text-gray-400 rounded-lg hover:text-white hover:bg-gray-100 hover:bg-gray-700 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
