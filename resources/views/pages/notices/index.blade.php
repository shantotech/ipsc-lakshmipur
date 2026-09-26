@extends('layouts.app', ['title' => __('Notices')])

@section('content')
    @include('partials.page-header', ['title' => __('Notices'), 'intro' => __('News, announcements and circulars from the school.')])

    <section class="container-site max-w-5xl py-16 sm:py-20">
        <nav class="flex flex-wrap gap-2" aria-label="{{ __('Filter notices') }}">
            @foreach (['' => 'All'] + \App\Models\Notice::CATEGORIES as $key => $label)
                @php($selected = ($category ?? '') === $key)
                <a href="{{ route('notices', $key ? ['category' => $key] : []) }}" @if($selected) aria-current="page" @endif
                   class="rounded-full px-4 py-2 text-sm font-semibold transition {{ $selected ? 'bg-brand-700 text-white' : 'bg-white text-ink/75 ring-1 ring-line hover:ring-brand-300' }}">{{ __($label) }}</a>
            @endforeach
        </nav>

        <div class="card mt-8 divide-y divide-line p-2">
            @forelse ($notices as $notice)
                @include('partials.notice-item', ['notice' => $notice])
            @empty
                <div class="flex flex-col items-center gap-3 p-12 text-center text-muted">
                    @include('partials.icon', ['name' => 'bell', 'class' => 'size-10 text-brand-200'])
                    <p>{{ $category ? __('No notices in this category yet.') : __('No notices have been published yet.') }}</p>
                </div>
            @endforelse
        </div>

        @if ($notices->hasPages())
            <div class="mt-8">{{ $notices->links() }}</div>
        @endif
    </section>
@endsection
