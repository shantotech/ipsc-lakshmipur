{{-- Small notice row used on the homepage, notices list and careers page. --}}
@php
    use App\Support\Locale;
    $categoryLabels = ['admission' => __('Admission'), 'recruitment' => __('Recruitment'), 'general' => __('General')];
@endphp
<a href="{{ route('notices.show', ['slug' => $notice['slug']]) }}" class="group flex gap-4 rounded-2xl p-4 transition hover:bg-brand-50/70 sm:gap-5">
    <div class="flex w-16 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-50 py-2 text-brand-700 ring-1 ring-brand-100 group-hover:bg-white">
        <span class="text-2xl leading-none font-bold">{{ Locale::date($notice['date'], 'dd') }}</span>
        <span class="mt-1 text-xs font-medium">{{ Locale::date($notice['date'], 'MMM y') }}</span>
    </div>
    <div class="min-w-0 flex-1">
        <div class="flex flex-wrap items-center gap-2">
            @if ($notice['pinned'])
                <span class="inline-flex items-center gap-1 rounded-full bg-gold-100 px-2 py-0.5 text-xs font-semibold text-gold-700">@include('partials.icon', ['name' => 'pin', 'class' => 'size-3']) {{ __('Pinned') }}</span>
            @endif
            <span class="rounded-full bg-white px-2 py-0.5 text-xs font-medium text-muted ring-1 ring-line">{{ $categoryLabels[$notice['category']] ?? '' }}</span>
        </div>
        <h3 class="mt-1.5 text-lg font-semibold text-ink group-hover:text-brand-700 bn:text-[1.1rem]">{{ Locale::pick($notice['title']) }}</h3>
        <p class="mt-1 line-clamp-2 text-[0.95rem] leading-7 text-muted">{{ Locale::pick($notice['excerpt']) }}</p>
    </div>
    <span class="hidden self-center text-brand-600 opacity-0 transition group-hover:translate-x-1 group-hover:opacity-100 sm:block">@include('partials.icon', ['name' => 'arrow-right'])</span>
</a>
