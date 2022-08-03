@php
$configData = applClasses();
@endphp
<div class="main-menu menu-fixed {{ $configData['themeuser'] === 'light' || $configData['themeuser'] === 'semi-dark' ? 'menu-dark' : 'menu-light' }} menu-accordion menu-shadow"
    data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('user.home') }}">
                    <span class="brand-logo">
                        <img src="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}"
                            alt="{{ __('locale.image') }}">
                    </span>
                    <div class="brand-text"><img
                            src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}"
                            alt="{{ __('locale.image') }}"></div>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="bi bi-x d-block d-xl-none text-primary toggle-icon font-medium-4"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Foreach menu item starts --}}
            @if (isset($usermenuData[0]))
                @foreach ($usermenuData[0] as $menu)
                    @if (isset($menu->navheader))
                        <li class="navigation-header">
                            <span>{{ __('locale.' . $menu->navheader) }}</span>
                            <i class="bi bi-three-dots-vertical"></i>
                        </li>
                    @else
                        {{-- Add Custom Class with nav-item --}}
                        @php
                            $custom_classes = '';
                            if (isset($menu->classlist)) {
                                $custom_classes = $menu->classlist;
                            }
                        @endphp
                        <li
                            class="nav-item {{ $custom_classes }} {{ Route::currentRouteName() === $menu->slug ? 'active' : '' }}">
                            <a href="{{ isset($menu->url) ? url('user#/' . $menu->url) : 'javascript:void(0)' }}"
                                class="d-flex align-items-center"
                                target="{{ isset($menu->newTab) ? '_blank' : '_self' }}">
                                <i class="bi bi-{{ $menu->icon }}"></i>
                                <span class="menu-title text-truncate">{{ __('locale.' . $menu->name) }}</span>
                                @if (isset($menu->badge))
                                    <?php $badgeClasses = 'badge rounded-pill badge-light-primary ms-auto me-1'; ?>
                                    <span
                                        class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $menu->badge }}</span>
                                @endif
                            </a>
                            @if (isset($menu->submenu))
                                @include('panels/user/submenu', ['menu' => $menu->submenu])
                            @endif
                        </li>
                    @endif
                @endforeach
            @endif
            {{-- Foreach menu item ends --}}
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
