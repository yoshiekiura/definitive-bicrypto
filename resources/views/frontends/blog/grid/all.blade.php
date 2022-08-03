<x-utils.container>
    <div class="row g-4">
        @foreach(\App\Models\Post::all() as $post)
            <div class="card card-blog shadow-box shadow-hover border-0">
                <a href="/post/{{ $post->slug }}">
                    <img class="card-img-top img-responsive" src="https://picsum.photos/350/200/?random&gravity={{ $post['gravity'] }}" alt="">
                </a>

                <div class="card-body">
                    <p class="card-title regular">
                        <a href="blog-post">{{ $post->title }}</a>
                    </p>

                    <p class="card-text text-secondary">{{ Str::limit($post->body, 100) }}</p>

                    <p class="bold small text-secondary my-0"><small>May 14 2021</small></p>
                </div>
            </div>
            @endforeach
    </div>

    <nav class="nav justify-content-center mt-5">
        <a class="btn btn-outline-primary btn-rounded me-5" href="javascript:;"><i class="fas fa-angle-left me-3"></i> Previous</a>
        <a class="btn btn-outline-primary btn-rounded" href="javascript:;">Next <i class="fas fa-angle-right ms-3"></i></a>
    </nav>
</x-utils.container>
