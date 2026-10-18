@props(['name'])
<svg {{ $attributes->merge(['class' => 'ico']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('bowl')
            <path d="M3 12h18a8 8 0 0 1-8 8h-2a8 8 0 0 1-8-8z"/><path d="M8 8c0-2 2-2 2-4"/><path d="M13 8c0-2 2-2 2-4"/>
            @break
        @case('arrow-right')
            <path d="M5 12h14"/><path d="M13 6l6 6-6 6"/>
            @break
        @case('arrow-left')
            <path d="M19 12H5"/><path d="M11 6l-6 6 6 6"/>
            @break
        @case('arrow-up-right')
            <path d="M7 17L17 7"/><path d="M8 7h9v9"/>
            @break
        @case('user')
            <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
            @break
        @case('eye')
            <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>
            @break
        @case('eye-off')
            <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path d="M3 3l18 18"/>
            @break
        @case('map-pin')
            <path d="M12 22s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/>
            @break
        @case('receipt')
            <path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6"/><path d="M9 12h6"/>
            @break
        @case('shield')
            <path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M9 12l2 2 4-4"/>
            @break
        @case('clock')
            <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
            @break
        @case('flame')
            <path d="M12 3c1 4 5 5 5 10a5 5 0 0 1-10 0c0-2 1-3 2-4 0 2 1 3 2 3 0-3-1-5 1-9z"/>
            @break
        @case('bag')
            <path d="M5 8h14l-1 12H6z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>
            @break
        @case('bike')
            <circle cx="6" cy="17" r="3.5"/><circle cx="18" cy="17" r="3.5"/><path d="M6 17l4-8h5l3 8"/><path d="M9 9H7"/>
            @break
        @case('plus')
            <path d="M12 5v14"/><path d="M5 12h14"/>
            @break
        @case('check')
            <path d="M5 12l5 5 9-10"/>
            @break
        @case('layers')
            <path d="M12 3l9 5-9 5-9-5z"/><path d="M3 13l9 5 9-5"/>
            @break
        @case('cup')
            <path d="M5 4h14l-1.5 16h-11z"/><path d="M6 9h12"/>
            @break
    @endswitch
</svg>
