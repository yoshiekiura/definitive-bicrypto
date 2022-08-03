@extends('blogetc_admin::layouts.admin_layout')
@section('title','Blog Etc Admin - Upload Images')
@section('blog')
    <h5>Upload Images</h5>
    <div class="card">
        <div class="card-body">


    <form method="post" action="{{route("admin.blogetc.admin.images.store")}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="image_title">Image title</label>
            <small id="image_title_help" class="form-text text-muted">Image Title</small>
            <input required class="form-control" type="text" name="image_title" id="image_title"
                   aria-describedby="image_title_help">
        </div>
        <div class="form-group mt-1">
            <label for="upload">Upload image</label>
            <small id="blog_upload_help" class="form-text text-muted">Upload image</small>
            <input required class="form-control" type="file" name="upload" id="upload"
                   aria-describedby="upload_help">
        </div>

        <div class="form-group mt-1">
            <label>Sizes to convert to</label>
            <div>
                <input type="checkbox" name="sizes_to_upload[blogetc_full_size]" value="true" checked
                       id="size_blogetc_full_size">
                <label for="size_blogetc_full_size">Full size (no resizing)</label>
            </div>
            @foreach((array)config('blogetc.image_sizes') as $size => $image_size_details)
                <div>
                    <input type="checkbox" name="sizes_to_upload[{{$size}}]" value="true" checked id="size_{{$size}}">
                    <label for="size_{{$size}}">{{$image_size_details['name']}} - {{$image_size_details['w']}}
                        x {{$image_size_details['h']}}px</label>
                </div>
            @endforeach
        </div>
        <div class="form-group mt-1">
            <input type="submit" class="btn btn-primary" value="Upload">
        </div>
    </form></div>
</div>
@endsection

