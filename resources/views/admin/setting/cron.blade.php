@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.To Automate trade result run the') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as what you set the minimum time in general settings. Once per') }}<code>
                            5-15 </code>{{ __('locale.minutes is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="cron" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('cron') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="var copyText = document.getElementById('cron');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.To automate practice trade result run the') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as what you set the minimum time in general settings. Once per') }}<code>
                            5-15 </code>{{ __('locale.minutes is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="practiceRef" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('practice.cron') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="var copyText = document.getElementById('practiceRef');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.Crypto Scheduled Orders') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as what you set the minimum time in general settings. Once per') }}<code>
                            1-2 </code>{{ __('locale.minutes is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="schedule" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('schedule.cron') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="
                                                  var copyText = document.getElementById('schedule');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($bot->installed == 1)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <p class="cron-p-style">{{ __('locale.Bot Trader Results') }}<code>
                                {{ __('locale.cron job') }}
                            </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                                10-15 </code>{{ __('locale.minutes is ideal') }}.</p>
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('locale.Cron Command') }}</label>
                        <div class="input-group">
                            <input id="Botref" type="text" class="form-control form-control-lg"
                                value="curl -s {{ route('bot.result') }}" readonly="">
                            <span id="copybtn" class="input-group-text btn-success" title=""
                                onclick="
                                                  var copyText = document.getElementById('Botref');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <p class="cron-p-style">{{ __('locale.Bot Trader Results If Missed') }}<code>
                                {{ __('locale.cron job') }}
                            </code>{{ __('locale.on your server. Set the Cron time as minimum as possible and less than the Bot Trader Results cron. Once per') }}<code>
                                5-10 </code>{{ __('locale.minutes is ideal') }}.</p>
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('locale.Cron Command') }}</label>
                        <div class="input-group">
                            <input id="Botmis" type="text" class="form-control form-control-lg"
                                value="curl -s {{ route('bot.missed') }}" readonly="">
                            <span id="copybtn" class="input-group-text btn-success" title=""
                                onclick="
                                                  var copyText = document.getElementById('Botmis');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($forex->installed == 1)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <p class="cron-p-style">{{ __('locale.Forex Investment Results') }}<code>
                                {{ __('locale.cron job') }}
                            </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                                10-15 </code>{{ __('locale.minutes is ideal') }}.</p>
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('locale.Cron Command') }}</label>
                        <div class="input-group">
                            <input id="forexref" type="text" class="form-control form-control-lg"
                                value="curl -s {{ route('forex.result') }}" readonly="">
                            <span id="copybtn" class="input-group-text btn-success" title=""
                                onclick="
                                                  var copyText = document.getElementById('forexref');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <p class="cron-p-style">{{ __('locale.Forex Investment Results If Missed') }}<code>
                                {{ __('locale.cron job') }}
                            </code>{{ __('locale.on your server. Set the Cron time as minimum as possible and less than the forex Trader Results cron. Once per') }}<code>
                                5-10 </code>{{ __('locale.minutes is ideal') }}.</p>
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('locale.Cron Command') }}</label>
                        <div class="input-group">
                            <input id="forexmis" type="text" class="form-control form-control-lg"
                                value="curl -s {{ route('forex.missed') }}" readonly="">
                            <span id="copybtn" class="input-group-text btn-success" title=""
                                onclick="
                                                  var copyText = document.getElementById('forexmis');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($mlm->installed == 1)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <p class="cron-p-style">{{ __('locale.MLM Ranks Upgrader') }}<code>
                                {{ __('locale.cron job') }}
                            </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                                12-24 </code>{{ __('locale.hours is ideal') }}.</p>
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('locale.Cron Command') }}</label>
                        <div class="input-group">
                            <input id="mlm" type="text" class="form-control form-control-lg"
                                value="curl -s {{ route('mlm.ranks') }}" readonly="">
                            <span id="copybtn" class="input-group-text btn-success" title=""
                                onclick="
                                                  var copyText = document.getElementById('mlm');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.Provider Markets To Tables') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                            3-7 </code>{{ __('locale.days is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="marketsToTable" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('provider.marketsToTable') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="
                                                  var copyText = document.getElementById('marketsToTable');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.Provider Currencies') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                            3-7 </code>{{ __('locale.days is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="currencies" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('provider.currencies') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="
                                                  var copyText = document.getElementById('currencies');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.Provider Currencies To Table') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                            3-7 </code>{{ __('locale.days is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="currenciesToTable" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('provider.currenciesToTable') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="
                                                  var copyText = document.getElementById('currenciesToTable');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.Provider Pairs To Table') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                            3-7 </code>{{ __('locale.days is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="pairsToTable" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('provider.pairsToTable') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="
                                                  var copyText = document.getElementById('pairsToTable');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.Provider Check Deposit') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                            1-5 </code>{{ __('locale.minutes is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="check_deposit" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('provider.checkdeposit') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="
                                                  var copyText = document.getElementById('check_deposit');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-2">
                    <p class="cron-p-style">{{ __('locale.Provider Fetch Address') }}<code>
                            {{ __('locale.cron job') }}
                        </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                            1-5 </code>{{ __('locale.minutes is ideal') }}.</p>
                </div>
                <div class="col-md-12">
                    <label>{{ __('locale.Cron Command') }}</label>
                    <div class="input-group">
                        <input id="fetch_order" type="text" class="form-control form-control-lg"
                            value="curl -s {{ route('provider.fetchorder') }}" readonly="">
                        <span id="copybtn" class="input-group-text btn-success" title=""
                            onclick="
                                                  var copyText = document.getElementById('fetch_order');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($staking->installed == 1)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 my-2">
                        <p class="cron-p-style">{{ __('locale.Staking Profit') }}<code>
                                {{ __('locale.cron job') }}
                            </code>{{ __('locale.on your server. Set the Cron time as minimum as possible. Once per') }}<code>
                                1 </code>{{ __('locale.day is ideal') }}.</p>
                    </div>
                    <div class="col-md-12">
                        <label>{{ __('locale.Cron Command') }}</label>
                        <div class="input-group">
                            <input id="staking" type="text" class="form-control form-control-lg"
                                value="curl -s {{ route('staking.profit') }}" readonly="">
                            <span id="copybtn" class="input-group-text btn-success" title=""
                                onclick="
                                                  var copyText = document.getElementById('staking');
                                                  copyText.select();
                                                  copyText.setSelectionRange(0, 99999)
                                                  document.execCommand('copy');
                                                  notify('success', 'Url copied successfully ' + copyText.value);">{{ __('locale.Copy') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('breadcrumb-plugins')
    <button type="button"
        class="btn @if (Carbon\Carbon::parse($general->last_cron_run)->diffInSeconds() < 600) btn-success @elseif(Carbon\Carbon::parse($general->last_cron_run)->diffInSeconds() < 1200) btn-warning @else
        btn-danger @endif "><i
            class="bi bi-clock"></i> {{ __('locale.Last Cron Run') }} :
        {{ Carbon\Carbon::parse($general->last_cron_run)->difFforHumans() }}</button>
@endpush
