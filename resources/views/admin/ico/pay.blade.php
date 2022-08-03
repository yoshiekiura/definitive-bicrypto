@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('locale.Token Sale') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="card-body">
                    @php
                        $user_meta = \App\Models\UserMeta::where('user_id', $ico_log->user_id)->first();
                    @endphp
                    <div class="d-flex justify-content-between align-items-center my-1 p-1 shadow rounded border-secondary">
                        <div class="">{{ __('locale.User') }}</div>
                        <a class="badge bg-info" href="{{ route('admin.users.detail', $ico_log->user_id) }}">
                            {{ $user->where('id', $ico_log->user_id)->first()->username }}</a>
                    </div>
                    <div
                        class="text-uppercase d-flex justify-content-between align-items-center my-1 p-1 shadow rounded border-secondary">
                        <div class="">{{ __('locale.Token') }}</div>
                        <div class="">{{ \App\Models\ICO::where('id', $ico_log->ico_id)->first()->symbol }}</div>
                    </div>
                    <div
                        class="text-uppercase d-flex justify-content-between align-items-center my-1 p-1 shadow rounded border-secondary">
                        {{ __('locale.TxHash') }}
                        @if ($ico_log->txHash == null)
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#payToken"
                                data-id="{{ $ico_log->id }}" data-inp_amount="{{ $ico_log->ico_amount }}"
                                onclick="$('#payToken').find('input[name=id]').val($(this).data('id'));
                                        $('#payToken').find('input[name=inp_amount]').val($(this).data('inp_amount'));">
                                {{ __('locale.Pay') }}
                            </button>
                        @else
                            <a class="text-nowrap" href="https://testnet.bscscan.com/tx/{{ $ico_log->txHash }}">
                                {{ $ico_log->txHash }}
                            </a>
                        @endif
                    </div>
                    <div class=" my-1 p-1 shadow rounded border-secondary">{{ __('locale.Amount') }}
                        <div
                            class="d-flex justify-content-between align-items-center my-1 p-1 shadow rounded border-secondary">
                            <div>{{ __('locale.Paid') }}</div>
                            <span class="fw-bold">{{ getAmount($ico_log->amount) }}
                                {{ $ico_log->from_symbol }}</span>
                        </div>
                        <div
                            class="d-flex justify-content-between align-items-center my-1 p-1 shadow rounded border-secondary">
                            <div>{{ __('locale.To Recieve') }}</div>
                            <span class="fw-bold">{{ getAmount($ico_log->ico_amount) }}
                                {{ \App\Models\ICO::where('id', $ico_log->ico_id)->first()->symbol }}</span>
                        </div>
                        <div
                            class="d-flex justify-content-between align-items-center my-1 p-1 shadow rounded border-secondary">
                            <div>{{ __('locale.Recieved') }}</div>
                            <span class="fw-bold">
                                @if ($ico_log->status == 0)
                                    <span class="badge bg-warning">{{ __('locale.Pending') }}</span>
                                    @if ($ico_log->txHash != null)
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#verifyTrx" data-id="{{ $ico_log->id }}"
                                            onclick="$('#verifyTrx').find('input[name=id]').val($(this).data('id'));">
                                            {{ __('locale.Verify') }}
                                        </button>
                                    @endif
                                @elseif($ico_log->status == 1)
                                    {{ getAmount($ico_log->ico_amount) }}
                                    {{ \App\Models\ICO::where('id', $ico_log->ico_id)->first()->symbol }}
                                @elseif($ico_log->status == 2)
                                    <span class="badge bg-danger">{{ __('locale.Rejected') }}</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-1 p-1 shadow rounded border-secondary">
                        {{ __('locale.Status') }}
                        @if ($ico_log->status == 0)
                            <span class="badge bg-warning">{{ __('locale.Pending') }}</span>
                        @elseif($ico_log->status == 1)
                            <span class="badge bg-success">{{ __('locale.Paid') }}</span>
                        @elseif($ico_log->status == 2)
                            <span class="badge bg-danger">{{ __('locale.Rejected') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('locale.Guide') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="card-body">
                    <ul>
                        <li>{{ __('locale.Add Smart Contract Token to your metamask') }} <button
                                class="btn btn-success btn-sm addToken">{{ __('locale.Add Token') }}</button></li>
                        <li>{{ __('locale.Click') }} <b class="text-success">{{ __('locale.Pay') }}</b>
                            {{ __('locale.to send the payment to client from metamask') }}</li>
                        <li>{{ __('locale.Web3 will command the metamask to add your ICO network if it dont exist in MetaMask') }}
                        </li>
                        <li>{{ __('locale.Web3 will command the metamask to switch to your ICO network to process the payment') }}
                        </li>
                        <li>{{ __('locale.If Metamask was not abile to select your token wallet you added as a custom wallet them from the top click edit and then select your token and enter the amount u need to pay') }}
                        </li>
                        <li>{{ __('locale.After payment Web3 will return the value of the transaction Hash to the site and save it') }}
                        </li>
                        <li>{{ __('locale.Either wait for Metamask to inform you of it success or click the Hash link to verify manually') }}
                        </li>
                        <li>{{ __('locale.If Success then click') }} <b
                                class="text-success">{{ __('locale.Verify') }}</b>
                            {{ __('locale.btn to update the client contract so he know he get paid') }}</li>
                        <li>{{ __('locale.If payment failed do the same but mark it as Rejected so the client get refunded nad transaction marked as failed') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-slide-in fade" id="payToken">
        <div class="modal-dialog sidebar-sm add-new-record modal-content pt-0">
            <input type="hidden" id="id" name="id">
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('locale.Set Payment Method') }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                <label class="form-label" for="inp_amount">{{ __('locale.Amount To Send') }}</label>
                <div class="input-group">
                    <input type="number" class="form-control" required="" id="inp_amount" name="inp_amount"
                        placeholder="Amount" readonly>
                    <span class="input-group-text text-dark" id="profit">{{ $ico->symbol }}</span>
                </div>
                <label class="form-label mt-1" for="name">{{ __('locale.ICO Chain Network') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" value="{{ $network->chainName }}" readonly disabled>
                    <span class="input-group-text text-dark">{{ $network->symbol }}</span>
                </div>
                <div class="text-end my-1">
                    <button class="btn btn-success sendEthButton">{{ __('locale.Pay') }}</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal modal-slide-in fade" id="verifyTrx">
        <div class="modal-dialog sidebar-sm add-new-record modal-content pt-0">
            <form class="add-new-record modal-content pt-0" action="{{ route('admin.ico.verify') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="status" name="status">
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('locale.Set Transaction Status') }}</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="dropdown">
                        <button class="w-100 btn btn-outline-warning dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false" id="trxStatus"
                            name="trxStatus">{{ __('locale.Select Status') }}</button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item"
                                    onclick="$('#trxStatus').text($(this).text());$('#verifyTrx').find('input[name=status]').val($(this).data('status'));"
                                    data-status="1">Successful</a></li>
                            <li><a class="dropdown-item"
                                    onclick="$('#trxStatus').text($(this).text());$('#verifyTrx').find('input[name=status]').val($(this).data('status'));"
                                    data-status="0">Failed</a></li>
                        </ul>
                    </div>
                    <div class="my-1">
                        <button type="submit" class="btn btn-success me-1">{{ __('locale.Submit') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
