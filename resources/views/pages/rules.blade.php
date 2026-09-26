@extends('layouts.app', ['title' => __('site.rules.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.rules.title'), 'intro' => __('site.rules.intro'), 'crumbs' => [['label' => __('Administration'), 'url' => route('administration')]]])

    <section class="container-site max-w-4xl space-y-5 py-16 sm:py-20">
        @foreach (__('site.rules.sections') as $i => $section)
            <div x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }" class="card overflow-hidden">
                <button type="button" x-on:click="open = !open" x-bind:aria-expanded="open" class="flex w-full items-center gap-4 p-6 text-left">
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-brand-50 font-bold text-brand-700">{{ \App\Support\Locale::number($i + 1) }}</span>
                    <span class="flex-1 text-xl font-semibold">{{ $section['title'] }}</span>
                    <span x-bind:class="open && 'rotate-180'" class="text-brand-600 transition">@include('partials.icon', ['name' => 'chevron-down'])</span>
                </button>
                <div x-show="open" x-collapse>
                    <ul class="prose-site px-6 pb-6 sm:pl-20">
                        @foreach ($section['items'] as $rule)
                            <li>{{ $rule }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </section>
@endsection
