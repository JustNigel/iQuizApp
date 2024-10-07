@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-white border-gray-300 focus:border-indigo-500 bg-purple-900 bg-opacity-20 focus:ring-purple-900 rounded-md shadow-sm']) !!}>