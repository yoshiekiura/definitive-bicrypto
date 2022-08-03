@php
$countries = \App\Helpers\Handler::getCountries();
@endphp
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h4 name="card-title">
                {{ __('Profile Information') }}
            </h4>

            <div name="description">
                {{ __('Update your account\'s profile information and email address.') }}
            </div>

            <div class="row mt-2">
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <div class="me-1">
                        <img class="img-thumbnail mb-1"
                            src="{{ getImage(imagePath()['profileImage']['path'] . '/' . $user->profile_photo_path, imagePath()['profileImage']['size']) }}" />
                    </div>
                    <div>
                        <input class="form-control" name="image" type="file" id="image"
                            accept=".jpg,.jpeg,.png,.svg" />
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- Firstname -->
                    <div class="mb-1">
                        <label class="form-label" for="firstname">{{ __('Firstname') }}</label>
                        <input id="firstname" type="text" class="form-control" name="firstname"
                            autocomplete="firstname" value="{{ $user->firstname }}"
                            @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1) disabled @endif>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- Lastname -->
                    <div class="mb-1">
                        <label class="form-label" for="lastname">{{ __('Lastname') }}</label>
                        <input id="lastname" type="text" class="form-control" name="lastname" autocomplete="lastname"
                            value="{{ $user->lastname }}" @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1) disabled @endif>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- Email -->
                    <div class="mb-1">
                        <label class="form-label" for="email">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- Address -->
                    <div class="mb-1">
                        <label class="form-label" for="address">{{ __('Address') }}</label>
                        <input id="address" type="text" class="form-control" name="address" autocomplete="address"
                            value="{{ $user->address }}" @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1) disabled @endif>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- City -->
                    <div class="mb-1">
                        <label class="form-label" for="city">{{ __('City') }}</label>
                        <input id="city" type="text" class="form-control" name="city" autocomplete="city"
                            value="{{ $user->city }}" @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1) disabled @endif>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- State -->
                    <div class="mb-1">
                        <label class="form-label" for="state">{{ __('State') }}</label>
                        <input id="state" type="text" class="form-control" name="state" autocomplete="state"
                            value="{{ $user->state }}" @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1) disabled @endif>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- Zip -->
                    <div class="mb-1">
                        <label class="form-label" for="zip">{{ __('Zip') }}</label>
                        <input id="zip" type="text" class="form-control" name="zip" autocomplete="zip"
                            value="{{ $user->zip }}" @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1) disabled @endif>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <!-- Country -->
                    <div class="mb-1">
                        <label class="form-label" for="country">{{ __('Country') }}</label>
                        <div class="input-group mb-1">
                            <label for="country" class="input-group-text">{{ __('Country') }}</label>
                            <select class="form-select" name="country" id="country" data-dd-class="search-on"
                                @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1) disabled @endif>
                                <option value="">{{ __('Select Country') }}</option>
                                @foreach ($countries as $country)
                                    <option
                                        {{ (isset($user->country) ? $user->country : '') == $country ? 'selected' : '' }}
                                        value="{{ $country }}" name="country">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @if (checkKYC($user->id) == 1 && getPlatform('kyc')->kyc_status == 1)
                    <div class="col-md-4 col-sm-6 col-lg-4">
                        <!-- Country -->
                        <div class="mb-1">
                            <label class="form-label" for="country">{{ __('Resubmit KYC') }}</label>
                            <div class="input-group mb-1">
                                <a href="/user/kyc/application?state=new" class="w-100 btn btn-success">Resubmit
                                    KYC</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
    </div>

    @if (auth()->user()->role_id != 3)
        <div class="card-footer text-end">
            <button class="btn btn-success" type="submit">
                {{ __('Update') }}
            </button>
        </div>
    @endif
    </form>

</div>
</div>
