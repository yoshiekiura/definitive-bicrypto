@extends('layouts.app')
@section('content')

<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Referrals')}}</h4><div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead>
                            <th>{{ __('locale.ID')}}</th>
                            <th>{{ __('locale.First Name')}}</th>
                            <th>{{ __('locale.Last Name')}}</th>
                            <th>{{ __('locale.Username')}}</th>
                            <th>{{ __('locale.Date')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $referral)
                            <tr>
                                <td data-label="{{ __('locale.ID')}}">{{$loop->iteration}}</td>
                                <td data-label="{{ __('locale.First Name')}}">{{__($referral->firstname)}}</td>
                                <td data-label="{{ __('locale.Last Name')}}">{{__($referral->lastname)}}</td>
                                <td data-label="{{ __('locale.Username')}}"> {{__($referral->username)}}</td>
                                <td data-label="{{ __('locale.Date')}}">{{ showDateTime($referral->created_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
        <div class="mb-1">{{paginateLinks($referrals) }}</div>
    </div>
</div>
@endsection



