<form wire:submit.prevent="submit" class="add-new-record modal-content pt-0">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
    <div class="modal-header mb-1">
        <h5 class="modal-title" id="exampleModalLabel">New Coin</h5>
    </div>
    <div class="modal-body flex-grow-1">
        <div class="mb-1">
            <label class="form-label" for="name">{{ __('locale.Name')}}</label>
            <input type="text" class="form-control" wire:model="name" maxlength="80" name="name" value="{{ old('name') }}"
                placeholder="{{ __('locale.Name')}}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-1">
            <label class="form-label" for="symbol">{{ __('locale.Symbol')}}</label>
            <input type="text" class="form-control" wire:model="symbol" maxlength="30" name="symbol" value="{{old('symbol')}}"
                placeholder="{{ __('locale.Symbol')}}" required>
                @error('symbol') <span class="text-danger">{{ $message }}</span> @enderror
            <small class="form-text"> All Capital Letters </small>
        </div>
            @if ($image)
            <div class="mb-1 d-flex justify-content-between align-items-center">
                <img src="{{ $image->temporaryUrl() }}">
            @else
            <div class="mb-1">
                <label class="form-label" for="image">{{ __('locale.Image')}}</label>
            @endif
            <input class="form-control" name="image" type="file" wire:model="image" required="" />
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div wire:loading wire:target="image" class="text-warning mb-1">Uploading...</div>
        <div class="mb-1">
            <label class="form-label" for="status">{{ __('locale.Status')}} </label>
            <input class="form-check-input" data-width="100%" type="checkbox" data-bs-toggle="toggle"
                data-onstyle="success" data-offstyle="danger" data-on="Enable" data-off="Disable" name="status" wire:model="status">
        </div>
        @if (session()->has('message'))
            <button onClick="window.location.reload();" class="btn btn-outline-secondary">Close</button>
        @else
            @if (auth()->user()->role_id == 1)
                <button type="submit" class="btn btn-outline-primary">Add</button>
            @else
                <button type="submit" class="btn btn-outline-primary" disabled>Add</button>
            @endif
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        @endif
        @if (auth()->user()->role_id == 3)
            <div class="mt-1 p-1 alert alert-danger">
                Action Disabled in Demo
            </div>
        @endif


        @if (session()->has('message'))
            <div class="mt-1 p-1 alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
</form>
