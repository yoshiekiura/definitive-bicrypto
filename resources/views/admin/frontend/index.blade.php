@extends('layouts.app')


@section('content')
<div class="row" id="table-hover-row">
    @forelse($templates as $template)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card img-cover" style="@if($template->status == 1) box-shadow: 0 4px 24px 0 rgb(7 255 0 / 27%); @endif background-image: url('{{ getImage('images/frontends/'.$template->title.'.png') }}')">
            <div class="card-img-overlay  text-center">
                @if ($template->activated == 1)
                    @if ($template->installed == 1)
                        <a href="{{ route('admin.template.pages',$template->id) }}" class="btn btn-icon btn-info btn-sm" style="top:80%"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('locale.Edit')}}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @php
                            $res = $api->check_update($template->product_id);
                        @endphp
                        @if($res['status'])
                            <a type="button" class="btn btn-warning btn-sm" style="top:80%" href="{{ route('admin.template.install',$template->product_id) }}">Update Available</a>
                        @endif
                        @if($template->status == 0)
                            <button type="button" data-bs-toggle="modal" data-bs-target="#activateModal"
                            data-id="{{ $template->id }}" data-name="{{ __($template->name) }}"
                                    class="btn btn-icon btn-success ms-1 btn-sm activateBtn" style="top:80%">
                                    <i class="bi bi-check-lg"></i> Activate
                            </button>
                        @endif
                    @else
                        <a href="{{ route('admin.template.install',[$template->product_id]) }}" style="top:80%" class="btn btn-icon btn-sm btn-dark ms-1">
                            <i class="bi bi-download"></i> Install
                        </a>
                    @endif
                @else
                    <a href="{{ route('admin.template.activater',[$template->product_id]) }}" style="top:80%" class="btn btn-icon btn-sm btn-success ms-1">
                        Verify License
                    </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <tr>
        <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
    </tr>
    @endforelse
</div>

{{-- ACTIVATE METHOD MODAL --}}
<div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.Template Activation Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.template.activate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to activate')}} <span class="fw-bold section-name"></span> {{ __('locale.Template')}}?</p>
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
                <h5 class="modal-title">{{ __('locale.Template Disable Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.template.deactivate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to disable')}} <span class="fw-bold section-name"></span> {{ __('locale.Template')}}?</p>
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

@push('script')
    <script>
        $(function () {
            "use strict";
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.template-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.template-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });
        });

    </script>
@endpush
