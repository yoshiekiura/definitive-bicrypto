<div class="row pb-1 px-1">
    <div class="col-6">
        <label for="basic-url"
            class="form-label mb-1 d-flex justify-content-between text-1 text-light">
            <a class="text-light">{{ $symbol }} Wallet</a>
        </label>
        @if($fromW == '0')
        <form method="POST" action="{{ route('user.wallet.create') }}">
            @csrf
            <input type="hidden" id="symbol" name="symbol" value="{{ $symbol }}">
            <input type="hidden" id="type" name="type" value="trading">
            <button type="submit" class="btn btn-success btn-sm">Create Wallet</button></span>
        </form>
        @else
        <div class="input-group input-group-sm mb-1">
            <input type="number" class="form-control text-white border-0" value="{{ ttz($from_balance) }}" readonly
                aria-label="Amount (to the nearest dollar)">
            <span class="input-group-text text-light border-0">{{ $symbol }}</span>
        </div>
        @endif
        <label for="basic-url"
            class="form-label mb-1 d-flex justify-content-between text-1 text-light">
            <a class="text-light">Fees</a>
        </label>
        <div class="input-group input-group-sm mb-1">
            <input type="number" class="form-control border-0" value="{{ $gnl->exchange_fee }}" readonly>
            <span class="input-group-text text-light border-0">%</span>
        </div>
    </div>
    <div class="col-6">
        <label for="basic-url"
            class="form-label mb-1 d-flex justify-content-between text-1 text-light">
            <a class="text-light">{{ $currency }} Wallet</a>
        </label>
        @if($toW == '0')
        <form method="POST" action="{{ route('user.wallet.create') }}">
            @csrf
            <input type="hidden" id="symbol" name="symbol" value="{{ $currency }}">
            <input type="hidden" id="type" name="type" value="trading">
            <button type="submit" class="btn btn-success btn-sm">Create Wallet</button></span>
        </form>
        @else
        <div class="input-group input-group-sm mb-1">
            <input type="number" class="form-control text-white border-0" value="{{ ttz($to_balance) }}" readonly
                aria-label="Amount (to the nearest dollar)">
            <span class="input-group-text text-light border-0">{{ $currency }}</span>
        </div>
        @endif
    </div>
</div>
