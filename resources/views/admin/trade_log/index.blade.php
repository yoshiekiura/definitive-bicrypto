@extends('layouts.app')
@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Trade Logs</h4><div class="card-search"></div>
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
                            @forelse($tradelogs as $tradelog)
                            <tr>
                                <td data-label="{{ __('locale.ID')}}">{{__($loop->iteration)}}</td>
                                <td data-label="{{ __('locale.Username')}}"><a href="{{ route('admin.users.detail', $tradelog->user_id) }}">{{ $tradelog->user->username }}</a></td>
                                <td data-label="{{ __('locale.Symbol')}}" class="text-uppercase">{{__($tradelog->symbol)}}/{{$tradelog->pair}}</td>
                                <td data-label="{{ __('locale.Amount')}}">{{__(getAmount($tradelog->amount))}} {{$tradelog->pair}}</td>
                                <td data-label="{{ __('locale.High Low')}}">
                                    @if($tradelog->hilow == 1)
                                        <span class="badge bg-success">{{ __('locale.High')}}</span>
                                    @elseif($tradelog->hilow == 2)
                                        <span class="badge bg-danger">{{ __('locale.Low')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Result')}}">
                                    @if($tradelog->result == 1)
                                        <span class="badge bg-success">{{ __('locale.Win')}}</span>
                                    @elseif($tradelog->result == 2)
                                        <span class="badge bg-danger">{{ __('locale.Lose')}}</span>
                                    @elseif($tradelog->result == 3)
                                        <span class="badge bg-warning">{{ __('locale.Draw')}}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('locale.Pending')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Status')}}">
                                    @if($tradelog->status == 0)
                                        <span class="badge bg-primary">{{ __('locale.Running')}}</span>
                                    @elseif($tradelog->status == 1)
                                        <span class="badge bg-success">{{ __('locale.Complete')}}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('locale.Date')}}">
                                    <div>Start: <span class="fw-bold">{{showDateTime($tradelog->created_at, 'd M, Y h:i:s')}}</span></div>
                                    <div>End: <span class="fw-bold">{{showDateTime($tradelog->in_time, 'd M, Y h:i:s')}}</span></div>
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
            </div>

            <div class="mb-1">{{paginateLinks($tradelogs) }}</div>
        </div>
    </div>
@endsection
