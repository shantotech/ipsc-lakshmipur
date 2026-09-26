{{-- School emblem. Swap for the official logo by adding public/images/logo.svg (or .png). --}}
@php
    $official = collect(['images/logo.svg', 'images/logo.png'])->first(fn ($p) => file_exists(public_path($p)));
@endphp
@if ($official)
    <img src="{{ asset($official) }}" alt="{{ __('site.school.full_name') }}" class="{{ $class ?? 'size-11' }} object-contain">
@else
    <svg viewBox="0 0 48 48" class="{{ $class ?? 'size-11' }}" role="img" aria-label="{{ __('site.school.full_name') }}">
        <circle cx="24" cy="24" r="23" fill="#125735"/>
        <circle cx="24" cy="24" r="19" fill="none" stroke="#edbb3f" stroke-width="1.5" stroke-dasharray="20 4"/>
        <path d="M24 10l3.4 8 8 3.4-8 3.4-3.4 8-3.4-8-8-3.4 8-3.4z" fill="#edbb3f"/>
        <rect x="17.5" y="15" width="13" height="13" transform="rotate(45 24 21.4)" fill="none" stroke="#ffffff" stroke-opacity=".55" stroke-width="1"/>
        <text x="24" y="40.5" text-anchor="middle" font-family="Georgia, serif" font-size="6.5" font-weight="700" fill="#ffffff" letter-spacing=".6">IPSC</text>
    </svg>
@endif
