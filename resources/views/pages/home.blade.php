@extends('layouts.app')

@php
    use App\Support\Locale;
    $heroImage = collect(['images/hero.jpg', 'images/hero.webp', 'images/hero.png'])->first(fn ($p) => file_exists(public_path($p)));
@endphp

@section('content')

    {{-- Hero: clean headline on a calm background (the reference site put text over a busy banner) --}}
    <section class="bg-pattern-light relative overflow-hidden">
        <div class="pointer-events-none absolute top-0 right-0 h-full w-1/2 bg-gradient-to-l from-brand-50 to-transparent"></div>
        <div class="container-site relative grid items-center gap-12 py-14 sm:py-20 lg:grid-cols-2 lg:py-24">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-white px-3.5 py-1.5 text-sm font-semibold text-brand-700 shadow-sm ring-1 ring-brand-100">
                    <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-gold-400 opacity-75"></span><span class="relative inline-flex size-2 rounded-full bg-gold-500"></span></span>
                    {{ __('site.hero.eyebrow') }}
                </span>
                <h1 class="mt-6 text-[2.6rem] leading-[1.1] font-semibold text-brand-900 sm:text-6xl bn:text-[2.4rem] bn:leading-[1.3] sm:bn:text-5xl">
                    {{ __('site.hero.title') }}
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-muted">{{ __('site.hero.text') }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('admission.apply') }}" class="btn-primary !px-6 !py-3">{{ __('site.hero.primary') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
                    <a href="{{ route('about') }}" class="btn-outline !px-6 !py-3">{{ __('site.hero.secondary') }}</a>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-md lg:max-w-none">
                {{-- Arch-shaped frame: shows public/images/hero.jpg once uploaded --}}
                <div class="relative mx-auto aspect-[4/5] w-full max-w-[26rem] overflow-hidden rounded-t-[12rem] rounded-b-[2rem] bg-brand-800 shadow-2xl shadow-brand-900/20 ring-8 ring-white">
                    @if ($heroImage)
                        <img src="{{ asset($heroImage) }}" alt="{{ __('site.school.full_name') }}" class="size-full object-cover">
                    @else
                        <div class="bg-pattern absolute inset-0"></div>
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-brand-800/20 to-brand-950/60"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-5 p-10 text-center">
                            @include('partials.logo', ['class' => 'size-28 drop-shadow-xl'])
                            <p class="text-xl font-semibold text-white">{{ __('site.school.name') }}</p>
                            <p class="-mt-3 text-gold-300">{{ __('site.school.branch') }}</p>
                        </div>
                    @endif
                </div>

                {{-- Floating chips --}}
                <div class="absolute top-10 -left-2 rounded-2xl bg-white px-4 py-3 shadow-xl shadow-brand-900/10 ring-1 ring-line sm:-left-6">
                    <p class="text-xs font-medium text-muted">{{ __('We teach in') }}</p>
                    <div class="mt-1.5 flex gap-1.5 text-sm font-semibold">
                        <span class="rounded-md bg-brand-50 px-2 py-0.5 text-brand-700">English</span>
                        <span class="rounded-md bg-gold-50 px-2 py-0.5 text-gold-700" lang="ar" dir="rtl">العربية</span>
                        <span class="rounded-md bg-red-50 px-2 py-0.5 text-accent-red" lang="bn">বাংলা</span>
                    </div>
                </div>
                <div class="absolute -right-2 bottom-12 flex items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-xl shadow-brand-900/10 ring-1 ring-line sm:-right-4">
                    <span class="grid size-10 place-items-center rounded-full bg-gold-400 text-brand-950">@include('partials.icon', ['name' => 'graduation-cap', 'class' => 'size-5'])</span>
                    <div>
                        <p class="text-sm font-semibold text-ink">{{ __('Admission open') }}</p>
                        <p class="text-xs text-muted">{{ __('Academic year') }} {{ Locale::number(2027) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="container-site relative pb-14">
            <dl class="grid gap-px overflow-hidden rounded-2xl bg-line ring-1 ring-line sm:grid-cols-3">
                @foreach (__('site.hero.stats') as $stat)
                    <div class="bg-white px-6 py-5">
                        <dt class="text-sm text-muted">{{ $stat['label'] }}</dt>
                        <dd class="mt-1 font-display text-3xl font-semibold text-brand-700 bn:font-bangla bn:font-bold">{{ $stat['value'] }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </section>

    {{-- Why IPSC --}}
    <section class="container-site py-16 sm:py-24">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow justify-center">{{ __('Why choose us') }}</span>
            <h2 class="section-title">{{ __('site.school.tagline') }}</h2>
        </div>
        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (__('site.features') as $i => $feature)
                @php($tones = ['bg-brand-600', 'bg-gold-500', 'bg-accent-blue', 'bg-accent-red'])
                <div class="card group p-6 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-900/5">
                    <span class="grid size-12 place-items-center rounded-2xl {{ $tones[$i % 4] }} text-white shadow-sm">
                        @include('partials.icon', ['name' => $feature['icon'], 'class' => 'size-6'])
                    </span>
                    <h3 class="mt-5 text-xl font-semibold">{{ $feature['title'] }}</h3>
                    <p class="mt-2 leading-7 text-muted">{{ $feature['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- About, mission, vision --}}
    <section class="bg-white py-16 sm:py-24">
        <div class="container-site grid gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-6">
                <span class="eyebrow">{{ __('About Us') }}</span>
                <h2 class="section-title">{{ __('site.school.full_name') }}</h2>
                <p class="mt-6 border-l-4 border-gold-400 pl-5 text-lg leading-8 font-medium text-ink/90">{{ __('site.about.lead') }}</p>
                <p class="mt-5 leading-8 text-muted">{{ __('site.about.body')[0] }}</p>
                <a href="{{ route('about') }}" class="btn-outline mt-8">{{ __('Read more') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
            </div>
            <div class="grid gap-5 lg:col-span-6">
                <div class="rounded-3xl bg-brand-50 p-7 ring-1 ring-brand-100 sm:p-8">
                    <div class="flex items-center gap-3">
                        <span class="grid size-11 place-items-center rounded-xl bg-brand-600 text-white">@include('partials.icon', ['name' => 'star'])</span>
                        <h3 class="text-2xl font-semibold">{{ __('site.about.mission_title') }}</h3>
                    </div>
                    <p class="mt-4 text-lg leading-8 text-ink/80">{{ __('site.about.mission') }}</p>
                </div>
                <div class="rounded-3xl bg-gold-50 p-7 ring-1 ring-gold-100 sm:p-8">
                    <div class="flex items-center gap-3">
                        <span class="grid size-11 place-items-center rounded-xl bg-gold-500 text-brand-950">@include('partials.icon', ['name' => 'globe'])</span>
                        <h3 class="text-2xl font-semibold">{{ __('site.about.vision_title') }}</h3>
                    </div>
                    <p class="mt-4 text-lg leading-8 text-ink/80">{{ __('site.about.vision') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Notices + upcoming events --}}
    <section class="container-site py-16 sm:py-24">
        <div class="grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <span class="eyebrow">{{ __('Stay updated') }}</span>
                        <h2 class="section-title">{{ __('Latest Notices') }}</h2>
                    </div>
                    <a href="{{ route('notices') }}" class="hidden shrink-0 items-center gap-1 font-semibold text-brand-700 hover:text-brand-900 sm:flex">{{ __('View all') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
                </div>
                <div class="card mt-8 divide-y divide-line p-2">
                    @forelse ($notices as $notice)
                        @include('partials.notice-item', ['notice' => $notice])
                    @empty
                        <p class="p-8 text-center text-muted">{{ __('No notices have been published yet.') }}</p>
                    @endforelse
                </div>
                <a href="{{ route('notices') }}" class="btn-outline mt-5 w-full sm:hidden">{{ __('View all notices') }}</a>
            </div>

            <div class="lg:col-span-5">
                <span class="eyebrow">{{ __('Mark your calendar') }}</span>
                <h2 class="section-title">{{ __('Upcoming Events') }}</h2>
                <ol class="mt-8 space-y-4">
                    @foreach ($events as $event)
                        <li class="card flex items-center gap-4 p-4">
                            <div class="flex w-16 shrink-0 flex-col items-center rounded-xl bg-brand-700 py-2.5 text-white">
                                <span class="text-2xl leading-none font-bold">{{ Locale::date($event['date'], 'dd') }}</span>
                                <span class="mt-1 text-xs text-white/80">{{ Locale::date($event['date'], 'MMM') }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-ink">{{ Locale::pick($event['title']) }}</p>
                                <p class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-muted">
                                    <span class="flex items-center gap-1">@include('partials.icon', ['name' => 'clock', 'class' => 'size-3.5']) {{ Locale::pick($event['time']) }}</span>
                                    <span class="flex items-center gap-1">@include('partials.icon', ['name' => 'map-pin', 'class' => 'size-3.5']) {{ Locale::pick($event['place']) }}</span>
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ol>
                <a href="{{ route('calendar') }}" class="mt-5 inline-flex items-center gap-1 font-semibold text-brand-700 hover:text-brand-900">{{ __('Academic Calendar') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
            </div>
        </div>
    </section>

    {{-- Quick links --}}
    <section class="container-site">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['route' => 'calendar', 'icon' => 'calendar', 'label' => __('Academic Calendar'), 'text' => __('Terms, exams and holidays')],
                ['route' => 'school-hours', 'icon' => 'clock', 'label' => __('School Hours'), 'text' => __('Class and office timings')],
                ['route' => 'gallery', 'icon' => 'image', 'label' => __('Gallery'), 'text' => __('Moments from campus life')],
                ['route' => 'admission', 'icon' => 'file-text', 'label' => __('Admission Information'), 'text' => __('Ages, documents and steps')],
            ] as $link)
                <a href="{{ route($link['route']) }}" class="group flex items-center gap-4 rounded-2xl bg-brand-900 p-5 text-white transition hover:bg-brand-800">
                    <span class="grid size-12 shrink-0 place-items-center rounded-xl bg-white/10 text-gold-300 transition group-hover:bg-gold-400 group-hover:text-brand-950">@include('partials.icon', ['name' => $link['icon'], 'class' => 'size-6'])</span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-semibold">{{ $link['label'] }}</span>
                        <span class="block text-sm text-white/65">{{ $link['text'] }}</span>
                    </span>
                    @include('partials.icon', ['name' => 'arrow-up-right', 'class' => 'size-5 text-white/40 transition group-hover:text-gold-300'])
                </a>
            @endforeach
        </div>
    </section>

    {{-- Facilities preview --}}
    <section class="container-site py-16 sm:py-24">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <span class="eyebrow">{{ __('Our campus') }}</span>
                <h2 class="section-title">{{ __('site.facilities.title') }}</h2>
                <p class="mt-3 text-lg text-muted">{{ __('site.facilities.intro') }}</p>
            </div>
            <a href="{{ route('facilities') }}" class="btn-outline shrink-0">{{ __('All facilities') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
        </div>
        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (array_slice(__('site.facilities.items'), 0, 4) as $item)
                <div class="rounded-2xl border border-line bg-white p-6">
                    <span class="text-brand-600">@include('partials.icon', ['name' => $item['icon'], 'class' => 'size-8', 'stroke' => 1.5])</span>
                    <h3 class="mt-4 text-lg font-semibold">{{ $item['title'] }}</h3>
                    <p class="mt-1.5 text-[0.95rem] leading-7 text-muted">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Principal's message teaser --}}
    <section class="bg-white py-16 sm:py-24">
        <div class="container-site grid items-center gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <div class="relative mx-auto aspect-square max-w-xs overflow-hidden rounded-[2rem] bg-brand-100">
                    <div class="bg-pattern-light absolute inset-0"></div>
                    <div class="absolute inset-0 grid place-items-center text-brand-300">@include('partials.icon', ['name' => 'user', 'class' => 'size-28', 'stroke' => 1])</div>
                </div>
            </div>
            <div class="lg:col-span-8">
                @include('partials.icon', ['name' => 'quote', 'class' => 'size-10 text-gold-400'])
                <h2 class="mt-4 text-3xl font-semibold">{{ __('site.messages.principal.title') }}</h2>
                <p class="mt-5 text-xl leading-9 text-ink/80 bn:text-lg bn:leading-9">{{ __('site.messages.principal.body')[0] }}</p>
                <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="font-semibold text-ink">{{ __('site.messages.principal.name') }}</p>
                        <p class="text-sm text-muted">{{ __('site.messages.principal.role') }}</p>
                    </div>
                    <a href="{{ route('message', ['person' => 'principal']) }}" class="inline-flex items-center gap-1 font-semibold text-brand-700 hover:text-brand-900">{{ __('Read full message') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.cta')

@endsection
