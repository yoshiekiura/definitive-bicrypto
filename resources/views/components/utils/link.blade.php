@props([
    'active' => '',
    'text' => '',
    'hide' => false,
    'icon' => false
])

@if (!$hide)
    <a {{ $attributes->merge(['href' => 'javascript:;', 'class' => $active]) }}>
        @if ($icon)<i class="{{ $icon }}"></i> @endif
        {{ strlen($text) ? $text : $slot }}
    </a>
@endif
