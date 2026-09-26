{{-- A labelled form field. Params: name, label, type (text|email|tel|date|textarea|select), options, required, placeholder, span --}}
@php($type = $type ?? 'text')
<div class="{{ $span ?? '' }}">
    <label for="{{ $name }}" class="field-label">
        {{ $label }}
        @if ($required ?? false)<span class="text-accent-red" aria-hidden="true">*</span>@endif
    </label>
    @if ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows ?? 4 }}" class="field-input" placeholder="{{ $placeholder ?? '' }}" @required($required ?? false)>{{ old($name) }}</textarea>
    @elseif ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" class="field-input" @required($required ?? false)>
            <option value="">{{ __('Select') }}</option>
            @foreach ($options as $value => $optionLabel)
                <option value="{{ $value }}" @selected(old($name) == $value)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name) }}" class="field-input" placeholder="{{ $placeholder ?? '' }}" @required($required ?? false) @if($type === 'tel') inputmode="tel" autocomplete="tel" @endif>
    @endif
    @error($name)
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>
