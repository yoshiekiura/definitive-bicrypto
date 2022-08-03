@foreach ($contracts as $contract)
<div class="card @if ($contract->result == 1) bg-light-danger  @else bg-light-success @endif">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <small class="text-light">{{ __('locale.Profit/Loss')}}:</small><br><div class="@if($contract->result == 1) text-danger @else text-success @endif"><b>@if($contract->result == 1)- @else + @endif{{ $contract->amount * ($gnl->profit/100) }}</b></div>
            </div>
            <div class="col text-light">
                <small>{{ __('locale.Type')}}:</small><br>@if($contract->hilow == 1)<b class="text-success"><i class="bi bi-arrow-up"></i> {{ __('locale.Rise')}}</b>@else <b class="text-danger"><i class="bi bi-arrow-down"></i> {{ __('locale.Fall')}}</b>@endif
            </div>
        </div>
        <div class="row mt-1">
            <div class="col text-light">
                <small>{{ __('locale.Buy')}}:</small><br><b>{{ getAmount($contract->amount) }}</b>
            </div>
            <div class="col text-light">
                <small>{{ __('locale.Sell')}}:</small><br><b>{{ $contract->amount + ($contract->amount * ($gnl->profit/100)) }}</b>
            </div>
        </div>
    </div>
</div>
@endforeach
