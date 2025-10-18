@props(['active', 'name'])

@php
$classes = ($active ?? false)
            ? 'flex items-center cursor-pointer p-2 rounded-lg text-white bg-gray-700 group'
            : 'flex items-center cursor-pointer p-2 text-gray-400 rounded-lg hover:text-white hover:bg-gray-100 hover:bg-gray-700 group';
@endphp

<a aria-controls="dropdown-{{ $name }}" data-collapse-toggle="dropdown-{{ $name }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
