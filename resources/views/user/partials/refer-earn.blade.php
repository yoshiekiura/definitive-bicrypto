<!-- refer and earn modal -->
<div class="modal fade" id="referEarnModal" tabindex="-1" aria-labelledby="referEarnTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-refer-earn">
    <div class="modal-content">
      <div class="modal-header bg-transparent">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pb-5 px-sm-0">
        <div class="px-sm-4 mx-50">
          <h1 class="text-center mb-1" id="referEarnTitle">{{ __('locale.Refer & Earn')}}</h1>
          <p class="text-center mb-5">
            {{ __('locale.Invite your friend here, if thay sign up and complete 1 successful deposit,')}}
            <br />
            {{ __('locale.you will earn 5% of their future deposits')}}
          </p>

          <div class="row mb-4">
            <div class="col-12 col-lg-4">
              <div class="d-flex justify-content-center mb-1">
                <div
                  class="
                    modal-refer-earn-step
                    d-flex
                    width-100
                    height-100
                    rounded-circle
                    justify-content-center
                    align-items-center
                    bg-light-primary
                  "
                >
                  <i class="bi bi-chat-left display-4 text-warning"></i>
                </div>
              </div>
              <div class="text-center">
                <h6 class="fw-bolder mb-1">{{ __('locale.Send Invitation')}} 🤟🏻</h6>
                <p>{{ __('locale.Send your referral link to your friend')}}</p>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="d-flex justify-content-center mb-1">
                <div
                  class="
                    modal-refer-earn-step
                    d-flex
                    width-100
                    height-100
                    rounded-circle
                    justify-content-center
                    align-items-center
                    bg-light-primary
                  "
                >
                <i class="bi bi-card-checklist display-4 text-info"></i>
                </div>
              </div>
              <div class="text-center">
                <h6 class="fw-bolder mb-1">{{ __('locale.Registration')}} 👩🏻‍💻</h6>
                <p>{{ __('locale.Let them register to our trading platform')}}</p>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="d-flex justify-content-center mb-1">
                <div
                  class="
                    modal-refer-earn-step
                    d-flex
                    width-100
                    height-100
                    rounded-circle
                    justify-content-center
                    align-items-center
                    bg-light-primary
                  "
                >
                <i class="bi bi-award display-4 text-success"></i>
                </div>
              </div>
              <div class="text-center">
                <h6 class="fw-bolder mb-1">{{ __('locale.Earn')}} 5% 🎉</h6>
                <p>{{ __('locale.from each successful deposit from your friends')}}</p>
              </div>
            </div>
          </div>
        </div>

        <hr />

        <div class="px-sm-5 mx-50">
          <h4 class="fw-bolder mt-4 mb-1">{{ __('locale.Share the referral link')}}</h4>
          <form class="row g-1" onsubmit="return false">
            <div class="col-lg-8">
              <label class="form-label" for="referralURL">
                {{ __('locale.You can also copy and send it or share it on your social media.')}} 🥳
              </label>
              <div class="input-group input-group-merge">
                <input type="text" class="form-control" value="{{ route('refer.register', Auth::user()->username) }}" id="referralURL" readonly />
                <a class="input-group-text btn btn-outline-primary" onclick="myFunction()" id="copyBoard">{{ __('locale.Copy link')}}</a>
              </div>
            </div>
            <div class="col-lg-4 d-flex align-items-end">
              <div class="social-btns">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('refer.register', Auth::user()->username) }}" type="button" class="btn btn-icon btn-facebook me-50">
                  <i class="bi bi-facebook font-medium-2"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ route('refer.register', Auth::user()->username) }}" type="button" class="btn btn-icon btn-twitter me-50">
                  <i class="bi bi-twitter font-medium-2"></i>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('refer.register', Auth::user()->username) }}" type="button" class="btn btn-icon btn-linkedin me-50">
                  <i class="bi bi-linkedin font-medium-2"></i>
                </a>
                <a href="https://pinterest.com/pin/create/button/?url={{ route('refer.register', Auth::user()->username) }}" type="button" class="btn btn-icon btn-pinterest">
                    <i class="bi bi-pinterest font-medium-2"></i>
                  </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / refer and earn modal -->
<div class="modal fade custom--modal" id="practiceAmount">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Add Practice Balance')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form class="deposit-form" action="{{route('user.binary.add.practice.balance')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>@lang('Are you sure you want to add practice balance')?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm text--white btn-danger" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-primary btn-sm text--white btn-success">{{ __('locale.Confirm')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('script')
    <script>
        "use strict";
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Referral Url Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush
