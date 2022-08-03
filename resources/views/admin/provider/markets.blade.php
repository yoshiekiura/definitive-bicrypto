@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Markets')}}</h4>
                <div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.Market')}}</th>
                            <th scope="col">{{ __('locale.Fees')}}</th>
                            <th scope="col">{{ __('locale.Limits')}}</th>
                            <th scope="col">{{ __('locale.Status')}}</th>
                            <th scope="col">{{ __('locale.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($markets as $pairs)
                            @forelse($pairs as $market)
                                <tr>
                                    <td data-label="{{ __('locale.market')}}">
                                        <span class="fw-bold fs-6">{{ $market->symbol }}</span>
                                    </td>
                                    <td data-label="{{ __('locale.Fees')}}">
                                        <div class="fw-bold">{{ __('locale.Taker')}}: <span class="text-success">{{ $market->taker }}</span></div>
                                        <div class="fw-bold">{{ __('locale.Maker')}}: <span class="text-success">{{ $market->maker }}</span></div>
                                    </td>
                                    <td data-label="{{ __('locale.Limits')}}">
                                        <div class="fw-bold">{{ __('locale.Minimum')}}: <span class="text-success">{{ $market->min_amount }}</span></div>
                                        <div class="fw-bold">{{ __('locale.Maximum')}}: <span class="text-success">{{ $market->max_amount }}</span></div>
                                    </td>
                                    <td data-label="{{ __('locale.Status')}}">
                                        @if($market->status == 1)
                                        <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                        @else
                                        <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Action')}}">
                                        @if($market->status == 0)
                                            <button type="button"
                                                    class="btn btn-icon btn-success btn-sm activateBtn"
                                                    data-bs-toggle="modal" data-bs-target="#activateModal"
                                                    data-symbol="{{ $market->symbol }}"
                                                    title="{{ __('locale.Enable')}}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="btn btn-icon btn-danger btn-sm deactivateBtn"
                                                    data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                                    data-symbol="{{ $market->symbol }}"
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
                        @endforeach
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
                <h5 class="modal-title">{{ __('locale.market Activation Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.provider.market.activate') }}" method="POST">
                @csrf
                <input type="hidden" name="symbol">
                <input type="hidden" name="provider_id" value="{{ $id }}">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to activate')}} <span class="fw-bold market-name"></span> {{ __('locale.market')}}?</p>
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
                <h5 class="modal-title">{{ __('locale.market Deactivation Confirmation')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.provider.market.deactivate') }}" method="POST">
                @csrf
                <input type="hidden" name="symbol">
                <input type="hidden" name="provider_id" value="{{ $id }}">
                <div class="modal-body">
                    <p>{{ __('locale.Are you sure to deactivate')}} <span class="fw-bold market-name"></span> {{ __('locale.market')}}?</p>
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
                modal.find('.market-name').text($(this).data('symbol'));
                modal.find('input[name=symbol]').val($(this).data('symbol'));
            });
            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.market-name').text($(this).data('symbol'));
                modal.find('input[name=symbol]').val($(this).data('symbol'));
            });

        });

    </script>
@endpush

@push('breadcrumb-plugins')
    <a href="{{ route('admin.provider.index') }}" class="btn btn-primary btn-sm" ><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush
