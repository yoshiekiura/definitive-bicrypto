<div class="blog-post-nav mb-3">
    <a href="/blog"><i class="fas fa-long-arrow-alt-left"></i></a>
</div>

<div class="d-flex">
    <img class="me-3 rounded-circle icon-lg" src="{{ asset('images/portrait/small/avatar-s-11.jpg') }}" alt="">

    <div class="flex-fill small">
        <span class="author">by <a href="#">{{ $post->author->name }}</a></span>
        <span class="d-block text-secondary">{{ $post->posted_at->diffForHumans() }}</span>
    </div>

    <div class="col">
        @can(\WebDevEtc\BlogEtc\Gates\GateTypes::MANAGE_BLOG_ADMIN)
            <a href="{{ route('admin.blogetc.admin.index') }}"
                class="ms-1 btn btn-outline-warning btn-sm pull-right float-end">
                Back To Dashboard
            </a>
            <a href="{{ route('admin.blogetc.admin.edit_post', $post->id) }}"
                class="btn btn-outline-info btn-sm pull-right float-end">
                Edit Post
            </a>
        @endcan
    </div>

</div>
<hr class="mb-5">

<p class="lead text-secondary italic mb-5">{{ $post->subtitle }}
</p>

<p>{!! $post->renderBody() !!}</p>
