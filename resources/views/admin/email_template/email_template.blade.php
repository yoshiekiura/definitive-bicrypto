@extends('layouts.app')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Email Templates</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th>{{ __('locale.Short Code') }} </th>
                                <th>{{ __('locale.Description') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <tr>
                                <td data-label="{{ __('locale.Short Code') }}">@{{ name }}</td>
                                <td data-label="{{ __('locale.Description') }}">{{ __('locale.User Name') }}</td>
                            </tr>
                            <tr>
                                <td data-label="{{ __('locale.Short Code') }}">@{{ message }}</td>
                                <td data-label="{{ __('locale.Description') }}">{{ __('locale.Message') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mt-1">
                <div class="card-body">
                    <form action="{{ route('admin.email.template.global') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col col-md-12">
                                <label class="h6 mt-1">{{ __('locale.Email Sent From') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg"
                                    placeholder="{{ __('locale.Email address') }}" name="email_from"
                                    value="{{ $general_setting->email_from }}" required />
                            </div>
                            <div class="col col-md-12">
                                <label class="h6 mt-1">{{ __('locale.Email Body') }} <span
                                        class="text-danger">*</span></label>
                                <textarea name="email_template" rows="10" class="form-control form-control-lg"
                                    placeholder="{{ __('locale.Your email template') }}">{{ $general_setting->email_template }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-2 mt-2">{{ __('locale.Update') }}</button>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection
@section('vendor-script')
@endsection
