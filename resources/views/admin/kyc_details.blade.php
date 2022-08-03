@extends('layouts.app')
@php
$page_title ="KYC Details"
@endphp
@section('title', 'KYC details')
@php
$space = "&nbsp;";
@endphp
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/kyc/style.css'))}}">
@endsection
@section('content')
<div class="page-content">
    <div class="container">
        <div class="card content-area">
            <div class="card-innr">
                <div class="card-head d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-1">KYC Information of <span>{{ _x($kyc->firstName).' '._x($kyc->lastName) }}</h4>
                    <div class="d-flex align-items-center guttar-20px">
                        <div class="flex-col d-sm-block d-none">
                            <a href="{{ route('admin.kycs') }}" class="btn btn-light btn-sm btn-auto btn-primary"><i class="bi bi-chevron-left mr-3"></i> Back</a>
                        </div>
                        <div class="flex-col d-sm-none">
                            <a href="{{ route('admin.kycs') }}" class="btn btn-icon btn-sm btn-primary"><i class="bi bi-arrow-left"></i></a>
                        </div>
                        <div class="relative d-inline-block">
                            <div class="dropdown">
                                <button type="button" class="btn btn-dark btn-icon btn-sm ms-1" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if($kyc->status != 'approved')
                                        <a class="dropdown-item kyc_action kyc_approve" data-bs-toggle="modal" data-bs-target="#kyc_action" data-id="{{ $kyc->id }}" data-toggle="modal" data-target="#actionkyc"><i class="bi bi-check-square"></i> Update Status</a></li>
                                    @endif
                                    @if($kyc->status == 'missing' || $kyc->status == 'rejected')
                                        <a class="dropdown-item delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $kyc->id }}" data-name="{{ $kyc->id }}"><i class="bi bi-trash"></i> Delete</a></li>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gaps-1-5x"></div>
                <div class="data-details d-md-flex flex-wrap align-items-center justify-content-between">
                    <div class="fake-class">
                        <span class="data-details-title">Submited By</span>
                        <span class="data-details-info">{{ set_id($kyc->userId) }}</span>
                    </div>
                    <div class="fake-class">
                        <span class="data-details-title">Submited On</span>
                        <span class="data-details-info">{{ _date($kyc->created_at) }}</span>
                    </div>
                    @if($kyc->reviewedBy != 0)
                    <div class="fake-class">
                        <span class="data-details-title">Checked By</span>
                        <span class="data-details-info">{{ $kyc->checker_info->name }}</span>
                    </div>
                    @else
                    <div class="fake-class">
                        <span class="data-details-title">Checked On</span>
                        <span class="data-details-info">Not reviewed yet</span>
                    </div>
                    @endif
                    @if($kyc->reviewedAt != NULL)
                    <div class="fake-class">
                        <span class="data-details-title">Checked On</span>
                        <span class="data-details-info">{{ _date($kyc->updated_at) }}</span>
                    </div>
                    @endif
                    <div class="fake-class">
                        <span class="badge badge-md badge-{{ __status($kyc->status,'status')}} ucap">{{ __status($kyc->status,'text') }}</span>
                    </div>
                    @if($kyc->notes !== NULL)
                    <div class="gaps-2x w-100 d-none d-md-block"></div>
                    <div class="w-100">
                        <span class="data-details-title">Admin Note</span>
                        <span class="data-details-info">{!! $kyc->notes !!}</span>
                    </div>
                    @endif
                </div>
                <div class="gaps-3x mt-1"></div>
                <h6 class="card-sub-title">Personal Information</h6>
                <ul class="data-details-list">
                    <li>
                        <div class="data-details-head">First Name</div>
                        <div class="data-details-des">{!! ($kyc->firstName) ? _x($kyc->firstName) : $space !!}</div>
                    </li>{{-- li --}}
                    <li>
                        <div class="data-details-head">Last Name</div>
                        <div class="data-details-des">{!! ($kyc->lastName) ? _x($kyc->lastName) : $space !!}</div>
                    </li>{{-- li --}}
                    <li>
                        <div class="data-details-head">Email Address</div>
                        <div class="data-details-des">{!! ($kyc->email) ? explode_user_for_demo($kyc->email, auth()->user()->type) : $space !!}</div>
                    </li>{{-- li --}}
                    <li>
                        <div class="data-details-head">Phone Number</div>
                        <div class="data-details-des">{!! ($kyc->phone) ? _x($kyc->phone) : $space !!}</div>
                    </li>{{-- li --}}
                    <li>
                        <div class="data-details-head">Date of Birth</div>
                        <div class="data-details-des">{!! ($kyc->dob) ? _date($kyc->dob, get_setting('site_date_format')) : $space !!}</div>
                    </li>{{-- li --}}
                    <li>
                        <div class="data-details-head">Full Address</div>
                        <div class="data-details-des">{!! kyc_address($kyc, $space) !!}</div>
                    </li>{{-- li --}}
                    <li>
                        <div class="data-details-head">Country of Residence</div>
                        <div class="data-details-des">{!! ($kyc->country) ? _x($kyc->country) : $space !!}</div>
                    </li>{{-- li --}}
                    <li>
                        <div class="data-details-head">Telegram Username</div>
                        <div class="data-details-des">
                            @if ($kyc->telegram)
                            <span>{{ '@'.preg_replace('/@/', '', _x($kyc->telegram), 1) }}</span><a href="https://t.me/{{preg_replace('/@/', '', _x($kyc->telegram), 1)}}" target="_blank"><em class="far fa-paper-plane"></em></a>
                            @else
                            &nbsp;
                            @endif
                        </div>
                    </li>{{-- li --}}
                </ul>
                <div class="gaps-3x"></div>
                <h6 class="card-sub-title">Uploaded Documnets</h6>
                <ul class="data-details-list">
                    <li>
                        <div class="data-details-head">
                            @if($kyc->documentType == 'nidcard')
                            National ID Card
                            @elseif($kyc->documentType == 'passport')
                            Passport
                            @elseif($kyc->documentType == 'license')
                            Driving License
                            @else
                            Documents
                            @endif
                        </div>
                        @if($kyc->document != NULL||$kyc->document2 != NULL||$kyc->document3 != NULL)
                        <ul class="data-details-docs">
                            @if($kyc->document != NULL)
                            <li>
                                <span class="data-details-docs-title">{{ $kyc->documentType == 'nidcard' ? 'Front Side' : 'Document' }}</span>
                                <div class="data-doc-item data-doc-item-lg">
                                    <div class="data-doc-image">
                                        <img class="img-fluid img-thumbnail" src="{{ getImage('assets/images/kyc/'.$kyc->document) }}">
                                    </div>
                                    <ul class="data-doc-actions">
                                        <li><a href="{{ getImage('assets/images/kyc/'.$kyc->document) }}" target="_blank" ><i class="bi bi-cloud-download text-white"></i></a></li>
                                    </ul>
                                </div>
                            </li>{{-- li --}}
                            @endif
                            @if($kyc->document2 != NULL)
                            <li>
                                <span class="data-details-docs-title">{{ $kyc->documentType == 'nidcard' ? 'Back Side' : 'Proof' }}</span>
                                <div class="data-doc-item data-doc-item-lg">
                                    <div class="data-doc-image">
                                        <img class="img-fluid img-thumbnail" src="{{ getImage('assets/images/kyc/'.$kyc->document2) }}">
                                    </div>
                                    <ul class="data-doc-actions">
                                        <li><a href="{{ getImage('assets/images/kyc/'.$kyc->document2) }}" target="_blank"><i class="bi bi-cloud-download text-white"></i></a></li>
                                    </ul>
                                </div>
                            </li>{{-- li --}}
                            @endif

                            @if($kyc->document3 != NULL)
                            <li>
                                <span class="data-details-docs-title">Proof</span>
                                <div class="data-doc-item data-doc-item-lg">
                                    <div class="data-doc-image">
                                        <img class="img-fluid img-thumbnail" src="{{ getImage('assets/images/kyc/'.$kyc->document3) }}">
                                    </div>
                                    <ul class="data-doc-actions">
                                        <li><a href="{{ getImage('assets/images/kyc/'.$kyc->document3) }}" target="_blank"><i class="bi bi-cloud-download text-white"></i></a></li>
                                    </ul>
                                </div>
                            </li>{{-- li --}}
                            @endif
                        </ul>
                        @else
                        No document uploaded.
                        @endif
                    </li>{{-- li --}}
                </ul>
            </div>{{-- .card-innr --}}
        </div>{{-- .card --}}
    </div>{{-- .container --}}
