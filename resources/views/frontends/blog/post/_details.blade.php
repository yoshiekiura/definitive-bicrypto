<ul class="list-unstyled d-flex flex-wrap flex-row align-items-center">
    <li class="me-4"><i class="fas fa-tag text-secondary"></i></li>
    @foreach($post->categories as $category)
    <li><a href="{{ $category->url() }}" class="badge rounded-pill badge-outline-secondary me-2">{{ $category->category_name }}</a></li>
            @endforeach
</ul>

<ul class="list-unstyled d-flex flex-wrap flex-row align-items-center">
    <li class="me-4"><i class="fas fa-bookmark text-secondary"></i></li>
    <li>
        <a href="https://twitter.com/intent/tweet?text=Post and Share &amp;url={{urlencode(url()->current()) }}" class="btn btn-circle btn-sm btn-secondary me-2">
            <i class="fab fa-twitter"></i>
        </a>
    </li>
    <li>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" class="btn btn-circle btn-sm btn-secondary me-2">
            <i class="fab fa-facebook"></i>
        </a>
    </li>
    <li>
        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}" class="btn btn-circle btn-sm btn-secondary">
            <i class="fab fa-linkedin"></i>
        </a>
    </li>
</ul>
