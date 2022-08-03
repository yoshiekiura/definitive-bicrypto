@extends('layouts.app')
@section('content')
    <div class=" my-2 text-end">
        <a href="{{ route('user.ticket.open') }}" class="btn btn-primary btn-sm">{{ __('locale.New Ticket') }}</a>
    </div>
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('locale.Subject') }}</th>
                                <th>{{ __('locale.Status') }}</th>
                                <th>{{ __('locale.Last Reply') }}</th>
                                <th>{{ __('locale.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $key => $support)
                                <tr>
                                    <td data-label="{{ __('locale.Subject') }}"> <a
                                            href="{{ route('user.ticket.view', $support->ticket) }}"
                                            class="fw-bold">[{{ __('locale.Ticket') }}#{{ $support->ticket }}]
                                            {{ __($support->subject) }} </a></td>
                                    <td data-label="{{ __('locale.Status') }}">
                                        @if ($support->status == 0)
                                            <span class="badge bg-success">{{ __('locale.Open') }}</span>
                                        @elseif($support->status == 1)
                                            <span class="badge bg-primary">{{ __('locale.Answered') }}</span>
                                        @elseif($support->status == 2)
                                            <span class="badge bg-warning">{{ __('locale.Customer Reply') }}</span>
                                        @elseif($support->status == 3)
                                            <span class="badge bg-danger">{{ __('locale.Closed') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('locale.Last Reply') }}">
                                        {{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                    <td data-label="{{ __('locale.Action') }}">
                                        <a href="{{ route('user.ticket.view', $support->ticket) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-display"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%"> {{ __('locale.No results found') }}!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ paginateLinks($supports) }}
            </div>
        </div>
    </div>
@endsection
