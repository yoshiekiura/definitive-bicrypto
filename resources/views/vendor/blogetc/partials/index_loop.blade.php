<div class="col-md-6 col-12">
    <div class="card">
        <a href="{{$post->url()}}">
            {!! $post->imageTag('medium', true, 'img-thumbnail card-img-top img-fluid') !!}
        </a>

        <div class="card-body">
            <h4 class="card-title">
                <a href="{{$post->url()}}" class="blog-title-truncate text-body-heading">{{$post->title}}</a>
            </h4><h5>{{$post->subtitle}}</h5>
            <div class="d-flex">
                <div class="avatar me-50">
                    <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" alt="Avatar" width="24" height="24" />
                </div>
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
