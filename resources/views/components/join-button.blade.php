@props(['href'])

<a {{ $attributes->merge(['href' => $href, 'class' => ' border-2 rounded-lg bg-button-bg p-3 font-medium text-white hover:bg-transparent hover:border-button-bg hover:text-button-bg hover:border-2']) }}>
    {{ $slot }}
</a>
