@extends('layouts.app')
@section('content')
    <div class=" my-2 text-end">
        <a href="{{ route('user.ticket') }}" class="btn btn-primary btn-sm">{{ __('locale.Back') }}</a>
    </div>
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('locale.Create New Ticket') }}</h4>
                    <a href="{{ route('ticket') }}" class="btn btn-primary btn-sm">{{ __('locale.All Tickets') }}</a>
                </div>
                <div class="card-body">
                    <form class="message__chatbox__form row" action="{{ route('user.ticket.store') }}" method="post"
                        enctype="multipart/form-data" onsubmit="return submitUserForm();">
                        @csrf
                        <div class="form-group mb-1 col-sm-6">
                            <label for="name" class="label">{{ __('locale.Name') }}</label>
                            <input type="text" id="name" name="name" class="form-control " value="{{ $user->fullname }}"
                                readonly>
                        </div>
                        <div class="form-group mb-1 col-sm-6">
                            <label for="email" class="label">{{ __('locale.Email') }}</label>
                            <input type="text" id="email" name="email" class="form-control " value="{{ $user->email }}"
                                readonly>
                        </div>
                        <div class="form-group mb-1 col-sm-12">
                            <label for="subject" class="label">{{ __('locale.Subject') }}</label>
                            <input type="text" id="subject" name="subject" class="form-control "
                                placeholder="{{ __('locale.Enter Subject') }}" required="">
                        </div>
                        <div class="form-group mb-1 col-sm-12">
                            <label for="message" class="label">{{ __('locale.Message') }}</label>
                            <textarea id="message" name="message" class="form-control " placeholder="{{ __('locale.Message') }}"></textarea>
                        </div>

                        <div class="form-group mb-1 col-sm-12">
                            <div class="d-flex">
                                <div class="start-group col p-0">
                                    <label for="file2" class="label">{{ __('locale.Attachments') }}</label>
                                    <input type="file" class="overflow-hidden form-control mb-2" name="attachments[]"
                                        id="file2">
                                    <div id="fileUploadsContainer"></div>
                                    <span class="info fs--14">{{ __('locale.Allowed File Extensions') }}: .jpg, .jpeg,
                                        .png, .pdf, .doc, .docx</span>
                                </div>
                                <div class="add-area">
                                    <label class="label d-block">&nbsp;</label>
                                    <button class="btn btn-primary btn-sm bg-primary ms-2 ms-md-4"
                                        onclick="extraTicketAttachment()" type="button"><i
                                            class="bi bi-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-1 col-sm-12 mb-0">
                            <button type="submit" class="btn btn-primary">{{ __('locale.Send Message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>
@endsection
@push('script')
    <script>
        "use strict";

        function extraTicketAttachment() {
            $("#fileUploadsContainer").append(
                '<input type="file" name="attachments[]" class="overflow-hidden form-control mb-2"/>')
        }
    </script>
@endpush
