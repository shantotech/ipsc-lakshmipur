@php($message = __("site.messages.$person"))
@extends('layouts.app', ['title' => $message['title']])

@section('content')
    @include('partials.page-header', ['title' => $message['title'], 'crumbs' => [['label' => __('About Us'), 'url' => route('about')]]])

    <section class="container-site grid gap-12 py-16 sm:py-20 lg:grid-cols-12">
        <aside class="lg:col-span-4">
            <div class="lg:sticky lg:top-28">
                <div class="relative mx-auto aspect-[4/5] max-w-xs overflow-hidden rounded-[2rem] bg-brand-100 ring-8 ring-white">
                    <div class="bg-pattern-light absolute inset-0"></div>
                    <div class="absolute inset-0 grid place-items-center text-brand-300">@include('partials.icon', ['name' => 'user', 'class' => 'size-28', 'stroke' => 1])</div>
                </div>
                <div class="mt-5 text-center">
                    <p class="text-xl font-semibold">{{ $message['name'] }}</p>
                    <p class="text-muted">{{ $message['role'] }}</p>
                </div>
            </div>
        </aside>
        <article class="lg:col-span-8">
            @include('partials.icon', ['name' => 'quote', 'class' => 'size-12 text-gold-400'])
            <div class="prose-site mt-6 text-lg leading-9">
                @foreach ($message['body'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
            <div class="mt-10 border-t border-line pt-6">
                <p class="font-semibold">{{ $message['name'] }}</p>
                <p class="text-muted">{{ $message['role'] }}</p>
            </div>
            @php($other = $person === 'chairman' ? 'principal' : 'chairman')
            <a href="{{ route('message', ['person' => $other]) }}" class="btn-outline mt-10">{{ __("site.messages.$other.title") }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
        </article>
    </section>
@endsection
