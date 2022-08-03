@extends('layouts/fullLayoutMaster')
@php
use mobiledetect\mobiledetectlib\Detection;
$detect = new Mobile_Detect();
@endphp
@section('title', 'Login Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <!-- Login basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="#" class="col d-flex justify-content-center mb-1">
                        <div class="brand-text"><img
                                src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}"
                                alt="{{ __('locale.image') }}"></div>
                    </a>

                    <h4 class="card-title mb-1">Welcome! 👋</h4>
                    <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>

                    @if (session('status'))
                        <div class="alert alert-success mb-1 rounded-0" role="alert">
                            <div class="alert-body">
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="mb-1">
                            <label for="login-email" class="form-label">Email / Username</label>
                            <input type="text"
                                class="form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror"
                                id="login-email" name="email" placeholder="john@example.com" aria-describedby="login-email"
                                tabindex="1" autofocus value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                @endif
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="login-password"
                                    name="password" tabindex="2"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="login-password" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" tabindex="3"
                                    {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label" for="remember"> Remember Me </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" tabindex="4">Sign in</button>
                    </form>

                    <p class="text-center mt-2">
                        <span>New on our platform?</span>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">
                                <span>Create an account</span>
                            </a>
                        @endif
                    </p>
                    @if (getExt('7')->status == 1)
                        <div class="divider my-2">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="auth-footer-btn d-flex justify-content-center">
                            <button type="button" class="btn btn-success w-100 walletConnectBtc" data-bs-toggle="modal"
                                data-bs-target="#walletConnect">
                                Sign In With Wallet
                            </button>
                            {{-- <a href="#" class="btn btn-facebook">
              <i data-feather="facebook"></i>
            </a>
            <a href="#" class="btn btn-twitter white">
              <i data-feather="twitter"></i>
            </a>
            <a href="#" class="btn btn-google">
              <i data-feather="mail"></i>
            </a>
            <a href="#" class="btn btn-github">
              <i data-feather="github"></i> --}}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /Login basic -->
        </div>
    </div>
    @if (getExt('7')->status == 1)
        <div class="modal fade" tabindex="-1" id="walletConnect">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Wallet Connect</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div style="display: grid; grid-template-columns: 1fr 1fr;">
                            @if (!$detect->isMobile() && !$detect->isTablet())
                                <div onclick="login('Metamask')"
                                    style="align-items: center; display: flex; flex-direction: column; height: auto; justify-content: center; margin-left: auto; margin-right: auto; padding: 20px 5px; cursor: pointer;">
                                    <img src="{{ asset('assets/images/wallets/metamaskWallet.png') }}" alt="Metamask"
                                        style="align-self: center; fill: rgb(40, 13, 95); flex-shrink: 0; margin-bottom: 8px; height: 30px;"><span
                                        class="ant-typography" style="font-size: 14px;">Metamask</span>
                                </div>
                            @endif
                            <div onclick="login('WalletConnect')"
                                style="align-items: center; display: flex; flex-direction: column; height: auto; justify-content: center; margin-left: auto; margin-right: auto; padding: 20px 5px; cursor: pointer;">
                                <img src="{{ asset('assets/images/wallets/wallet-connect.svg') }}" alt="WalletConnect"
                                    style="align-self: center; fill: rgb(40, 13, 95); flex-shrink: 0; margin-bottom: 8px; height: 30px;"><span
                                    class="ant-typography" style="font-size: 14px;">WalletConnect</span>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button onclick="logOut()" class="btn btn-danger">Disconnect</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@if (getExt('7')->status == 1)
    @section('page-script')
        <script src="https://unpkg.com/moralis@1.5.10/dist/moralis.js"></script>
        <script>
            $(".walletConnectBtc").click(function() {
                $.getScript(
                    "https://github.com/WalletConnect/walletconnect-monorepo/releases/download/1.7.7/web3-provider.min.js"
                );
            });
            const serverUrl = "{{ getGen()->moralis_server_url }}";
            const appId = "{{ getGen()->moralis_app_id }}";

            /* Authentication code */
            async function login($a) {
                await Moralis.start({
                    serverUrl,
                    appId
                });
                let user = Moralis.User.current();
                if (!user) {
                    if ($a == 'Metamask') {
                        user = await Moralis.authenticate({
                                signingMessage: "Log to {{ siteName() }} using MetaMask"
                            })
                            .then(function(user) {
                                let ethAddress = user.get("ethAddress")
                                $.ajax({
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    },
                                    url: "{{ route('metamask.login') }}",
                                    method: "POST",
                                    data: {
                                        ethAddress: ethAddress,
                                    },
                                    success: function(response) {
                                        if (response == 1) {
                                            notify('success', 'Successfully Logged in')
                                            window.location.href = "{{ route('user.home') }}";
                                        } else {
                                            notify('error', 'Login Failed')
                                        }
                                    }
                                });
                            })
                            .catch((error) => {
                                if (error.responseJSON.message.includes('No query results for')) {
                                    notify('error', 'Your Account Dont Have Connected Wallet')
                                }
                            });
                    } else if ($a == 'WalletConnect') {
                        user = await Moralis.authenticate({
                                provider: "walletconnect"
                            })
                            .then(function(user) {
                                let ethAddress = user.get("ethAddress")
                                $.ajax({
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    },
                                    url: "{{ route('metamask.login') }}",
                                    method: "POST",
                                    data: {
                                        ethAddress: ethAddress,
                                    },
                                    success: function(response) {
                                        if (response == 1) {
                                            notify('success', 'Successfully Logged in')
                                            window.location.href = "{{ route('user.home') }}";
                                        } else {
                                            notify('error', 'Login Failed')
                                        }
                                    }
                                });
                            })
                            .catch((error) => {
                                if (error.responseJSON.message.includes('No query results for')) {
                                    notify('error', 'Your Account Dont Have Connected Wallet')
                                };
                            });
                    }
                } else {
                    let ethAddress = user.get("ethAddress")
                    $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            url: "{{ route('metamask.login') }}",
                            method: "POST",
                            data: {
                                ethAddress: ethAddress,
                            },
                            success: function(response) {
                                if (response == 1) {
                                    notify('success', 'Successfully Logged in')
                                    window.location.href = "{{ route('user.home') }}";
                                } else {
                                    notify('error', 'Login Failed')
                                }
                            }
                        })
                        .catch((error) => {
                            if (error.responseJSON.message.includes('No query results for')) {
                                notify('error', 'Your Account Dont Have Connected Wallet')
                            };
                        });
                }
            }

            async function logOut() {
                await Moralis.start({
                    serverUrl,
                    appId
                });
                await Moralis.User.logOut();
                notify('success', 'Wallet Disconnected Successfully')
            }
        </script>
    @endsection
@endif
