@props(['name'])

<svg {{ $attributes->merge(['class' => 'h-6 w-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    @switch($name)
        @case('academic-cap')
            <path d="M12 3 22 8 12 13 2 8Z" />
            <path d="M7 9.8V14c0 1.5 2.2 2.7 5 2.7s5-1.2 5-2.7V9.8" />
            <path d="M19 9v4.6" />
            <circle cx="19" cy="14.7" r="0.9" />
            <path d="M12 3V1.2" stroke-width="1.1" />
            <circle cx="12" cy="0.7" r="0.5" stroke-width="1.1" />
            <path d="M9.3 6.4 12 7.7l2.7-1.3" stroke-width="0.9" opacity="0.6" />
            @break

        @case('book-open')
            <path d="M12 6.5c-2-1.6-5-2-8-1.2V17c3-.8 6-.4 8 1.2 2-1.6 5-2 8-1.2V5.3c-3-.8-6-.4-8 1.2Z" />
            <path d="M12 6.5V18.2" />
            <path d="M5.5 8.3h4M5.5 10.6h4M5.5 12.9h3.3" stroke-width="0.9" opacity="0.7" />
            <path d="M14.5 8.3h4M14.5 10.6h4M15.2 12.9h3.3" stroke-width="0.9" opacity="0.7" />
            @break

        @case('briefcase')
            <rect x="3" y="8.5" width="18" height="11" rx="1.6" />
            <path d="M8.6 8.5V6.8c0-1 .8-1.8 1.8-1.8h3.2c1 0 1.8.8 1.8 1.8v1.7" />
            <path d="M3 13.2h18" stroke-width="0.9" opacity="0.6" />
            <rect x="10.4" y="12.1" width="3.2" height="2.6" rx="0.5" stroke-width="1.1" />
            <path d="M6 16.3h2.4M15.6 16.3h2.4" stroke-width="0.9" opacity="0.5" />
            @break

        @case('heart')
            <path d="M12 19.5S3.5 13.8 3.5 8.2C3.5 5 6 2.9 8.8 3.9c1.7.6 2.9 2.1 3.2 3 .3-.9 1.5-2.4 3.2-3 2.8-1 5.3 1.1 5.3 4.3 0 5.6-8.5 11.3-8.5 11.3Z" />
            <path d="M6.6 8.9c.8.9 2.1.9 2.9 0" stroke-width="0.9" opacity="0.6" />
            <path d="M15 6.6l1-.9M16.1 8.6l1.2-.4M15.5 10.2l1.3.1" stroke-width="0.9" opacity="0.6" />
            @break

        @case('moon-star')
            <path d="M14.9 4.3a6.8 6.8 0 1 0 4.8 11.9A8.2 8.2 0 0 1 14.9 4.3Z" />
            <path d="M18.5 3.4l.5 1.3 1.3.5-1.3.5-.5 1.3-.5-1.3-1.3-.5 1.3-.5Z" stroke-width="1" />
            <path d="M20.2 9.6l.3.8.8.3-.8.3-.3.8-.3-.8-.8-.3.8-.3Z" stroke-width="0.9" opacity="0.75" />
            @break

        @case('quote')
            <path d="M7 11c-1.7 0-3-1.3-3-3s1.3-3 3-3c1.5 0 2.6 1 2.9 2.4C10.4 10.4 8.7 14 5 15.5" />
            <path d="M17 11c-1.7 0-3-1.3-3-3s1.3-3 3-3c1.5 0 2.6 1 2.9 2.4c.5 3-1.2 6.6-4.9 8.1" />
            @break

        @case('arrow-right')
            <path d="M5 12h14" />
            <path d="M13 6l6 6-6 6" />
            @break

        @case('handshake')
            <path d="M2 12l4-4h3l3 3" />
            <path d="M22 12l-4-4h-3l-5 5c-.8.8-.8 2 0 2.8c.8.8 2 .8 2.8 0" />
            <path d="M9 14l1.5 1.5c.8.8 2 .8 2.8 0" />
            <path d="M6 8l6 6" />
            @break

        @case('map-pin')
            <path d="M12 21s7-6.7 7-11.7A7 7 0 0 0 5 9.3C5 14.3 12 21 12 21Z" />
            <circle cx="12" cy="9.3" r="2.4" />
            @break

        @case('chat')
            <path d="M21 11.5c0 4.14-4.03 7.5-9 7.5-1.06 0-2.08-.15-3.02-.43L3 20l1.13-3.4A7.36 7.36 0 0 1 3 11.5C3 7.36 7.03 4 12 4s9 3.36 9 7.5Z" />
            @break

        @case('globe')
            <circle cx="12" cy="12" r="9" />
            <path d="M3 12h18" />
            <path d="M12 3c2.5 2.5 4 6 4 9s-1.5 6.5-4 9c-2.5-2.5-4-6-4-9s1.5-6.5 4-9Z" />
            @break
    @endswitch
</svg>
