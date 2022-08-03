<h4 class="mb-3 bold">Search</h4>
<form class="form search-box">
    <div class="input-group">
        <input type="email" name="Search[q]" class="form-control @rtl rounded-circle-right @else rounded-circle-left @endrtl shadow-none" placeholder="Search form..." required>
        <button class="btn @rtl rounded-circle-left border-end-0 @else rounded-circle-right @endrtl btn-contrast border-input" type="submit" data-loading-text="Searching ...">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>

<h4 class="mt-5 mb-3 bold">Latest Posts</h4>
<ul class="list-unstyled">
    @foreach ($posts as $post)
    <li class="d-flex align-items-center">
        <a href="blog-post" class="d-flex @rtl ms-3 @else me-3 @endrtl py-2">
            <img class="rounded-circle icon-xl shadow" src="https://picsum.photos/100/100/?random&gravity={{ $post['gravity'] }}" alt="...">
        </a>

        <div class="flex-fill">
            <h6 class="semi-bold mt-0 mb-1">
                <a href="blog-post" class="text-dark">{{ $post['title'] }}</a>
            </h6>

            <span class="small text-muted"><i class="fas fa-calendar"></i> May 21 2021</span>
        </div>
    </li>
    @endforeach
</ul>

<h4 class="mt-5 mb-3 bold">Archives</h4>
<ul class="list-unstyled">
    <li><a href="#">September <span class="badge badge-light badge-pill">76</span></a></li>
    <li><a href="#">August <span class="badge badge-light badge-pill">49</span></a></li>
    <li><a href="#">July <span class="badge badge-light badge-pill">24</span></a></li>
    <li><a href="#">June <span class="badge badge-light badge-pill">59</span></a></li>
    <li><a href="#">May <span class="badge badge-light badge-pill">36</span></a></li>
    <li><a href="#">April <span class="badge badge-light badge-pill">67</span></a></li>
</ul>

<h4 class="mt-4 mb-3 bold">Tags</h4>
<div class="tags">
    <ul class="list-unstyled d-flex flex-wrap flex-row">
        <li><a href="#" class="badge rounded-pill badge-outline-dark @rtl ms-2 @else me-2 @endrtl">app</a></li>
        <li><a href="#" class="badge rounded-pill badge-outline-dark @rtl ms-2 @else me-2 @endrtl">development</a></li>
        <li><a href="#" class="badge rounded-pill badge-outline-dark @rtl ms-2 @else me-2 @endrtl">software</a></li>
        <li><a href="#" class="badge rounded-pill badge-outline-dark @rtl ms-2 @else me-2 @endrtl">awesome</a></li>
        <li><a href="#" class="badge rounded-pill badge-outline-dark @rtl ms-2 @else me-2 @endrtl">startup</a></li>
        <li><a href="#" class="badge rounded-pill badge-outline-dark">business</a></li>
    </ul>
</div>
