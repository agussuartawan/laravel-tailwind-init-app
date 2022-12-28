<a {{ $attributes->merge(['class' => 'button px-1 text-xs rounded-full bg-red-600 hover:bg-red-700
    focus:bg-red-700 active:bg-red-900 text-white uppercase']) }}>
    {{ $slot }}
</a>