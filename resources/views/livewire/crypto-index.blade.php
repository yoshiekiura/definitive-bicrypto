<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-4">
        @foreach($markets as $market)
        <div class="col-lg-4 col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center">
                        <img class="avatar-content" width="32px"
                            src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($market->pair).'.png') }}"
                            alt="{{ $market->pair }}">
                        <span class="ms-1 fw-bold">{{ $market->symbol }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-lg-9 col-md-9 col-sm-8">
        <div class="row">
            @foreach($markets as $market)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('user.exchange.now',[$market->currency,$market->pair]) }}">
                            <div class="d-flex justify-content-start align-items-center">
                                <img class="avatar-content" width="32px"
                                src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($market->currency).'.png') }}"
                                alt="{{ $market->currency }}">
                                <i class="bi bi-chevron-right"></i>
                                <img class="avatar-content" width="32px"
                                    src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($market->pair).'.png') }}"
                                    alt="{{ $market->pair }}">
                                <span class="ms-1 fw-bold">{{ $market->symbol }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div>
    <div class="row mb-2">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <input type="text" class="form-control bg-light border-dark" placeholder="Search" wire:model="search" />
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <select class="form-select border-light" wire:model="pair" id="pair" >
                <option selected>Select Pair</option>
                @foreach ($pairss as $pairs)
                    <option value="{{ $pairs->symbol }}" wire:click="emit('whatpair')">{{ $pairs->symbol }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row gx-2">
        @if($pair != null)
            @foreach($cryptos as $crypto)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card cardh match-height">
                    <a href="{{route('user.exchange.now', [$crypto['symbol'], $pair])}}" class="stretched-link">
                            <div class="d-flex justify-content-between align-items-center m-1">
                                <div class="avatar avatar-xl">
                                    <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($crypto['image']))}}"
                                        alt="{{__($crypto['name'])}}">
                                </div>


                                <a class="text-dark fs-4">{{__($crypto['name'])}}</a>
                                {{-- @if(in_array($crypto['symbol'], $watched))
                                <a data-bs-toggle="modal" data-bs-target="#deleteWatchlist"
                                    onclick="document.getElementById('bk').value = '{{ $crypto['symbol'] }}';"
                                    id="deleteWatchlist" data-id="{{ $crypto['id'] }}" data-name="{{ $crypto['name'] }}"
                                    data-symbol="{{ $crypto['symbol'] }}" style="z-index: 10;"
                                    title="Remove From Watchlist"><i
                                        class="bi bi-bookmark bookmark-icon float-end fs-3 text-warning"></i></a>
                                @else
                                <a data-bs-toggle="modal" data-bs-target="#addWatchlist"
                                    onclick="document.getElementById('inputfav').value = '{{ $crypto['symbol'] }}';"
                                    id="addWatchlist" data-id="{{ $crypto['id'] }}" data-name="{{ $crypto['name'] }}"
                                    data-symbol="{{ $crypto['symbol'] }}" style="z-index: 10;" title="Add to Watchlist"><i
                                        class="bi bi-bookmark bookmark-icon float-end fs-3"></i></a>
                                @endif --}}

                            </div>
                        </a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    {{ $cryptos->links() }}
</div>
