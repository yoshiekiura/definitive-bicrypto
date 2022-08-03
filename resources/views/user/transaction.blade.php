@extends('layouts.app')
@section('content')

<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Transactions')}}</h4>
                <div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead>
                        <th>{{ __('locale.Date')}}</th>
                        <th>{{ __('locale.TRX')}}</th>
                        <th>{{ __('locale.Amount')}}</th>
                        <th>{{ __('locale.Charge')}}</th>
                        <th>{{ __('locale.Post Balance')}}</th>
                        <th>{{ __('locale.Detail')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td data-label="{{ __('locale.Date')}}">{{ showDateTime($trx->created_at) }}</td>
                            <td data-label="{{ __('locale.TRX')}}" class="fw-bold">{{ Str::limit($trx->trx, 15,'...') }}
                            </td>
                            <td data-label="{{ __('locale.Amount')}}" class="budget">
                                <strong @if($trx->trx_type == '+') class="text-success" @else class="text-danger"
                                    @endif> {{($trx->trx_type == '+') ? '+':'-'}}
                                    {{getAmount($trx->amount) * getCurrency()->rate}}
                                    {{ $trx->currency ? $trx->currency : getCurrency()->symbol }}</strong>
                            </td>
                            <td data-label="{{ __('locale.Charge')}}" class="budget">
                                {{ getAmount($trx->charge * getCurrency()->rate) }} {{ $trx->currency ? $trx->currency : getCurrency()->symbol }} </td>
                            <td data-label="{{ __('locale.Post Balance')}}">
                                {{ getAmount($trx->post_balance * getCurrency()->rate) }}
                                {{ $trx->currency ? $trx->currency : getCurrency()->symbol }}</td>
                            <td data-label="{{ __('locale.Detail')}}">{{ __($trx->details) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
        <div class="mb-1">{{paginateLinks($transactions) }}</div>
    </div>
</div>
@endsection



