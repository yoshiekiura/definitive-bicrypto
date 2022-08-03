
<tbody>
    @forelse($orders as $order)
    <tr>
        <td data-label="TxHash" class="text-uppercase">{{ $order->order_id }}</td>
        <td data-label="Date" class="text-uppercase">{{ $order->created_at }}</td>
        <td data-label="Pair" class="text-uppercase">{{ $order->symbol }}</td>
        <td data-label="Side" class="text-uppercase">@if ($order->side == 'buy')<span class="fw-bold text-success">Buy @else<span class="fw-bold text-danger">Sell @endif</span></td>
        <td data-label="Price">{{ttz($order->price)}} {{ $order->pair }}</td>
        <td data-label="Amount">{{ttz($order->amount)}} {{ getPair($order->symbol)[0] }}</td>
        <td data-label="Filled">{{ttz($order->filled)}} {{ getPair($order->symbol)[0] }}</td>
        <td data-label="{{ __('locale.Status')}}">
            @if($order->status == 'open')
                <span class="badge bg-primary">{{ __('locale.Live')}}</span>
            @elseif($order->status == 'filling')
                <span class="badge bg-warning">{{ __('locale.Filling')}}</span>
            @endif
        </td>
        {{-- <td data-label="{{ __('locale.Action')}}">
            @if($order->status == 'open')
                <form id="cancelOrder">
                    <input type="hidden" class="orderSymbol" value="{{ $order->symbol }}">
                    <button type="submit" class="btn btn-danger btn-sm cancelBtn" value="{{ $order->order_id }}">{{ __('locale.Cancel') }}</button></span>
                </form>
            @endif
        </td> --}}
    </tr>
    @empty
        <tr>
            <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
        </tr>
    @endforelse
</tbody>
