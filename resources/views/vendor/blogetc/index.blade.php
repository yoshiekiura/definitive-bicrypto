@extends("frontends.blog",['title'=>$title])
@section("blogfront")

@can(\WebDevEtc\BlogEtc\Gates\GateTypes::MANAGE_BLOG_ADMIN)
    <div class="text-center">
        <p class="mb-1">
            You are logged in as a blog admin user.
            <br>
            <a href="{{route("admin.blogetc.admin.index")}}"
                class="btn border btn-outline-primary btn-sm">
                <i class="fa fa-cogs" aria-hidden="true"></i>
                Go To Blog Admin Panel
            </a>
        </p>
    </div>
@endcan

@if(isset($blogetc_category) && $blogetc_category)
                <h2 class="text-center">
                    Viewing Category: {{$blogetc_category->category_name}}
                </h2>
                @if($blogetc_category->category_description)
                    <p class="text-center">{{$blogetc_category->category_description}}</p>
                @endif
            @endif

        <div class="row">
            @forelse($posts as $post)
        <div class="col-md-6 col-12">
            <div class="card mb-4 p-1 shadow">
                <a href="{{$post->url()}}">
                    {!! $post->imageTag('medium', true, 'card-img-top img-fluid') !!}
                </a>

                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{$post->url()}}" class="blog-title-truncate text-body-heading">{{$post->title}}</a>
                    </h4><h5>{{$post->subtitle}}</h5>
                    <div class="d-flex">
                        <div class="author-info">
                            <small class="text-muted me-25">by</small>
                            <small><a href="#" class="text-body">{{$post->author->name}}</a></small>
                            <span class="text-muted ms-50 me-25">|</span>
                            <small class="text-muted">{{ $post->posted_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="my-1 py-25">
                        @foreach($post->categories as $category)
                        <a href="{{ $category->url() }}">
                            <span class="badge rounded-pill badge-light-warning">{{ $category->category_name }}</span>
                        </a>
                        @endforeach
                    </div>
                    <p class="card-text blog-content-truncate">
                        @if(config('blogetc.show_full_post_on_index'))
                                {!! $post->renderBody() !!}
                            @else
                                <p>{!! $post->generateIntroduction(400) !!}</p>
                            @endif
                    </p>
                    <hr />
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{$post->url()}}" class="fw-bold">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="alert alert-danger">No posts</div>
        @endforelse
        </div>

            <div class="text-center col-sm-4 mx-auto">
                {{$posts->appends( [] )->links()}}
            </div>
@endsection