</div>{{-- .page-content --}}

<div id="kyc_action" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.KYC Update Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form action="{{ route('admin.kyc.update') }}" method="POST" id="kyc_status_form" class="card-body">
                @csrf
                <input type="hidden" name="req_type" value="update_kyc_status">
                <input type="hidden" name="kyc_id" id="kyc_id" required="required">
                <div id="missingnotediv" class="input-item input-with-label hide">
                    <label class="input-item-label">Admin Note</label>
                    <textarea name="notes" class="input-bordered input-textarea input-textarea-sm"></textarea>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Status</label>
                    <select class="form-select" id="status" name="status">
                      <option selected>Choose...</option>
                      <option value="approved">Approve</option>
                      <option value="missing">Missing</option>
                      <option value="rejected">Reject</option>
                    </select>
                  </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-success">{{ __('locale.Update')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.KYC Delete Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.kyc.delete') }}" method="POST">
                @csrf
                <input type="hidden" id="idd" name="id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure want to Reject This KYC Application')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-success">{{ __('locale.Delete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
.hide {
display:none;
}
</style>
@endsection
@section('page-script')
<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
@endsection
@push('script')
<script>
$(document).on('click','.delete',function(){
 $('#idd').val($(this).attr('data-id'));
});
$(document).on('click','.kyc_action',function(){
 $('#kyc_id').val($(this).attr('data-id'));
});
$(function () {
$("#status").change(function() {
var val = $(this).val();
if(val === "missing") {
$("#missingnotediv").removeClass('hide');
} else {
$("#missingnotediv").addClass('hide');
}
});
});
</script>
@endpush
