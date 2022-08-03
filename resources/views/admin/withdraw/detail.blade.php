@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Withdraw Via') {{__(@$withdrawal->method->name)}}</h5>

                    <img class="img-thumbnail img-fluid" src="{{$methodImage}}" alt="{{ __('locale.image')}}" class="rounded-2 withdraw-detailImage" >


                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Date')}}
                            <span class="fw-bold">{{ showDateTime($withdrawal->created_at) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Trx Number')
                            <span class="fw-bold">{{ $withdrawal->trx }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Username')}}
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $withdrawal->user_id) }}">{{ @$withdrawal->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.method')}}
                            <span class="fw-bold">{{__($withdrawal->method->name)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Amount')}}
                            <span class="fw-bold">{{ getAmount($withdrawal->amount ) }} {{ __($general->cur_text) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Charge')}}
                            <span class="fw-bold">{{ getAmount($withdrawal->charge ) }} {{ __($general->cur_text) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('After Charge')
                            <span class="fw-bold">{{ getAmount($withdrawal->after_charge ) }} {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Rate')}}
                            <span class="fw-bold">1 {{__($general->cur_text)}}
                                = {{ getAmount($withdrawal->rate ) }} {{__($withdrawal->currency)}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Payable')
                            <span class="fw-bold">{{ getAmount($withdrawal->final_amount) }} {{__($withdrawal->currency)}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Status')}}
                            @if($withdrawal->status == 2)
                                <span class="badge rounded-pill bg-warning">{{ __('locale.Pending')}}</span>
                            @elseif($withdrawal->status == 1)
                                <span class="badge rounded-pill bg-success">@lang('Approved')</span>
                            @elseif($withdrawal->status == 3)
                                <span class="badge rounded-pill bg-danger">@lang('Rejected')</span>
                            @endif
                        </li>

                        @if($withdrawal->admin_feedback)
                        <li class="list-group-item">
                            <strong>@lang('Admin Response')</strong>
                            <br>
                           <p>{{$withdrawal->admin_feedback}}</p>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-6">

            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">@lang('User Withdraw Information')</h5>


                    @if($details != null)
                        @foreach(\GuzzleHttp\json_decode($details) as $k => $val)
                            @if($val->type == 'file')
                                <div class="row mt-2">
                                    <div class="col-md-8">
                                        <h6>{{__(inputTitle($k))}}</h6>
                                        <img src="{{getImage('assets/images/verify/withdraw/'.$val->field_name)}}" alt="{{ __('locale.image')}}">
                                    </div>
                                </div>
                            @else
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h6>{{__(inputTitle($k))}}</h6>
                                        <p>{{$val->field_name}}</p>
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    @endif


                    @if($withdrawal->status == 2)
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button class="btn btn-success ms-1 approveBtn" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="@lang('Approve')"
                                        data-id="{{ $withdrawal->id }}" data-amount="{{ getAmount($withdrawal->final_amount) }} {{$withdrawal->currency}}">
                                    <i class="fas la-check"></i> @lang('Approve')
                                </button>

                                <button class="btn btn-danger ms-1 rejectBtn" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="@lang('Reject')"
                                        data-id="{{ $withdrawal->id }}" data-amount="{{ getAmount($withdrawal->final_amount) }} {{__($withdrawal->currency)}}">
                                    <i class="fas fa-ban"></i> @lang('Reject')
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
                    <h5 class="modal-title">@lang('Approve Withdrawal Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.withdraw.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Have you Sent') <span class="fw-bold withdraw-amount text-success"></span>?</p>
                        <p class="withdraw-detail"></p>
                        <textarea name="details" class="form-control pt-3" rows="3" placeholder="@lang('Provide the Details. eg: Transaction number')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit" class="btn btn-success">@lang('Approve')</button>
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
                    <h5 class="modal-title">@lang('Reject Withdrawal Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.withdraw.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <strong>@lang('Reason of Rejection')</strong>
                        <textarea name="details" class="form-control pt-3" rows="3" placeholder="@lang('Provide the Details')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit" class="btn btn-danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function () {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.modal('show');
            });

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.modal('show');
            });
        });

    </script>
@endpush
