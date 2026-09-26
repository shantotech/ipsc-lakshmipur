{{--
    Full-width homepage slider. Each slide has a background video or photo,
    with optional label, title, text and button.
--}}
<section x-data="heroSlider({{ $slides->count() }})" class="relative isolate h-[clamp(520px,82vh,820px)] overflow-hidden bg-brand-950 text-white"
         aria-roledescription="carousel" aria-label="{{ __('Highlights') }}">

    @foreach ($slides as $i => $slide)
        <div data-slide data-duration="{{ $slide->isVideo() ? 12000 : 7000 }}"
             class="absolute inset-0 transition-opacity duration-1000 ease-out"
             x-bind:class="index === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
             @if ($i > 0) x-cloak @endif
             role="group" aria-roledescription="slide" aria-label="{{ $i + 1 }} / {{ $slides->count() }}"
             x-bind:aria-hidden="index !== {{ $i }}">

            {{-- Background --}}
            @if ($slide->isVideo())
                <video class="absolute inset-0 size-full object-cover" muted loop playsinline
                       preload="{{ $i === 0 ? 'auto' : 'none' }}" @if ($i === 0) autoplay @endif
                       @if ($slide->imageUrl()) poster="{{ $slide->imageUrl() }}" @endif aria-hidden="true">
                    <source src="{{ $slide->videoUrl() }}" type="{{ str_ends_with(strtolower($slide->video), '.webm') ? 'video/webm' : 'video/mp4' }}">
                </video>
            @elseif ($slide->imageUrl())
                <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->localized('title') ?: __('site.school.full_name') }}"
                     class="hero-kenburns absolute inset-0 size-full object-cover" x-bind:class="index === {{ $i }} && 'is-active'"
                     @if ($i === 0) fetchpriority="high" @else loading="lazy" @endif>
            @endif

            {{-- Shade so text stays readable on any photo --}}
            @if ($slide->localized('title') || $slide->localized('text'))
                <div class="absolute inset-0 bg-gradient-to-r from-brand-950/85 via-brand-950/50 to-brand-950/5"></div>
            @endif
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-brand-950/70 to-transparent"></div>

            {{-- Text --}}
            @if ($slide->localized('title') || $slide->localized('text'))
                <div class="container-site relative flex h-full items-center pb-16">
                    <div class="max-w-2xl" x-bind:class="index === {{ $i }} ? 'hero-rise' : ''">
                        @if ($slide->localized('eyebrow'))
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-sm font-semibold text-gold-200 ring-1 ring-white/25 backdrop-blur">
                                <span class="size-1.5 rounded-full bg-gold-400"></span>
                                {{ $slide->localized('eyebrow') }}
                            </span>
                        @endif
                        @if ($slide->localized('title'))
                            <h{{ $i === 0 ? '1' : '2' }} class="mt-5 text-[2.4rem] leading-[1.1] font-semibold text-balance text-white sm:text-6xl bn:text-[2.2rem] bn:leading-[1.3] sm:bn:text-5xl">{!! nl2br(e($slide->localized('title'))) !!}</h{{ $i === 0 ? '1' : '2' }}>
                        @endif
                        @if ($slide->localized('text'))
                            <p class="mt-5 max-w-xl text-lg leading-8 text-white/85">{{ $slide->localized('text') }}</p>
                        @endif
                        @if ($slide->buttonHref() && $slide->localized('button_label'))
                            <a href="{{ $slide->buttonHref() }}" class="btn-gold mt-8 !px-6 !py-3" x-bind:tabindex="index === {{ $i }} ? 0 : -1">
                                {{ $slide->localized('button_label') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endforeach

    {{-- Controls --}}
    @if ($slides->count() > 1)
        <div class="container-site absolute inset-x-0 bottom-20 z-20 flex items-center justify-between gap-4 sm:bottom-24">
            <div class="flex items-center gap-2">
                @foreach ($slides as $i => $slide)
                    <button type="button" x-on:click="go({{ $i }})" class="group relative h-1.5 w-8 overflow-hidden rounded-full bg-white/30 transition-all sm:w-12"
                            x-bind:class="index === {{ $i }} && '!w-14 sm:!w-20'" aria-label="{{ __('Go to slide') }} {{ $i + 1 }}" x-bind:aria-current="index === {{ $i }}">
                        <span class="absolute inset-y-0 left-0 rounded-full bg-gold-400"
                              x-bind:class="index === {{ $i }} ? (playing ? 'hero-progress' : 'w-full') : 'w-0'"
                              style="--duration: {{ $slide->isVideo() ? 12000 : 7000 }}ms"></span>
                    </button>
                @endforeach
                <button type="button" x-on:click="toggle()" class="ml-2 grid size-9 place-items-center rounded-full bg-white/10 ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20"
                        x-bind:aria-label="playing ? '{{ __('Pause slideshow') }}' : '{{ __('Play slideshow') }}'">
                    <svg x-show="playing" viewBox="0 0 24 24" class="size-4" fill="currentColor" aria-hidden="true"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
                    <svg x-show="!playing" x-cloak viewBox="0 0 24 24" class="size-4" fill="currentColor" aria-hidden="true"><path d="M8 5.5v13a1 1 0 0 0 1.5.9l10-6.5a1 1 0 0 0 0-1.8l-10-6.5A1 1 0 0 0 8 5.5z"/></svg>
                </button>
            </div>
            <div class="hidden gap-2 sm:flex">
                <button type="button" x-on:click="prev()" class="grid size-11 place-items-center rounded-full bg-white/10 ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20" aria-label="{{ __('Previous') }}">@include('partials.icon', ['name' => 'chevron-left', 'class' => 'size-5'])</button>
                <button type="button" x-on:click="next()" class="grid size-11 place-items-center rounded-full bg-white/10 ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20" aria-label="{{ __('Next') }}">@include('partials.icon', ['name' => 'chevron-right', 'class' => 'size-5'])</button>
            </div>
        </div>
    @endif
</section>
