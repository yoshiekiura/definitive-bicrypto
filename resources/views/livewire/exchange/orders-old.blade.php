<div class="navbar-fixed-bottom orderList">
    <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel-heading" role="tab" id="headingOne" style="cursor: pointer" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            <div class="d-flex justify-content-between align-items-center px-2">
                <span class="float-md-start d-none d-md-inline-block mt-25"><i class="bi bi-info"></i> Orders</span>
                <div class="my-auto border-start border-end">
                    <i class="fs-4 mx-1 bi bi-chevron-up"></i>
                    <i class="fs-4 mx-1 bi bi-chevron-down"></i>
                </div>
            </div>
        </div>
        <div id="collapseOne" class="panel-collapse collapse notifications-scroll-area" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false">
        <div class="panel-body">
            <div class="table-responsive" style="font-size: 11px">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">{{ __('locale.Trade')}}</th>
                            <th scope="col">{{ __('locale.Pricing')}}</th>
                            <th scope="col">{{ __('locale.Order')}}</th>
                            <th scope="col">{{ __('locale.Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td data-label="{{ __('locale.Trade')}}" class="text-uppercase">
                                <div> {{ __('locale.Pair')}}: <span class="fw-bold text-info">{{ $order->symbol }}</span></div>
                                <div> {{ __('locale.ID')}}: <span class="fw-bold text-info">{{ $order->order_id }}</span></div>
                            </td>
                            <td data-label="{{ __('locale.Pricing')}}">
                                <div> {{ __('locale.Price')}}: <span class="fw-bold text-warning">{{getAmount($order->price)}} {{ $order->pair }}</span></div>
                                <div> {{ __('locale.Amount')}}: <span class="fw-bold text-warning">{{getAmount($order->amount)}} {{ getPair($order->symbol)[0] }}</span></div>
                                <div> {{ __('locale.Cost')}}: <span class="fw-bold text-warning">{{getAmount($order->cost)}} {{ getPair($order->symbol)[1] }}</span></div>
                                <div> {{ __('locale.Fees')}}: <span class="fw-bold text-danger">{{ttz($order->fee)}} {{ getPair($order->symbol)[1] }}</span></div>
                            </td>
                            <td data-label="{{ __('locale.Order')}}">
                                <div>{{ __('locale.Type')}}:
                                        @if ($order->side == 'buy')
                                        <span class="fw-bold text-success">Buy
                                    @else
                                        <span class="fw-bold text-danger">Sell
                                    @endif</span>
                                </div>
                                <div> {{ __('locale.Filled')}}: <span class="fw-bold text-info">{{ttz($order->filled)}} {{ getPair($order->symbol)[0] }}</span></div>
                                <div> {{ __('locale.Remaining')}}: <span class="fw-bold text-danger">{{ttz($order->remaining)}} {{ getPair($order->symbol)[0] }}</span></div>
                            </td>
                            <td data-label="{{ __('locale.Status')}}">
                                @if($order->status == 'closed')
                                    <span class="badge bg-success">{{ __('locale.Filled')}}</span>
                                @elseif($order->status == 'open')
                                    <span class="badge bg-primary">{{ __('locale.Live')}}</span>
                                    {{-- <form method="POST" action="{{ route('user.exchange.cancel') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order->order_id }}">
                                        <input type="hidden" name="symbol" value="{{ $order->symbol }}">
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('locale.Cancel') }}</button></span>
                                    </form> --}}
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">{{ __('locale.Canceled')}}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
