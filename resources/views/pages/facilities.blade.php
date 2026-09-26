@extends('layouts.app', ['title' => __('site.facilities.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.facilities.title'), 'intro' => __('site.facilities.intro'), 'crumbs' => [['label' => __('Academic'), 'url' => route('academic')]]])

    <section class="container-site py-16 sm:py-20">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (__('site.facilities.items') as $i => $item)
                <div class="card group overflow-hidden">
                    <div class="bg-pattern relative grid aspect-[16/10] place-items-center {{ ['bg-brand-700', 'bg-brand-600', 'bg-brand-800', 'bg-brand-500'][$i % 4] }} text-gold-300">
                        @include('partials.icon', ['name' => $item['icon'], 'class' => 'size-12 transition duration-300 group-hover:scale-110', 'stroke' => 1.25])
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-semibold">{{ $item['title'] }}</h2>
                        <p class="mt-2 leading-7 text-muted">{{ $item['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @include('partials.cta', ['class' => 'pb-16 sm:pb-20'])
@endsection
