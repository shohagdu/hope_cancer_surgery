@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-1.5 rounded-md border-b-2 border-indigo-500 text-sm font-semibold leading-5 text-indigo-700 bg-indigo-50 focus:outline-none transition duration-150 ease-in-out'
    : 'inline-flex items-center px-3 py-1.5 rounded-md border-b-2 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-300 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
