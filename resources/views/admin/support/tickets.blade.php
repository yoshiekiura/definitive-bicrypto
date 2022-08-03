@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Tickets</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Subject')}}</th>
                                <th scope="col">{{ __('locale.Submitted By')}}</th>
                                <th scope="col">{{ __('locale.Status')}}</th>
                                <th scope="col">{{ __('locale.Last Reply')}}</th>
                                <th scope="col">{{ __('locale.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td data-label="{{ __('locale.Subject')}}">
                                        <a href="{{ route('admin.ticket.view', $item->id) }}" class="fw-bold"> [Ticket#{{ $item->ticket }}] {{ $item->subject }} </a>
                                    </td>

                                    <td data-label="{{ __('locale.Submitted By')}}">
                                        @if($item->user_id)
                                        <a href="{{ route('admin.users.detail', $item->user_id)}}"> {{@$item->user->fullname}}</a>
                                        @else
                                            <p class="fw-bold"> {{$item->name}}</p>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Status')}}">
                                        @if($item->status == 0)
                                            <span class="badge bg-success">{{ __('locale.Open')}}</span>
                                        @elseif($item->status == 1)
                                            <span class="badge  bg-primary">{{ __('locale.Answered')}}</span>
                                        @elseif($item->status == 2)
                                            <span class="badge bg-warning">{{ __('locale.Customer Reply')}}</span>
                                        @elseif($item->status == 3)
                                            <span class="badge bg-dark">{{ __('locale.Closed')}}</span>
                                        @endif
                                    </td>

                                    <td data-label="{{ __('locale.Last Reply')}}">
                                        {{ diffForHumans($item->last_reply) }}
                                    </td>

                                    <td data-label="{{ __('locale.Action')}}">
                                        <a href="{{ route('admin.ticket.view', $item->id) }}" class="btn btn-info btn-icon btn-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="{{ __('locale.Details')}}">
                                            <i class="bi bi-display"></i>
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
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($items) }}</div>

        </div>
    </div>
@endsection


