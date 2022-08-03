@extends('layouts.app')
@section('content')

<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Contracts Log</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead>
                        <tr>
                            <th>{{ __('locale.ID')}}</th>
                            <th>{{ __('locale.Symbol')}}</th>
                            <th>{{ __('locale.Amount')}}</th>
                            <th>{{ __('locale.Profit')}}</th>
                            <th>{{ __('locale.Rise/Fall')}}</th>
                            <th>{{ __('locale.Result')}}</th>
                            <th>{{ __('locale.Status')}}</th>
                            <th>{{ __('locale.Date')}}</th>
                            <th>{{ __('locale.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contracts as $contract)
                            <tr>
                                <td data-label="@lang("Id")">{{$loop->iteration}}</td>
                                <td data-label="@lang("Symbol")">{{__($contract->symbol)}}/{{$contract->pair}}</td>
                                <td data-label="@lang("Amount")">{{getAmount($contract->amount)}} {{$contract->pair}}</td>
                                <td data-label="@lang("Profit")">
                                    @if($contract->result == 1)
                                        <span class="badge bg-success">{{getAmount($contract->margin)}} {{$contract->pair}}</span>
                                    @elseif($contract->result == 2)
                                        <span class="badge bg-danger">- {{getAmount($contract->amount)}} {{$contract->pair}}</span>
                                    @elseif($contract->result == 3)
                                        <span class="badge bg-warning">0</span>
                                    @else
                                            <span class="badge bg-warning">{{ __('locale.Pending')}}</span>
                                    @endif
                                </td>
                                <td data-label="@lang("High/Low")">
                                    @if($contract->hilow == 1)
                                        <span class="badge bg-success">{{ __('locale.Rise')}}</span>
                                    @elseif($contract->hilow == 2)
                                        <span class="badge bg-danger">{{ __('locale.Fall')}}</span>
                                    @endif
                                </td>
                                <td data-label="@lang("Result")">
                                    @if($contract->result == 1)
                                        <span class="badge bg-success">{{ __('locale.Win')}}</span>
                                    @elseif($contract->result == 2)
                                        <span class="badge bg-danger">{{ __('locale.Lose')}}</span>
                                    @elseif($contract->result == 3)
                                        <span class="badge bg-warning">{{ __('locale.Draw')}}</span>
                                    @else
                                          <span class="badge bg-warning">{{ __('locale.Pending')}}</span>
                                    @endif
                                </td>
                                <td data-label="@lang("Status")">
                                    @if($contract->status == 0)
                                        <span class="badge bg-primary">{{ __('locale.Running')}}</span>
                                    @elseif($contract->status == 1)
                                        <span class="badge bg-success">{{ __('locale.Complete')}}</span>
                                    @endif
                                </td>
                                 <td data-label="@lang("Date")">{{showDateTime($contract->created_at, 'd M, Y h:i:s')}}</td>
                                 @if($contract->result != NULL)
                                    @if (isset($datas[$user->id][$contract->id]))
                                        @if (Request::is('**/trade*'))
                                        <td><a href="{{ route('user.binary.trade.contract.log.preview', $contract->id) }}" class="btn btn-icon btn-sm btn-outline-info"><i class="bi bi-info-lg"></i></a></td>
                                        @else
                                        <td><a href="{{ route('user.binary.practice.contract.log.preview', $contract->id) }}" class="btn btn-icon btn-sm btn-outline-info"><i class="bi bi-info-lg"></i></a></td>
                                        @endif
                                    @else
                                    <td><span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('locale.Contract chart data was lost because you closed the trade page before it complete')}}">{{ __('locale.Not Data Recorded')}}</span></td>
                                    @endif
                                 @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%"> {{ __('locale.No results found')}}!</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div><div class="mb-1">{{paginateLinks($contracts) }}</div>
    </div>
</div>
@endsection
