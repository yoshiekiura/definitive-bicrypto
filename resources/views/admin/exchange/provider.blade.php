@extends('layouts.app')
@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Thirdparty Trade Logs')}}</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.User')}}</th>
                            <th scope="col">{{ __('locale.Info')}}</th>
                            <th scope="col">{{ __('locale.Amount')}}</th>
                            <th scope="col">{{ __('locale.State')}}</th>
                            <th scope="col">{{ __('locale.Status')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tradeLogs as $log)
                        <tr>
                            <td data-label="{{ __('locale.User')}}"><a class="badge bg-info" href="{{ route('admin.users.detail', $log->user_id) }}">{{ $user->where('id',$log->user_id)->first()->username; }}</a></td>
                            <td data-label="{{ __('locale.Info')}}">
                                <div> {{ __('locale.Symbol')}}: <span class="fw-bold">{{$log->symbol}}</span></div>
                                <div> {{ __('locale.Type')}}: <span class="fw-bold">{{ strtoUpper($log->type) }}</span></div>
                                <div> {{ __('locale.Side')}}: <span class="fw-bold">
                                    @if($log->side == 'buy')
                                        <span class="badge bg-success">{{ __('locale.Buy')}}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('locale.Sell')}}</span>
                                    @endif </span>
                                </div>
                                <div> {{ __('locale.Provider')}}: <span class="fw-bold">{{ strtoUpper($log->provider) }}</span></div>
                            </td>
                            <td data-label="{{ __('locale.Amount')}}">
                                <div> {{ __('locale.Price')}}: <span class="fw-bold text-success">{{ ttz($log->price) }}</span> {{ getPair($log->symbol)[1] }}</div>
                                <div> {{ __('locale.Stop Price')}}: <span class="fw-bold">{{ ttz($log->stopPrice) }}</span> {{ getPair($log->symbol)[1] }}</div>
                                <div> {{ __('locale.Amount')}}: <span class="fw-bold">{{ ttz($log->amount) }}</span> {{ getPair($log->symbol)[0] }}</div>
                                <div> {{ __('locale.Cost')}}: <span class="fw-bold text-danger">{{ ttz($log->cost) }}</span> {{ getPair($log->symbol)[1] }}</div>
                                <div> {{ __('locale.Processing Fee')}}: <span class="fw-bold text-danger">{{ ttz($log->amount * (getGen()->exchange_fee / 100)) }}</span> {{ getPair($log->symbol)[0] }}</div>
                            </td>
                            <td data-label="{{ __('locale.State')}}">
                                <div> {{ __('locale.Filled')}}: <span class="fw-bold text-success">{{ ttz($log->filled) }}</span> {{ getPair($log->symbol)[0] }}</div>
                                <div> {{ __('locale.Remaining')}}: <span class="fw-bold text-danger">{{ ttz($log->remaining) }}</span> {{ getPair($log->symbol)[0] }}</div>
                            </td>
                            <td data-label="{{ __('locale.Status')}}">
                                @if($log->status == 'open')
                                    <span class="badge bg-primary">{{ __('locale.Live')}}</span>
                                @elseif($log->status == 'closed')
                                    <span class="badge bg-success">{{ __('locale.Filled')}}</span>
                                @elseif($log->status == 'filling')
                                    <span class="badge bg-warning">{{ __('locale.Filling')}}</span>
                                @elseif($log->status == 'canceled')
                                    <span class="badge bg-danger">{{ __('locale.Canceled')}}</span>
                                @endif </span>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
        </div>
        <div class="mb-1">{{paginateLinks($tradeLogs) }}</div>
    </div>
</div>
@endsection
