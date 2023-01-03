@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} type="checkbox" {!! $attributes->merge(['class' => 'w-4 h-4
text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500']) !!}>