@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Subscribers</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Email')}}</th>
                                <th scope="col">{{ __('locale.Joined')}}</th>
                                <th scope="col">{{ __('locale.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subscribers as $subscriber)
                                <tr>
                                    <td data-label="{{ __('locale.Email')}}">{{ $subscriber->email }}</td>
                                    <td data-label="{{ __('locale.Joined')}}">{{ showDateTime($subscriber->created_at) }}</td>
                                    <td data-label="{{ __('locale.Action')}}">
                                        <a href="javascript:void(0)"
                                           data-id="{{ $subscriber->id }}"
                                           data-email="{{ $subscriber->email }}"
                                           class="btn-icon btn-danger ms-1 removeModalBtn" data-bs-toggle="tooltip"
                                           data-bs-placement="top" title="{{ __('locale.Remove')}}">
                                            <i class="bi bi-trash"></i>
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
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($subscribers) }}</div>

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
                <form action="{{ route('admin.subscriber.remove') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="subscriber">
                        <p><span class="fw-bold subscriber-email"></span> {{ __('locale.will be removed.')}}</p>
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
    <a href="{{ route('admin.subscriber.sendEmail') }}" class="btn btn-primary" ><i class="bi bi-send"></i>{{ __('locale. Send Email')}}</a>
@endpush

@push('script')
    <script>
        $(function(){
            "use strict";

            $('.removeModalBtn').on('click', function() {
                $('#removeModal').find('input[name=subscriber]').val($(this).data('id'));
                $('#removeModal').find('.subscriber-email').text($(this).data('email'));
                $('#removeModal').modal('show');
            });
        });

    </script>
@endpush
