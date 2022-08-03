@extends('layouts.app')
@section('content')

    <div class=" my-2 text-end">
        <a href="{{ route('user.ticket') }}" class="btn btn-primary btn-sm">{{ __('locale.Back') }}</a>
    </div>
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <h5 class="title">
                            @if ($my_ticket->status == 0)
                                <span class="badge bg-success">{{ __('locale.Open') }}</span>
                            @elseif($my_ticket->status == 1)
                                <span class="badge bg-primary">{{ __('locale.Answered') }}</span>
                            @elseif($my_ticket->status == 2)
                                <span class="badge bg-warning">{{ __('locale.Replied') }}</span>
                            @elseif($my_ticket->status == 3)
                                <span class="badge bg-danger">{{ __('locale.Closed') }}</span>
                            @endif
                            <span class="text-white">[{{ __('locale.Ticket') }}#{{ $my_ticket->ticket }}]
                                {{ $my_ticket->subject }}</span>
                        </h5>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#DelModal"
                            class="btn-sm d-block btn btn-primary btn-danger text-center mt-2">{{ __('locale.Close Ticket') }}</a>
                    </div>
                    <div class="card-body">
                        @if ($my_ticket->status != 4)
                            <form method="post" action="{{ route('user.ticket.reply', $my_ticket->id) }}"
                                class="message__chatbox__form row" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-sm-12">
                                    <textarea id="message" name="message" class="form-control "
                                        placeholder="{{ __('locale.Enter Message') }}"></textarea>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="d-flex mt-1">
                                        <div class="start-group col p-0">
                                            <label for="file"
                                                class="label">{{ __('locale.Attachments') }}</label>
                                            <input type="file" class="overflow-hidden form-control  mb-2" id="file"
                                                name="attachments[]">
                                            <div id="fileUploadsContainer"></div>
                                            <span class="info fs-14">{{ __('locale.Allowed File Extensions') }}:
                                                .jpg,
                                                .jpeg, .png, .pdf, .doc, .docx</span>
                                        </div>
                                        <div class="add-area">
                                            <label class="label d-block">&nbsp;</label>
                                            <button class="btn btn-primary btn-sm bg-primary  ms-2 ms-md-4"
                                                onclick="extraTicketAttachment()" type="button"><i
                                                    class="bi bi-plus"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 mt-2 mb-0">
                                    <button type="submit" class="btn btn-primary" name="replayTicket"
                                        value="1">{{ __('locale.Send Message') }}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="reply-message-area">
                        @foreach ($messages as $message)
                            @if ($message->admin_id == 0)
                                <div class="reply-item rounded bg-wallet mb-1 p-1 shadow border-light">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="reply-thumb">
                                                <img src="{{ getImage('assets/images/user/profile/' . auth()->user()->image, '350x300') }}"
                                                    alt="{{ __('locale.User') }}">
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <div class="meta-date text-warning">
                                                {{ __('locale.Posted on') }} <span
                                                    class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                            </div>
                                            <p>
                                                {{ $message->message }}
                                            </p>
                                            @if ($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach ($message->attachments as $k => $image)
                                                        <a href="{{ route('user.ticket.download', encrypt($image->id)) }}"
                                                            class="mr-3"><i class="bi bi-file-earmark"></i>
                                                            {{ __('locale.Attachment') }} {{ ++$k }} </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="name-area">
                                        <h6 class="title">{{ __($message->ticket->name) }}</h6>
                                    </div>

                                </div>
                            @else
                                <ul>
                                    <li>
                                        <div class="reply-item">
                                            <div class="name-area">
                                                <div class="reply-thumb">
                                                    <img src="{{ getImage('assets/admin/images/profile/' . $message->admin->image, '400x400') }}"
                                                        alt="{{ __('locale.Admin Image') }}">
                                                </div>
                                                <h6 class="title">{{ __($message->admin->name) }}</h6>
                                            </div>
                                            <div class="content-area">
                                                <span class="meta-date">
                                                    {{ __('locale.Posted on') }}, <span
                                                        class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                                </span>
                                                <p>
                                                    {{ $message->message }}
                                                </p>
                                                @if ($message->attachments()->count() > 0)
                                                    <div class="mt-2">
                                                        @foreach ($message->attachments as $k => $image)
                                                            <a href="{{ route('user.ticket.download', encrypt($image->id)) }}"
                                                                class="mr-3"><i class="bi bi-file-earmark"></i>
                                                                {{ __('locale.Attachment') }} {{ ++$k }} </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    <div class="modal fade custom-modal" id="DelModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('locale.Confirmation') }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form class="deposit-form" method="post" action="{{ route('user.ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <div class="modal-body">
                        <p>{{ __('locale.Are you sure you want to close this support ticket') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm text-white btn-danger"
                            data-bs-dismiss="modal">{{ __('locale.Close') }}</button>
                        <button type="submit" class="btn btn-primary btn-sm text-white btn-success" name="replayTicket"
                            value="2">{{ __('locale.Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        "use strict";

        function extraTicketAttachment() {
            $("#fileUploadsContainer").append(
                '<input type="file" name="attachments[]" class="overflow-hidden form-control  mb-2" />')
        }
    </script>
@endpush
