@extends('layouts.app')

@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Balances')}}</h4>
                <div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.Currency')}}</th>
                            <th scope="col">{{ __('locale.Available')}}</th>
                            <th scope="col">{{ __('locale.Used')}}</th>
                            <th scope="col">{{ __('locale.Total')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($currencies as $currency)
                            @if($currency[$free] != 0)
                            <tr>
                                <td data-label="{{ __('locale.Currency')}}">

                                    <img class="avatar-content me-1" width="32px"
                                    src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($currency[$symbol]).'.png') }}"
                                    alt="{{ $currency[$symbol] }}">
                                    {{ $currency[$symbol] }}
                                </td>
                                <td data-label="{{ __('locale.Available')}}">{{ number_format($currency[$free],8) }}</td>
                                <td data-label="{{ __('locale.Used')}}">{{ number_format($currency[$used],8) }}</td>
                                <td data-label="{{ __('locale.Total')}}">{{ number_format($currency[$free] + $currency[$used],8) }}</td>
                            </tr>
                            @endif
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                        </tr>
                        @endforelse

                    </tbody>
                </table><!-- table end -->
            </div>
        </div><!-- card end -->
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.provider.index') }}" class="btn btn-primary btn-sm" ><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush
