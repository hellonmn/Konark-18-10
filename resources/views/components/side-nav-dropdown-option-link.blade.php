@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 hover:bg-gray-700 group text-white'
            : 'flex items-center w-full p-2 text-gray-400 transition duration-75 rounded-lg pl-11 group hover:bg-gray-700 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
