@extends('layouts.app')


@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Template Sections')}}</h4>
                <div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.Name')}}</th>
                            <th scope="col">{{ __('locale.Status')}}</th>
                            <th scope="col">{{ __('locale.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                        <tr>
                            <td data-label="{{ __('locale.Name')}}">{{ $section->title }}</td>
                            <td data-label="{{ __('locale.Status')}}">
                                @if($section->status == 1)
                                <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                @elseif($section->status == 2)
                                <span class="badge bg-secondary">{{ __('locale.In Development')}}</span>
                                @else
                                <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('locale.Action')}}">
                                @if($section->status != 2)
                                <a href="{{ route('admin.template.editor',[$section->template_id,$section->page_id,$section->section_id]) }}" class="btn btn-icon btn-warning"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('locale.Edit')}}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endif
                                @if($section->status == 0)
                                    <a class="activateBtn" data-bs-toggle="modal" data-bs-target="#activateModal"
                                    data-template_id="{{ $section->template_id }}" data-page_id="{{ $section->page_id }}" data-section_id="{{ $section->section_id }}" data-title="{{ __($section->title) }}">
                                        <button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('locale.Enable')}}"
                                                class="btn btn-icon btn-success rounded ms-1">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </a>
                                @elseif($section->status == 1)
                                    <a class="deactivateBtn"
                                    data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                    data-template_id="{{ $section->template_id }}" data-page_id="{{ $section->page_id }}" data-section_id="{{ $section->section_id }}" data-title="{{ __($section->title) }}">
                                        <button type="button"
                                                class="btn btn-icon btn-danger ms-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('locale.Disable')}}">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table><!-- table end -->
            </div>
        </div><!-- card end -->
        <div class="mb-1">{{ paginateLinks($sections) }}</div>
    </div>
</div>

{{-- ACTIVATE METHOD MODAL --}}
<div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Section Activation Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.template.section.activate') }}" method="POST">
                @csrf
                <input type="hidden" name="template_id">
                <input type="hidden" name="page_id">
                <input type="hidden" name="section_id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to activate')}} <span class="fw-bold section-name"></span> {{ __('locale.Section')}}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{ __('locale.Activate')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- DEACTIVATE METHOD MODAL --}}
<div id="deactivateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Section Disable Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.template.section.deactivate') }}" method="POST">
                @csrf
                <input type="hidden" name="template_id">
                <input type="hidden" name="page_id">
                <input type="hidden" name="section_id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to disable')}} <span class="fw-bold section-name"></span> {{ __('locale.Section')}}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-danger">{{ __('locale.Disable')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.template.pages',[$page_id]) }}" class="btn btn-primary btn-sm" ><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush

@push('script')
    <script>
        $(function () {
            "use strict";
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.section-title').text($(this).data('title'));
                modal.find('input[name=template_id]').val($(this).data('template_id'));
                modal.find('input[name=page_id]').val($(this).data('page_id'));
                modal.find('input[name=section_id]').val($(this).data('section_id'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.section-title').text($(this).data('title'));
                modal.find('input[name=template_id]').val($(this).data('template_id'));
                modal.find('input[name=page_id]').val($(this).data('page_id'));
                modal.find('input[name=section_id]').val($(this).data('section_id'));
            });
        });

    </script>
@endpush
