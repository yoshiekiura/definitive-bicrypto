@extends('layouts.app')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('locale.Tokens') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Name') }}</th>
                                <th scope="col">{{ __('locale.Symbol') }}</th>
                                <th scope="col">{{ __('locale.Price') }}</th>
                                <th scope="col">{{ __('locale.Type') }}</th>
                                <th scope="col">{{ __('locale.Status') }}</th>
                                <th scope="col">{{ __('locale.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($icos as $ico)
                                <tr>
                                    <td data-label="{{ __('locale.Name') }}">{{ $ico->name }}</td>
                                    <td data-label="{{ __('locale.Symbol') }}">{{ $ico->symbol }}</td>
                                    <td data-label="{{ __('locale.Price') }}">
                                        <div span class="text-danger">{{ __('locale.Soft Cap') }}: <span
                                                class="fw-bold">{{ getAmount($ico->soft_price) }}</span></div>
                                        <div span class="text-success">{{ __('locale.Hard Cap') }}: <span
                                                class="fw-bold">{{ getAmount($ico->hard_price) }}</span></div>
                                    </td>
                                    <td data-label="{{ __('locale.Type') }}">
                                        @if ($ico->type == 1)
                                            <span class="badge bg-info">{{ __('locale.Soft') }}</span>
                                        @elseif ($ico->type == 2)
                                            <span class="badge bg-info">{{ __('locale.Soft/Hard') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Status') }}">
                                        @if ($ico->status == 0)
                                            <span class="badge bg-warning">{{ __('locale.Upcoming') }}</span>
                                        @elseif ($ico->status == 1)
                                            @if ($ico->stage == 0)
                                                <span class="badge bg-success">{{ __('locale.Soft Cap Started') }}</span>
                                            @elseif($ico->stage == 1)
                                                <span class="badge bg-success">{{ __('locale.Soft Cap Ended') }}</span>
                                            @elseif($ico->stage == 2)
                                                <span class="badge bg-success">{{ __('locale.Hard Cap Started') }}</span>
                                            @endif
                                        @elseif ($ico->status == 2)
                                            <span class="badge bg-danger">{{ __('locale.Sale Ended') }}</span>
                                        @elseif ($ico->status == 3)
                                            <span class="badge bg-secondary">{{ __('locale.Canceled') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Action') }}">
                                        <a href="javascript:void(0)" data-id="{{ $ico->id }}"
                                            class="btn btn-icon btn-danger btn-sm removeModalBtn" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="{{ __('locale.Remove') }}"
                                            onclick="$('#removeModal').find('input[name=id]').val($(this).data('id'));$('#removeModal').modal('show');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <a href="{{ route('admin.ico.edit', $ico->id) }}"
                                            class="btn btn-icon btn-warning btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="{{ __('locale.Edit') }}">
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
            </div><!-- card end -->
            <div class="mb-1">{{ paginateLinks($icos) }}</div>

        </div>


    </div>

    {{-- Remove Subscriber MODAL --}}
    <div id="removeModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('locale.Are you sure want to remove?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.ico.remove') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <p><span class="fw-bold"></span> {{ __('locale.ico will be removed.') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('locale.Remove') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.ico.new') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i>
        {{ __('locale.New Token') }}</a>
@endpush
