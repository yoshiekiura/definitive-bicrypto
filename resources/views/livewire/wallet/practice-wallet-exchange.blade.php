<form wire:submit.prevent="practice">
    <div class="row mb-1">
        <div class="col">
            <label class="form-label" for="from">From</label>
            <select class="form-select border-light" wire:model="from" id="from">
                <option selected></option>
                <option value="USD" wire:click="emit('towhat')">USD</option>
                <option value="BTC" wire:click="emit('towhat')">BTC</option>
            </select>
        </div>
        <div class="col">
            <label class="form-label">To</label>
            <div class="rounded border-dark" style="padding:10px;">{{ $to }}</div>
        </div>
    </div>
    <div class="input-group mb-2 border-primary rounded">
        <span class="input-group-text" id="basic-addon2">1 BTC = </span>
        <input type="text" class="form-control" readonly value="$ {{ $p_btc }}" />

    </div>
    <div class="mb-1">
        <label class="form-label" for="amount">{{ __('locale.Amount To Exchange')}}</label>
        <input type="text" class="form-control" wire:model="amount" maxlength="80" name="amount"
            value="{{ old('amount') }}" placeholder="{{ __('locale.amount')}}" required>
        @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <button type="submit" class="btn btn-outline-warning">Exchange</button>

    @if (session()->has('message_success'))
        <div class="mt-1 p-1 alert alert-success">
            {{ session('message_success') }}
        </div>
    @elseif (session()->has('message_failed'))
        <div class="mt-1 p-1 alert alert-danger">
            {{ session('message_failed') }}
        </div>
    @else
    @endif
</form>
