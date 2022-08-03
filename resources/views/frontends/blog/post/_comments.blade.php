<div class="media-list text-darker">

    @forelse($comments as $comment)
    <div class="d-flex">
        <img class="d-flex @rtl ms-3 @else me-3 @endrtl icon-md rounded"
             src="{{ asset('img/avatar/user.png') }}" alt="...">
        <div class="flex-fill">
            <h5 class="my-0 bold">{{ $comment->author() }}</h5>
            @if(config('blogetc.comments.ask_for_author_website') && $comment->author_website)
                    (<a href="{{ $comment->author_website }}" target="_blank" rel="noopener">website</a>)
                @endif
            <time class="small" datetime="2017-09-29 21:35">{{ $comment->created_at->diffForHumans() }}</time>
            <p>{!! nl2br(e($comment->comment)) !!}</p>
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

</div>
