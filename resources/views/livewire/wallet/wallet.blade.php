<div class="row me-1">
    <div class="col-lg-5 col-md-5 d-none d-md-block">
        <div class="card-title">Account Balances</div>
                @foreach ($wallets as $wallet)
                    <div class="row">
                        <div class="col test-start">{{ $wallet->symbol }}</div>
                        <div class="col test-end">{{ getAmount($wallet->balance) }}</div>
                    </div>
                @endforeach
            <div class="row"><a href="{{ route('user.wallet.index') }}" class="position-absolute bottom-0 mb-1 text-info w-75">View All Wallets</a></div>
    </div>
    <div class="col-lg-7 col-md-7">
        <div class="row bg-wallet p-1 rounded">
            <a href="{{route('user.home')}}" style="display: contents;">
                <div class="col-6 test-start">
                        <div class="fs-bold fs-4 text-white">Practice Account</div>
                        <div class="fs-bold fs-4 text-warning">
                            {{getCurrency()->symbol}}<livewire:partials.practice-balance/></div>
                </div>
                <div class="col-6 text-end">
                    <a href="javascript:void(0)"><button class="btn btn-outline-warning btn-sm"
                            data-bs-toggle="modal" data-bs-target="#practiceAmount">
                            <i class="bi bi-plus"></i>Top Up</button></a>
                </div>
            </a>
        </div>
        <div class="row bg-wallet-active p-1 rounded mt-1">
            <a href="{{route('user.home.trade')}}" style="display: contents;">
                <div class="col-6 test-start">
                    <div class="fs-bold fs-4 text-white">Trade Account</div>
                    <div class="fs-bold fs-4 text-success">
                        {{getCurrency()->symbol}}<livewire:partials.balance/></div>
                </div>
                <div class="col-6 text-end">
                    @if ($wal != 'null')
                    <a href="{{ route('user.wallet.index') }}"><button class="btn btn-outline-light btn-sm">
                        <i class="bi bi-plus"></i>Deposit</button></a>
                        <a href="{{ route('user.withdraw',$wal->address) }}"><button class="mt-1 btn btn-outline-light btn-sm">
                            <i class="bi bi-plus"></i>Withdraw</button></a>
                    @else
                    <a href="{{ route('user.wallet.index') }}">
                        <button type="submit" class="mt-1 btn btn-outline-light btn-sm">Create Wallet</button>
                    </a>
                    @endif
                </div>
            </a>
        </div>
    </div>
</div>
