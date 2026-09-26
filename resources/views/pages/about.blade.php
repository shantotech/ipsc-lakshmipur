@extends('layouts.app', ['title' => __('site.about.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.about.title'), 'intro' => __('site.school.tagline').' — '.__('site.school.version')])

    <section class="container-site grid gap-12 py-16 sm:py-20 lg:grid-cols-12">
        <div class="lg:col-span-7">
            <p class="border-l-4 border-gold-400 pl-5 text-xl leading-9 font-medium text-ink/90">{{ __('site.about.lead') }}</p>
            <div class="prose-site mt-8">
                @foreach (__('site.about.body') as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>
        <aside class="space-y-5 lg:col-span-5">
            <div id="mission" class="scroll-mt-28 rounded-3xl bg-brand-50 p-7 ring-1 ring-brand-100">
                <h2 class="flex items-center gap-3 text-2xl font-semibold">
                    <span class="grid size-10 place-items-center rounded-xl bg-brand-600 text-white">@include('partials.icon', ['name' => 'star', 'class' => 'size-5'])</span>
                    {{ __('site.about.mission_title') }}
                </h2>
                <p class="mt-4 text-lg leading-8 text-ink/80">{{ __('site.about.mission') }}</p>
            </div>
            <div id="vision" class="scroll-mt-28 rounded-3xl bg-gold-50 p-7 ring-1 ring-gold-100">
                <h2 class="flex items-center gap-3 text-2xl font-semibold">
                    <span class="grid size-10 place-items-center rounded-xl bg-gold-500 text-brand-950">@include('partials.icon', ['name' => 'globe', 'class' => 'size-5'])</span>
                    {{ __('site.about.vision_title') }}
                </h2>
                <p class="mt-4 text-lg leading-8 text-ink/80">{{ __('site.about.vision') }}</p>
            </div>
        </aside>
    </section>

    <section class="bg-white py-16 sm:py-20">
        <div class="container-site">
            <h2 class="section-title text-center">{{ __('site.about.values_title') }}</h2>
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (__('site.about.values') as $value)
                    <div class="rounded-2xl border border-line p-6">
                        <span class="text-brand-600">@include('partials.icon', ['name' => $value['icon'], 'class' => 'size-8', 'stroke' => 1.5])</span>
                        <h3 class="mt-4 text-lg font-semibold">{{ $value['title'] }}</h3>
                        <p class="mt-1.5 leading-7 text-muted">{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container-site grid gap-5 py-16 sm:py-20 md:grid-cols-2">
        @foreach (['chairman', 'principal'] as $person)
            <a href="{{ route('message', ['person' => $person]) }}" class="card group flex items-center gap-5 p-6 transition hover:shadow-xl hover:shadow-brand-900/5">
                <span class="grid size-16 shrink-0 place-items-center rounded-2xl bg-brand-100 text-brand-500">@include('partials.icon', ['name' => 'user', 'class' => 'size-8'])</span>
                <span class="min-w-0 flex-1">
                    <span class="block text-xl font-semibold text-ink group-hover:text-brand-700">{{ __("site.messages.$person.title") }}</span>
                    <span class="mt-1 block text-muted">{{ __("site.messages.$person.role") }}</span>
                </span>
                @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-5 text-brand-600 transition group-hover:translate-x-1'])
            </a>
        @endforeach
    </section>

    @include('partials.cta', ['class' => 'pb-16 sm:pb-20'])
@endsection
