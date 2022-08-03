@php
$option =  $defaultDoc = $defaultImg = '';

$has_docs = (field_value('kyc_document_passport') || field_value('kyc_document_nidcard') || field_value('kyc_document_driving'));
$support_docs = array(
    'passport' => field_value('kyc_document_passport'),
    'nidcard' => field_value('kyc_document_nidcard'),
    'driving' => field_value('kyc_document_driving')
);
$default_docs = array();
foreach ($support_docs as $doc => $type){
    if($type) {
        $default_docs = array('doc' => $doc, 'name' => $title[$doc], 'image' => $doc);
        break;
    }
}
if (!empty($default_docs)) {
    $defaultDoc = $default_docs['name'];
    $defaultImg = $default_docs['image'];
}

$step_01 = ($has_docs) ? '01' : '';
$step_02 = ($step_01 && $has_docs) ? '02' : '';

@endphp

<div class="form-step form-step1">
    <div class="form-step-head card-innr">
        <div class="step-head">
            <div class="step-number">{{ $step_01 }}</div>
            <div class="step-head-text">
                <h4 class="text-warning">{{__('Personal Details')}}</h4>
                <p>{{__('Your basic personal information is required for identification purposes.')}}</p>
            </div>
        </div>
    </div>{{-- .step-head --}}
    <div class="form-step-fields card-innr">
        <div class="note note-plane note-light-alt note-md pdb-1x">
            <p><i class="bi bi-info-circle"></i>
            {{__('Please type carefully and fill out the form with your personal details. You are not allowed to edit the details once you have submitted the application.')}}</p>
        </div>
        <div class="row">
            @if(field_value('kyc_firstname', 'show'))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="first-name" class="input-group-text">{{__('First Name')}}  {!! required_mark('kyc_firstname') !!}</label>

                        <input {{ field_value('kyc_firstname', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text" value = "{{ isset($user_kyc) ? $user_kyc->firstName : ''}}" id="first-name" name="first_name">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_lastname', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="last-name" class="input-group-text">{{__('Last Name')}} {!! required_mark('kyc_lastname') !!}</label>

                        <input {{ field_value('kyc_lastname', 'req' ) == '1' ? 'required ' : '' }}class="form-control" value = "{{ isset($user_kyc) ? $user_kyc->lastName : ''}}" type="text" id="last-name" name="last_name">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_email', 'show' ) && isset($input_email) && $input_email == true)
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="email" class="input-group-text">{{__('Email Address')}} {!! required_mark('kyc_email') !!}</label>

                        <input {{ field_value('kyc_email', 'req' ) == '1' ? 'required ' : '' }}class="form-control" value = "{{ isset($user_kyc) ? $user_kyc->email : ''}}" type="email" id="email" name="email">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif

            @if(!isset($user_kyc))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="password" class="input-group-text">{{__('Password')}}
                        <span class="text-require text-danger">*</span>
                    </label>

                        <input required class="form-control" placeholder="*******" type="password" minlength="6" id="password" name="password">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif

            @if(field_value('kyc_phone', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="phone-number" class="input-group-text">{{__('Phone Number ')}}{!! required_mark('kyc_phone') !!}</label>

                        <input {{ field_value('kyc_phone', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text" value = "{{ isset($user_kyc) ? $user_kyc->phone : ''}}" id="phone-number" name="phone">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_dob', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="date-of-birth" class="input-group-text">{{__('Date of Birth')}} {!! required_mark('kyc_dob') !!}</label>

                        <input {{ field_value('kyc_dob', 'req' ) == '1' ? 'required ' : '' }}class="form-control date-picker-dob" type="text" value = "{{ isset($user_kyc) ? $user_kyc->dob : ''}}" id="date-of-birth" name="dob">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_gender', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="gender" class="input-group-text">{{__('Gender')}} {!! required_mark('kyc_gender') !!}</label>
                        <select {{ field_value('kyc_gender', 'req' ) == '1' ? 'required ' : '' }}class="form-select" name="gender" id="gender">
                            <option value="">{{__('Select Gender')}}</option>
                            <option {{( (isset($user_kyc) ? $user_kyc->gender : '') == 'male')?"selected":"" }} value="male">{{__('Male')}}</option>
                            <option {{( (isset($user_kyc) ? $user_kyc->gender : '') == 'female')?"selected":"" }} value="female">{{__('Female')}}</option>
                            <option {{( (isset($user_kyc) ? $user_kyc->gender : '') == 'other')?"selected":"" }} value="other">{{__('Other')}}</option>
                        </select>

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_telegram', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="telegram" class="input-group-text">{{__('Telegram Username')}}  {!! required_mark('kyc_telegram') !!}</label>

                        <input {{ field_value('kyc_telegram', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text" value = "{{ isset($user_kyc) ? $user_kyc->telegram : ''}}" id="telegram" name="telegram">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
        </div>{{-- .row --}}
        <h4 class="text-secondary mgt-0-5x">{{__('Your Address')}}</h4>
        <div class="row">
            @if(field_value('kyc_country', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="country" class="input-group-text">{{__('Country')}} {!! required_mark('kyc_country') !!}</label>

                        <select {{ field_value('kyc_country', 'req' ) == '1' ? 'required ' : '' }}class="form-select" name="country" id="country" data-dd-class="search-on">
                            <option value="">{{__('Select Country')}}</option>
                            @foreach($countries as $country)
                            <option {{ (isset($user_kyc) ? $user_kyc->country : '') == $country ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_state', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="state" class="input-group-text">{{__('State')}} {!! required_mark('kyc_state') !!}</label>

                        <input {{ field_value('kyc_state', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text" value = "{{ isset($user_kyc) ? $user_kyc->state : ''}}" id="state" name="state">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_city', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="city" class="input-group-text">{{__('City')}} {!! required_mark('kyc_city') !!}</label>

                        <input {{ field_value('kyc_city', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text" value = "{{ isset($user_kyc) ? $user_kyc->city : ''}}" id="city" name="city">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_zip', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="zip" class="input-group-text">{{__('Zip / Postal Code')}} {!! required_mark('kyc_zip') !!}</label>

                        <input {{ field_value('kyc_zip', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text" value = "{{ isset($user_kyc) ? $user_kyc->zip : ''}}" id="zip" name="zip">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_address1', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="address_1" class="input-group-text">{{__('Address Line 1')}} {!! required_mark('kyc_address1') !!}</label>

                        <input {{ field_value('kyc_address1', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text" value = "{{ isset($user_kyc) ? $user_kyc->address1 : ''}}" id="address_1" name="address_1">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
            @if(field_value('kyc_address2', 'show' ))
            <div class="col-md-6">
                <div class="input-group mb-1">
                    <label for="address_2" class="input-group-text">{{__('Address Line 2')}} {!! required_mark('kyc_address2') !!}</label>

                        <input {{ field_value('kyc_address2', 'req' ) == '1' ? 'required ' : '' }}class="form-control" type="text"  value = "{{ isset($user_kyc) ? $user_kyc->address2 : ''}}" id="address_2" name="address_2">

                </div>{{-- .input-item --}}
            </div>{{-- .col --}}
            @endif
        </div>{{-- .row --}}
    </div>{{-- .step-fields --}}
</div>
@if($has_docs)
<div class="form-step form-step2">
    <div class="form-step-head card-innr">
        <div class="step-head">
            <div class="step-number">{{ $step_02 }}</div>
            <div class="step-head-text">
                <h4 class="text-warning">{{__('Document Upload')}}</h4>
                <p>{{__('To verify your identity, we ask you to upload high-quality scans or photos of your official identification documents issued by the government.')}}</p>
            </div>
        </div>
    </div>{{-- .step-head --}}
    <div class="form-step-fields card-innr">
        <div class="note note-plane note-light-alt note-md pdb-0-5x">
            <p><i class="bi bi-info-circle"></i>
            {{__('In order to complete, please upload any of the following personal documents.')}}</p>
        </div>
        <div class="gaps-2x"></div>
        @if (!empty($support_docs))
        <ul class="document-list guttar-vr-10px">
            @foreach ($support_docs as $doc_item => $opt)
            @if ($opt)
            <div class="col-lg-3 col-md-3 me-1">
                    @if ($doc_item=='passport' && ($opt))
                        <input class="document-type" type="radio" name="documentType" value="{{ $doc_item }}" id="docType-{{ $doc_item }}" data-title="{{ $title[$doc_item] }}" data-img="{{ asset('assets/images/vector-'.$doc_item.'.png') }}"{{ (isset($default_docs['doc']) && $default_docs['doc'] == $doc_item) ? ' checked' : '' }}>
                        <label for="docType-{{ $doc_item }}">
                                <img style="height:36px;" src="{{ asset('assets/images/icon-passport.png') }}" alt="">
                            <span>{{ $title[$doc_item] }}</span>
                        </label>
                    @endif
                    @if ($doc_item=='nidcard' && ($opt))
                        <input class="document-type" type="radio" name="documentType" data-change=".doc-upload-d2" value="{{ $doc_item }}" id="docType-{{ $doc_item }}" data-title="{{ $title[$doc_item] }}" data-img="{{ asset('assets/images/vector-'.$doc_item.'.png') }}"{{ (isset($default_docs['doc']) && $default_docs['doc'] == $doc_item) ? ' checked' : '' }}>
                        <label for="docType-{{ $doc_item }}">
                                <img style="height:36px;" src="{{ asset('assets/images/icon-national-id.png') }}" alt="">
                            <span>{{ $title[$doc_item] }}</span>
                        </label>
                    @endif
                    @if ($doc_item=='driving' && ($opt))
                        <input class="document-type" type="radio" name="documentType"  value="{{ $doc_item }}" id="docType-{{ $doc_item }}" data-title="{{ $title[$doc_item] }}" data-img="{{ asset('assets/images/vector-'.$doc_item.'.png') }}"{{ (isset($default_docs['doc']) && $default_docs['doc'] == $doc_item) ? ' checked' : '' }}>
                        <label for="docType-{{ $doc_item }}">
                                <img style="height:36px;" src="{{ asset('assets/images/icon-license.png') }}" alt="">
                            <span>{{ $title[$doc_item] }}</span>
                        </label>
                    @endif
            </div>
            @endif
            @endforeach
        </ul>
        @endif
        <div class="doc-upload-area">
            <p class="text-secondary font-bold">{{__('To avoid delays with verification process, please double-check to ensure the below requirements are fully met:')}}</p>
            <ul>
                <li>{{__('Chosen credential must not be expired.')}}</li>
                <li>{{__('Document should be in good condition and clearly visible.')}}</li>
                <li>{{__('There is no light glare or reflections on the card.')}}</li>
                <li>{{__('File is at least 1 MB in size and has at least 300 dpi resolution.')}}</li>
            </ul>
            <div class="gaps-2x"></div>
            <div class="doc-upload doc-upload-d1">
                <h6 class="font-mid doc-type-title">{!! __('Upload Here Your :doctype Copy', ['doctype' => '<storng class="doc-type-name">'.$defaultDoc.'</storng>']) !!}</h6>
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <input class="form-control" type="file" id="document_one" name="document_one" required=""/>
                    </div>
                    <div class="col-sm-4 d-none d-sm-block">
                        <div class="mx-md-4">
                            <img width="160" class="_image" src="{{ asset('assets/images/vector-'.$defaultImg.'.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="doc-upload doc-upload-d2{{ (isset($default_docs['doc']) && $default_docs['doc'] == 'nidcard') ? '' : ' hide' }}">
                <h6 class="font-mid">{{ __('Upload Here Your National ID Back Side') }}</h6>
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <input class="form-control" type="file" id="document_two" name="document_two"/>
                    </div>
                    <div class="col-sm-4 d-none d-sm-block">
                        <div class="mx-md-4">
                            <img width="160" src="{{  asset('assets/images/vector-id-back.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="sap sap-gap"></div>
            <div class="doc-upload doc-upload-d3">
                <h6 class="font-mid">{{__('Upload a selfie as a Photo Proof while holding document in your hand')}}</h6>
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <input class="form-control" type="file" id="document_image_hand" name="document_image_hand" required=""/>
                    </div>
                    <div class="col-sm-4 d-none d-sm-block">
                        <div class="mx-md-4">
                            <img width="160" src="{{ asset('assets/images/vector-hand.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="form-step form-step-final">
    <div class="form-step-fields card-innr">
        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
              <div class="mb-1">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="term-condition" name="condition" required="required" data-msg-required="{{ __("You should read our terms and policy.") }}"/>
                      <label class="form-check-label" for="term-condition">
                          I agree to the <a href="{{ route('terms.show') }}" target="_blank">terms_of_service</a> and
                          <a href="{{ route('policy.show') }}" target="_blank">privacy_policy</a>
                      </label>
                  </div>
              </div>
        @endif
        <div class="input-item">
            <input class="form-check-input" id="info-currect" name="currect" type="checkbox" required="required" data-msg-required="{{ __("Confirm that all information is correct.") }}">
            <label class="form-check-label" for="info-currect">{{__('All the personal information I have entered is correct.')}}</label>
        </div>
        <div class="input-item">
            <input class="form-check-input" id="certification" name="certification" type="checkbox" required="required" data-msg-required="{{ __("Certify that you are individual.") }}">
            <label class="form-check-label" for="certification">{{__("I certify that, I am registering to participate in the trading platform in the capacity of an individual (and beneficial owner) and not as an agent or representative of a third party corporate entity.")}}</label>
        </div>
        <div class="gaps-1x"></div>
        <button class="btn btn-primary" type="submit">{{__('Proceed to Verify')}}</button>
    </div>{{-- .step-fields --}}
</div>
<div class="hiddenFiles"></div>
