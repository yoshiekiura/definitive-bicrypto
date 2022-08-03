<div>
    <div class="row mb-2">
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <input type="text" class="form-control bg-light border-dark" placeholder="Search" wire:model="search" />
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('locale.Wallet')}}</th>
                                <th>{{ __('locale.Balance')}}</th>
                                <th>{{ __('locale.Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wallets as $wallet)
                            <tr>
                                <td data-label="Wallet" class="d-flex justify-content-start align-items-center">
                                    <div class="avatar bg-transparent rounded">
                                        <img class="avatar-content"
                                            src="{{ getImage('assets/images/cryptoCurrency/'. strtolower($wallet->symbol).'.png') }}"
                                            alt="">
                                    </div>
                                    <div class="ms-1">{{ $wallet->symbol }}</div>
                                </td>
                                <td data-label="Balance">
                                    {{getAmount($wallet->balance)}} {{$wallet->symbol}}
                                    {!! QrCode::size(128)->generate($wallet->wallet_id) !!}
                                </td>
                                <td data-label="Actions">
                                    {{-- @if (!$wallet->balance)
                                        <form method="POST" action="{{ route('user.wallet.create') }}">
                                            @csrf
                                            <input type="hidden" id="symbol" name="symbol" value="{{ $wallet->symbol }}">
                                            <button type="submit"  wire:click="emit('walletCreated')" class="btn btn-success btn-sm">Create Wallet</button></span>
                                        </form>
                                    @endif --}}
                                    @if ($wallet->symbol == 'USDT')
                                        <a href="{{ route('user.deposit') }}" class="btn btn-success btn-sm">Deposit</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%">
                                    <div class="d-flex justify-content-between  align-items-center">
                                        <span class="text-warning">{{ __('locale.Create your first wallet:')}}</span>

                                        <a href="{{ route('user.wallet.index') }}">
                                            <button type="submit" class="mt-1 btn btn-outline-light btn-sm">Create Wallet</button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $wallets->links() }}
            </div>
        </div>
    </div>
</div>
