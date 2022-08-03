@extends('layouts.app')
@section('vendor-style')
  {{-- vendor css files --}}
    <!-- bootstrap toggle css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.css">

@endsection
@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                            <tr>
                                <th>{{ __('locale.Short Code')}}</th>
                                <th>{{ __('locale.Description')}}</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse($email_template->shortcodes as $shortcode => $key)
                                <tr>
                                    <th data-label="{{ __('locale.Short Code')}}">@php echo "{{". $shortcode ."}}"  @endphp</th>
                                    <td data-label="{{ __('locale.Description')}}">{{ __($key) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-muted text-center">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- card end -->
        </div>

        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header bg-dark">
                    <h5 class="card-title text-white">{{ __($page_title) }}</h5>
                </div>
                <form action="{{ route('admin.email.template.update', $email_template->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col col-md-8">
                                <label class="h6 mt-1">{{ __('locale.Subject')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" placeholder="{{ __('locale.Email subject')}}" name="subject" value="{{ $email_template->subj }}"/>
                            </div>
                            <div class="col col-md-4">
                                <label class="h6 mt-1">{{ __('locale.Status')}} <span class="text-danger">*</span></label>
                                <input class="form-check-input" data-width="100%" type="checkbox" data-bs-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="{{ __('locale.Send Email')}}"
                                       data-off="@lang("Don't Send")" name="email_status"
                                       @if($email_template->email_status) checked @endif>
                            </div>
                            <div class="col col-md-12">
                                <label class="h6 mt-1">{{ __('locale.Message')}} <span class="text-danger">*</span></label>
                                <textarea name="email_body" rows="10" class="form-control" placeholder="{{ __('locale.Your message using shortcodes')}}">{{ $email_template->email_body }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('locale.Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
{{-- vendor files --}}
<!-- bootstrap-toggle js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>


@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.email.template.index') }}" class="btn btn-primary"><i class="bi bi-chevron-left"></i> {{ __('locale.Go Back')}} </a>
@endpush
@push('script')
    <script>
        'use strict';
        $('.toggle').bootstrapToggle({
    on: 'Y',
    off: 'N',
    width: '100%',
    size: 'small'
});
</script>
@endpush

