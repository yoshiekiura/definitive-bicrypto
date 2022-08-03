<form method="post" {{ $attributes->merge(['action' => '#', 'class' => 'form']) }}>
    @csrf

    {{ $slot }}
</form>
