@extends('layouts.app', ['title' => __('Page not found')])

@section('content')
    <section class="bg-pattern-light">
        <div class="container-site flex min-h-[60vh] flex-col items-center justify-center py-20 text-center">
            <p class="font-display text-8xl font-semibold text-brand-200">{{ \App\Support\Locale::number(404) }}</p>
            <h1 class="mt-4 text-3xl font-semibold sm:text-4xl">{{ __('Page not found') }}</h1>
            <p class="mt-3 max-w-md text-lg text-muted">{{ __('The page you are looking for may have moved or no longer exists.') }}</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="btn-primary">@include('partials.icon', ['name' => 'home', 'class' => 'size-4']) {{ __('Go to homepage') }}</a>
                <a href="{{ route('contact') }}" class="btn-outline">{{ __('Contact us') }}</a>
            </div>
        </div>
    </section>
@endsection
