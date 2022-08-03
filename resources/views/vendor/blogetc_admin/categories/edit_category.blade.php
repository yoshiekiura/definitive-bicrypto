@extends('blogetc_admin::layouts.admin_layout')
@section('title', 'Edit Category ' . $category->category_name)
@section('blog')
<div class="card">
    <div class="card-header card-title">
        Edit Category
    </div>
    <form method="post" action="{{ route('admin.blogetc.admin.categories.edit_category', $category->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('blogetc_admin::categories.form', ['category' => $category])
<div class="card-footer text-end">
    <input type="submit" class="btn btn-primary" value="Save">
</div>

    </form>
@endsection
