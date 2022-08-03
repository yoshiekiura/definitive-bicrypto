@props ([
    'name' => '',
    'id' => '',
    'value' => null,
    'disabled' => false,
    'checked' => false,
    'label' => false
])

<div {{ $attributes->merge(['class' => 'checkbox']) }}>
    <input
        type="checkbox"
        class="form-check-input"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $checked ? 'checked' : '' }}
        {{ $value ? "value=$value" : '' }}
    />
    <label class="form-check-label" for="{{ $id }}">
        <span class="check-mark"></span>
        @if ($label) <span>{{ $label }}</span> @endif
    </label>
</div>
