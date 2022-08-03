@php
    /** @var \WebDevEtc\BlogEtc\Models\Comment[] $comments */
@endphp
@forelse($comments as $comment)
<div class="card">
    <div class="card-body">
      <div class="d-flex align-items-start">
        <div class="author-info">
          <h6 class="fw-bolder mb-25">{{ $comment->author() }}</h6>
          @if(config('blogetc.comments.ask_for_author_website') && $comment->author_website)
                (<a href="{{ $comment->author_website }}" target="_blank" rel="noopener">website</a>)
            @endif
          <p class="card-text">{{ $comment->created_at->diffForHumans() }}</p>
          <p class="card-text">
            {!! nl2br(e($comment->comment)) !!}
          </p>
        </div>
      </div>
    </div>
  </div>
@empty
<div class="alert alert-info" role="alert">
    <div class="alert-body">
        No comments yet!
        @can(\WebDevEtc\BlogEtc\Gates\GateTypes::ADD_COMMENT)
            Why don't you be the first?
        @endcan
    </div>
  </div>
@endforelse

@if(count($comments) >= config('blogetc.comments.max_num_of_comments_to_show', 500))
    <p class="alert alert-info">
            Only the first {{ config('blogetc.comments.max_num_of_comments_to_show', 500) }} comments are shown.
    </p>
@endif


