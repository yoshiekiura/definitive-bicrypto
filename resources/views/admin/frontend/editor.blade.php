@extends('layouts.app')


@section('content')
<form class="form" action="{{ route('admin.template.editor.update.text') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="template_id" value="{{ $section->template_id }}">
    <input type="hidden" name="page_id" value="{{ $section->page_id }}">
    <input type="hidden" name="section_id" value="{{ $section->section_id }}">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-warning">{{ $section->title }} Section</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($fields as $key => $field)
                <div class="col-lg-6">
                    <label for="{{ $key }}">{{ $key }}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="field[{{ $key }}]" name="field[{{ $key }}]"
                            value="{{ $field }}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer mt-1">
            <div class="col-sm-9 offset-sm-3 text-end">
                <button type="submit" class="btn btn-primary me-1">Update</button>
            </div>
        </div>
    </div>
</form>
<form class="form" action="{{ route('admin.template.editor.update.image') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="template_id" value="{{ $section->template_id }}">
    <input type="hidden" name="page_id" value="{{ $section->page_id }}">
    <input type="hidden" name="section_id" value="{{ $section->section_id }}">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-warning">{{ $section->title }} Images</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($images as $image)
                <div class="col-lg-6">
                    <div class="mb-1">
                        <img class="me-1 img-thumbnail mb-1"
                            src="../../../../../../../../{{ $image->image }}" />
                        <input class="form-control" name="img[]" type="file" id="img[]"
                            accept=".png, .jpg, .jpeg" value="{{ $image->image }}" />
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer mt-1">
            <div class="text-end">
                <button type="submit" class="btn btn-primary me-1">Update</button>
            </div>
        </div>
    </div>
</form>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.template.sections',[$section->template_id,$section->page_id]) }}" class="btn btn-primary btn-sm" ><i class="bi bi-chevron-left"></i> {{ __('locale.Back')}}</a>
@endpush
