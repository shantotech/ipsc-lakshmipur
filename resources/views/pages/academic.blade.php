@extends('layouts.app', ['title' => __('site.academic.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.academic.title'), 'intro' => __('site.academic.intro')])

    <section class="container-site py-16 sm:py-20">
        <h2 class="section-title">{{ __('site.academic.levels_title') }}</h2>
        <div class="mt-10 grid gap-5 md:grid-cols-3">
            @foreach (__('site.academic.levels') as $i => $level)
                <div class="card relative overflow-hidden p-7 {{ $i === 2 ? 'border-dashed bg-transparent' : '' }}">
                    <span class="font-display text-6xl font-semibold text-brand-100">{{ \App\Support\Locale::number('0'.($i + 1)) }}</span>
                    <h3 class="mt-2 text-2xl font-semibold">{{ $level['name'] }}</h3>
                    <p class="mt-1 font-semibold text-gold-700">{{ $level['classes'] }}</p>
                    <p class="mt-3 leading-7 text-muted">{{ $level['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white py-16 sm:py-20">
        <div class="container-site grid gap-12 lg:grid-cols-2">
            <div>
                <span class="eyebrow">{{ __('Teaching Method') }}</span>
                <h2 class="section-title">{{ __('site.academic.method_title') }}</h2>
                <ul class="mt-8 space-y-4">
                    @foreach (__('site.academic.method') as $point)
                        <li class="flex gap-3">
                            <span class="mt-0.5 grid size-7 shrink-0 place-items-center rounded-full bg-brand-600 text-white">@include('partials.icon', ['name' => 'check', 'class' => 'size-4', 'stroke' => 2.5])</span>
                            <span class="text-lg text-ink/85">{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <span class="eyebrow">{{ __('Curriculum') }}</span>
                <h2 class="section-title">{{ __('site.academic.subjects_title') }}</h2>
                <div class="mt-8 flex flex-wrap gap-2.5">
                    @foreach (__('site.academic.subjects') as $subject)
                        <span class="rounded-full border border-line bg-paper px-4 py-2 font-medium text-ink/85">{{ $subject }}</span>
                    @endforeach
                </div>
                <div class="mt-10 grid gap-3 sm:grid-cols-3">
                    @foreach ([['school-hours', 'clock', __('School Hours')], ['calendar', 'calendar', __('Academic Calendar')], ['uniform', 'shirt', __('Uniform')]] as [$route, $icon, $label])
                        <a href="{{ route($route) }}" class="flex flex-col items-start gap-3 rounded-2xl bg-brand-50 p-4 font-semibold text-brand-800 ring-1 ring-brand-100 transition hover:bg-brand-100">
                            @include('partials.icon', ['name' => $icon, 'class' => 'size-6'])
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @include('partials.cta')
@endsection
