@extends('layouts.app')
@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('locale.Deposit History') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead>
                            <th>{{ __('locale.Transaction ID') }}</th>
                            <th>{{ __('locale.Gateway') }}</th>
                            <th>{{ __('locale.Amount') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Date') }}</th>
                            <th> {{ __('locale.Details') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $k=>$data)
                                <tr>
                                    <td data-label="#{{ __('locale.TRX') }}">{{ $data->trx }}</td>
                                    <td data-label="{{ __('locale.Gateway') }}">{{ __(@$data->gateway->name) }}</td>
                                    <td data-label="{{ __('locale.Amount') }}">
                                        <strong>{{ getAmount($data->amount * getCurrency()->rate) }}
                                            {{ __(getCurrency()->symbol) }}</strong>
                                    </td>
                                    <td>
                                        @if ($data->status == 1)
                                            <span class="badge bg-success">{{ __('locale.Complete') }}</span>
                                        @elseif($data->status == 2)
                                            <span class="badge bg-primary">{{ __('locale.Pending') }}</span>
                                        @elseif($data->status == 3)
                                            <span class="badge bg-danger">{{ __('locale.Cancel') }}</span>
                                        @endif

                                        @if ($data->admin_feedback != null)
                                            <button class="btn-info btn-rounded  badge detailBtn"
                                                data-admin_feedback="{{ $data->admin_feedback }}"><i
                                                    class="bi bi-info-circle"></i></button>
                                        @endif

                                    </td>
                                    <td data-label="{{ __('locale.Date') }}">
                                        {{ showDateTime($data->created_at, 'd M Y') }}
                                    </td>

                                    @php
                                        $details = $data->detail != null ? json_encode($data->detail) : null;
                                    @endphp

                                    <td data-label="{{ __('locale.Details') }}">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-icon approveBtn"
                                            data-info="{{ $details }}" data-id="{{ $data->id }}"
                                            data-amount="{{ getAmount($data->amount * getCurrency()->rate) }} {{ __(getCurrency()->symbol) }}"
                                            data-charge="{{ getAmount($data->charge * getCurrency()->rate) }} {{ __(getCurrency()->symbol) }}"
                                            data-after_charge="{{ getAmount(($data->amount + $data->charge) * getCurrency()->rate) }} {{ __(getCurrency()->symbol) }}"
                                            data-rate="{{ getAmount($data->rate) }} {{ getCurrency()->symbol }} = 1 {{ __($gnl->cur_sym) }}"
                                            data-payable="{{ getAmount($data->final_amo) }} {{ __($data->method_currency) }}">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%"> {{ __('locale.No results found') }}!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="mb-1">{{ paginateLinks($logs) }}</div>
        </div>
    </div>


    <div class="modal fade custom--modal" id="approveModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('locale.Details') }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group text-center list--group">
                        <li class="list-group-item">{{ __('locale.Amount') }} : <span class="withdraw-amount "></span>
                        </li>
                        <li class="list-group-item">{{ __('locale.Charge') }} : <span class="withdraw-charge "></span>
                        </li>
                        <li class="list-group-item">{{ __('locale.After Charge') }} : <span
                                class="withdraw-after_charge"></span></li>
                        <li class="list-group-item">{{ __('locale.Conversion Rate') }} : <span
                                class="withdraw-rate"></span></li>
                        <li class="list-group-item">{{ __('locale.Payable Amount') }} : <span
                                class="withdraw-payable"></span></li>
                    </ul>
                    <ul class="list-group withdraw-detail mt-1 text-center list--group"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm text--white btn-danger"
                        data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";
        $('.approveBtn').on('click', function() {
            var modal = $('#approveModal');
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-charge').text($(this).data('charge'));
            modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
            modal.find('.withdraw-rate').text($(this).data('rate'));
            modal.find('.withdraw-payable').text($(this).data('payable'));
            var list = [];
            var details = Object.entries($(this).data('info'));

            var ImgPath = "{{ asset(imagePath()['verify']['deposit']['path']) }}/";
            var singleInfo = '';
            for (var i = 0; i < details.length; i++) {
                if (details[i][1].type == 'file') {
                    singleInfo += `<li class="list-group-item">
                                        <span class="fw-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="{{ __('locale.image') }}" class="w-100">
                                    </li>`;
                } else {
                    singleInfo += `<li class="list-group-item">
                                        <span class="fw-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="fw-bold ms-3">${details[i][1].field_name}</span>
                                    </li>`;
                }
            }

            if (singleInfo) {
                modal.find('.withdraw-detail').html(
                    `<br><strong class="my-3">{{ __('locale.Payment Information') }}</strong>  ${singleInfo}`);
            } else {
                modal.find('.withdraw-detail').html(`${singleInfo}`);
            }
            modal.modal('show');
        });

        $('.detailBtn').on('click', function() {
            var modal = $('#detailModal');
            var feedback = $(this).data('admin_feedback');
            modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
            modal.modal('show');
        });
    </script>
@endpush
