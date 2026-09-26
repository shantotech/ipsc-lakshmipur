@extends('layouts.app', ['title' => __('site.school_hours.title')])

@section('content')
    @include('partials.page-header', ['title' => __('site.school_hours.title'), 'intro' => __('site.school_hours.intro'), 'crumbs' => [['label' => __('Academic'), 'url' => route('academic')]]])

    <section class="container-site max-w-4xl py-16 sm:py-20">
        <div class="card overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-brand-700 text-white">
                    <tr>
                        <th scope="col" class="px-5 py-4 font-semibold">{{ __('Class') }}</th>
                        <th scope="col" class="hidden px-5 py-4 font-semibold sm:table-cell">{{ __('Days') }}</th>
                        <th scope="col" class="px-5 py-4 font-semibold">{{ __('Time') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach (__('site.school_hours.rows') as $row)
                        <tr class="odd:bg-white even:bg-paper">
                            <td class="px-5 py-4 font-semibold">{{ $row['group'] }}<span class="block text-sm font-normal text-muted sm:hidden">{{ $row['days'] }}</span></td>
                            <td class="hidden px-5 py-4 text-muted sm:table-cell">{{ $row['days'] }}</td>
                            <td class="px-5 py-4 font-medium text-brand-700">{{ $row['time'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <ul class="mt-8 space-y-3">
            @foreach (__('site.school_hours.notes') as $note)
                <li class="flex gap-3 rounded-2xl bg-gold-50 p-4 ring-1 ring-gold-100">
                    @include('partials.icon', ['name' => 'bell', 'class' => 'mt-1 size-5 shrink-0 text-gold-600'])
                    <span>{{ $note }}</span>
                </li>
            @endforeach
        </ul>
    </section>
@endsection
