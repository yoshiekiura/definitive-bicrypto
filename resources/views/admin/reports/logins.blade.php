@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Login History</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('locale.Date')}}</th>
                                <th scope="col">{{ __('locale.Username')}}</th>
                                <th scope="col">{{ __('locale.IP')}}</th>
                                <th scope="col">{{ __('locale.Location')}}</th>
                                <th scope="col">{{ __('locale.Browser')}}</th>
                                <th scope="col">{{ __('locale.OS')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($login_logs as $log)
                                <tr>
                                    <td data-label="{{ __('locale.Date')}}">{{diffForHumans($log->created_at) }}</td>
                                    <td data-label="{{ __('locale.Username')}}"><a href="{{ route('admin.users.detail', $log->user_id)}}"> {{ ($log->user) ? $log->user->username : '' }}</a></td>
                                    <td data-label="{{ __('locale.IP')}}">
                                        <a href="{{route('admin.report.login.ipHistory',[$log->user_ip])}}">
                                            {{ $log->user_ip }}
                                        </a>
                                    </td>
                                    <td data-label="{{ __('locale.Location')}}">{{ $log->location }}</td>
                                    <td data-label="{{ __('locale.Browser')}}">{{ __($log->browser) }}</td>
                                    <td data-label="{{ __('locale.OS')}}">{{ __($log->os) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
            </div><!-- card end --><div class="mb-1">{{ paginateLinks($login_logs) }}</div>

        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.report.login.history'))
    <form action="{{ route('admin.report.login.history') }}" method="GET" class=" float-sm-right bg--white">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ __('locale.Search here')}}" value="{{ $search ?? '' }}">
            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </form>
    @endif
@endpush
