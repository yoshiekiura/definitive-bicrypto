<div>
    <label for="basic-url"
        class="form-label mb-1 d-flex justify-content-between text-1 text-light">
        <a class="text-light">Practice Wallet</a>
    </label>
    <div class="input-group input-group-sm mb-1">
        <input type="number" class="form-control text-white border-0" value="{{ ttz(getUser(auth()->user()->id)->practice_balance) }}" readonly
            aria-label="Amount (to the nearest dollar)">
        <span class="input-group-text text-light border-0">{{ $currency }}</span>
    </div>

    <label for="basic-url"
        class="form-label mb-1 d-flex justify-content-between text-1 text-light">
        <a class="text-light">Profit</a>
    </label>
    <div class="input-group input-group-sm mb-1">
        <input type="number" class="form-control border-0" value="{{ ttz(getGen()->profit) }}" readonly>
        <span class="input-group-text text-light border-0">%</span>
    </div>
</div>
