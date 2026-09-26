@extends('layouts.app', ['title' => __('Gallery')])

@php
    $photos = $albums->flatMap(fn ($album) => $album->photos->map(fn ($photo) => [
        'src' => $photo->url(),
        'caption' => $photo->caption() ?: $album->title(),
        'album' => $album->slug,
    ]))->values();
@endphp

@section('content')
    @include('partials.page-header', ['title' => __('Gallery'), 'intro' => __('Moments from campus life.')])

    <section class="container-site py-16 sm:py-20">
        @if ($photos->isEmpty())
            <div class="card flex flex-col items-center gap-3 p-14 text-center text-muted">
                @include('partials.icon', ['name' => 'image', 'class' => 'size-12 text-brand-200'])
                <p class="text-lg">{{ __('Photos will be added soon.') }}</p>
            </div>
        @else
            <div x-data="gallery(@js($photos))">
                @if ($albums->count() > 1)
                    <div class="flex flex-wrap gap-2">
                        @foreach (['all' => __('All')] + $albums->mapWithKeys(fn ($a) => [$a->slug => $a->title()])->all() as $key => $label)
                            <button type="button" x-on:click="album = '{{ $key }}'" x-bind:aria-pressed="album === '{{ $key }}'"
                                    x-bind:class="album === '{{ $key }}' ? 'bg-brand-700 text-white' : 'bg-white text-ink/75 ring-1 ring-line hover:ring-brand-300'"
                                    class="rounded-full px-4 py-2 text-sm font-semibold transition">{{ $label }}</button>
                        @endforeach
                    </div>
                @endif

                <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4">
                    <template x-for="(photo, i) in photos" x-bind:key="photo.src">
                        <button type="button" x-show="album === 'all' || album === photo.album" x-on:click="show(i)"
                                class="group relative aspect-square overflow-hidden rounded-2xl bg-brand-50 text-left focus-visible:outline-offset-4">
                            <img x-bind:src="photo.src" x-bind:alt="photo.caption" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/65 to-transparent p-3 pt-10 text-sm font-semibold text-white opacity-0 transition group-hover:opacity-100 group-focus-visible:opacity-100" x-text="photo.caption"></span>
                        </button>
                    </template>
                </div>

                {{-- Lightbox --}}
                <div x-show="current" x-cloak x-transition.opacity x-on:keydown.escape.window="close()" x-on:keydown.arrow-right.window="current && next()" x-on:keydown.arrow-left.window="current && prev()"
                     class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-950/95 p-4" role="dialog" aria-modal="true" x-on:click.self="close()">
                    <button type="button" x-on:click="close()" class="absolute top-4 right-4 rounded-full bg-white/10 p-2 text-white hover:bg-white/20" aria-label="{{ __('Close') }}">@include('partials.icon', ['name' => 'x', 'class' => 'size-6'])</button>
                    <button type="button" x-on:click="prev()" class="absolute left-3 z-10 rounded-full bg-white/10 p-3 text-white hover:bg-white/20" aria-label="{{ __('Previous') }}">@include('partials.icon', ['name' => 'chevron-left', 'class' => 'size-6'])</button>
                    <template x-if="current">
                        <figure class="flex max-h-full w-full max-w-5xl flex-col items-center">
                            <img x-bind:src="current.src" x-bind:alt="current.caption" class="max-h-[80vh] w-auto rounded-xl object-contain shadow-2xl">
                            <figcaption class="mt-3 text-center text-white/85" x-text="current.caption"></figcaption>
                        </figure>
                    </template>
                    <button type="button" x-on:click="next()" class="absolute right-3 z-10 rounded-full bg-white/10 p-3 text-white hover:bg-white/20" aria-label="{{ __('Next') }}">@include('partials.icon', ['name' => 'chevron-right', 'class' => 'size-6'])</button>
                </div>
            </div>
        @endif
    </section>
@endsection
