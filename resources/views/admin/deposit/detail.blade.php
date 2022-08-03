@extends('layouts.app')
@section('content')
    <div class="row mb-none-30">
        <div class="col-xl-4 col-md-6 mb-30">
            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">{{ __('locale.Deposit Via')}} {{ __(@$deposit->gateway->name) }}</h5>
                    <div class="p-3 bg--white">
                        <img src="{{ $deposit->gateway_currency()->methodImage() }}" alt="{{ __('locale.Profile Image')}}" class="rounded-2 deposit-imgView">
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Date')}}
                            <span class="fw-bold">{{ showDateTime($deposit->created_at) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Transaction Number')}}
                            <span class="fw-bold">{{ $deposit->trx }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Username')}}
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $deposit->user_id) }}">{{ @$deposit->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Method')}}
                            <span class="fw-bold">{{ __(@$deposit->gateway->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Amount')}}
                            <span class="fw-bold">{{ getAmount($deposit->amount ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Charge')}}
                            <span class="fw-bold">{{ getAmount($deposit->charge ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.After Charge')}}
                            <span class="fw-bold">{{ getAmount($deposit->amount+$deposit->charge ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Rate')}}
                            <span class="fw-bold">1 {{__($general->cur_text)}}
                                = {{ getAmount($deposit->rate) }} {{__($deposit->baseCurrency())}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Payable')}}
                            <span class="fw-bold">{{ getAmount($deposit->final_amo ) }} {{__($deposit->method_currency)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Status')}}
                            @if($deposit->status == 2)
                                <span class="badge rounded-pill bg--warning">{{ __('locale.Pending')}}</span>
                            @elseif($deposit->status == 1)
                                <span class="badge rounded-pill bg--success">{{ __('locale.Approved')}}</span>
                            @elseif($deposit->status == 3)
                                <span class="badge rounded-pill bg--danger">{{ __('locale.Rejected')}}</span>
                            @endif
                        </li>
                        @if($deposit->admin_feedback)
                            <li class="list-group-item">
                                <strong>{{ __('locale.Admin Response')}}</strong>
                                <br>
                                <p>{{__($deposit->admin_feedback)}}</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6 mb-1">
            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body">
                    <h5 class="card-title mb-2 border-bottom pb-2">{{ __('locale.User Deposit Information')}}</h5>
                    @if($details != null)
                        @foreach(json_decode($details) as $k => $val)
                            @if($val->type == 'file')
                                <div class="row mt-4">
                                    <div class="col-md-8">
                                        <h6>{{inputTitle($k)}}</h6>
                                        <img src="{{getImage('assets/images/verify/deposit/'.$val->field_name)}}" alt="{{ __('locale.Image')}}">
                                    </div>
                                </div>
                            @else
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h6>{{inputTitle($k)}}</h6>
                                        <p>{{__($val->field_name)}}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    @if($deposit->status == 2)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button class="btn btn-success ms-1 approveBtn"
                                        data-id="{{ $deposit->id }}"
                                        data-info="{{$details}}"
                                        data-amount="{{ getAmount($deposit->amount)}} {{ __($general->cur_text) }}"
                                        data-username="{{ @$deposit->user->username }}"
                                        data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="{{ __('locale.Approve')}}"><i class="fas fa-check"></i>
                                    {{ __('locale.Approve')}}
                                </button>

                                <button class="btn btn-danger ms-1 rejectBtn"
                                        data-id="{{ $deposit->id }}"
                                        data-info="{{$details}}"
                                        data-amount="{{ getAmount($deposit->amount)}} {{ __($general->cur_text) }}"
                                        data-username="{{ @$deposit->user->username }}"
                                        data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="{{ __('locale.Reject')}}"><i class="fas fa-ban"></i>
                                    {{ __('locale.Reject')}}
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Approve Deposit Confirmation')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.deposit.approve')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure to')}} <span class="fw-bold">{{ __('locale.approve')}}</span> <span class="fw-bold withdraw-amount text-success"></span> {{ __('locale.deposit of')}} <span class="fw-bold withdraw-user"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit" class="btn btn-success">{{ __('locale.Approve')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Reject Deposit Confirmation')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.deposit.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure to')}} <span class="fw-bold">{{ __('locale.reject')}}</span> <span class="fw-bold withdraw-amount text-success"></span> {{ __('locale.deposit of')}} <span class="fw-bold withdraw-user"></span>?</p>

                        <div class="col">
                            <label class="fw-bold mt-2">{{ __('locale.Reason for Rejection')}}</label>
                            <textarea name="message" id="message" placeholder="{{ __('locale.Reason for Rejection')}}" class="form-control" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{ __('locale.Reject')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
@endsection
@push('script')
    <script>
        "use strict";
        $('.approveBtn').on('click', function () {
            var modal = $('#approveModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));
            modal.modal('show');
        });

        $('.rejectBtn').on('click', function () {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));
            modal.modal('show');
        });
    </script>
@endpush
