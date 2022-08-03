<div>
    <div class="row mb-2">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <input type="text" class="form-control bg-light border-dark" placeholder="Search" wire:model="search" />
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <select class="form-select border-light" wire:model="pair" id="pair" >
                <option selected>Select Pair</option>
                <option value="USDT" wire:click="emit('whatpair')">USDT</option>
                <option value="BTC" wire:click="emit('whatpair')">BTC</option>
            </select>
        </div>
    </div>
    <div class="row gx-2">
        @if($pair != null)
            @foreach($cryptos as $crypto)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card cardh match-height">
                    <a href="{{route('user.practice.now', [$crypto['symbol'], $pair])}}" class="stretched-link">
                            <div class="d-flex justify-content-between align-items-center m-1">
                                <div class="avatar avatar-xl">
                                    <img src="{{getImage('assets/images/cryptoCurrency/'. strtolower($crypto['image']))}}"
                                        alt="{{__($crypto['name'])}}">
                                </div>


                                <a class="text-dark fs-4">{{__($crypto['name'])}}</a>
                                @if(in_array($crypto['symbol'], $watched))
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
                                @endif

                            </div>
                        </a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    {{ $cryptos->links() }}
</div>
