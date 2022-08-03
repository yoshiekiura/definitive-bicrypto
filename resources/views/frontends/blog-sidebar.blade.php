<div class="blog-sidebar my-2 my-lg-0">
  <!-- Search bar -->
  @if (config('blogetc.search.search_enabled') )
  <div class="blog-search mb-3">
        <form method="get" action="{{ route('blogetc.search') }}" class="text-center">
            <div class="input-group input-group-merge">
                <input type="text" name="s" placeholder="Search..." class="form-control" value="{{ Request::get('s') }}" placeholder="Search here"/>
                <input type="submit" value="Search" class="input-group-text cursor-pointer">
            </div>
        </form>
    </div>
    @endif
  <!--/ Search bar -->

  <!-- Recent Posts -->
  <div class="blog-recent-posts">
    <h6 class="section-label">Recent Posts</h6>
    <div class="mt-75">
        @foreach(\WebDevEtc\BlogEtc\Models\Post::orderBy('posted_at','desc')->limit(5)->get() as $post)
        <div class="card mb-2">
            <div class="card-body">
                <div class="blog-info">
                    <h6 class="blog-recent-post-title">
                      <a href="{{ $post->url() }}" class="text-body-heading">{{ $post->title }}</a>
                    </h6>
                  </div>
            </div>
        </div>
      @endforeach
    </div>
  </div>
  <!--/ Recent Posts -->

  <!-- Categories -->
  <div class="blog-categories mt-3">
    <h6 class="section-label">Categories</h6>
    <div class="mt-1">
        <div class="d-flex justify-content-start align-items-center">
    @foreach(\WebDevEtc\BlogEtc\Models\Category::orderBy('category_name')->limit(200)->get() as $category)
        <a href="{{ $category->url() }}" class="m-1">
          <div class="avatar bg-light-info rounded">
            <div class="avatar-content">
              <i class="bi bi-coin font-medium-1"></i>
            </div>
          </div>
        </a>
        <a href="{{ $category->url() }}">
            <div class="badge bg-secondary btn-sm">{{ $category->category_name }}</div>
        </a>
      @endforeach
    </div>
    </div>
  </div>
  <!--/ Categories -->
</div>
