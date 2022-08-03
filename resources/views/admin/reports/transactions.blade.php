@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Transactions</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Date')}}</th>
                                <th scope="col">{{ __('locale.TRX')}}</th>
                                <th scope="col">{{ __('locale.Username')}}</th>
                                <th scope="col">{{ __('locale.Amount')}}</th>
                                <th scope="col">{{ __('locale.Charge')}}</th>
                                <th scope="col">{{ __('locale.Post Balance')}}</th>
                                <th scope="col">{{ __('locale.Detail')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td data-label="{{ __('locale.Date')}}">{{ showDateTime($trx->created_at) }}</td>
                                    <td data-label="{{ __('locale.TRX')}}" class="fw-bold">{{ $trx->trx }}</td>
                                    <td data-label="{{ __('locale.Username')}}"><a href="{{ route('admin.users.detail', $trx->user_id) }}">{{ @$trx->user->username }}</a></td>
                                    <td data-label="{{ __('locale.Amount')}}" class="budget">
                                        <strong @if($trx->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($trx->trx_type == '+') ? '+':'-'}} {{getAmount($trx->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="{{ __('locale.Charge')}}" class="budget">{{ __(__($general->cur_sym)) }} {{ getAmount($trx->charge) }} </td>
                                    <td data-label="{{ __('locale.Post Balance')}}">{{ getAmount($trx->post_balance) }} {{__($general->cur_text)}}</td>
                                    <td data-label="{{ __('locale.Detail')}}">{{ __($trx->details) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($transactions) }}</div>

        </div>
    </div>



@endsection


@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.users.transactions'))
        <form action="" method="GET" class=" float-sm-right bg--white">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="{{ __('locale.TRX / Username')}}" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    @else
        <form action="{{ route('admin.report.transaction.search') }}" method="GET" class=" float-sm-right bg--white">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="{{ __('locale.TRX / Username')}}" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    @endif
@endpush


