@php
    /** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp
<div>
    @foreach($post->categories as $category)
        <a class="badge bg-secondary btn-sm" href="{{ $category->url() }}">
            {{ $category->category_name }}
        </a>
    @endforeach
</div>

