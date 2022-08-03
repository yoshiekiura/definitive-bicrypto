<!-- ./Main navigation -->
<x-utils.container :section="false" tag="nav" class="navbar navbar-expand-md navigation sidebar-left {{ $class }}" container-class="{{ $containerClass }}">
    <button class="navbar-toggler" type="button">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <a href="#main" class="navbar-brand">
        <img src="{{ asset('img/logo.png') }}" alt="{{ appName() }}" class="logo logo-sticky">
    </a>

    <div class="collapse navbar-collapse ms-auto">
        <div class="sidebar-brand">
            <a href="#main">
                <img src="{{ asset('img/logo.png') }}" alt="{{ appName() }}" class="logo">
            </a>
        </div>

        {{ $slot }}
    </div>
</x-utils.container>
