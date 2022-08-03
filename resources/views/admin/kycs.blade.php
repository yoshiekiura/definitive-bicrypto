@extends('layouts.app')
@php
$page_title ="";
@endphp
@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/kyc/style.css'))}}">
@endsection

@section('content')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">KYC Application</h4><div class="card-search"></div>
            </div>
            <div class="card-body">
                <div class="page-nav-wrap">
                    <div class="page-nav-bar justify-content-between bg-lighter">
                        <div class="page-nav w-100 w-lg-auto">
                            <ul class="nav">
                                <li class="nav-item{{ (is_page('kyc-list.pending') ? ' active' : '') }}"><a class="nav-link" href="{{ route('admin.kycs', 'pending') }}">Pending</a></li>

                                <li class="nav-item{{ (is_page('kyc-list.missing') ? ' active' : '') }}"><a class="nav-link" href="{{ route('admin.kycs', 'missing') }}">Missing</a></li>

                                <li class="nav-item{{ (is_page('kyc-list.approved') ? ' active' : '') }}"><a class="nav-link" href="{{ route('admin.kycs', 'approved') }}">Approved</a></li>

                                <li class="nav-item{{ (is_page('kyc-list') ? ' active' : '') }}"><a class="nav-link" href="{{ route('admin.kycs') }}">All</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                @if($kycs->total() > 0)
                <div class="table-responsive" style="min-height: 80vh">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Doc Type</th>
                                <th scope="col">Documents</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">Submitted</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($kycs as $kyc)
                        <tr>
                            <td data-label="User">
                                <span class="d-none">{{ $kyc->status }}</span>
                                <span class="row h5">{{ _x($kyc->firstName).' '._x($kyc->lastName) }}</span>
                                <span class="row">{{ set_id($kyc->userId) }}</span>
                            </td>
                            <td data-label="Doc Type">
                                <span class="sub sub-s2 sub-dtype">{{ ucfirst($kyc->documentType) }}</span>
                            </td>

                            <td data-label="Doc Front">
                                @if($kyc->document != NULL)
                                    @if(pathinfo(storage_path('app/'.$kyc->document), PATHINFO_EXTENSION) != 'pdf')
                                        <a href="{{ getImage('assets/images/kyc/'.$kyc->document) }}" class="image-popup">{{ ($kyc->documentType == 'nidcard') ? 'Front Side' : 'Document' }}</a>
                                    @else
                                        {!! ($kyc->documentType == 'nidcard') ? '<a>Front Side</a>' : '<a>Document</a>' !!}
                                    @endif
                                    &nbsp; <a title="Download" href="{{ getImage('assets/images/kyc/'.$kyc->document) }}" target="_blank"><i class="bi bi-download"></i></a>
                                @else
                                &nbsp;
                                @endif
                            </td>
                            <td data-label="Doc Back">
                                @if($kyc->document2 != NULL)
                                    @if(pathinfo(storage_path('app/'.$kyc->document2), PATHINFO_EXTENSION) != 'pdf')
                                        <a href="{{ getimage('assets/images/kyc/'.$kyc->document2) }}" class="image-popup">{{ ($kyc->documentType == 'nidcard') ? 'Back Side' : 'Proof' }}</a>
                                    @else
                                        {!! ($kyc->documentType == 'nidcard') ? '<a>Back Side</a>' : '<a>Proof</a>' !!}
                                    @endif
                                    &nbsp; <a title="Download" href="{{ getimage('assets/images/kyc/'.$kyc->document2) }}" target="_blank"><i class="bi bi-download"></i></a>
                                @else
                                &nbsp;
                                @endif
                            </td>
                            <td data-label="Doc Proof">
                                @if($kyc->document3 != NULL)
                                    @if(pathinfo(storage_path('app/'.$kyc->document3), PATHINFO_EXTENSION) != 'pdf')
                                        <a href="{{ getimage('assets/images/kyc/'.$kyc->document3) }}" class="image-popup">Proof</a>
                                    @else
                                        <a>Proof</a>
                                    @endif
                                    &nbsp; <a title="Download" href="{{ getimage('assets/images/kyc/'.$kyc->document3) }}" target="_blank"><i class="bi bi-download"></i></a>
                                @else
                                &nbsp;
                                @endif
                            </td>
                            <td data-label="Date">
                                <span class="sub sub-s2 sub-time">{{ _date($kyc->created_at) }}</span>
                            </td>
                            <td data-label="Status">
                                <span class="dt-status-md badge1 badge-outline badge-md badge-{{ __status($kyc->status,'status') }}">{{ __status($kyc->status,'text') }}</span>
                            </td>
                            <td data-label="Actions">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-dark btn-icon" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('admin.kyc.view', [$kyc->id, 'kyc_details' ])}}"><i class="bi bi-eye"></i> View Details</a></a>
                                        @if($kyc->status != 'approved')
                                            <a class="dropdown-item kyc_action kyc_approve" data-bs-toggle="modal" data-bs-target="#kyc_action" data-id="{{ $kyc->id }}" data-toggle="modal" data-target="#actionkyc"><i class="bi bi-check-square"></i> Update Status</a></li>
                                        @endif
                                        @if($kyc->status == 'missing' || $kyc->status == 'rejected')
                                            <a class="dropdown-item delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $kyc->id }}" data-name="{{ $kyc->id }}"><i class="bi bi-trash"></i> Delete</a></li>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                @else
                    <div class="bg-light text-center rounded py-2">
                        <p><i class="bi bi-arrow-down"></i><br>{{ ($is_page=='all') ? 'No KYC application found!' : 'No '.$is_page.' KYC application here!' }}</p>
                        <p><a class="btn btn-primary btn-auto" href="{{ route('admin.kycs') }}">View All KYC Application</a></p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-1 me-4">{{ paginateLinks($kycs) }}</div>

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

@push('breadcrumb-plugins')
<div class="d-flex flex-row-reverse">
<div class="col-lg-4 col-md-6 col-sm-12">
    <form action="{{route('admin.kyc.search')}}" method="GET" class="form-inline">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="@lang('Search ...')" value="{{ $search ?? '' }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </form>
</div>
</div>
@endpush

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
