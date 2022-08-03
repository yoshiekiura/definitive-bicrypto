@extends('layouts.app')
@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('locale.Bot Contracts') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.ID') }}</th>
                                <th scope="col">{{ __('locale.User') }}</th>
                                <th scope="col">{{ __('locale.Token') }}</th>
                                <th scope="col">{{ __('locale.TxHash') }}</th>
                                <th scope="col">{{ __('locale.Amount') }}</th>
                                <th scope="col">{{ __('locale.Status') }}</th>
                                <th scope="col">{{ __('locale.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ico_logs as $ico_log)
                                @php
                                    $user_meta = \App\Models\UserMeta::where('user_id', $ico_log->user_id)->first();
                                @endphp
                                <tr>
                                    <td data-label="{{ __('locale.ID') }}">{{ __($loop->iteration) }}</td>
                                    <td data-label="{{ __('locale.User') }}"><a class="badge bg-info"
                                            href="{{ route('admin.users.detail', $ico_log->user_id) }}">{{ $user->where('id', $ico_log->user_id)->first()->username }}</a>
                                    </td>
                                    <td data-label="{{ __('locale.Token') }}" class="text-uppercase">
                                        {{ \App\Models\ICO::where('id', $ico_log->ico_id)->first()->symbol }}</td>
                                    <td data-label="{{ __('locale.TxHash') }}" class="text-uppercase">
                                        @if ($ico_log->status == 0)
                                            <span class="badge bg-warning">{{ __('locale.Pending') }}</span>
                                        @else
                                            <a class="text-nowrap" href="{{ $ico_log->txUrl }}">
                                                {{ $ico_log->txHash }}
                                            </a>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Amount') }}">
                                        <div> {{ __('locale.Amount') }}: <span
                                                class="fw-bold">{{ getAmount($ico_log->amount) }}
                                                {{ \App\Models\ICO::where('id', $ico_log->ico_id)->first()->symbol }}</span>
                                        </div>
                                        <div> {{ __('locale.To Recieve') }}: <span
                                                class="fw-bold">{{ getAmount($ico_log->amount - $ico_log->recieved) }}
                                                {{ \App\Models\ICO::where('id', $ico_log->ico_id)->first()->symbol }}</span>
                                        </div>
                                        <div> {{ __('locale.Recieved') }}: <span class="fw-bold">
                                                @if ($ico_log->status == 0)
                                                    <span class="badge bg-warning">{{ __('locale.Pending') }}</span>
                                                @else
                                                    {{ getAmount($ico_log->recieved) }}
                                                    {{ \App\Models\ICO::where('id', $ico_log->ico_id)->first()->symbol }}
                                                @endif
                                            </span>
                                        </div>
                                        <div> {{ __('locale.Cost') }}: <span class="fw-bold">
                                                {{ getAmount($ico_log->cost) }}
                                                {{ $ico_log->network_symbol }}
                                        </div>
                                    </td>
                                    <td data-label="{{ __('locale.Status') }}">
                                        @if ($ico_log->status == 0)
                                            <span class="badge bg-warning">{{ __('locale.Pending') }}</span>
                                        @elseif($ico_log->status == 1)
                                            <span class="badge bg-success">{{ __('locale.Paid') }}</span>
                                        @elseif($ico_log->status == 2)
                                            <span class="badge bg-danger">{{ __('locale.Cancelled') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Action') }}">
                                        @if ($ico_log->status == 0)
                                            <button class="btn btn-icon btn-success" data-bs-toggle="modal"
                                                data-bs-target="#pay" data-id="{{ $ico_log->id }}"
                                                data-rec_wallet="{{ $ico_log->rec_wallet }}"
                                                onclick="$('#pay').find('input[name=id]').val($(this).data('id'));$('#pay').find('input[name=rec_wallet]').val($(this).data('rec_wallet'));">
                                                {{ __('locale.Pay') }}
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
                </div>
            </div>
            <div class="mb-1">{{ paginateLinks($ico_logs) }}</div>
        </div>
    </div>
    <div class="modal modal-slide-in fade" id="pay">
        <div class="modal-dialog sidebar-sm">
            <form class="add-new-record modal-content pt-0" action="{{ route('admin.ico.pay') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id" name="id">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Pay Tokens</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="mb-1">
                        <label class="form-label" for="rec_wallet">Client Recieving Wallet</label>
                        <input type="text" class="form-control" name="rec_wallet" disabled>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="txHash">Transaction Hash</label>
                        <input type="text" class="form-control txHash" id="txHash" maxlength="80" name="txHash"
                            value="{{ old('txHash') }}" placeholder="{{ __('locale.TxHash') }}" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="txUrl">Transaction Url</label>
                        <input type="text" class="form-control txUrl" id="txUrl" maxlength="80" name="txUrl"
                            value="{{ old('txUrl') }}" placeholder="txUrl" required>
                    </div>
                    <button type="submit" class="btn btn-primary data-submit me-1">Pay</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
