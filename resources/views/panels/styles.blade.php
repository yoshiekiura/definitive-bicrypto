<!-- BEGIN: Vendor CSS-->

  <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" />

@yield('vendor-style')
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('css/base/themes/dark-layout.css')) }}" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

@php $configData = applClasses(); @endphp

<!-- BEGIN: Page CSS-->
  <link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/vertical-menu.css')) }}" />

{{-- Page Styles --}}
@yield('page-style')

<!-- laravel style -->
<link rel="stylesheet" href="{{ asset(mix('css/overrides.css')) }}" />

<!-- BEGIN: Custom CSS-->

  <link rel="stylesheet" href="{{ asset(mix('css/style.css')) }}" />

@livewireStyles
