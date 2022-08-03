@extends('layouts.app')
@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Commissions</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Date')}}</th>
                                <th scope="col">{{ __('locale.Username')}}</th>
                                <th scope="col">{{ __('locale.From Username')}}</th>
                                <th scope="col">{{ __('locale.TRX')}}</th>
                                <th scope="col">{{ __('locale.Amount')}}</th>
                                <th scope="col">{{ __('locale.Post Balance')}}</th>
                                <th scope="col">{{ __('locale.Detail')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($commissions as $value)
                                <tr>
                                    <td data-label="{{ __('locale.Date')}}">{{ showDateTime($value->created_at) }}</td>
                                    <td data-label="{{ __('locale.Username')}}">
                                        <a href="{{ route('admin.users.detail', $value->user_id) }}">{{ @$value->user->username }}</a>
                                    </td>
                                     <td data-label="{{ __('locale.From Username')}}">
                                        <a href="{{ route('admin.users.detail', $value->from_user_id) }}">{{ @$value->fromUser->username }}</a>
                                    </td>
                                    <td data-label="{{ __('locale.TRX')}}">{{ $value->trx }}</td>
                                    <td data-label="{{ __('locale.Amount')}}">
                                        {{getAmount($value->amount)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="{{ __('locale.Post Balance')}}">{{ getAmount($value->post_balance) }} {{__($general->cur_text)}}</td>
                                    <td data-label="{{ __('locale.Detail')}}">{{ __($value->details) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($commissions) }}</div>

        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <form action="{{route('admin.report.commission.search')}}" method="GET" class=" float-sm-right bg--white">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ __('locale.TRX / Username / From Username')}}" value="{{ $search ?? '' }}">
            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </form>
@endpush


