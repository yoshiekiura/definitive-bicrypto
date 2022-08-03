<div class="card card-blog shadow-box shadow-hover border-0">
    <a href="{{ $post->url() }}">
        {!! $post->imageTag('thumbnail', false, 'card-img-top img-responsive') !!}
    </a>

    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <div class="author d-flex align-items-center">
                <img class="author-picture rounded-circle icon-md shadow-box"
                    src="{{ asset('img/avatar/user.png') }}" alt="...">
                <p class="small bold my-0">{{$post->author->name}}</p>
            </div>

            <nav class="nav">
                @foreach($post->categories as $category)
                <a href="{{ $category->url() }}">
                    <span class="badge rounded-pill badge-light-warning">{{ $category->category_name }}</span>
                </a>
                @endforeach
            </nav>
        </div>

        <hr>

        <p class="card-title regular">
            <a href="blog-post">{{ $post->title }}</a>
        </p>

        <p class="card-text text-secondary">@if(config('blogetc.show_full_post_on_index'))
            {!! $post->renderBody() !!}
        @else
            <p>{!! $post->generateIntroduction(400) !!}</p>
        @endif</p>

        <p class="bold small text-secondary my-0"><small>{{ $post->posted_at->diffForHumans() }}</small></p>
    </div>
</div>
