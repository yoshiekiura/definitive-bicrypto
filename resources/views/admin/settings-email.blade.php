@extends('layouts.app')
@php
$page_title = 'Email Setup';
@endphp
@section('title', 'Email Setup')
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/kyc/style.css')) }}">
@endsection
@section('content')
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="main-content col-lg-12">
                    <div class="content-area card">
                        <div class="card-innr">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Email Templates<br></h3>
                                <ul class="text-end">
                                    <a data-bs-toggle="modal" data-bs-target="#mailSetting" class="btn btn-primary">
                                        <i class="bi bi-gear"></i><span> Email Settings</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="card-text">
                                <ul class="list list-s1 list-col2x">
                                    @foreach ($templates as $template)
                                        <li class="item">
                                            <div class="list-content justify-content-between">
                                                <span>{{ $template->name }}</span>
                                                <div class="d-flex guttar-10px">
                                                    <div class="action-btn">
                                                        <a class="btn btn-xs btn-icon btn-circle btn-light-alt et-item"
                                                            data-bs-toggle="modal" data-bs-target="#{{ $template->slug }}"
                                                            data-slug="{{ $template->slug }}"
                                                            data-id="{{ $template->id }}"><i
                                                                class="bi bi-pencil-square"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <div class="modal fade text-start  w-100" aria-hidden="true" role="dialog"
                                            id="{{ $template->slug }}" tabindex="-1">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit {{ $template->name }} Template
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="{{ route('admin.settings.email.template.update') }}"
                                                            class="validate-modern" method="POST" id="update_et">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $template->id }}">
                                                            <input type="hidden" name="slug"
                                                                value="{{ $template->slug }}">
                                                            <div class="msg-box"></div>
                                                            <div class="input-item input-with-label">
                                                                <label for="name" class="input-item-label"> Name</label>
                                                                <div class="input-wrap">
                                                                    <input name="name" id="name" class="input-bordered"
                                                                        value="{{ $template->name }}" type="text"
                                                                        readonly="readonly">
                                                                </div>
                                                            </div>
                                                            <div class="input-item input-with-label">
                                                                <label for="subject" class="input-item-label">Template
                                                                    Subject</label>
                                                                <div class="input-wrap">
                                                                    <input name="subject" id="subject"
                                                                        class="input-bordered"
                                                                        value="{{ $template->subject }}" type="text"
                                                                        required="">
                                                                </div>
                                                            </div>
                                                            <div class="input-item input-with-label">
                                                                <label for="greeting" class="input-item-label">Template
                                                                    Greeting</label>
                                                                <div class="input-wrap">
                                                                    <input name="greeting" id="greeting"
                                                                        class="input-bordered"
                                                                        value="{{ $template->greeting }}" type="text"
                                                                        required="">
                                                                </div>
                                                            </div>
                                                            <div class="input-item  input-with-label">
                                                                <label for="message" class="input-item-label">Template
                                                                    Content</label>
                                                                <div class="input-wrap">
                                                                    <textarea id="message" name="message" class="input-bordered input-textarea editor">{{ $template->message }}</textarea>
                                                                </div>
                                                                @if ($template->slug == 'users-reset-password-email')
                                                                    <span class="input-note">
                                                                        This line will automatically added: <strong>Your New
                                                                            Password is : ******* </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if (str_contains($template->slug, 'admin'))
                                                                <div class="input-item input-with-label">
                                                                    <span class="input-item-label">Send Notification to
                                                                        Admin</span>
                                                                    <div class="input-wrap">
                                                                        <input type="checkbox" class="input-switch"
                                                                            name="notify" value="1"
                                                                            {{ $template->notify == 1 ? 'checked' : '' }}
                                                                            id="notify">
                                                                        <label for="notify">Notify</label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="input-item input-with-label">
                                                                <span class="input-item-label">Email Footer</span>
                                                                <div class="input-wrap">
                                                                    <input type="checkbox" class="input-switch"
                                                                        name="regards" value="1"
                                                                        {{ $template->regards == 'true' ? 'checked' : '' }}
                                                                        id="regards">
                                                                </div>
                                                                <label for="regards">Global</label>
                                                                <span class="text-info">You can use these shortcut:
                                                                    [[site_name]], [[site_email]], [[user_name]]
                                                                    @if ($template->slug == 'send-user-email')
                                                                        , [[message]]
                                                                    @endif
                                                                    @if (starts_with($template->slug, 'order-'))
                                                                        , [[order_id]], [[order_details]], [[token_symbol]],
                                                                        [[token_name]], [[payment_from]],
                                                                        [[payment_gateway]], [[payment_amount]],
                                                                        [[total_tokens]]
                                                                    @endif
                                                                </span> <br>
                                                                <span class="text-danger">Don't use Markdown character,It
                                                                    may broke email style.</span>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">{{ __('locale.Update') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mailSetting" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Update Mailing Setting') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.settings.email.update') }}" autocomplete="false" method="POST"
                    id="email_settings">
                    <div class="modal-body">
                        @csrf
                        <h5 class="text-primary">Choose Email Driver </h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="input-item input-with-label">
                                    <input id="smtp_uchk" class="form-check-input" type="radio"
                                        {{ email_setting('driver', env('MAIL_DRIVER', 'sendmail')) == 'sendmail' ? 'checked' : '' }}
                                        name="site_mail_driver" value="sendmail">
                                    <label for="smtp_uchk">Send Mail</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-item input-with-label">
                                    <input id="smtp_chk" class="form-check-input" type="radio"
                                        {{ email_setting('driver', env('MAIL_DRIVER', 'smtp')) == 'smtp' ? 'checked' : '' }}
                                        name="site_mail_driver" value="smtp">
                                    <label for="smtp_chk">SMTP</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-item input-with-label">
                                    <input id="mail" class="form-check-input" type="radio"
                                        {{ email_setting('driver', env('MAIL_DRIVER', 'mail')) == 'mail' ? 'checked' : '' }}
                                        name="site_mail_driver" value="mail">
                                    <label for="mail">Mail </label>
                                    <small class="text-success">*Recommended</small>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="smtp-box">
                            <div class="col-12 col-md-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">SMTP HOST</label>
                                    <input class="input-bordered" type="text" name="site_mail_host" placeholder=""
                                        value="{{ email_setting('host', env('MAIL_HOST')) }}">
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">SMTP Port</label>
                                    <input class="input-bordered" type="number" name="site_mail_port"
                                        value="{{ email_setting('port', env('MAIL_PORT')) }}" placeholder="587">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">SMTP Secure</label>
                                    <input class="input-bordered" type="text" name="site_mail_encryption"
                                        value="{{ email_setting('encryption', env('MAIL_ENCRYPTION', 'tls')) }}"
                                        placeholder="tls">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">SMTP UserName</label>
                                    <input class="input-bordered" type="text" name="site_mail_username" placeholder=""
                                        value="{{ Auth::user()->type == 'demo' ? 'hide@ouremail.address' : email_setting('user_name', env('MAIL_USERNAME')) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">SMTP Password</label>
                                    <input class="input-bordered" type="password" autocomplete="new-password"
                                        name="site_mail_password"
                                        value="{{ Auth::user()->type == 'demo' ? '' : email_setting('password', env('MAIL_PASSWORD')) }}"
                                        placeholder="********">
                                </div>
                                <small class="text-danger">Add between <code>""</code> if your password have
                                    whitespace or special letters</small>
                            </div>
                        </div>
                        <div class="gaps-1x"></div>
                        <div class="sap"></div>
                        <div class="gaps-2x"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Email From Address</label>
                                    <input class="input-bordered" type="email" name="site_mail_from_address"
                                        value="{{ email_setting('from_address') }}" placeholder="info@sitename.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-item input-with-label">
                                    <label class="input-item-label">Email From Name</label>
                                    <input class="input-bordered" type="text" name="site_mail_from_name"
                                        value="{{ email_setting('from_name') }}" placeholder="Site Name">
                                    <small class="text-danger">Add between <code>""</code> if your name have
                                        whitespace</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" input-item input-with-label">
                                    <label class="input-item-label">Email Global Footer</label>
                                    <textarea class="input-bordered" name="site_mail_footer" id="gblfootr" cols="30" rows="4">{{ get_setting('site_mail_footer') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="input-item input-with-label">
                                    <label for="emails" class="input-item-label">Enter External Emails</label>
                                    <div class="input-wrap">
                                        <input name="send_notification_mails" id="emails" type="text"
                                            class="input-bordered" value="{{ get_setting('send_notification_mails') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('locale.Update') }}</button>
                    </div>
                </form>
            </div>
        </div>{{-- .modal-content --}}
    </div>{{-- .modal-dialog --}}
    </div>
    {{-- Modal End --}}
@endsection
