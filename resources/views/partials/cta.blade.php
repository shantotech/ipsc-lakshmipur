@php
    use App\Support\Locale;
@endphp
{{-- Admission call-to-action band, used at the bottom of several pages. --}}
<section class="container-site {{ $class ?? 'py-16 sm:py-20' }}">
    <div class="bg-pattern relative overflow-hidden rounded-[2rem] bg-brand-800 px-6 py-12 text-white sm:px-12 sm:py-14">
        <div class="pointer-events-none absolute -bottom-20 -left-10 size-72 rounded-full bg-gold-400/20 blur-3xl"></div>
        <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold text-white sm:text-4xl">{{ __('site.admission.cta_title') }}</h2>
                <p class="mt-3 text-lg text-white/80">{{ __('site.admission.cta_text') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admission.apply') }}" class="btn-gold !px-6 !py-3">{{ __('Apply Online') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
                <a href="{{ Site::phoneHref() }}" class="btn-ghost-light !px-6 !py-3">@include('partials.icon', ['name' => 'phone', 'class' => 'size-4']) {{ __('Call the office') }}</a>
            </div>
        </div>
    </div>
</section>
