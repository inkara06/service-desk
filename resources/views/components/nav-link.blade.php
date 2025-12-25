@props(['active'])

@php
$classes = 'inline-flex items-center px-3 py-2 text-sm font-medium leading-5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}
   style="
     color: {{ ($active ?? false) ? '#345DAB' : '#3f4a5d' }};
     border-bottom: 2px solid {{ ($active ?? false) ? '#00ffff' : 'transparent' }};
   "
   onmouseover="this.style.color='#345DAB'"
   onmouseout="this.style.color='{{ ($active ?? false) ? '#345DAB' : '#3f4a5d' }}'">
    {{ $slot }}
</a>