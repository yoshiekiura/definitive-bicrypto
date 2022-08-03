@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ 'Editing ' . $bot->title . ' Bot' }}</h4>
            <div class="card-search"></div>
        </div>
        <form action="{{ route('admin.bot.update') }}" method="POST" enctype="multipart/form-data" id="botUpdate">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $bot->id }}">
            <input type="hidden" name="result_missed" id="result_missed" value="{{ $bot->result_missed }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="title">{{ __('locale.Title') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="title" name="title" aria-label="Bot Title"
                                aria-describedby="title" value="{{ $bot->title }}">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="perc">{{ __('locale.APR') }}</label>
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" id="perc" name="perc" aria-label="Bot APR"
                                aria-describedby="perc" value="{{ $bot->perc }}">
                            <span class="input-group-text" for="perc">%</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="fake">{{ __('locale.Uses') }}</label>
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" id="fake" name="fake" aria-label="Bot Uses"
                                aria-describedby="fake" value="{{ $bot->fake }}">
                            <span class="input-group-text" for="fake">%</span>
                        </div>
                    </div>
                </div>
                <label for="desc">{{ __('locale.Description') }}</label>
                <div class="input-group mb-1">
                    <input type="text" class="form-control" id="desc" name="desc" aria-label="Bot Description"
                        aria-describedby="desc" value="{{ $bot->desc }}">
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="min_profit">{{ __('locale.Minimum Profit') }}</label>
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" id="min_profit" name="min_profit"
                                aria-label="Minimum Profit" aria-describedby="min_profit" value="{{ $bot->min_profit }}">
                            <span class="input-group-text" for="min_profit">%</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="max_profit">{{ __('locale.Maximum Profit') }}</label>
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" id="max_profit" name="max_profit"
                                aria-label="Maximum Profit" aria-describedby="max_profit" value="{{ $bot->max_profit }}">
                            <span class="input-group-text" for="max_profit">%</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="result_missed">{{ __('locale.Result If Missed') }}</label>
                        <div class="dropdown">
                            <button class="btn btn-outline-warning dropdown-toggle w-100" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false" id="result_missedt" name="result_missedt">
                                @if ($bot->result_missed == 1)
                                    {{ __('locale.Win') }}
                                @elseif ($bot->result_missed == 2)
                                    {{ __('locale.Lose') }}
                                @elseif ($bot->result_missed == 3)
                                    {{ __('locale.Draw') }}
                                @else
                                    {{ __('locale.Select Result If Missed') }}
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item"
                                        onclick="$('#result_missedt').text($(this).text());$('#botUpdate').find('input[name=result_missed]').val($(this).data('result'));"
                                        data-result="1">{{ __('locale.Win') }}</a></li>
                                <li><a class="dropdown-item"
                                        onclick="$('#result_missedt').text($(this).text());$('#botUpdate').find('input[name=result_missed]').val($(this).data('result'));"
                                        data-result="2">{{ __('locale.Lose') }}</a></li>
                                <li><a class="dropdown-item"
                                        onclick="$('#result_missedt').text($(this).text());$('#botUpdate').find('input[name=result_missed]').val($(this).data('result'));"
                                        data-result="3">{{ __('locale.Draw') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="profit_missed">{{ __('locale.Profit If Missed') }}</label>
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" id="profit_missed" name="profit_missed"
                                aria-label="Maximum Profit" aria-describedby="profit_missed"
                                value="{{ $bot->profit_missed }}">
                            <span class="input-group-text" for="profit_missed">%</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-control-label h6">{{ __('locale.Bot Minimum Amount') }} </label>
                        <div class="input-group mb-1">
                            <input class="form-control form-control-lg" type="number" name="min_bot_amount"
                                step="0.00000001" value="{{ $limits->min_bot_amount }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-control-label h6">{{ __('locale.Bot Maximum Amount') }} </label>
                        <div class="input-group mb-1">
                            <input class="form-control form-control-lg" type="number" name="max_bot_amount"
                                value="{{ $limits->max_bot_amount }}">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-top mb-1">
                    <div class="me-1">
                        <img class="img-thumbnail mb-1"
                            src="{{ getImage(imagePath()['bot']['path'] . '/' . $bot->image, imagePath()['bot']['size']) }}" />
                    </div>
                    <div>
                        <input class="form-control" name="image" type="file" id="image" accept=".png, .jpg, .jpeg" />
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-top">
                    <div class="form-check me-2">
                        <input class="form-check-input" type="checkbox" data-bs-toggle="toggle" name="is_new" id="is_new"
                            @if ($bot->is_new == 1) checked @endif>
                        <label class="form-check-label" for="is_new">{{ __('locale.is New') }}?</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" data-bs-toggle="toggle" name="status" id="status"
                            @if ($bot->status == 1) checked @endif>
                        <label class="form-check-label" for="is_new">{{ __('locale.is Active') }}?</label>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-success" type="submit"><i class="bi bi-pencil-square"></i> {{ __('locale.Edit') }}
                </button>
            </div>
        </form>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.bot.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
        {{ __('locale.Back') }}</a>
@endpush
