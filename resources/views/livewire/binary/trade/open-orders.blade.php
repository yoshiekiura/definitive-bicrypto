
<tbody>
    @forelse($orders as $order)
    <tr>
        <td data-label="TxHash" class="text-uppercase">{{ $order->id }}</td>
        <td data-label="Date" class="text-uppercase">{{ $order->created_at }}</td>
        <td data-label="Pair" class="text-uppercase">{{ $order->symbol }}/{{ $order->pair }}</td>
        <td data-label="Type" class="text-uppercase">@if ($order->hilow == 1)<span class="fw-bold text-success">Rise @else<span class="fw-bold text-danger">Fall @endif</span></td>
        <td data-label="Amount">{{ttz($order->amount)}} {{ $order->pair }}</td>
        <td data-label="Price Was">{{ttz($order->price_was)}} {{ $order->pair }}</td>
        <td data-label="Duration">
            @if($order->duration > 60 && $order->duration < 3600 )
            {{ number_format($order->duration / 60, 2) }} Min
            @elseif($order->duration > 3600)
            {{ number_format($order->duration / 3600, 2) }} Hours
            @else
            {{ $order->duration }} Sec
            @endif
        </td>
        <td data-label="{{ __('locale.Status')}}">
            @if($order->status == 0)
                <span class="badge bg-success">{{ __('locale.Running')}}</span>
            @endif
        </td>
    </tr>
    @empty
        <tr>
            <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
        </tr>
    @endforelse
</tbody>
