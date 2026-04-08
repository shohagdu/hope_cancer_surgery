@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center w-full ps-4 pe-4 py-3 border-l-4 border-indigo-500 text-base font-semibold text-indigo-700 bg-indigo-50 focus:outline-none transition duration-150 ease-in-out'
    : 'flex items-center w-full ps-4 pe-4 py-3 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-indigo-700 hover:bg-indigo-50 hover:border-indigo-400 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
