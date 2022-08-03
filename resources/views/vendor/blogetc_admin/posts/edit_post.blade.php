@php
    /** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp
@extends('blogetc_admin::layouts.admin_layout')
@section('blog')
    <h5>Admin - Editing post
        <a target="_blank" href="{{ $post->url() }}" class="btn btn-primary ms-2">
            View post
        </a>
    </h5>

    <form method="post" action="{{ route('admin.blogetc.admin.update_post', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('blogetc_admin::posts.form', ['post' => $post])
        <div class="card-footer text-end">
            <input type="submit" class="btn btn-primary" value="Save Changes">
        </div>
    </form>
@endsection
