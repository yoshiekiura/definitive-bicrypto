@extends('layouts.app')

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">{{ __('locale.Title')}}</th>
                    <th scope="col">{{ __('locale.Order')}}</th>
                    <th scope="col">{{ __('locale.Status')}}</th>
                    <th scope="col">{{ __('locale.Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sidebars as $sidebar)
                    <tr>
                        <td data-label="{{ __('locale.Title')}}">{{ $sidebar->title }}</td>
                        <td data-label="{{ __('locale.Order')}}">{{ $sidebar->order }}</td>
                        <td data-label="{{ __('locale.Status')}}">
                            @if($sidebar->status == 1)
                            <span class="badge bg-success">{{ __('locale.Active')}}</span>
                            @else
                            <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                            @endif
                        </td>
                        <td data-label="{{ __('locale.Action')}}">
                            {{-- <a href="{{ route('admin.sidebar.edit',$sidebar->id) }}" class="btn btn-icon btn-warning btn-sm"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('locale.Edit')}}">
                                <i class="bi bi-pencil-square"></i>
                            </a> --}}
                            @if($sidebar->status == 0)
                                <button type="button"
                                        class="btn btn-icon btn-success rounded activateBtn btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#activateModal"
                                        data-id="{{ $sidebar->id }}" data-name="{{ __($sidebar->name) }}"
                                        title="{{ __('locale.Enable')}}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-icon btn-danger deactivateBtn btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                        data-id="{{ $sidebar->id }}" data-name="{{ __($sidebar->name) }}"
                                        title="{{ __('locale.Disable')}}">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
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

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Sidebar Item Activation Confirmation')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.sidebar.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure to activate')}} <span class="fw-bold sidebar-name"></span> {{ __('locale.this sidebar item')}}?</p>
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
                    <h5 class="modal-title">{{ __('locale.Sidebar Item Disable Confirmation')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.sidebar.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure to disable')}} <span class="fw-bold sidebar-name"></span> {{ __('locale.this sidebar item')}}?</p>
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
                modal.find('.sidebar-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.sidebar-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

        });

    </script>
@endpush
