@extends('layouts.app')
@section('content')
    <div class="notify-area">
    	@foreach($notifications as $notification)
        <a class="notify-item @if($notification->read_status == 0) unread-notification @endif" href="{{ route('admin.notification.read',$notification->id) }}">
            <div class="notify-thumb">
                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.@$notification->user->image,imagePath()['profile']['user']['size'])}}">
            </div>
            <div class="notify-content">
                <h6 class="title text-primary">{{ __($notification->title) }}</h6>
                <span class="date"><i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
            </div>
        </a>
        @endforeach
        {{ paginateLinks($notifications) }}
    </div>
@endsection
