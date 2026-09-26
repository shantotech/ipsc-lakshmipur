@extends('layouts.app', ['title' => __('site.admission.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.admission.title'), 'intro' => __('site.admission.intro')])

    <section class="container-site py-16 sm:py-20">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <h2 class="section-title">{{ __('site.admission.steps_title') }}</h2>
            <a href="{{ route('admission.apply') }}" class="btn-primary shrink-0">{{ __('Apply Online') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
        </div>
        <ol class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (__('site.admission.steps') as $i => $step)
                <li class="card relative p-6">
                    <span class="grid size-11 place-items-center rounded-full bg-gold-400 text-lg font-bold text-brand-950">{{ \App\Support\Locale::number($i + 1) }}</span>
                    <h3 class="mt-5 text-xl font-semibold">{{ $step['title'] }}</h3>
                    <p class="mt-2 leading-7 text-muted">{{ $step['text'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    <section class="bg-white py-16 sm:py-20">
        <div class="container-site grid gap-10 lg:grid-cols-2">
            <div>
                <h2 class="text-2xl font-semibold sm:text-3xl">{{ __('site.admission.ages_title') }}</h2>
                <p class="mt-2 text-muted">{{ __('site.admission.ages_note') }}</p>
                <div class="card mt-6 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-brand-50 text-brand-800">
                            <tr>
                                <th scope="col" class="px-5 py-3.5 font-semibold">{{ __('Class') }}</th>
                                <th scope="col" class="px-5 py-3.5 font-semibold">{{ __('Minimum age') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line">
                            @foreach (__('site.admission.ages') as $row)
                                <tr>
                                    <td class="px-5 py-3.5 font-medium">{{ $row['class'] }}</td>
                                    <td class="px-5 py-3.5 text-muted">{{ $row['age'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-semibold sm:text-3xl">{{ __('site.admission.documents_title') }}</h2>
                <ul class="mt-6 space-y-3">
                    @foreach (__('site.admission.documents') as $doc)
                        <li class="flex gap-3 rounded-2xl border border-line p-4">
                            <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-brand-50 text-brand-600">@include('partials.icon', ['name' => 'file-text', 'class' => 'size-4'])</span>
                            <span class="self-center">{{ $doc }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    @include('partials.cta')
@endsection
