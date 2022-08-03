@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Currencies')}}</h4>
                <div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.Currency')}}</th>
                            <th scope="col">{{ __('locale.Deposit')}}</th>
                            <th scope="col">{{ __('locale.Withdraw')}}</th>
                            <th scope="col">{{ __('locale.Status')}}</th>
                            <th scope="col">{{ __('locale.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currencies as $currency)
                            <tr>
                                <td data-label="{{ __('locale.Currency')}}">
                                    <img class="avatar-content me-1" style="max-height: 48px;max-width:48px;"
                                        src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($currency->symbol).'.png') }}" />
                                        <span class="fw-bold fs-6">{{ $currency->symbol }} ({{ $currency->name }})</span>
                                </td>
                                <td data-label="{{ __('locale.Deposit')}}">
                                    @if($currency->deposit == 1)
                                    <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                    @else
                                    <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Withdraw')}}">
                                    @if($currency->withdraw == 1)
                                    <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                    @else
                                    <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Status')}}">
                                    @if($currency->status == 1)
                                    <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                    @else
                                    <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Action')}}">
                                    @if($currency->status == 0)
                                        <button type="button"
                                                class="btn btn-icon btn-success btn-sm activateBtn"
                                                data-bs-toggle="modal" data-bs-target="#activateModal"
                                                data-id="{{ $currency->id }}" data-name="{{ __($currency->name) }}"
                                                title="{{ __('locale.Enable')}}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-icon btn-danger btn-sm deactivateBtn"
                                                data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                                data-id="{{ $currency->id }}" data-name="{{ __($currency->name) }}"
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
        </div>
    </div>
</div>
{{-- ACTIVATE METHOD MODAL --}}
<div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('locale.currency Activation Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.provider.currency.activate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="provider_id" value="{{ $id }}">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to activate')}} <span class="fw-bold currency-name"></span> {{ __('locale.currency')}}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-success">{{ __('locale.Activate')}}</button>
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
                <h5 class="modal-title">{{ __('locale.currency Deactivation Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.provider.currency.deactivate') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="provider_id" value="{{ $id }}">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to deactivate')}} <span class="fw-bold currency-name"></span> {{ __('locale.currency')}}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('locale.Close')}}</button>
                    <button type="submit" class="btn btn-danger">{{ __('locale.Deactivate')}}</button>
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
                modal.find('.currency-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });
            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.currency-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

        });

    </script>
@endpush

@push('breadcrumb-plugins')
    <a class="btn btn-primary" href="{{ route('admin.provider.index') }}"><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush
