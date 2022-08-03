@extends("frontends.blog",['title'=>$post->genSeoTitle()])
@section("blogfront")
@include("blogetc::partials.show_errors")
<div class="blog-detail-wrapper">
    <div class="row">
      <!-- Blog -->
      <div class="col-12">
        <div class="card">
            {!! $post->imageTag('large', false, 'img-fluid card-img-top') !!}
          <div class="card-body">
            <h4 class="card-title">{{$post->title}}
            @can(\WebDevEtc\BlogEtc\Gates\GateTypes::MANAGE_BLOG_ADMIN)
                <a href="{{route("admin.blogetc.admin.index")}}" class="ms-1 btn btn-outline-warning btn-sm pull-right float-end">
                    Back To Dashboard
                </a>
                <a href="{{$post->editUrl()}}" class="btn btn-outline-info btn-sm pull-right float-end">
                    Edit Post
                </a>
            @endcan</h4>
            {{$post->subtitle}}
            <div class="d-flex">
              <div class="avatar me-50">
                <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" width="24" height="24" />
              </div>
              <div class="author-info">
                <small class="text-muted me-25">by</small>
                <small><a href="#" class="text-body">{{$post->author->name}}</a></small>
                @if($post->posted_at)
                    <span class="text-muted ms-50 me-25">|</span>
                    <small class="text-muted">{{ $post->posted_at->diffForHumans() }}</small>
                @endif
              </div>
            </div>
            <div class="my-1 py-25">
            @foreach($post->categories as $category)
                <a href="{{ $category->url() }}">
                    <span class="badge rounded-pill badge-light-warning">{{ $category->category_name }}</span>
                </a>
            @endforeach
            </div>
            <p class="card-text mb-2">
                {!! $post->renderBody() !!}
            </p>
            {{-- <hr class="my-2" />
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="d-flex align-items-center me-1">
                  <a href="#" class="me-50">
                    <i data-feather="message-square" class="font-medium-5 text-body align-middle"></i>
                  </a>
                  <a href="#">
                    <div class="text-body align-middle">19.1K</div>
                  </a>
                </div>
                <div class="d-flex align-items-center">
                  <a href="#" class="me-50">
                    <i data-feather="bookmark" class="font-medium-5 text-body align-middle"></i>
                  </a>
                  <a href="#">
                    <div class="text-body align-middle">139</div>
                  </a>
                </div>
              </div>
              <div class="dropdown blog-detail-share">
                <i
                  data-feather="share-2"
                  class="font-medium-5 text-body cursor-pointer"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                ></i>
                <div class="dropdown-menu dropdown-menu-end">
                  <a href="#" class="dropdown-item py-50 px-1">
                    <i data-feather="github" class="font-medium-3"></i>
                  </a>
                  <a href="#" class="dropdown-item py-50 px-1">
                    <i data-feather="gitlab" class="font-medium-3"></i>
                  </a>
                  <a href="#" class="dropdown-item py-50 px-1">
                    <i data-feather="facebook" class="font-medium-3"></i>
                  </a>
                  <a href="#" class="dropdown-item py-50 px-1">
                    <i data-feather="twitter" class="font-medium-3"></i>
                  </a>
                  <a href="#" class="dropdown-item py-50 px-1">
                    <i data-feather="linkedin" class="font-medium-3"></i>
                  </a>
                </div>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
      <!--/ Blog -->

      <!-- Blog Comment -->
      @if(config("blogetc.comments.type_of_comments_to_show","built_in") !== 'disabled')
            <div id="maincommentscontainer">
                <div class="col-12 mt-1" id="blogComment">
                    <h6 class="section-label mt-25" id="blogetccomments">Comment</h6>
                    @include("blogetc::partials.show_comments")
                </div>
            </div>
        @endif
      <!--/ Blog Comment -->
    </div>
  </div>
  <!--/ Blog Detail -->
@endsection

