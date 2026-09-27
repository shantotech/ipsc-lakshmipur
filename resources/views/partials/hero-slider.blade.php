{{--
    Full-width homepage slider. Photos/videos change in the background.
    Each slide shows one of (HeroSlide::textMode()):
      - 'main'   the main homepage text (Settings → Homepage),
      - 'own'    the slide's own title,
      - 'banner' no headline, for posters that already contain text; shown in full, uncropped.
    A dark overlay over the photo/video keeps the text readable on any background.
--}}
@php
    $modes = $slides->map(fn ($s) => $s->textMode())->values();
@endphp
<section x-data="heroSlider({{ $slides->count() }})" class="relative isolate h-[clamp(520px,82vh,820px)] overflow-hidden bg-brand-950 text-white"
         aria-roledescription="carousel" aria-label="{{ __('Highlights') }}">

    @foreach ($slides as $i => $slide)
        @php($mode = $modes[$i])
        <div data-slide data-duration="{{ $slide->durationMs() }}"
             class="absolute inset-0 transition-opacity duration-1000 ease-out"
             x-bind:class="index === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
             @if ($i > 0) x-cloak @endif
             role="group" aria-roledescription="slide" aria-label="{{ $i + 1 }} / {{ $slides->count() }}"
             x-bind:aria-hidden="index !== {{ $i }}">

            {{-- Background --}}
            @if ($slide->isVideo())
                <video class="absolute inset-0 size-full {{ $mode === 'banner' ? 'object-contain' : 'object-cover' }}" muted loop playsinline
                       preload="{{ $i === 0 ? 'auto' : 'none' }}" @if ($i === 0) autoplay @endif
                       @if ($slide->imageUrl()) poster="{{ $slide->imageUrl() }}" @endif aria-hidden="true">
                    <source src="{{ $slide->videoUrl() }}" type="{{ str_ends_with(strtolower($slide->video), '.webm') ? 'video/webm' : 'video/mp4' }}">
                </video>
            @elseif ($slide->imageUrl())
                @if ($mode === 'banner')
                    {{-- Blurred copy fills the edges around the uncropped poster --}}
                    <picture>
                        @if ($slide->mobileImageUrl())
                            <source media="(max-width: 767px)" srcset="{{ $slide->mobileImageUrl() }}">
                        @endif
                        <img src="{{ $slide->imageUrl() }}" alt="" aria-hidden="true"
                             class="absolute inset-0 size-full scale-110 object-cover opacity-60 blur-2xl" loading="lazy">
                    </picture>
                @endif
                <picture>
                    @if ($slide->mobileImageUrl())
                        <source media="(max-width: 767px)" srcset="{{ $slide->mobileImageUrl() }}">
                    @endif
                    <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->localized('title') ?: Site::fullName() }}"
                         class="absolute inset-0 size-full {{ $mode === 'banner' ? 'object-contain pb-24 sm:pb-28' : 'hero-kenburns object-cover' }}"
                         @if ($mode !== 'banner') x-bind:class="index === {{ $i }} && 'is-active'" @endif
                         @if ($i === 0) fetchpriority="high" @else loading="lazy" @endif>
                </picture>
            @endif

            {{-- Dark overlay over the whole photo/video, darkest behind the text. Banners only get a strip under the controls. --}}
            @if ($mode !== 'banner')
                <div class="absolute inset-0 bg-brand-950/65 sm:bg-brand-950/45"></div>
                <div class="absolute inset-0 hidden bg-gradient-to-r from-brand-950/75 via-brand-950/40 to-transparent sm:block"></div>
            @endif
            <div class="absolute inset-x-0 bottom-0 {{ $mode === 'banner' ? 'h-32' : 'h-44' }} bg-gradient-to-t from-brand-950/85 to-transparent"></div>

            {{-- This slide's own title --}}
            @if ($mode === 'own')
                <div class="container-site relative flex h-full items-center pt-6 pb-32 sm:pb-32">
                    <div class="max-w-2xl" x-bind:class="index === {{ $i }} ? 'hero-rise' : ''">
                        @if ($slide->localized('eyebrow'))
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-sm font-semibold text-gold-200 ring-1 ring-white/25 backdrop-blur">
                                <span class="size-1.5 rounded-full bg-gold-400"></span>
                                {{ $slide->localized('eyebrow') }}
                            </span>
                        @endif
                        <h2 class="hero-text-shadow mt-4 text-[2.1rem] leading-[1.12] font-semibold text-balance text-white sm:text-5xl xl:text-[3.4rem] bn:text-[2rem] bn:leading-[1.3] sm:bn:text-5xl">{!! nl2br(e($slide->localized('title'))) !!}</h2>
                        @if ($slide->localized('text'))
                            <p class="hero-text-shadow mt-4 max-w-xl text-base leading-7 text-white/90 sm:text-lg sm:leading-8">{{ $slide->localized('text') }}</p>
                        @endif
                        @if ($slide->buttonHref() && $slide->localized('button_label'))
                            <a href="{{ $slide->buttonHref() }}" class="btn-gold mt-7 !px-6 !py-3" x-bind:tabindex="index === {{ $i }} ? 0 : -1">
                                {{ $slide->localized('button_label') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Banner only: just the button, if one is set --}}
            @if ($mode === 'banner' && $slide->buttonHref() && $slide->localized('button_label'))
                <div class="container-site absolute inset-x-0 bottom-32 z-10 flex justify-center sm:bottom-36 sm:justify-start">
                    <a href="{{ $slide->buttonHref() }}" class="btn-gold !px-6 !py-3 shadow-lg shadow-black/30" x-bind:tabindex="index === {{ $i }} ? 0 : -1">
                        {{ $slide->localized('button_label') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
                    </a>
                </div>
            @endif
        </div>
    @endforeach

    {{-- Main homepage text (Settings → Homepage), over slides set to show it --}}
    <div class="pointer-events-none absolute inset-0 z-10" x-show="@js($modes)[index] === 'main'" x-transition.opacity.duration.500ms
         @if ($modes->first() !== 'main') x-cloak @endif>
        <div class="container-site flex h-full items-center pt-6 pb-32 sm:pb-32">
            <div class="hero-rise pointer-events-auto max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-sm font-semibold text-gold-200 ring-1 ring-white/25 backdrop-blur">
                    <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-gold-400 opacity-75"></span><span class="relative inline-flex size-2 rounded-full bg-gold-400"></span></span>
                    {{ Site::get('hero_eyebrow') }}
                </span>
                <h1 class="hero-text-shadow mt-4 text-[2.1rem] leading-[1.12] font-semibold text-balance text-white sm:text-5xl xl:text-[3.4rem] bn:text-[2rem] bn:leading-[1.3] sm:bn:text-5xl">{{ Site::get('hero_title') }}</h1>
                <p class="hero-text-shadow mt-4 max-w-xl text-base leading-7 text-white/90 sm:text-lg sm:leading-8">{{ Site::get('hero_text') }}</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('admission.apply') }}" class="btn-gold !px-6 !py-3">{{ __('site.hero.primary') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
                    <a href="{{ route('about') }}" class="btn-ghost-light !px-6 !py-3 backdrop-blur">{{ __('site.hero.secondary') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Controls --}}
    @if ($slides->count() > 1)
        <div class="container-site absolute inset-x-0 bottom-20 z-20 flex items-center justify-between gap-4 sm:bottom-24">
            <div class="flex items-center gap-2">
                @foreach ($slides as $i => $slide)
                    <button type="button" x-on:click="go({{ $i }})" class="group relative h-1.5 w-8 overflow-hidden rounded-full bg-white/30 transition-all sm:w-12"
                            x-bind:class="index === {{ $i }} && '!w-14 sm:!w-20'" aria-label="{{ __('Go to slide') }} {{ $i + 1 }}" x-bind:aria-current="index === {{ $i }}">
                        <span class="absolute inset-y-0 left-0 rounded-full bg-gold-400"
                              x-bind:class="index === {{ $i }} ? (playing ? 'hero-progress' : 'w-full') : 'w-0'"
                              style="--duration: {{ $slide->durationMs() }}ms"></span>
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
