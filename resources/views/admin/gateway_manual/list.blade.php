@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Manual Deposit Methods</h4><div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Method')}}</th>
                                <th scope="col">{{ __('locale.Status')}}</th>
                                <th scope="col">{{ __('locale.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($gateways as $gateway)
                                <tr>
                                    <td data-label="{{ __('locale.Method')}}">
                                        <div class="row centerize">
                                            <div class="col-md-3 thumb">
                                                <img src="{{ getImage(imagePath()['gateway']['path'].'/'. $gateway->image,imagePath()['gateway']['size'])}}" alt="{{ __('locale.image')}}"></div>
                                            <span class="col-md-9 name">{{__($gateway->name)}}</span>
                                        </div>
                                    </td>

                                    <td data-label="{{ __('locale.Status')}}">
                                        @if($gateway->status == 1)
                                            <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Action')}}">
                                        <a href="{{ route('admin.payment.manual.edit', $gateway->alias) }}">
                                        <button  class="btn btn-icon btn-warning btn-sm editGatewayBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ __('locale.Edit')}}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        </a>

                                        @if($gateway->status == 0)
                                            <button data-bs-toggle="modal" href="#activateModal" class="btn btn-icon btn-danger btn-sm ms-1 activateBtn" data-code="{{$gateway->code}}" data-name="{{__($gateway->name)}}" data-original-title="{{ __('locale.Enable')}}">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        @else
                                            <button data-bs-toggle="modal" href="#deactivateModal" class="btn btn-icon btn-success btn-sm ms-1 deactivateBtn" data-code="{{$gateway->code}}" data-name="{{__($gateway->name)}}" data-original-title="{{ __('locale.Disable')}}">
                                                <i class="bi bi-eye"></i>
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
            <div class="mb-1">{{ paginateLinks($gateways) }}</div>
        </div>
    </div>



    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Payment Method Activation Confirmation')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.payment.manual.activate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure to activate')}} <span class="fw-bold method-name"></span> {{ __('locale.method')}}?</p>
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
                    <h5 class="modal-title">{{ __('locale.Payment Method Disable Confirmation')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.payment.manual.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure to disable')}} <span class="fw-bold method-name"></span> {{ __('locale.method')}}?</p>
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
    <a class="btn btn-primary" href="{{ route('admin.payment.manual.create') }}"><i class="bi bi-plus"></i>{{ __('locale.Add new')}}</a>
@endpush
@push('script')
    <script>

        $(function () {
            "use strict";

            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });
            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });

        });

    </script>
@endpush
