@extends('layouts.app')
@section('content')

<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Commissions')}}</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead>
                            <th>{{ __('locale.Date')}}</th>
                            <th>{{ __('locale.Username')}}</th>
                            <th>{{ __('locale.TRX')}}</th>
                            <th>{{ __('locale.Amount')}}</th>
                            <th>{{ __('locale.Post Balance')}}</th>
                            <th>{{ __('locale.Detail')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commissions as $commission)
                            <tr>
                                <td data-label="{{ __('locale.Date')}}">{{ showDateTime($commission->created_at) }}</td>
                                <td data-label="{{ __('locale.Username')}}">{{$commission->fromUser->username}}</td>
                                <td data-label="{{ __('locale.TRX')}}" class="fw-bold">{{ $commission->trx }}</td>
                                <td data-label="{{ __('locale.Amount')}}">{{getAmount($commission->amount * getCurrency()->rate)}} {{__(getCurrency()->symbol)}}</td>
                                <td data-label="{{ __('locale.Post Balance')}}">{{ getAmount($commission->post_balance * getCurrency()->rate) }} {{__(getCurrency()->symbol)}}</td>
                                <td data-label="{{ __('locale.Detail')}}">{{ __($commission->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div><div class="mb-1">{{paginateLinks($commissions) }}</div>
    </div>
</div>
@endsection



