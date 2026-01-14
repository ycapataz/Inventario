@props([
    'label',
    'field',
    'sortBy',
    'sortDirection'
])

<button class="flex items-center space-x-1 cursor-pointer">
    <span>
        {{ $label }}
    </span>

    @if ($sortBy !== $field)
        {{-- sin ordenar --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 24 24" fill="none" 
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-up-icon lucide-arrow-down-up">
            <path d="m3 16 4 4 4-4"/>
            <path d="M7 20V4"/>
            <path d="m21 8-4-4-4 4"/>
            <path d="M17 4v16"/>
        </svg>

    @elseif ($sortDirection === 'DESC')
        {{-- descendente --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m3 16 4 4 4-4"/>
            <path d="M7 20V4"/>
            <path d="M20 8h-5"/>
            <path d="M15 10V6.5a2.5 2.5 0 0 1 5 0V10"/>
            <path d="M15 14h5l-5 6h5"/>
        </svg>
    @else
        {{-- ascendente --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m3 16 4 4 4-4"/>
            <path d="M7 4v16"/>
            <path d="M15 4h5l-5 6h5"/>
            <path d="M15 20v-3.5a2.5 2.5 0 0 1 5 0V20"/>
            <path d="M20 18h-5"/>
        </svg>
    @endif
</button>
