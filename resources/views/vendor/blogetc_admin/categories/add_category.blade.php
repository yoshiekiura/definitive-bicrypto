@extends('blogetc_admin::layouts.admin_layout')
@section('title', 'BlogEtc - Add Category')
@section('blog')
<div class="card">
    <div class="card-header card-title">
        Add Category
    </div>

    <form method="post" action="{{ route('admin.blogetc.admin.categories.create_category') }}" enctype="multipart/form-data">
        @csrf
        @include('blogetc_admin::categories.form', ['category' => new \WebDevEtc\BlogEtc\Models\Category()])


        <div class="card-footer text-end">
            <input type="submit" class="btn btn-primary" value="Add New Category">
        </div>
    </form>
@endsection
