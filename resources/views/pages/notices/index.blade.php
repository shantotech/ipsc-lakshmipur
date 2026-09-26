@extends('layouts.app', ['title' => __('Notices')])

@section('content')
    @include('partials.page-header', ['title' => __('Notices'), 'intro' => __('News, announcements and circulars from the school.')])

    <section class="container-site max-w-5xl py-16 sm:py-20">
        <div class="flex flex-wrap gap-2" role="tablist" aria-label="{{ __('Filter notices') }}">
            @foreach ([null => __('All'), 'admission' => __('Admission'), 'recruitment' => __('Recruitment'), 'general' => __('General')] as $key => $label)
                @php($selected = ($category ?? null) === ($key ?: null))
                <a href="{{ route('notices', $key ? ['category' => $key] : []) }}" role="tab" aria-selected="{{ $selected ? 'true' : 'false' }}"
                   class="rounded-full px-4 py-2 text-sm font-semibold transition {{ $selected ? 'bg-brand-700 text-white' : 'bg-white text-ink/75 ring-1 ring-line hover:ring-brand-300' }}">{{ $label }}</a>
            @endforeach
        </div>

        <div class="card mt-8 divide-y divide-line p-2">
            @forelse ($notices as $notice)
                @include('partials.notice-item', ['notice' => $notice])
            @empty
                <p class="p-10 text-center text-muted">{{ __('No notices in this category yet.') }}</p>
            @endforelse
        </div>
    </section>
@endsection
