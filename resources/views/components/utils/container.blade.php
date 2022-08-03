@props([
    "class" => "",
    "containerClass" => "",
    "tag" => "section",
    "section" => true
])

<{{ $tag }} {{ $attributes->merge( ['class' => ($section ? 'section' : '') . ( $class ? " {$class}" : "" )] ) }}>
    <div class="container{{ $containerClass ? " {$containerClass}": "" }}">
        {{ $slot }}
    </div>
</{{ $tag }}>
