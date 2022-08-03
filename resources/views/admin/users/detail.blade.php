<?php
$country_code = json_decode(json_encode(getIpInfo()), true)['code'];
?>
@extends('layouts.app')
@section('vendor-style')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-9 col-lg-7 col-md-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">{{ $user->fullname }} {{ __('locale.Information') }}</h5>
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('locale.First Name') }}<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname"
                                        value="{{ $user->firstname }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col">
                                    <label class="form-control-label  h6 mt-1">{{ __('locale.Last Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname"
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('locale.Email') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col">
                                    <label class="form-control-label  h6 mt-1">{{ __('locale.Mobile Number') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile"
                                        value="{{ $user->mobile }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('locale.Address') }} </label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ $user->address }}">
                                    <small class="form-text text-muted"><i class="bi bi-info-circle-circle"></i>
                                        {{ __('locale.House number, street address') }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col">
                                    <label class="form-control-label h6 mt-1">{{ __('locale.City') }} </label>
                                    <input class="form-control" type="text" name="city" value="{{ $user->city }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('locale.State') }} </label>
                                    <input class="form-control" type="text" name="state" value="{{ $user->state }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('locale.Zip/Postal') }} </label>
                                    <input class="form-control" type="text" name="zip" value="{{ $user->zip }}">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="col ">
                                    <label class="form-control-label h6 mt-1">{{ __('locale.Country') }} </label>
                                    <select id="country" name="country" placeholder="Country" aria-describedby="country"
                                        value="{{ old('country') }}" class="form-control"> @include('partials.country')
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-control-label h6 mt-1">Verification Status</label>
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                    data-on="Verified" data-off="Unverified" data-width="100%" name="email_verified_at"
                                    @if ($user->email_verified_at != null || $user->email_verified_at != '') checked @endif>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-control-label h6 mt-1">Role</label>
                                <input type="checkbox" data-onstyle="primary" data-offstyle="warning" data-toggle="toggle"
                                    data-on="Admin" data-off="User" data-width="100%" name="role_id"
                                    @if ($user->role_id == 1) checked @endif>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-control-label h6 mt-1">{{ __('locale.Status') }} </label>
                                <input type="checkbox" data-onstyle="success" data-offstyle="danger"
                                    data-toggle="toggle" data-on="{{ __('locale.Active') }}"
                                    data-off="{{ __('locale.Banned') }}" data-width="100%" name="status"
                                    @if ($user->status == 1) checked @endif>
                            </div>
                        </div>
                        <div class="card-footer mt-1 text-end">
                            <button type="submit" class="btn btn-primary">{{ __('locale.Save Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Wallets</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th>{{ __('locale.Symbol') }}</th>
                                <th>{{ __('locale.Address') }}</th>
                                <th>{{ __('locale.Provider') }}</th>
                                <th>{{ __('locale.Balance') }}</th>
                                <th>{{ __('locale.Type') }}</th>
                                <th>{{ __('locale.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wallets as $wallet)
                                <tr>
                                    <td data-label="{{ __('locale.Symbol') }}">{{ $wallet->symbol }}</td>
                                    <td data-label="{{ __('locale.Address') }}">{{ $wallet->address }}</td>
                                    <td data-label="{{ __('locale.Provider') }}">{{ strtoupper($wallet->provider) }}
                                    </td>
                                    <td data-label="{{ __('locale.Balance') }}">{{ $wallet->balance }}</td>
                                    <td data-label="{{ __('locale.Type') }}">{{ strtoupper($wallet->type) }}</td>
                                    <td data-label="{{ __('locale.Action') }}">
                                        <div class="d-flex justify-content-start">
                                            <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('locale.Add/Subtract Balance') }}"
                                                data-address="{{ $wallet->address }}"
                                                data-symbol="{{ $wallet->symbol }}"
                                                class="btn btn-icon btn-success btn-sm"
                                                onclick="$('#addSubModal').find('input[name=address]').val($(this).data('address'));
                                                            $('#addSubModal').find('input[name=symbol]').val($(this).data('symbol'));$('#addSubModal').modal('show');">
                                                <i class="bi bi-cash"></i>
                                            </a>
                                            @if ($wallet->provider != 'funding')
                                                <form class="ms-1" method="POST"
                                                    action="{{ route('admin.wallet.regenerate') }}">
                                                    @csrf
                                                    <input type="hidden" id="user_id" name="user_id"
                                                        value="{{ $user->id }}">
                                                    <input type="hidden" id="address" name="address"
                                                        value="{{ $wallet->address }}">
                                                    <input type="hidden" id="type" name="type"
                                                        value="{{ $wallet->type }}">
                                                    <button type="submit" class="btn btn-icon btn-warning btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('locale.Regenerate Wallet') }}"><i
                                                            class="bi bi-arrow-repeat"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td data-label="{{ __('locale.Symbol') }}">USDT</td>
                                    <td data-label="{{ __('locale.Address') }}"></td>
                                    <td data-label="{{ __('locale.Balance') }}"></td>
                                    <td data-label="{{ __('locale.Type') }}"></td>
                                    <td data-label="{{ __('locale.Action') }}">
                                        <form method="POST" action="{{ route('admin.wallet.create') }}">
                                            @csrf
                                            <input type="hidden" id="user_id" name="user_id"
                                                value="{{ $user->id }}">
                                            <input type="hidden" id="symbol" name="symbol" value="USDT">
                                            <input type="hidden" id="type" name="type"
                                                value="{{ $wallet_type }}">
                                            <button type="submit" class="btn btn-success btn-sm">Create
                                                Wallet</button></span>
                                        </form>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-5 col-md-5">
            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body p-0">
                    <div class="p-3 bg-white">
                        <div class="mb-2">
                            <img src="{{ getImage(imagePath()['profileImage']['path'] . '/' . $user->profile_photo_path, imagePath()['profileImage']['size']) }}"
                                alt="{{ __('locale.Profile Image') }}" class="w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{ $user->fullname }}</h4>
                            <span class="text-small">{{ __('locale.Joined At') }}
                                <strong>{{ showDateTime($user->created_at, 'd M, Y h:i A') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card rounded-2 overflow-hidden shadow">
                <div class="card-body">
                    <h5 class="text-muted">{{ __('locale.User information') }}</h5>
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Username') }}
                            <span class="h6 mt-1">{{ $user->username }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ __('locale.Status') }}
                            @switch($user->status)
                                @case(1)
                                    <span class="badge rounded-pill bg-success">{{ __('locale.Active') }}</span>
                                @break

                                @case(0)
                                    <span class="badge rounded-pill bg-danger">{{ __('locale.Banned') }}</span>
                                @break
                            @endswitch
                        </li>

                        @if ($refer_by)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="float-start">{{ __('locale.Referred By') }}</span>
                                <span class="float-end text-muted">{{ __($refer_by->username) }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="card rounded-2 overflow-hidden mt-2 shadow">
                <div class="card-body">
                    <h5 class="text-muted">{{ __('locale.User action') }}</h5>
                    <a href="{{ route('admin.users.email.single', $user->id) }}" class="btn btn-danger mt-2">
                        {{ __('locale.Send Email') }}
                    </a>
                    <a href="{{ route('admin.users.referral.log', $user->id) }}" class="btn btn-info mt-2">
                        {{ __('locale.Referral Log') }}
                    </a>

                    <a href="{{ route('admin.users.commission.log', $user->id) }}" class="btn btn-warning mt-2">
                        {{ __('locale.Commission Log') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="addSubModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Add / Subtract Balance') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.addSubBalance', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="address">
                    <input type="hidden" name="symbol">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col col-md-12">
                                <input class="form-check-input" data-width="100%" data-size="lg" type="checkbox"
                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('locale.Add Balance') }}"
                                    data-off="{{ __('locale.Subtract Balance') }}" name="act" checked>
                            </div>


                            <div class="col col-md-12 mt-1">
                                <label>{{ __('locale.Amount') }}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="amount" class="form-control"
                                        placeholder="{{ __('locale.Please provide positive amount') }}">
                                    <div class="input-group-text">{{ __($general->cur_sym) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('locale.Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
@endsection

@push('script')
    <script>
        "use strict";
        $('.toggle').bootstrapToggle({
            on: 'Y',
            off: 'N',
            width: '100%',
            size: 'small'
        });
        $("select[name=country]").val("{{ @$user->country }}");
        @if ($country_code)
            $(`option[data-code={{ $country_code[0] }}]`).attr('selected', '');
        @endif
        $('select[name=country_code]').change(function() {
            $('input[name=country]').val($('select[name=country_code] :selected').data('country'));
        }).change();
    </script>
@endpush
