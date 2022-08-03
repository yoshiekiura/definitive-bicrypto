@php
    /** @var \WebDevEtc\BlogEtc\Models\Comment[] $comments */
@endphp
@extends('blogetc_admin::layouts.admin_layout')
@section('title', 'Manage Comments')
@section('blog')
    @forelse ($comments as $comment)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{$comment->author()}} commented on:

                    @if($comment->post)
                        <a href="{{$comment->post->url()}}">{{$comment->post->title}}</a>
                    @else
                        Unknown blog post
                    @endif

                    on {{$comment->created_at}} </h5>

                <p class="bg-gray-500 p-1 rounded shadow">{{$comment->comment}}</p>
            </div>
            <div class="card-footer d-flex justify-content-start align-items-center">
                @if($comment->post)
                    <a href="{{$comment->post->url()}}"><button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-file-text" aria-hidden="true"></i>
                        View Post
                    </button></a>
                    <a href="{{$comment->post->edit_url()}}"><button class="ms-1 btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                        Edit Post
                    </button></a>
                @endif

                @if(!$comment->approved)
                    {{--APPROVE BUTTON--}}
                    <form method="post" action="{{route("admin.blogetc.admin.comments.approve", $comment->id)}}"
                          class="float-right">
                        @csrf
                        @method("PATCH")
                        <button type="submit" class="ms-1 btn btn-success btn-sm" value="Approve">Approve</button>
                    </form>
                @endif

                {{--DELETE BUTTON--}}
                <form
                        onsubmit="return confirm('Are you sure you want to delete this blog post comment?\n You cannot undo this action!');"
                        method="post" action="{{route("admin.blogetc.admin.comments.delete", $comment->id)}}"
                        class="float-right">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="ms-1 btn btn-danger btn-sm" value="Delete">Delete</button>
                </form>
                </div>
        </div>
    @empty
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Error</h4>
            <div class="alert-body">
                None found
            </div>
          </div>
    @endforelse

    <div class="text-center">
        {{ $comments->links() }}
    </div>
@endsection

