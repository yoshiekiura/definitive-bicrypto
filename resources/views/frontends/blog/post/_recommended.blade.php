<h4>Recommended Posts</h4>

<div class="row gap-y">
    @foreach(\WebDevEtc\BlogEtc\Models\Post::orderBy('posted_at','desc')->limit(3)->get() as $post)
        <div class="col-md-6 col-lg-4">
            @include ("frontends.blog.grid._card", [ "post" => $post ])
        </div>
    @endforeach
</div>
