{{-- Event popup (admin: Website → Popup). Once per visit; again after the set hours. --}}
@php($href = \App\Models\HeroSlide::href($popup->button_url))
<div x-data="sitePopup(@js($popup->versionKey()), {{ max(1, (int) $popup->repeat_after_hours) }})" x-show="open" x-cloak
     x-on:keydown.escape.window="open && close()"
     class="fixed inset-0 z-[70] flex items-end justify-center p-3 sm:items-center sm:p-6" role="dialog" aria-modal="true" aria-labelledby="popup-title">
    <div x-show="open" x-transition.opacity.duration.300ms x-on:click="close()" class="absolute inset-0 bg-brand-950/60 backdrop-blur-sm"></div>

    <div x-show="open" x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-y-6 opacity-0 sm:scale-95"
         x-transition:leave="transition duration-150" x-transition:leave-end="opacity-0"
         class="relative flex max-h-[92vh] w-full max-w-lg flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <button type="button" x-ref="close" x-on:click="close()"
                class="absolute top-3 right-3 z-10 grid size-9 place-items-center rounded-full bg-white/90 text-ink shadow ring-1 ring-black/5 transition hover:bg-white"
                aria-label="{{ __('Close') }}">@include('partials.icon', ['name' => 'x', 'class' => 'size-5'])</button>

        <div class="overflow-y-auto">
            @if ($popup->imageUrl())
                <div class="bg-brand-50">
                    <img src="{{ $popup->imageUrl() }}" alt="" class="mx-auto max-h-[42vh] w-full object-contain">
                </div>
            @endif
            <div class="p-6 text-center sm:p-8">
                <h2 id="popup-title" class="text-2xl font-semibold sm:text-3xl">{{ $popup->localized('title') }}</h2>
                @if ($popup->localized('body'))
                    <p class="mt-3 leading-7 text-muted">{!! nl2br(e($popup->localized('body'))) !!}</p>
                @endif
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    @if ($href && $popup->localized('button_label'))
                        <a href="{{ $href }}" x-on:click="close()" class="btn-primary !px-6 !py-3">{{ $popup->localized('button_label') }} @include('partials.icon', ['name' => 'arrow-right', 'class' => 'size-4'])</a>
                    @endif
                    <button type="button" x-on:click="close()" class="btn-outline !px-6 !py-3">{{ __('Maybe later') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
