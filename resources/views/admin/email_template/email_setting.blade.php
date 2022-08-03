@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('admin.email.template.setting') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col mb-1 col-md-6">
                                <label class="mb-1 h6">{{ __('locale.Email Send Method') }}</label>
                                <select name="email_method" class="form-control">
                                    <option value="php" @if ($general_setting->mail_config->name == 'php') selected @endif>
                                        {{ __('locale.PHP Mail') }}</option>
                                    <option value="smtp" @if ($general_setting->mail_config->name == 'smtp') selected @endif>
                                        {{ __('locale.SMTP') }}</option>
                                    <option value="sendgrid" @if ($general_setting->mail_config->name == 'sendgrid') selected @endif>
                                        {{ __('locale.SendGrid API') }}</option>
                                    <option value="mailjet" @if ($general_setting->mail_config->name == 'mailjet') selected @endif>
                                        {{ __('locale.Mailjet API') }}</option>
                                </select>
                            </div>
                            <div class="col col-md-6 text-end">
                                <h6 class="mb-1">&nbsp;</h6>
                                <button type="button" data-bs-target="#testMailModal" data-bs-toggle="modal"
                                    class="btn btn-info">{{ __('locale.Send Test Mail') }}</button>
                            </div>
                        </div>
                        <div class="row d-none configForm" id="smtp">
                            <div class="col-md-12">
                                <h6 class="mb-2">{{ __('locale.SMTP Configuration') }}</h6>
                            </div>
                            <div class="col col-md-4">
                                <label class="fw-bold">{{ __('locale.Host') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    placeholder="e.g. {{ __('locale.smtp.googlemail.com') }}" name="host"
                                    value="{{ $general_setting->mail_config->host ?? '' }}" />
                            </div>
                            <div class="col col-md-4">
                                <label class="fw-bold">{{ __('locale.Port') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ __('locale.Available port') }}"
                                    name="port" value="{{ $general_setting->mail_config->port ?? '' }}" />
                            </div>
                            <div class="col col-md-4">
                                <label class="fw-bold">{{ __('locale.Encryption') }}</label>
                                <select class="form-control" name="enc">
                                    <option value="ssl">{{ __('locale.SSL') }}</option>
                                    <option value="tls">{{ __('locale.TLS') }}</option>
                                </select>
                            </div>
                            <div class="col col-md-6">
                                <label class="fw-bold">{{ __('locale.Username') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    placeholder="{{ __('locale.Normally your email') }} address" name="username"
                                    value="{{ $general_setting->mail_config->username ?? '' }}" />
                            </div>
                            <div class="col col-md-6">
                                <label class="fw-bold">{{ __('locale.Password') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    placeholder="{{ __('locale.Normally your email password') }}" name="password"
                                    value="{{ $general_setting->mail_config->password ?? '' }}" />
                            </div>
                        </div>
                        <div class="row d-none configForm" id="sendgrid">
                            <div class="col-md-12">
                                <h6 class="mb-2">{{ __('locale.SendGrid API Configuration') }}</h6>
                            </div>
                            <div class="col col-md-12">
                                <label>{{ __('locale.APP KEY') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    placeholder="{{ __('locale.SendGrid app key') }}" name="appkey"
                                    value="{{ $general_setting->mail_config->appkey ?? '' }}" />
                            </div>
                        </div>
                        <div class="row d-none configForm" id="mailjet">
                            <div class="col-md-12">
                                <h6 class="mb-2">{{ __('locale.Mailjet API Configuration') }}</h6>
                            </div>
                            <div class="col col-md-6">
                                <label class="fw-bold">{{ __('locale.API PUBLIC KEY') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    placeholder="{{ __('locale.Mailjet API PUBLIC KEY') }}" name="public_key"
                                    value="{{ $general_setting->mail_config->public_key ?? '' }}" />
                            </div>
                            <div class="col col-md-6">
                                <label class="fw-bold">{{ __('locale.API SECRET KEY') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    placeholder="{{ __('locale.Mailjet API SECRET KEY') }}" name="secret_key"
                                    value="{{ $general_setting->mail_config->secret_key ?? '' }}" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('locale.Update') }}</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>


    {{-- TEST MAIL MODAL --}}
    <div id="testMailModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Test Mail Setup') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.email.template.sendTestMail') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col col-md-12">
                                <label>{{ __('locale.Sent to') }} <span class="text-danger">*</span></label>
                                <input type="text" name="email" class="form-control"
                                    placeholder="{{ __('locale.Email Address') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('locale.Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(function() {
            "use strict";
            $('select[name=email_method]').on('change', function() {
                var method = $(this).val();
                $('.configForm').addClass('d-none');
                if (method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }).change();

        });
    </script>
@endpush
