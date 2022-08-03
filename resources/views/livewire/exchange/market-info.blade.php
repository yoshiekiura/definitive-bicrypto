<div>
    <div class="d-flex d-lg-none justify-content-between align-items-center text-2">
        <div class="d-flex flex-column">
            <span class="text-muted">Last Price: <span class="last_price">------</span><i class="last_price_icon bi"></i></span>
            <span class="text-muted">24h Change: <span class="day_change">------</span><i class="day_change_icon bi"></i></span>
        </div>
        @if ($provide != 'coinbasepro')
        <div class="d-flex flex-column">
            <span class="text-muted d-none d-md-block">{{ $symbol }} Volume: <span class="text-dark day_volume_pair">------</span></span>
            <span class="text-muted d-none d-md-block">{{ $currency }} Volume: <span class="text-dark day_volume_currency">------</span></span>
        </div>
        <div class="d-flex flex-column">
            <span class="text-muted">24h High: <span class="text-dark day_high">------</span></span>
            <span class="text-muted">24h Low: <span class="text-dark day_low">------</span></span>
        </div>
        @endif
    </div>
    <div class="d-none d-lg-flex align-items-center p-1 text-2">
        <div class="d-flex align-items-center me-3">
            <img class="avatar-content" width="24px"
                src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($symbol).'.png') }}"
                alt="{{ $symbol }}">
                <i class="bi bi-chevron-right"></i>
                <img class="avatar-content" width="24px"
                    src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($currency).'.png') }}"
                    alt="{{ $currency }}">
        </div>
        @if ($provide != 'coinbasepro')
        <div class="d-flex flex-column me-3">
            <span class="text-muted">24h change</span>
            <span class="day_change">
                -------
            </span>
        </div>
        @endif
        <div class="d-flex flex-column me-3">
            <span class="text-muted">24h Price Range</span>
            <span class="text-muted">High: <span class="text-dark day_high">-------</span></span>
            <span class="text-muted">Low: <span class="text-dark day_low">-------</span>
        </div>
        <div class="d-flex flex-column">
            <span class="text-muted">24h Volume</span>
            <span class="text-muted">{{ $symbol }}: <span class="text-dark day_volume_pair">-------</span></span>
            @if ($provide != 'coinbasepro')
            <span class="text-muted">{{ $currency }}: <span class="text-dark day_volume_currency">-------</span></span>
            @endif
        </div>
    </div>
</div>
