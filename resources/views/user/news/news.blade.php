@extends('layouts.app')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" type="text/css" href="{{ asset('css/base/pages/page-blog.css') }}" />
@endsection

@section('content')
<!-- Blog List -->
<div class="blog-list-wrapper">
  <!-- Blog List Items -->
  <div class="row">
    <?php
    $i = 0;
    if(!empty($feeds)){

    foreach ($feeds->channel->item as $item) {
    if($i == 2):
    endif;
    $title = $item->title;
    $link = $item->link;
    $content = $item->description;
    $content2 = preg_replace("/<img[^>]+\>/i", "", $content);
    $description = str_replace('<a', '<a target=_bank', $content2);
    $excerpt = implode(' ', array_slice(explode(' ', $description), 0, 20));
    $postDate = $item->pubDate;
    $postImage = $item->enclosure['url'];
    $author = $item->dc['creator'];

    $pubDate = date('D, d M Y', strtotime($postDate));

    if ($i >= 10) break;
    ?>
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-md-10">
                    <h4 class="card-title"><?php echo $title; ?></h4>
                </div>
                <div class="col-md-2 text-end">
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                              <a data-action="collapse"><i class="text-info bi bi-chevron-down"></i>
                              <a data-action="reload"><i class="text-warning bi bi-arrow-repeat"></i>
                              <a data-action="close"><i class="btn-icon btn-danger rounded font-medium-1 bi bi-x"></i>
                        </ul>
                      </div>
                </div>
              </div>
        <div class="card-content collapse show">
          <div class="card-body">
            <img class="card-img-top img-fluid" src="{{ $postImage }}" alt="{{ $title }}" />
            <div class="card-body">

                <div class="d-flex">
                  <div class="avatar me-50">
                    <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" width="24" height="24" />
                  </div>
                  <div class="author-info">
                    <span class="text-muted ms-50 me-25">|</span>
                    <small class="text-muted"><?php echo $pubDate; ?></small>
                  </div>
                </div>
                {{-- <div class="my-1 py-25">
                  <a href="#">
                    <span class="badge rounded-pill badge-light-info me-50">Quote</span>
                  </a>
                  <a href="#">
                    <span class="badge rounded-pill badge-light-primary">Fashion</span>
                  </a>
                </div> --}}
                <p class="card-text blog-content-truncate">
                    <?php  echo $description; ?>
                </p>
              </div>
          </div>
        </div>
        </div>
      </div>

    <?php
    $i++;
    }
    }else {
        if (!$invalidurl) {
            echo "<h2>No item found</h2>";
        }
    }
    ?>

  </div>
  <!--/ Blog List Items -->

  <!-- Pagination -->
  {{-- <div class="row">
    <div class="col-12">
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-2">
          <li class="page-item prev-item"><a class="page-link" href="#"></a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item active" aria-current="page"><a class="page-link" href="#">4</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item next-item"><a class="page-link" href="#"></a></li>
        </ul>
      </nav>
    </div>
  </div> --}}
  <!--/ Pagination -->
</div>
<!--/ Blog List
@endsection
