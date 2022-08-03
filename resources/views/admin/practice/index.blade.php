@extends('layouts.app')
@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Practice Contracts</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.ID')}}</th>
                                <th scope="col">{{ __('locale.Username')}}</th>
                                <th scope="col">{{ __('locale.Symbol')}}</th>
                                <th scope="col">{{ __('locale.Amount')}}</th>
                                <th scope="col">{{ __('locale.HighLow')}}</th>
                                <th scope="col">{{ __('locale.Result')}}</th>
                                <th scope="col">{{ __('locale.Status')}}</th>
                                <th scope="col">{{ __('locale.Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($practiceLogs as $practiceLog)
                            <tr>
                                <td data-label="{{ __('locale.ID')}}">{{__($loop->iteration)}}</td>
                                <td data-label="{{ __('locale.Username')}}"><a href="{{ route('admin.users.detail', $practiceLog->user_id) }}">{{ $practiceLog->user->username }}</a></td>
                                <td data-label="{{ __('locale.Symbol')}}" class="text-uppercase">{{__($practiceLog->symbol)}}/{{$practiceLog->pair}}</td>
                                <td data-label="{{ __('locale.Amount')}}">{{__(getAmount($practiceLog->amount))}} {{$practiceLog->pair}}</td>
                                <td data-label="{{ __('locale.High Low')}}">
                                    @if($practiceLog->hilow == 1)
                                        <span class="badge bg-success">{{ __('locale.High')}}</span>
                                    @elseif($practiceLog->hilow == 2)
                                        <span class="badge bg-danger">{{ __('locale.Low')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Result')}}">
                                    @if($practiceLog->result == 1)
                                        <span class="badge bg-success">{{ __('locale.Win')}}</span>
                                    @elseif($practiceLog->result == 2)
                                        <span class="badge bg-danger">{{ __('locale.Lose')}}</span>
                                    @elseif($practiceLog->result == 3)
                                        <span class="badge bg-warning">{{ __('locale.Draw')}}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('locale.Pending')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Status')}}">
                                    @if($practiceLog->status == 0)
                                        <span class="badge bg-primary">{{ __('locale.Running')}}</span>
                                    @elseif($practiceLog->status == 1)
                                        <span class="badge bg-success">{{ __('locale.Complete')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Date')}}">
                                    <div>Start: <span class="fw-bold">{{showDateTime($practiceLog->created_at, 'd M, Y h:i:s')}}</span></div>
                                    <div>End: <span class="fw-bold">{{showDateTime($practiceLog->in_time, 'd M, Y h:i:s')}}</span></div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
            </div><div class="mb-1">{{paginateLinks($practiceLogs) }}</div>

        </div>
    </div>
@endsection
