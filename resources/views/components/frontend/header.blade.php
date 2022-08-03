@props([
    'title' => '',
    'subtitle' => '',
    'containerClass' => '',
])

<header class="page header text-contrast bg-primary">
    <div class="container {{ $containerClass ?? '' }}">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="bold display-md-4 text-contrast {{ $subtitle ? "mb-4" : "" }}">
                    {{ strlen($title) ? $title : $slot }}
                </h1>

                @if ($subtitle)
                    <p class="lead text-contrast">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    </div>
</header>
