@extends('blogetc_admin::layouts.admin_layout')
@section('blog')
    <h5>Admin - Add post</h5>

    <form method="POST" action="{{ route('admin.blogetc.admin.store_post') }}" enctype="multipart/form-data">
        @csrf
        @include("blogetc_admin::posts.form", ['post' => new \WebDevEtc\BlogEtc\Models\Post()])
        <div class="card-footer text-end">
            <input type="submit" class="btn btn-primary" value="Add new post">
        </div>

    </form>
@endsection
