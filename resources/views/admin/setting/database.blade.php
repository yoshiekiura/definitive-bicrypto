@extends('layouts.app')
@section('content')
@if($mlm->installed == 1)
<div class="card">
    <div class="card-body">
        <div class="card-title">
            MLM Table Optimizer
        </div>
        <a href="{{ route('admin.mlm.regenerate') }}" class="btn btn-primary">Regenerate MLM Rows For Old Users</a>
    </div>
</div>
@endif
<div class="card">
    <div class="card-body">
        <div class="card-title">
            Logs Cleaner
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.binary.practice.logs.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clean Binary Practice Logs</button>
                </form>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.binary.trade.logs.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clean Binary Trade Logs</button>
                </form>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.trade.logs.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clean Trade Logs</button>
                </form>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.forex.investments.logs.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clean Forex Investments Logs</button>
                </form>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.bot.investments.logs.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clean Bot Investments Logs</button>
                </form>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.staking.logs.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clean Staking Logs</button>
                </form>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.ico.logs.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Clean Token ICO Logs</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="card-title">
            Wallets Optimizer
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                <form method="POST" action="{{ route('admin.database.wallets.clean') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Clean Broken Wallets</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
