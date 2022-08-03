<div class="card-body" style="max-height:75vh;overflow-y:auto;">
    @foreach ($contracts as $contract)
        <div class="card mb-1 @if ($contract->result == 1) bg-light-danger  @else bg-light-success @endif">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <small class="text-light">Profit/Loss:</small><br>
                        <div class="@if($contract->result == 1) text-danger @else text-success @endif">
                            <b>@if($contract->result == 1)- @else + @endif{{ $contract->amount * ($gnl->profit/100) }}</b></div>
                    </div>
                    <div class="col text-light">
                        <small>Type:</small><br>@if($contract->result == 1)<b class="text-success"><i
                                class="bi bi-arrow-up"></i> Rise</b>@else <b class="text-danger"><i
                                class="bi bi-arrow-down"></i> Fall</b>@endif
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col text-light">
                        <small>Buy:</small><br><b>{{ getAmount($contract->amount) }}</b>
                    </div>
                    <div class="col text-light">
                        <small>Sell:</small><br><b>{{ $contract->amount + ($contract->amount * ($gnl->profit/100)) }}</b>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
