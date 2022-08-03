@extends('layouts.app')
@section('content')

<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Withdrawal Logs')}}</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead>
                        <tr>
                            <th>{{ __('locale.Transaction ID')}}</th>
                            <th>{{ __('locale.Gateway')}}</th>
                            <th>{{ __('locale.Amount')}}</th>
                            <th>{{ __('locale.Charge')}}</th>
                            <th>{{ __('locale.After Charge')}}</th>
                            <th>{{ __('locale.Rate')}}</th>
                            <th>{{ __('locale.Receivable')}}</th>
                            <th>{{ __('locale.Status')}}</th>
                            <th>{{ __('locale.Time')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdraws as $k=>$data)
                                <tr>
                                    <td data-label="#{{ __('locale.TRX')}}">{{$data->trx}}</td>
                                    <td data-label="{{ __('locale.Gateway')}}">{{ __($data->method->name) }}</td>
                                    <td data-label="{{ __('locale.Amount')}}">
                                        <strong>{{getAmount($data->amount)}} {{__(getCurrency()->symbol)}}</strong>
                                    </td>
                                    <td data-label="{{ __('locale.Charge')}}" class="text-danger">
                                        {{getAmount($data->charge)}} {{__(getCurrency()->symbol)}}
                                    </td>
                                    <td data-label="{{ __('locale.After Charge')}}">
                                        {{getAmount($data->after_charge)}} {{__(getCurrency()->symbol)}}
                                    </td>
                                    <td data-label="{{ __('locale.Rate')}}">
                                        {{getAmount($data->rate)}} {{__($data->currency)}}
                                    </td>
                                    <td data-label="{{ __('locale.Receivable')}}" class="text-success">
                                        <strong>{{getAmount($data->final_amount)}} {{__($data->currency)}}</strong>
                                    </td>
                                    <td data-label="{{ __('locale.Status')}}">
                                        <div class="d-flex justify-content-between">
                                        @if($data->status == 2)
                                            <span class="badge bg-primary">{{ __('locale.Pending')}}</span>
                                        @elseif($data->status == 1)
                                            <span class="badge bg-success">{{ __('locale.Completed')}}</span>
                                            <button class="btn btn-icon btn-info btn-sm approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="bi bi-info-circle"></i></button>
                                        @elseif($data->status == 3)
                                            <span class="badge bg-danger">{{ __('locale.Rejected')}}</span>
                                            <button class="btn btn-icon btn-info btn-sm approveBtn" data-admin_feedback="{{$data->admin_feedback}}"><i class="bi bi-info-circle"></i></button>
                                        @endif
                                        </div>
                                    </td>

                                    <td data-label="{{ __('locale.Time')}}">
                                        <i class="bi bi-calendar"></i>{{showDateTime($data->created_at)}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
            </div>

        </div><div class="mb-1">{{paginateLinks($withdraws) }}</div>
    </div>
</div>

<div id="detailModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Details')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="withdraw-detail"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm text-white btn-danger" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>

            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    "use strict";
    $('.approveBtn').on('click', function() {
        var modal = $('#detailModal');
        var feedback = $(this).data('admin_feedback');

        modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
        modal.modal('show');
    });
</script>
@endpush
