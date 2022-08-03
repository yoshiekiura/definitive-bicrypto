<div>
    <label for="basic-url"
        class="form-label mb-1 d-flex justify-content-between text-1 text-light">
        <a class="text-light">{{ $currency }} Wallet</a>
    </label>
    @if($toW == null)
    <form method="POST" action="{{ route('user.wallet.create') }}">
        @csrf
        <input type="hidden" id="symbol" name="symbol" value="{{ $currency }}">
        <input type="hidden" id="type" name="type" value="funding">
        <button type="submit" class="btn btn-success btn-sm mb-1">Create Funding Wallet</button></span>
    </form>
    @else
    <div class="input-group input-group-sm mb-1">
        <input type="number" class="form-control text-white border-0" value="{{ ttz($toW->balance) }}" readonly>
        <span class="input-group-text text-light border-0">{{ $currency }}</span>
    </div>
    @endif

    <label for="basic-url"
        class="form-label mb-1 d-flex justify-content-between text-1 text-light">
        <a class="text-light">Profit</a>
    </label>
    <div class="input-group input-group-sm mb-1">
        <input type="number" class="form-control border-0" value="{{ ttz(getGen()->profit) }}" readonly>
        <span class="input-group-text text-light border-0">%</span>
    </div>
</div>
