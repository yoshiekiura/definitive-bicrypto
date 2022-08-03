@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Wallet Transactions</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('locale.User') }}</th>
                            <th>{{ __('locale.Type') }}</th>
                            <th>{{ __('locale.Info') }}</th>
                            <th>{{ __('locale.Status') }}</th>
                            <th>{{ __('locale.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wallet_trx as $trx)
                        <tr>
                            <td data-label="{{ __('locale.User')}}">
                                <div class="row centerize">
                                    <div class="col-md-3 thumb">
                                        <img src="{{ getImage(imagePath()['profileImage']['path'].'/'. getUser($trx->user_id)->profile_photo_path,imagePath()['profileImage']['size']) }}"
                                            alt="{{ __('locale.image')}}">
                                    </div>
                                    <span class="col-md-9 fw-bold fs-5">{{ getUser($trx->user_id)->username }}</span>
                                </div>
                            </td>
                            <td data-label="{{ __('locale.Type')}}">
                                <span class="fw-bold fs-5">
                                    @if($trx->type == 1)
                                    Deposit
                                    @elseif($trx->type == 2)
                                    Withdraw
                                    @elseif($trx->type == 3)
                                    Transfer From Trading
                                    @elseif($trx->type == 4)
                                    Transfer From Funding
                                    @endif
                                </span>
                            </td>
                            <td data-label="{{ __('locale.Info')}}">
                                <div><span class="text-warning">{{ __('locale.TRX') }}:</span>
                                    {{ $trx->trx }}</div>
                                <div><span class="text-warning">{{ __('locale.Amount') }}:</span>
                                    @if ($trx->amount != 0)
                                    {{ ttz($trx->amount) }} {{ $trx->symbol }}</div>
                                    @else
                                    <span class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
                                    @endif
                                <div><span class="text-warning">{{ __('locale.Charge') }}:</span>
                                    @if ($trx->charge != 0)
                                    {{ ttz($trx->charge) }} {{ $trx->symbol }}</div>
                                    @else
                                    <span class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
                                    @endif
                                <div><span class="text-warning">{{ __('locale.Recieved') }}:</span>
                                    @if ($trx->amount_recieved != 0)
                                    {{ ttz($trx->amount_recieved) }} {{ $trx->symbol }}</div>
                                    @else
                                    <span class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
                                    @endif
                                @if($trx->type == 2)
                                <div><span class="text-warning">{{ __('locale.Processing Fees') }}:</span>
                                    {{ ttz($trx->fees) }} {{ $trx->symbol }}</div>
                                @endif
                                <div><span class="text-warning">Date:</span>
                                    {{ showDateTime($trx->created_at, 'd M, Y h:i:s') }}</div>
                            </td>
                            <td data-label="{{ __('locale.Status')}}">
                                @if($trx->status == 1)
                                <span class="badge rounded-pill badge-light-success me-1">{{ __('locale.Completed') }}</span>
                                @elseif($trx->status == 2)
                                <span class="badge rounded-pill badge-light-warning me-1">{{ __('locale.Pending') }}</span>
                                @elseif($trx->status == 3)
                                <span class="badge rounded-pill badge-light-danger me-1">{{ __('locale.Rejected') }}</span>
                                @endif
                            </td>

                            <td data-label="{{ __('locale.Actions')}}">
                                @if ($trx->type == 4 && $trx->status == 2)
                                <button class="btn btn-icon btn-danger rejectBtn" data-bs-toggle="modal" data-bs-target="#rejectTransfer"
                                    data-trx="{{ $trx->trx }}">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                <button class="btn btn-icon btn-success approveBtn" data-bs-toggle="modal" data-bs-target="#approveTransfer"
                                    data-trx="{{ $trx->trx }}">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($wallet_trx) }}</div>

        </div>
    </div>


    <div class="modal fade" id="approveTransfer">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('locale.Approve Transfer')}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <form class="deposit-form" action="{{route('admin.report.wallet.transfer.funding.approve')}}" method="POST">
                    @csrf
                    <input type="hidden" name="trx">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure you want to approve transfer')}}?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit"
                            class="btn btn-sm btn-success">{{ __('locale.Confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectTransfer" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Transfer Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.report.wallet.transfer.funding.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="trx">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure you want to reject transfer')}}?</p>
                    </div>
                    {{-- <div class="modal-body">
                        <strong>@lang('Reason of Rejection')</strong>
                        <textarea name="details" class="form-control pt-3" rows="3" placeholder="@lang('Provide the Details')" required=""></textarea>
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit" class="btn btn-danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <form action="{{ route('admin.report.'.$page.'.search') }}" method="GET" class=" float-sm-right bg-white">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ __('locale.TRX / Username')}}" value="{{ $search ?? '' }}">
                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </form>
@endpush
@push('script')
    <script>
        $('.approveBtn').on('click', function () {
                var modal = $('#approveTransfer');
                modal.find('input[name=trx]').val($(this).data('trx'));
            });
        $('.rejectBtn').on('click', function () {
                var modal = $('#rejectTransfer');
                modal.find('input[name=trx]').val($(this).data('trx'));
            });
    </script>
@endpush

