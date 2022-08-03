@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Contracts')}}</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Symbol')}}</th>
                                <th scope="col">{{ __('locale.Address')}}</th>
                                <th scope="col">{{ __('locale.Status')}}</th>
                                <th scope="col">{{ __('locale.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contracts as $contract)
                                <tr>
                                    <td data-label="{{ __('locale.Symbol')}}">{{ $contract->symbol }}</td>
                                    <td data-label="{{ __('locale.Address')}}">{{ $contract->address }}</td>
                                    <td data-label="{{ __('locale.Status')}}">
                                        @if($contract->status == 1)
                                            <span class="badge bg-success">{{ __('locale.Enabled')}}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Action')}}">
                                        <a href="javascript:void(0)"
                                           data-id="{{ $contract->id }}"
                                           class="btn btn-contractn btn-danger btn-sm removeModalBtn" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="{{ __('locale.Remove')}}" onclick="$('#removeModal').find('input[name=id]').val($(this).data('id'));$('#removeModal').modal('show');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <a href="{{ route('admin.contracts.edit',$contract->id) }}"
                                           class="btn btn-contractn btn-warning btn-sm" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="{{ __('locale.Edit')}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
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
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($contracts) }}</div>

        </div>


    </div>

    {{-- Remove Subscriber MODAL --}}
    <div id="removeModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Are you sure want to remove?')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.contracts.remove') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <p><span class="fw-bold"></span> {{ __('locale.contract will be removed.')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{ __('locale.Remove')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.contracts.new') }}" class="btn btn-primary" ><i class="bi bi-plus-lg"></i> {{ __('locale.New Contract')}}</a>
@endpush
