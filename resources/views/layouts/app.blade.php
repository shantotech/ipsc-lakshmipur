@php
    use App\Support\Locale;
    use App\Support\Navigation;

    $nav = Navigation::main();
    $pageTitle = isset($title) && $title ? $title.' — '.__('site.school.full_name') : __('site.school.full_name').' — '.__('site.school.tagline');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $description ?? __('site.meta.description') }}">
    <meta name="theme-color" content="#125735">
    @if (config('app.noindex'))
        <meta name="robots" content="noindex, nofollow">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $description ?? __('site.meta.description') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="{{ Locale::isBangla() ? 'bn_BD' : 'en_US' }}">

    <link rel="alternate" hreflang="{{ Locale::isBangla() ? 'en' : 'bn' }}" href="{{ Locale::switchUrl() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:shadow">{{ __('Skip to content') }}</a>

    {{-- Announcement (replaces the reference site's instant popup) --}}
    @if (__('site.announcement.text') && ! request()->routeIs('admission.apply'))
        <div x-data="announcement(@js(__('site.announcement.id')))" x-show="open" x-collapse x-cloak class="bg-gold-400 text-brand-950">
            <div class="container-site flex items-center gap-3 py-2 text-sm">
                @include('partials.icon', ['name' => 'megaphone', 'class' => 'size-4 shrink-0'])
                <p class="flex-1 leading-snug">
                    <span class="font-semibold">{{ __('site.announcement.text') }}</span>
                    <a href="{{ route('admission.apply') }}" class="ml-1 font-semibold whitespace-nowrap underline decoration-brand-900/40 underline-offset-4 hover:decoration-brand-900">{{ __('site.announcement.link_label') }} →</a>
                </p>
                <button type="button" x-on:click="close()" class="rounded-full p-1 hover:bg-black/10" aria-label="{{ __('Close') }}">
                    @include('partials.icon', ['name' => 'x', 'class' => 'size-4'])
                </button>
            </div>
        </div>
    @endif

    {{-- Top contact strip --}}
    <div class="hidden bg-brand-900 text-sm text-white/80 md:block">
        <div class="container-site flex h-10 items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', __('site.school.phone')) }}" class="flex items-center gap-2 hover:text-white">
                    @include('partials.icon', ['name' => 'phone', 'class' => 'size-3.5'])
                    <span dir="ltr">{{ __('site.school.phone') }}</span>
                </a>
                <a href="mailto:{{ __('site.school.email') }}" class="flex items-center gap-2 hover:text-white">
                    @include('partials.icon', ['name' => 'mail', 'class' => 'size-3.5'])
                    {{ __('site.school.email') }}
                </a>
                <span class="hidden items-center gap-2 lg:flex">
                    @include('partials.icon', ['name' => 'clock', 'class' => 'size-3.5'])
                    {{ __('site.school.office_hours') }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ __('site.school.facebook') }}" class="hover:text-white" aria-label="Facebook">@include('partials.icon', ['name' => 'facebook', 'class' => 'size-4'])</a>
                <a href="{{ __('site.school.youtube') }}" class="hover:text-white" aria-label="YouTube">@include('partials.icon', ['name' => 'youtube', 'class' => 'size-4'])</a>
            </div>
        </div>
    </div>

    {{-- Main header --}}
    <header x-data="{ mobile: false }" class="sticky top-0 z-50 border-b border-line/70 bg-paper/90 backdrop-blur supports-[backdrop-filter]:bg-paper/80">
        <div class="container-site flex h-[4.5rem] items-center gap-4">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3">
                @include('partials.logo', ['class' => 'size-11'])
                <span class="min-w-0 leading-tight">
                    <span class="hidden font-display text-[1.05rem] font-semibold whitespace-nowrap text-brand-800 sm:block bn:font-sans bn:font-bold">{{ __('site.school.name') }}</span>
                    <span class="block font-display text-[1.05rem] font-semibold whitespace-nowrap text-brand-800 sm:hidden bn:font-sans bn:font-bold">{{ __('site.school.short') }}</span>
                    <span class="block truncate text-xs font-medium tracking-wide text-gold-700">{{ __('site.school.branch') }}<span class="hidden sm:inline"> · {{ __('site.school.tagline') }}</span></span>
                </span>
            </a>

            <nav class="ml-auto hidden items-center gap-0.5 xl:flex" aria-label="{{ __('Main menu') }}">
                @foreach ($nav as $item)
                    @php($active = Navigation::isActive($item))
                    @if (isset($item['children']))
                        <div x-data="{ open: false }" class="relative" x-on:mouseenter="open = true" x-on:mouseleave="open = false" x-on:keydown.escape="open = false">
                            <button type="button" x-on:click="open = !open" x-bind:aria-expanded="open" class="flex items-center gap-1 rounded-full px-2.5 py-2 text-[0.95rem] font-medium whitespace-nowrap transition {{ $active ? 'text-brand-700' : 'text-ink/80 hover:text-brand-700' }}">
                                {{ $item['label'] }}
                                @include('partials.icon', ['name' => 'chevron-down', 'class' => 'size-3.5 opacity-60'])
                            </button>
                            <div x-show="open" x-transition.opacity.duration.150ms x-cloak class="absolute top-full left-0 z-50 pt-2">
                                <div class="w-64 rounded-2xl border border-line bg-white p-2 shadow-xl shadow-brand-950/5">
                                    @foreach ($item['children'] as $child)
                                        <a href="{{ Navigation::url($child) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-[0.95rem] text-ink/80 transition hover:bg-brand-50 hover:text-brand-800">
                                            <span class="grid size-8 place-items-center rounded-lg bg-brand-50 text-brand-600">@include('partials.icon', ['name' => $child['icon'], 'class' => 'size-4'])</span>
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ Navigation::url($item) }}" @if($active) aria-current="page" @endif class="relative rounded-full px-2.5 py-2 text-[0.95rem] font-medium whitespace-nowrap transition {{ $active ? 'text-brand-700' : 'text-ink/80 hover:text-brand-700' }}">
                            {{ $item['label'] }}
                            @if ($active)<span class="absolute inset-x-2.5 -bottom-0.5 h-0.5 rounded-full bg-gold-500"></span>@endif
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="ml-auto flex items-center gap-2 xl:ml-2">
                <a href="{{ Locale::switchUrl() }}" hreflang="{{ Locale::isBangla() ? 'en' : 'bn' }}" class="flex items-center gap-1.5 rounded-full border border-line bg-white px-3 py-1.5 text-sm font-semibold text-brand-700 transition hover:border-brand-300" title="{{ Locale::isBangla() ? 'Switch to English' : 'বাংলায় দেখুন' }}">
                    @include('partials.icon', ['name' => 'globe', 'class' => 'size-4'])
                    {{ Locale::isBangla() ? 'EN' : 'বাংলা' }}
                </a>
                <a href="{{ route('admission.apply') }}" class="btn-primary hidden !py-2 sm:inline-flex">{{ __('Apply') }}</a>
                <button type="button" x-on:click="mobile = true" class="rounded-full p-2 text-brand-800 hover:bg-brand-50 xl:hidden" aria-label="{{ __('Open menu') }}">
                    @include('partials.icon', ['name' => 'menu', 'class' => 'size-6'])
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobile" x-cloak class="fixed inset-0 z-50 xl:hidden" role="dialog" aria-modal="true">
            <div x-show="mobile" x-transition.opacity x-on:click="mobile = false" class="absolute inset-0 bg-brand-950/50"></div>
            <div x-show="mobile" x-transition:enter="transition duration-200" x-transition:enter-start="translate-x-full" x-transition:leave="transition duration-150" x-transition:leave-end="translate-x-full"
                 class="absolute inset-y-0 right-0 flex w-full max-w-sm flex-col bg-paper shadow-2xl" x-on:keydown.escape.window="mobile = false">
                <div class="flex h-[4.5rem] items-center justify-between border-b border-line px-5">
                    <span class="flex items-center gap-2 font-semibold text-brand-800">@include('partials.logo', ['class' => 'size-9']) {{ __('site.school.short') }}</span>
                    <button type="button" x-on:click="mobile = false" class="rounded-full p-2 hover:bg-brand-50" aria-label="{{ __('Close menu') }}">
                        @include('partials.icon', ['name' => 'x', 'class' => 'size-6'])
                    </button>
                </div>
                <nav class="flex-1 overflow-y-auto px-3 py-4" aria-label="{{ __('Mobile menu') }}">
                    @foreach ($nav as $item)
                        @if (isset($item['children']))
                            <div x-data="{ open: {{ Navigation::isActive($item) ? 'true' : 'false' }} }" class="border-b border-line/60">
                                <button type="button" x-on:click="open = !open" x-bind:aria-expanded="open" class="flex w-full items-center justify-between px-3 py-3 text-left font-medium">
                                    {{ $item['label'] }}
                                    <span x-bind:class="open && 'rotate-180'" class="transition">@include('partials.icon', ['name' => 'chevron-down', 'class' => 'size-4'])</span>
                                </button>
                                <div x-show="open" x-collapse>
                                    <div class="pb-2">
                                        @foreach ($item['children'] as $child)
                                            <a href="{{ Navigation::url($child) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-ink/80 hover:bg-brand-50">
                                                @include('partials.icon', ['name' => $child['icon'], 'class' => 'size-4 text-brand-600'])
                                                {{ $child['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ Navigation::url($item) }}" class="block border-b border-line/60 px-3 py-3 font-medium {{ Navigation::isActive($item) ? 'text-brand-700' : '' }}">{{ $item['label'] }}</a>
                        @endif
                    @endforeach
                </nav>
                <div class="space-y-3 border-t border-line p-5">
                    <a href="{{ route('admission.apply') }}" class="btn-primary w-full">{{ __('Apply for Admission') }}</a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', __('site.school.phone')) }}" class="btn-outline w-full">@include('partials.icon', ['name' => 'phone', 'class' => 'size-4']) <span dir="ltr">{{ __('site.school.phone') }}</span></a>
                </div>
            </div>
        </div>
    </header>

    <main id="main" class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-pattern mt-auto bg-brand-950 text-white/75">
        <div class="container-site grid gap-10 py-16 md:grid-cols-2 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @include('partials.logo', ['class' => 'size-12'])
                    <span class="leading-tight">
                        <span class="block font-semibold text-white">{{ __('site.school.name') }}</span>
                        <span class="block text-sm text-gold-300">{{ __('site.school.branch') }}</span>
                    </span>
                </a>
                <p class="mt-5 max-w-sm leading-7">{{ __('site.school.tagline') }}<br>{{ __('site.school.version') }}</p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ __('site.school.facebook') }}" class="grid size-10 place-items-center rounded-full bg-white/10 transition hover:bg-gold-400 hover:text-brand-950" aria-label="Facebook">@include('partials.icon', ['name' => 'facebook', 'class' => 'size-4'])</a>
                    <a href="{{ __('site.school.youtube') }}" class="grid size-10 place-items-center rounded-full bg-white/10 transition hover:bg-gold-400 hover:text-brand-950" aria-label="YouTube">@include('partials.icon', ['name' => 'youtube', 'class' => 'size-4'])</a>
                </div>
            </div>

            <div class="lg:col-span-2">
                <h2 class="font-sans text-sm font-semibold tracking-wide text-white uppercase bn:normal-case">{{ __('Quick Links') }}</h2>
                <ul class="mt-4 space-y-2.5">
                    <li><a href="{{ route('about') }}" class="hover:text-gold-300">{{ __('About Us') }}</a></li>
                    <li><a href="{{ route('academic') }}" class="hover:text-gold-300">{{ __('Academic') }}</a></li>
                    <li><a href="{{ route('facilities') }}" class="hover:text-gold-300">{{ __('Facilities') }}</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-gold-300">{{ __('Gallery') }}</a></li>
                    <li><a href="{{ route('careers') }}" class="hover:text-gold-300">{{ __('Careers') }}</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h2 class="font-sans text-sm font-semibold tracking-wide text-white uppercase bn:normal-case">{{ __('Parents') }}</h2>
                <ul class="mt-4 space-y-2.5">
                    <li><a href="{{ route('admission') }}" class="hover:text-gold-300">{{ __('Admission') }}</a></li>
                    <li><a href="{{ route('notices') }}" class="hover:text-gold-300">{{ __('Notices') }}</a></li>
                    <li><a href="{{ route('calendar') }}" class="hover:text-gold-300">{{ __('Academic Calendar') }}</a></li>
                    <li><a href="{{ route('school-hours') }}" class="hover:text-gold-300">{{ __('School Hours') }}</a></li>
                    <li><a href="{{ route('rules') }}" class="hover:text-gold-300">{{ __('Rules & Regulations') }}</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h2 class="font-sans text-sm font-semibold tracking-wide text-white uppercase bn:normal-case">{{ __('Contact') }}</h2>
                <ul class="mt-4 space-y-3.5">
                    <li class="flex gap-3">@include('partials.icon', ['name' => 'map-pin', 'class' => 'mt-1 size-4 shrink-0 text-gold-300']) {{ __('site.school.address') }}</li>
                    <li class="flex gap-3">@include('partials.icon', ['name' => 'phone', 'class' => 'mt-1 size-4 shrink-0 text-gold-300']) <a href="tel:{{ preg_replace('/[^0-9+]/', '', __('site.school.phone')) }}" class="hover:text-gold-300" dir="ltr">{{ __('site.school.phone') }}</a></li>
                    <li class="flex gap-3">@include('partials.icon', ['name' => 'mail', 'class' => 'mt-1 size-4 shrink-0 text-gold-300']) <a href="mailto:{{ __('site.school.email') }}" class="break-all hover:text-gold-300">{{ __('site.school.email') }}</a></li>
                    <li class="flex gap-3">@include('partials.icon', ['name' => 'clock', 'class' => 'mt-1 size-4 shrink-0 text-gold-300']) {{ __('site.school.office_hours') }}</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="container-site flex flex-col gap-2 py-5 text-sm text-white/55 sm:flex-row sm:items-center sm:justify-between">
                <p>© {{ Locale::number(date('Y')) }} {{ __('site.school.full_name') }}. {{ __('All rights reserved.') }}</p>
                <p>{{ __('A branch of the International Peace School & College network') }}</p>
            </div>
        </div>
    </footer>
</body>
</html>
