@php
    /** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp
@can(\WebDevEtc\BlogEtc\Gates\GateTypes::MANAGE_BLOG_ADMIN)
    <a href="{{$post->editUrl()}}" class="btn btn-outline-secondary btn-sm pull-right float-right">
        Edit Post
    </a>
@endcan

{!! $post->imageTag('large', false, 'img-fluid img-thumbnail') !!}
<div class="card-header ">
    <div class="card-title">{{$post->title}}
        <h5 class="blog_subtitle">{{$post->subtitle}}</h5>
    </div>
</div>

<div class="card-body">
<p class="blog_body_content">
    {!! $post->renderBody() !!}

    {{--@if(config("blogetc.use_custom_view_files")  && $post->use_view_file)--}}
    {{--                                // use a custom blade file for the output of those blog post--}}
    {{--   @include("blogetc::partials.use_view_file")--}}
    {{--@else--}}
    {{--   {!! $post->post_body !!}        // unsafe, echoing the plain html/js--}}
    {{--   {{ $post->post_body }}          // for safe escaping --}}
    {{--@endif--}}
</p>

<hr/>

@if($post->posted_at)
    Posted <strong>{{ $post->posted_at->diffForHumans() }}</strong>
@endif

@includeWhen($post->author, 'blogetc::partials.author', ['post'=>$post])
@includeWhen($post->categories, 'blogetc::partials.categories', ['post'=>$post])

