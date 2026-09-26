{{--
    Page banner for inner pages.
    @include('partials.page-header', ['title' => ..., 'intro' => ..., 'crumbs' => [['label' => ..., 'url' => ...]]])
--}}
<section class="bg-pattern relative overflow-hidden bg-brand-800 text-white">
    <div class="pointer-events-none absolute -top-24 -right-24 size-80 rounded-full bg-gold-400/15 blur-3xl"></div>
    <div class="container-site relative py-14 sm:py-20">
        <nav aria-label="{{ __('Breadcrumb') }}" class="mb-4 text-sm text-white/65">
            <ol class="flex flex-wrap items-center gap-1.5">
                <li><a href="{{ route('home') }}" class="hover:text-white">{{ __('Home') }}</a></li>
                @foreach ($crumbs ?? [] as $crumb)
                    <li class="flex items-center gap-1.5">
                        @include('partials.icon', ['name' => 'chevron-right', 'class' => 'size-3.5'])
                        @if (! empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="hover:text-white">{{ $crumb['label'] }}</a>
                        @else
                            <span>{{ $crumb['label'] }}</span>
                        @endif
                    </li>
                @endforeach
                <li class="flex items-center gap-1.5" aria-current="page">
                    @include('partials.icon', ['name' => 'chevron-right', 'class' => 'size-3.5'])
                    <span class="text-gold-300">{{ $title }}</span>
                </li>
            </ol>
        </nav>
        <h1 class="max-w-3xl text-4xl font-semibold text-white sm:text-5xl">{{ $title }}</h1>
        @if (! empty($intro))
            <p class="mt-4 max-w-2xl text-lg leading-8 text-white/80">{{ $intro }}</p>
        @endif
    </div>
</section>
