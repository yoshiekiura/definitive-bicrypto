@extends('layouts.app')

@section('content')

<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.method')}}</th>
                                <th scope="col">{{ __('locale.Currency')}}</th>
                                <th scope="col">{{ __('locale.Charge')}}</th>
                                <th scope="col">@lang('Withdraw Limit')</th>
                                <th scope="col">@lang('Processing Time') </th>
                                <th scope="col">{{ __('locale.Status')}}</th>
                                <th scope="col">{{ __('locale.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($methods as $method)
                                <tr>
                                    <td data-label="{{ __('locale.method')}}">
                                        <div class="row centerize">
                                            <div class="col-md-3 thumb">
                                                <img src="{{ getImage(imagePath()['withdraw']['method']['path'].'/'. $method->image,imagePath()['withdraw']['method']['size'])}}" alt="{{ __('locale.image')}}"></div>

                                            <span class="col-md-9 name">{{__($method->name)}}</span>
                                        </div>
                                    </td>

                                    <td data-label="{{ __('locale.Currency')}}"
                                        class="fw-bold">{{ __($method->currency) }}</td>
                                    <td data-label="{{ __('locale.Charge')}}"
                                        class="fw-bold">{{ getAmount($method->fixed_charge)}} {{__($general->cur_text) }} {{ (0 < $method->percent_charge) ? ' + '. getAmount($method->percent_charge) .' %' : '' }} </td>
                                    <td data-label="@lang('Withdraw Limit')"
                                        class="fw-bold">{{ $method->min_limit + 0 }}
                                        - {{ $method->max_limit + 0 }} {{__($general->cur_text) }}</td>
                                    <td data-label="@lang('Processing Time')">{{ $method->delay }}</td>
                                    <td data-label="{{ __('locale.Status')}}">
                                        @if($method->status == 1)
                                            <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Action')}}">
                                        <a href="{{ route('admin.withdraw.method.edit', $method->id)}}">
                                            <button class="btn btn-icon btn-warning btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="{{ __('locale.Edit')}}"><i class="bi bi-pen"></i> </button>
                                        </a>
                                        @if($method->status == 1)
                                            <button href="javascript:void(0)" class="btn btn-icon btn-danger btn-sm deactivateBtn" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="{{ __('locale.Disable')}}" data-id="{{ $method->id }}" data-name="{{ __($method->name) }}">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        @else
                                            <button href="javascript:void(0)" class="btn btn-icon btn-success btn-sm activateBtn"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="@lang('Enable')"
                                               data-id="{{ $method->id }}" data-name="{{ __($method->name) }}">
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
                </div>
            </div><!-- card end -->
        </div>



    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Withdrawal Method Activation Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.withdraw.method.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class="fw-bold method-name"></span> {{ __('locale.method')}}?</p>
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
                    <h5 class="modal-title">@lang('Withdrawal Method Disable Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.withdraw.method.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span class="fw-bold method-name"></span> {{ __('locale.method')}}?</p>
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
    <a class="btn btn-primary" href="{{ route('admin.withdraw.method.create') }}"><i class="bi bi-plus"></i>{{ __('locale.Add new')}}</a>
@endpush


@push('script')
    <script>
        $(function () {
            "use strict";
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });
        });
    </script>
@endpush
