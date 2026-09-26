@extends('layouts.app', ['title' => __('site.careers.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.careers.title'), 'intro' => __('site.careers.intro')])

    <section class="container-site grid gap-12 py-16 sm:py-20 lg:grid-cols-12">
        <div class="lg:col-span-7">
            <h2 class="section-title">{{ __('Open positions') }}</h2>
            <div class="card mt-8 divide-y divide-line p-2">
                @forelse ($notices as $notice)
                    @include('partials.notice-item', ['notice' => $notice])
                @empty
                    <p class="p-10 text-center text-muted">{{ __('There are no open positions right now. Please check back later.') }}</p>
                @endforelse
            </div>
        </div>
        <aside class="space-y-5 lg:col-span-5">
            <div class="card p-7">
                <h2 class="text-2xl font-semibold">{{ __('site.careers.why_title') }}</h2>
                <ul class="mt-5 space-y-3">
                    @foreach (__('site.careers.why') as $point)
                        <li class="flex gap-3">@include('partials.icon', ['name' => 'check-circle', 'class' => 'mt-0.5 size-5 shrink-0 text-brand-600']) {{ $point }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-3xl bg-brand-800 p-7 text-white">
                <span class="grid size-12 place-items-center rounded-2xl bg-gold-400 text-brand-950">@include('partials.icon', ['name' => 'briefcase', 'class' => 'size-6'])</span>
                <h2 class="mt-5 text-xl font-semibold text-white">{{ __('How to apply') }}</h2>
                <p class="mt-2 text-white/80">{{ __('site.careers.apply_text') }}</p>
                <a href="mailto:{{ __('site.school.email') }}" class="mt-5 inline-flex items-center gap-2 font-semibold break-all text-gold-300 hover:text-gold-200">@include('partials.icon', ['name' => 'mail', 'class' => 'size-4 shrink-0']) {{ __('site.school.email') }}</a>
            </div>
        </aside>
    </section>
@endsection
