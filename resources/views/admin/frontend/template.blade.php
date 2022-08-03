@extends('layouts.app')


@section('content')
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('locale.Template Pages')}}</h4>
                <div class="card-search"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover custom-data-bs-table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.Name')}}</th>
                            <th scope="col">{{ __('locale.Status')}}</th>
                            <th scope="col">{{ __('locale.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                        <tr>
                            <td data-label="{{ __('locale.Name')}}">{{ $page->name }}</td>
                            <td data-label="{{ __('locale.Status')}}">
                                @if($page->status == 1)
                                <span class="badge bg-success">{{ __('locale.Active')}}</span>
                                @else
                                <span class="badge bg-warning">{{ __('locale.Disabled')}}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('locale.Action')}}">
                                <a href="{{ route('admin.template.sections',[$page->template_id,$page->page_id]) }}" class="btn btn-icon btn-warning"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('locale.Edit Sections')}}">
                                    <i class="bi bi-pencil-square"></i>
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
        </div><!-- card end -->
        <div class="mb-1">{{ paginateLinks($pages) }}</div>
    </div>
</div>

@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.template.index') }}" class="btn btn-primary btn-sm" ><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush
