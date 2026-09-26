@php
    use App\Support\Locale;
    $noticeTitle = Locale::pick($notice['title']);
@endphp
@extends('layouts.app', ['title' => $noticeTitle, 'description' => Locale::pick($notice['excerpt'])])

@section('content')
    @include('partials.page-header', ['title' => $noticeTitle, 'crumbs' => [['label' => __('Notices'), 'url' => route('notices')]]])

    <section class="container-site grid gap-12 py-16 sm:py-20 lg:grid-cols-12">
        <article class="lg:col-span-8">
            <div class="flex flex-wrap items-center gap-4 text-muted">
                <span class="flex items-center gap-2">@include('partials.icon', ['name' => 'calendar', 'class' => 'size-4 text-brand-600']) {{ Locale::date($notice['date'], 'd MMMM y') }}</span>
                @if ($notice['pinned'])
                    <span class="inline-flex items-center gap-1 rounded-full bg-gold-100 px-2.5 py-0.5 text-sm font-semibold text-gold-700">@include('partials.icon', ['name' => 'pin', 'class' => 'size-3.5']) {{ __('Pinned') }}</span>
                @endif
            </div>
            <div class="card prose-site mt-6 p-6 sm:p-10">
                {!! Locale::pick($notice['body']) !!}
            </div>
            @if ($notice['attachment'])
                <a href="{{ $notice['attachment'] }}" class="btn-primary mt-6">@include('partials.icon', ['name' => 'download', 'class' => 'size-4']) {{ __('Download attachment (PDF)') }}</a>
            @endif
            <a href="{{ route('notices') }}" class="btn-outline mt-6">@include('partials.icon', ['name' => 'chevron-left', 'class' => 'size-4']) {{ __('All notices') }}</a>
        </article>

        <aside class="lg:col-span-4">
            <h2 class="text-xl font-semibold">{{ __('Other notices') }}</h2>
            <div class="card mt-4 divide-y divide-line p-1.5">
                @foreach ($others as $other)
                    <a href="{{ route('notices.show', ['slug' => $other['slug']]) }}" class="block rounded-xl p-4 transition hover:bg-brand-50">
                        <p class="text-sm text-gold-700">{{ Locale::date($other['date']) }}</p>
                        <p class="mt-1 font-semibold leading-snug">{{ Locale::pick($other['title']) }}</p>
                    </a>
                @endforeach
            </div>
        </aside>
    </section>
@endsection
