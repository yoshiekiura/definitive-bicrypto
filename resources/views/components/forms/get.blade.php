<form method="get" {{ $attributes->merge(['action' => '#', 'class' => 'form']) }}>
    {{ $slot }}
</form>
