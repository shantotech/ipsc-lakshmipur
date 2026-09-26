@extends('layouts.app', ['title' => __('Apply Online')])

@php
    $classOptions = array_map(fn ($label) => __($label), \App\Models\AdmissionApplication::CLASSES);
@endphp

@section('content')
    @include('partials.page-header', ['title' => __('Apply Online'), 'intro' => __('Fill in the form below. The school office will call you to arrange a campus visit.'), 'crumbs' => [['label' => __('Admission'), 'url' => route('admission')]]])

    <section class="container-site grid gap-10 py-16 sm:py-20 lg:grid-cols-12">
        <div class="lg:col-span-8">
            @if (session('status'))
                <div class="mb-6 flex gap-3 rounded-2xl bg-brand-50 p-5 text-brand-800 ring-1 ring-brand-200" role="status">
                    @include('partials.icon', ['name' => 'check-circle', 'class' => 'size-6 shrink-0'])
                    <div>
                        <p class="font-medium">{{ session('status') }}</p>
                        @if (session('reference'))
                            <p class="mt-2">{{ __('Your reference number:') }} <strong class="rounded-md bg-white px-2 py-0.5 font-mono tracking-wide ring-1 ring-brand-200">{{ session('reference') }}</strong></p>
                            <p class="mt-1 text-sm text-brand-700">{{ __('Please keep this number. Mention it when you call or visit the office.') }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admission.submit') }}" class="card space-y-10 p-6 sm:p-8">
                @csrf
                <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                <fieldset>
                    <legend class="flex items-center gap-2 text-xl font-semibold">
                        <span class="grid size-8 place-items-center rounded-lg bg-brand-600 text-sm text-white">{{ \App\Support\Locale::number(1) }}</span>
                        {{ __('Student information') }}
                    </legend>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        @include('partials.field', ['name' => 'student_name', 'label' => __('Student\'s full name'), 'required' => true, 'span' => 'sm:col-span-2'])
                        @include('partials.field', ['name' => 'date_of_birth', 'label' => __('Date of birth'), 'type' => 'date', 'required' => true])
                        @include('partials.field', ['name' => 'gender', 'label' => __('Gender'), 'type' => 'select', 'options' => ['male' => __('Boy'), 'female' => __('Girl')], 'required' => true])
                        @include('partials.field', ['name' => 'class', 'label' => __('Class applying for'), 'type' => 'select', 'options' => $classOptions, 'required' => true])
                        @include('partials.field', ['name' => 'previous_school', 'label' => __('Previous school (if any)')])
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="flex items-center gap-2 text-xl font-semibold">
                        <span class="grid size-8 place-items-center rounded-lg bg-brand-600 text-sm text-white">{{ \App\Support\Locale::number(2) }}</span>
                        {{ __('Guardian information') }}
                    </legend>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        @include('partials.field', ['name' => 'guardian_name', 'label' => __('Guardian\'s name'), 'required' => true, 'span' => 'sm:col-span-2'])
                        @include('partials.field', ['name' => 'phone', 'label' => __('Mobile number'), 'type' => 'tel', 'required' => true, 'placeholder' => '01XXXXXXXXX'])
                        @include('partials.field', ['name' => 'email', 'label' => __('Email (optional)'), 'type' => 'email'])
                        @include('partials.field', ['name' => 'address', 'label' => __('Present address'), 'type' => 'textarea', 'rows' => 3, 'required' => true, 'span' => 'sm:col-span-2'])
                    </div>
                </fieldset>

                <div class="flex flex-col gap-4 border-t border-line pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-muted">{{ __('Fields marked * are required.') }}</p>
                    <button type="submit" class="btn-primary !px-7 !py-3">{{ __('Submit application') }} @include('partials.icon', ['name' => 'send', 'class' => 'size-4'])</button>
                </div>
            </form>
        </div>

        <aside class="space-y-5 lg:col-span-4">
            <div class="rounded-3xl bg-brand-800 p-7 text-white">
                <h2 class="text-xl font-semibold text-white">{{ __('Need help?') }}</h2>
                <p class="mt-2 text-white/75">{{ __('Our office will gladly help you fill in the form.') }}</p>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', __('site.school.phone')) }}" class="mt-5 flex items-center gap-3 text-lg font-semibold text-gold-300">@include('partials.icon', ['name' => 'phone']) <span dir="ltr">{{ __('site.school.phone') }}</span></a>
                <p class="mt-2 text-sm text-white/60">{{ __('site.school.office_hours') }}</p>
            </div>
            <div class="card p-7">
                <h2 class="text-xl font-semibold">{{ __('site.admission.documents_title') }}</h2>
                <ul class="mt-4 space-y-2.5 text-[0.95rem] text-ink/80">
                    @foreach (__('site.admission.documents') as $doc)
                        <li class="flex gap-2.5">@include('partials.icon', ['name' => 'check', 'class' => 'mt-1 size-4 shrink-0 text-brand-600', 'stroke' => 2.5]) {{ $doc }}</li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </section>
@endsection
