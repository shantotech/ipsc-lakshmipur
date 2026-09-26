@extends('layouts.app', ['title' => __('site.calendar.title')])

@php
    use App\Support\Locale;
@endphp

@section('content')
    @include('partials.page-header', ['title' => __('site.calendar.title'), 'intro' => __('site.calendar.intro'), 'crumbs' => [['label' => __('Academic'), 'url' => route('academic')]]])

    <section class="container-site grid gap-12 py-16 sm:py-20 lg:grid-cols-12">
        <div class="lg:col-span-7">
            <h2 class="text-2xl font-semibold">{{ __('Upcoming Events') }}</h2>
            <ol class="relative mt-8 space-y-6 border-l-2 border-brand-100 pl-8">
                @foreach ($events as $event)
                    <li class="relative">
                        <span class="absolute top-1.5 -left-[2.55rem] size-4 rounded-full border-4 border-paper bg-brand-600 ring-2 ring-brand-200"></span>
                        <p class="text-sm font-semibold text-gold-700">{{ Locale::date($event['date'], 'EEEE, d MMMM y') }}</p>
                        <h3 class="mt-1 text-xl font-semibold">{{ Locale::pick($event['title']) }}</h3>
                        <p class="mt-1 flex flex-wrap gap-x-4 text-muted">
                            <span class="flex items-center gap-1.5">@include('partials.icon', ['name' => 'clock', 'class' => 'size-4']) {{ Locale::pick($event['time']) }}</span>
                            <span class="flex items-center gap-1.5">@include('partials.icon', ['name' => 'map-pin', 'class' => 'size-4']) {{ Locale::pick($event['place']) }}</span>
                        </p>
                    </li>
                @endforeach
            </ol>
        </div>
        <aside class="lg:col-span-5">
            <div class="card p-7">
                <h2 class="flex items-center gap-3 text-2xl font-semibold">@include('partials.icon', ['name' => 'calendar', 'class' => 'size-6 text-brand-600']) {{ __('site.calendar.holidays_title') }}</h2>
                <ul class="mt-6 divide-y divide-line">
                    @foreach (__('site.calendar.holidays') as $holiday)
                        <li class="flex items-center justify-between gap-4 py-3">
                            <span class="font-medium">{{ $holiday['name'] }}</span>
                            <span class="text-right text-sm text-muted">{{ $holiday['date'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </section>
@endsection
