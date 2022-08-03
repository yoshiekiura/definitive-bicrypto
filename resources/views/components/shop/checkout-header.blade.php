@props ([
    "links" => [
        [ "title" => "Customer", "icon" => "user", "url" => "customer" ],
        [ "title" => "Shipping", "icon" => "address-card", "url" => "shipping" ],
        [ "title" => "Payment", "icon" => "credit-card", "url" => "payment" ],
        [ "title" => "Confirmation", "icon" => "check-square", "url" => "confirmation" ]
    ],
    'title' => '',
    'subtitle' => ''
])

<section class="checkout-header page header bg-dark section">
    <div class="container bring-to-front pt-5 pb-0">
        <div class="page-title">
            <h1 class="regular text-contrast">{{ $title }}</h1>
            <p class="mb-0 text-muted">{{ $subtitle }}</p>
        </div>

        <nav class="nav navbar mt-4">
            @foreach ( $links as $link )
                <a href="{{ route("frontend.checkout.{$link['url']}") }}"
                              class="nav-item nav-link {{ activeClass( Route::is("frontend.checkout.{$link['url']}") ) }}"
                >
                    <i class="far fa-{{ $link['icon'] }} me-2"></i>
                    <span class="d-none d-md-inline">{{ $link['title'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>

    <!-- BreadCrumb -->
    <div class="bg-light shadow-sm">
        <div class="container bring-to-front py-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small py-2">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="shop-index">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
