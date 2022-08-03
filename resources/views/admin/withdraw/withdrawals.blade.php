@extends('layouts.app')
@section('vendor-style')
  {{-- vendor css files --}}
        <!-- datepicker css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css">
@endsection
@section('content')
        <div class="row" id="table-hover-row">
            @if(request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.method') || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.users.withdrawals.method'))
            <div class="col-xl-4 col-sm-6 mb-30">
                <div class="widget-two shadow rounded px-2 py-1 mb-1  bg-success">
                <div class="widget-two__content">
                    <h2 class="text-white">{{ __($general->cur_sym) }}{{ $withdrawals->where('status',1)->sum('amount') }}</h2>
                    <p class="text-white">@lang('Approved Withdrawals')</p>
                </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xl-4 col-sm-6 mb-30">
                <div class="widget-two shadow rounded px-2 py-1 mb-1  bg-6">
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ $withdrawals->where('status',2)->sum('amount') }}</h2>
                        <p class="text-white">@lang('Pending Withdrawals')</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xl-4 col-sm-6 mb-30">
                <div class="widget-two shadow rounded px-2 py-1 mb-1  bg-pink">
                <div class="widget-two__content">
                    <h2 class="text-white">{{ __($general->cur_sym) }}{{ $withdrawals->where('status',3)->sum('amount') }}</h2>
                    <p class="text-white">@lang('Rejected Withdrawals')</p>
                </div>
                </div><!-- widget-two end -->
            </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Withdrawals</h4><div class="card-search"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover custom-data-bs-table">
                            <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Date')}}</th>
                                <th scope="col">@lang('Trx Number')</th>
                                @if(!request()->routeIs('admin.users.withdrawals') && !request()->routeIs('admin.users.withdrawals.method'))
                                <th scope="col">{{ __('locale.Username')}}</th>
                                @endif
                                <th scope="col">{{ __('locale.method')}}</th>
                                <th scope="col">{{ __('locale.Amount')}}</th>
                                <th scope="col">{{ __('locale.Charge')}}</th>
                                <th scope="col">@lang('After Charge')</th>
                                <th scope="col">{{ __('locale.Rate')}}</th>
                                <th scope="col">@lang('Payable')</th>
                                @if(request()->routeIs('admin.withdraw.pending'))
                                    <th scope="col">{{ __('locale.Action')}}</th>
                                @elseif(request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.search')  || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.withdraw.method'))
                                    <th scope="col">{{ __('locale.Status')}}</th>
                                @endif

                                @if(request()->routeIs('admin.withdraw.approved') || request()->routeIs('admin.withdraw.rejected') || request()->routeIs('admin.users.withdrawals.method'))
                                    <th scope="col">@lang('Info')</th>
                                @endif

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($withdrawals as $withdraw)
                                @php
                                    $details = ($withdraw->withdraw_information != null) ? json_encode($withdraw->withdraw_information) : null;
                                @endphp
                                <tr>
                                    <td data-label="{{ __('locale.Date')}}">{{ showDateTime($withdraw->created_at) }}</td>
                                    <td data-label="@lang('Trx Number')" class="fw-bold">{{ strtoupper($withdraw->trx) }}</td>
                                    @if(!request()->routeIs('admin.users.withdrawals') && !request()->routeIs('admin.users.withdrawals.method'))
                                    <td data-label="{{ __('locale.Username')}}">
                                        <a href="{{ route('admin.users.detail', $withdraw->user_id) }}">{{ @$withdraw->user->username }}</a>
                                    </td>
                                    @endif
                                    <td data-label="{{ __('locale.method')}}">
                                        @if(request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.users.withdrawals'))
                                       <a href="{{ route('admin.users.withdrawals.method',[$withdraw->method->id,@$type?$type:'all',$userId]) }}"> {{ __(@$withdraw->method->name) }}</a>
                                       @else
                                       <a href="{{ route('admin.withdraw.method',[$withdraw->method->id,@$type]) }}"> {{ __(@$withdraw->method->name) }}</a>
                                       @endif
                                    </td>
                                    <td data-label="{{ __('locale.Amount')}}" class="budget fw-bold">{{ getAmount($withdraw->amount) }} {{__($general->cur_text)}}</td>
                                    <td data-label="{{ __('locale.Charge')}}" class="budget text-danger">{{ getAmount($withdraw->charge) }} {{__($general->cur_text)}}</td>
                                    <td data-label="@lang('After Charge')" class="budget">{{ getAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</td>
                                    <td data-label="{{ __('locale.Rate')}}" class="budget">{{ getAmount($withdraw->rate) }}  {{__($withdraw->currency)}}</td>

                                    <td data-label="@lang('Payable')" class="budget fw-bold">{{ getAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }} </td>
                                    @if(request()->routeIs('admin.withdraw.pending'))

                                        <td data-label="{{ __('locale.Action')}}">
                                            <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="btn btn-icon btn-info  btn-sm " data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('locale.Detail')}}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    @elseif(request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.search') || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.withdraw.method') ||  request()->routeIs('admin.users.withdrawals.method'))
                                        <td data-label="{{ __('locale.Status')}}">
                                            @if($withdraw->status == 2)
                                                <span class="text-small badge fw-normal bg-warning">{{ __('locale.Pending')}}</span>
                                            @elseif($withdraw->status == 1)
                                                <span class="text-small badge fw-normal bg-success">@lang('Approved')</span>
                                            @elseif($withdraw->status == 3)
                                                <span class="text-small badge fw-normal bg-danger">@lang('Rejected')</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if(request()->routeIs('admin.withdraw.approved') || request()->routeIs('admin.withdraw.rejected'))
                                        <td data-label="@lang('Info')">
                                            <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="btn btn-icon btn-info ms-1 " data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('locale.Detail')}}">
                                                <i class="bi bi-desktop"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($withdrawals) }}</div>
        </div>
    </div>

@endsection

@section('vendor-script')
{{-- vendor files --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/i18n/datepicker.en-US.min.js"></script>
@endsection


@push('breadcrumb-plugins')

    @if(!request()->routeIs('admin.users.withdrawals') && !request()->routeIs('admin.users.withdrawals.method'))
    <div class="row">
        <div class="col">
        <form action="{{ route('admin.withdraw.search', $scope ?? str_replace('admin.withdraw.', '', request()->route()->getName())) }}"
            method="GET" class=" float-sm-right bg-white">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="@lang('Withdrawal code/Username')" value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
    <div class="col">
        <form action="{{route('admin.withdraw.dateSearch',$scope ?? str_replace('admin.withdraw.', '', request()->route()->getName()))}}" method="GET" class=" float-sm-right bg-white me-0 me-xl-2 me-lg-0">
            <div class="input-group">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min Date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
                <input type="hidden" name="method" value="{{ @$method->id }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>
    @endif
@endpush
@push('script')
  <script>
    "use strict";
      // date picker
      $('.datepicker-here').datepicker();
       $('.datepicker-here').val(new Date())selectDate(new Date($('.datepicker-here').val()));
  </script>
@endpush
