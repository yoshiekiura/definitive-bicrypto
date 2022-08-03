@extends('blogetc_admin::layouts.admin_layout')
@section('blog')
    <div class="row">
        @forelse($posts as $post)
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card">
                    <a href="{{ $post->url() }}">
                        {!! $post->imageTag('large', false, 'card-img-top img-fluid') !!}
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{{ $post->url() }}"
                                class="blog-title-truncate text-body-heading">{{ $post->title }}</a>
                            {!! $post->is_published ? '<div class="badge rounded-pill bg-success fs-6">Published</div>' : '<div class="badge rounded-pill bg-danger fs-6">Not Published</div>' !!}
                        </h4>
                        <h5 class="card-subtitle mb-2 text-muted">{{ $post->subtitle }}</h5>
                        <div class="d-flex">
                            <div class="avatar me-50">
                                <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="Avatar" width="24"
                                    height="24" />
                            </div>
                            <div class="author-info">
                                <small class="text-muted me-25">by</small>
                                <small><a href="#" class="text-body">{{ $post->author_string() }}</a></small>
                                <span class="text-muted ms-50 me-25">|</span>
                                <small class="text-muted">{{ $post->posted_at }}</small>
                            </div>
                        </div>
                        <div class="my-1 py-25">
                            @if (count($post->categories))
                                @foreach ($post->categories as $category)
                                    <a href="{{ $category->edit_url() }}">
                                        <span class="badge rounded-pill badge-light-primary">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                            {{ $category->category_name }}
                                        </span>
                                    </a>
                                @endforeach
                            @else
                                No Categories
                            @endif
                        </div>
                        <p class="card-text blog-content-truncate">
                            {{ $post->html }}
                        </p>
                        @if ($post->use_view_file)
                            <h5>Uses Custom Viewfile:</h5>
                            <div class="m-2 p-1">
                                <strong>View file:</strong><br>
                                <code>{{ $post->use_view_file }}</code>
                                @php
                                    $viewfile = resource_path('views/custom_blog_posts/' . $post->use_view_file . '.blade.php');
                                @endphp
                                <br>
                                <strong>Full filename:</strong>
                                <br>
                                <small>
                                    <code>{{ $viewfile }}</code>
                                </small>

                                @if (!file_exists($viewfile))
                                    <div class="alert alert-danger">Warning! The custom view file does not exist. Create the
                                        file for this post to display correctly.
                                    </div>
                                @endif

                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="col-sm-4 btn btn-primary btn-sm" href="{{ $post->url() }}"
                                class="fw-bold">View
                                Post</a>
                            <a class="col-sm-4 btn btn-info btn-sm"
                                href="{{ route('admin.blogetc.admin.edit_post', $post->id) }}"
                                class="fw-bold">Edit
                                Post</a>
                            <form
                                onsubmit="return confirm('Are you sure you want to delete this blog post?\n You cannot undo this action!');"
                                method='post' action='{{ route('admin.blogetc.admin.destroy_post', $post->id) }}'>
                                @csrf
                                <input name="_method" type="hidden" value="DELETE" />
                                <button type='submit' class='btn btn-danger btn-sm'>
                                    <i class="bi bi-trash" aria-hidden="true"></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">No posts to show you. Why don't you add one?</div>
    </div>
    @endforelse
    </div>
    <div class="text-center">
        {{ $posts->appends([])->links() }}
    </div>
@endsection
