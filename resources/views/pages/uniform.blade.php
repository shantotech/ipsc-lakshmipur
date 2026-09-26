@extends('layouts.app', ['title' => __('site.uniform.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.uniform.title'), 'intro' => __('site.uniform.intro'), 'crumbs' => [['label' => __('Academic'), 'url' => route('academic')]]])

    <section class="container-site py-16 sm:py-20">
        <div class="grid gap-5 md:grid-cols-3">
            @foreach (__('site.uniform.groups') as $i => $group)
                <div class="card p-7">
                    <span class="grid size-12 place-items-center rounded-2xl {{ ['bg-brand-600 text-white', 'bg-gold-400 text-brand-950', 'bg-accent-blue text-white'][$i % 3] }}">@include('partials.icon', ['name' => 'shirt', 'class' => 'size-6'])</span>
                    <h2 class="mt-5 text-2xl font-semibold">{{ $group['name'] }}</h2>
                    <ul class="mt-4 space-y-2.5">
                        @foreach ($group['items'] as $item)
                            <li class="flex gap-2.5">@include('partials.icon', ['name' => 'check', 'class' => 'mt-1 size-4 shrink-0 text-brand-600', 'stroke' => 2.5]) {{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </section>
@endsection
