@extends('layouts.app', ['title' => __('Gallery')])

@php
    use App\Support\Locale;
    $tones = [
        'brand' => 'bg-brand-700 text-gold-300',
        'gold' => 'bg-gold-400 text-brand-900',
        'blue' => 'bg-accent-blue text-white',
        'red' => 'bg-accent-red text-white',
    ];
    $albums = ['all' => __('All'), 'campus' => __('Campus'), 'classroom' => __('Classroom'), 'events' => __('Events')];
    $lightbox = collect($photos)->map(fn ($p) => ['caption' => Locale::pick($p['caption']), 'tone' => $tones[$p['tone']], 'icon' => $p['icon'], 'album' => $p['album']])->all();
@endphp

@section('content')
    @include('partials.page-header', ['title' => __('Gallery'), 'intro' => __('Moments from campus life. Photos will be added as our school year begins.')])

    <section class="container-site py-16 sm:py-20" x-data="gallery(@js($lightbox))">
        <div class="flex flex-wrap gap-2">
            @foreach ($albums as $key => $label)
                <button type="button" x-on:click="album = '{{ $key }}'" x-bind:class="album === '{{ $key }}' ? 'bg-brand-700 text-white' : 'bg-white text-ink/75 ring-1 ring-line hover:ring-brand-300'"
                        class="rounded-full px-4 py-2 text-sm font-semibold transition">{{ $label }}</button>
            @endforeach
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($lightbox as $i => $photo)
                <button type="button" x-show="album === 'all' || album === '{{ $photo['album'] }}'" x-transition.opacity x-on:click="show({{ $i }})"
                        class="group relative overflow-hidden rounded-2xl text-left {{ $i % 5 === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                    <div class="bg-pattern grid aspect-square size-full place-items-center {{ $photo['tone'] }}">
                        @include('partials.icon', ['name' => $photo['icon'], 'class' => ($i % 5 === 0 ? 'size-20' : 'size-12').' opacity-80 transition duration-300 group-hover:scale-110', 'stroke' => 1.25])
                    </div>
                    <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-4 pt-10 font-semibold text-white">{{ $photo['caption'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- Lightbox --}}
        <div x-show="current" x-cloak x-transition.opacity x-on:keydown.escape.window="close()" x-on:keydown.arrow-right.window="current && next()" x-on:keydown.arrow-left.window="current && prev()"
             class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-950/90 p-4" role="dialog" aria-modal="true">
            <button type="button" x-on:click="close()" class="absolute top-4 right-4 rounded-full bg-white/10 p-2 text-white hover:bg-white/20" aria-label="{{ __('Close') }}">@include('partials.icon', ['name' => 'x', 'class' => 'size-6'])</button>
            <button type="button" x-on:click="prev()" class="absolute left-3 rounded-full bg-white/10 p-3 text-white hover:bg-white/20" aria-label="{{ __('Previous') }}">@include('partials.icon', ['name' => 'chevron-left', 'class' => 'size-6'])</button>
            <template x-if="current">
                <figure class="w-full max-w-3xl">
                    <div class="bg-pattern grid aspect-[4/3] place-items-center rounded-2xl" x-bind:class="current.tone">
                        <span class="text-2xl font-semibold" x-text="current.caption"></span>
                    </div>
                    <figcaption class="mt-3 text-center text-white/80" x-text="current.caption"></figcaption>
                </figure>
            </template>
            <button type="button" x-on:click="next()" class="absolute right-3 rounded-full bg-white/10 p-3 text-white hover:bg-white/20" aria-label="{{ __('Next') }}">@include('partials.icon', ['name' => 'chevron-right', 'class' => 'size-6'])</button>
        </div>
    </section>
@endsection
