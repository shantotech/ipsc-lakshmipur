@extends('layouts.app', ['title' => __('site.administration.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.administration.title'), 'intro' => __('site.administration.intro')])

    <div class="container-site space-y-16 py-16 sm:py-20">
        @foreach (__('site.administration.groups') as $group)
            <section>
                <h2 class="section-title">{{ $group['name'] }}</h2>
                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($group['people'] as $person)
                        <div class="card overflow-hidden text-center">
                            <div class="bg-pattern-light relative grid aspect-square place-items-center bg-brand-50 text-brand-200">
                                @include('partials.icon', ['name' => 'user', 'class' => 'size-24', 'stroke' => 1])
                            </div>
                            <div class="p-5">
                                <p class="text-lg font-semibold">{{ $person['name'] }}</p>
                                <p class="text-gold-700">{{ $person['role'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <a href="{{ route('rules') }}" class="card flex items-center gap-5 p-6 transition hover:shadow-xl hover:shadow-brand-900/5">
            <span class="grid size-14 shrink-0 place-items-center rounded-2xl bg-gold-400 text-brand-950">@include('partials.icon', ['name' => 'scroll', 'class' => 'size-7'])</span>
            <span class="flex-1">
                <span class="block text-xl font-semibold">{{ __('site.rules.title') }}</span>
                <span class="block text-muted">{{ __('Rules for students and parents') }}</span>
            </span>
            @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-5 text-brand-600'])
        </a>
    </div>
@endsection
