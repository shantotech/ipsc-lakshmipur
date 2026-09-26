@extends('layouts.app', ['title' => __('site.contact.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.contact.title'), 'intro' => __('site.contact.intro')])

    <section class="container-site py-16 sm:py-20">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['icon' => 'map-pin', 'label' => __('Address'), 'value' => __('site.school.address'), 'href' => null],
                ['icon' => 'phone', 'label' => __('Phone'), 'value' => __('site.school.phone'), 'href' => 'tel:'.preg_replace('/[^0-9+]/', '', __('site.school.phone'))],
                ['icon' => 'mail', 'label' => __('Email'), 'value' => __('site.school.email'), 'href' => 'mailto:'.__('site.school.email')],
                ['icon' => 'clock', 'label' => __('Office hours'), 'value' => __('site.school.office_hours'), 'href' => null],
            ] as $info)
                <div class="card p-6">
                    <span class="grid size-11 place-items-center rounded-xl bg-brand-50 text-brand-600">@include('partials.icon', ['name' => $info['icon']])</span>
                    <p class="mt-4 text-sm font-semibold text-muted">{{ $info['label'] }}</p>
                    @if ($info['href'])
                        <a href="{{ $info['href'] }}" class="mt-1 block font-semibold break-words text-ink hover:text-brand-700" @if($info['icon'] === 'phone') dir="ltr" @endif>{{ $info['value'] }}</a>
                    @else
                        <p class="mt-1 font-semibold text-ink">{{ $info['value'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-10 grid gap-8 lg:grid-cols-2">
            <div>
                @if (session('status'))
                    <div class="mb-6 flex gap-3 rounded-2xl bg-brand-50 p-5 text-brand-800 ring-1 ring-brand-200" role="status">
                        @include('partials.icon', ['name' => 'check-circle', 'class' => 'size-6 shrink-0'])
                        <p class="font-medium">{{ session('status') }}</p>
                    </div>
                @endif
                <form method="POST" action="{{ route('contact.submit') }}" class="card space-y-5 p-6 sm:p-8">
                    @csrf
                    <h2 class="text-2xl font-semibold">{{ __('Send us a message') }}</h2>
                    <div class="grid gap-5 sm:grid-cols-2">
                        @include('partials.field', ['name' => 'name', 'label' => __('Your name'), 'required' => true])
                        @include('partials.field', ['name' => 'phone', 'label' => __('Mobile number'), 'type' => 'tel', 'required' => true, 'placeholder' => '01XXXXXXXXX'])
                        @include('partials.field', ['name' => 'email', 'label' => __('Email (optional)'), 'type' => 'email', 'span' => 'sm:col-span-2'])
                        @include('partials.field', ['name' => 'subject', 'label' => __('Subject'), 'required' => true, 'span' => 'sm:col-span-2'])
                        @include('partials.field', ['name' => 'message', 'label' => __('Message'), 'type' => 'textarea', 'rows' => 5, 'required' => true, 'span' => 'sm:col-span-2'])
                    </div>
                    <button type="submit" class="btn-primary w-full !py-3 sm:w-auto">{{ __('Send message') }} @include('partials.icon', ['name' => 'send', 'class' => 'size-4'])</button>
                </form>
            </div>
            <div class="card min-h-80 overflow-hidden">
                <iframe title="{{ __('Map') }}" src="https://maps.google.com/maps?q={{ urlencode(__('site.contact.map_query')) }}&z=14&output=embed" class="size-full min-h-80 border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
@endsection
