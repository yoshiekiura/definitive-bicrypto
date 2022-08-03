    @if($user_kyc == NULL)
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body text-center d-flex justify-content-center align-items-center border-light rounded">
                <div class="status-empty">
                    <div class="status-icon d-flex justify-content-center align-items-center">
                        <i class="bi bi-files"></i>
                    </div>
                    <span
                        class="status-text-d text-dark">{{__('You have not submitted your necessary documents to verify your identity.')}}{{ __(' In order to trade in our platform, please verify your identity.')}}</span>
                    <p class="">
                        {{__('It would great if you please submit the form. If you have any question, please feel free to contact our support team.')}}
                    </p>
                    <a href="{{ route('user.kyc.application') }}?state=new"
                        class="btn btn-primary">{{__('Click here to complete your KYC')}}</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- IF SUBMITED @Thanks --}}
    @if($user_kyc !== NULL && isset($_GET['thank_you']))
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body text-center d-flex justify-content-center align-items-center border-warning rounded">
                <div class="status-thank">
                    <div class="status-icon d-flex justify-content-center align-items-center">
                        <i class="bi bi-check"></i>
                    </div>
                    <span class="status-text-d large text-dark">{{__('You have completed the process of KYC')}}</span>
                    <p class="">
                        {{__('We are still waiting for your identity verification. Once our team verified your identity, you will be notified by email. You can also check your KYC  compliance status from your profile page.')}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- IF PENDING --}}
    @if($user_kyc !== NULL && $user_kyc->status == 'pending' && !isset($_GET['thank_you']))

    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div
                class="card-body text-center d-flex justify-content-center align-items-center border-info rounded d-flex align-items-center">
                <div class="status-process">
                    <div class="status-icon d-flex justify-content-center align-items-center">
                        <i class="bi bi-infinity"></i>
                    </div>
                    <span class="text-dark">{{__('Your application verification under process.')}}</span>
                    <p class="">
                        {{__('We are still working on your identity verification. Once our team verified your identity, you will be notified by email.')}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- IF REJECTED/MISSING --}}
    @if($user_kyc !== NULL && ($user_kyc->status == 'missing' || $user_kyc->status == 'rejected') &&
    !isset($_GET['thank_you']))

    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body text-center d-flex justify-content-center align-items-center border-warning rounded">
                <div class="status{{ ($user_kyc->status == 'missing') ? '-warnning' : '-canceled' }}">
                    <div class="status-icon d-flex justify-content-center align-items-center">
                        <i class="bi bi-exclamation-lg"></i>
                    </div>
                    <span class="status-text-d text-dark">
                        {{ $user_kyc->status == 'missing' ? __('We found some information to be missing.') : __('Sorry! Your application was rejected.') }}
                    </span>
                    <p class="">
                        {{__('In our verification process, we found information that is incorrect or missing. Please resubmit the form. In case of any issues with the submission please contact our support team.')}}
                    </p>
                    <a href="{{ route('user.kyc.application') }}?state={{ $user_kyc->status == 'missing' ? 'missing' : 'resubmit' }}"
                        class="btn btn-primary mt-0">{{__('Submit Again')}}</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- IF VERIFIED --}}
    @if($user_kyc !== NULL && $user_kyc->status == 'approved' && !isset($_GET['thank_you']))
    @endif
