{{-- Key facts under the homepage hero. --}}
<div class="container-site relative {{ $class ?? 'pb-14' }}">
    <dl class="grid gap-px overflow-hidden rounded-2xl bg-line ring-1 ring-line sm:grid-cols-3">
        @foreach (__('site.hero.stats') as $stat)
            <div class="bg-white px-6 py-5">
                <dt class="text-sm text-muted">{{ $stat['label'] }}</dt>
                <dd class="mt-1 font-display text-3xl font-semibold text-brand-700 bn:font-bangla bn:font-bold">{{ $stat['value'] }}</dd>
            </div>
        @endforeach
    </dl>
</div>
