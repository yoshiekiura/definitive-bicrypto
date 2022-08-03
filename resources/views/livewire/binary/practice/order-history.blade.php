
<tbody>
    @forelse($orders as $order)
    <tr>
        <td data-label="TxHash" class="text-uppercase">Practice {{ $order->id }}</td>
        <td data-label="Date" class="text-uppercase">{{ $order->created_at }}</td>
        <td data-label="Pair" class="text-uppercase">{{ $order->symbol }}/{{ $order->pair }}</td>
        <td data-label="Type" class="text-uppercase">@if ($order->hilow == 1)<span class="fw-bold text-success">Rise @else<span class="fw-bold text-danger">Fall @endif</span></td>
        <td data-label="Amount">{{getAmount($order->amount)}} {{ $order->pair }}</td>
        <td data-label="Price Was">{{getAmount($order->price_was)}} {{ $order->pair }}</td>
        <td data-label="Duration">
            @if($order->duration > 60 && $order->duration < 3600 )
            @php
                $duration = $order->duration / 60;
                $unit = 'Min';
            @endphp
            @elseif($order->duration > 3600)
            @php
                $duration = $order->duration / 3600;
                $unit = 'Hour';
            @endphp
            @endif
            {{ $duration ?? $order->duration }} {{ $unit ?? 'Sec' }}
        </td>
        <td data-label="{{ __('locale.Status')}}">
            @if($order->result == 1)
                <span class="badge bg-success">{{ __('locale.Win')}}</span>
            @elseif($order->result == 2)
                <span class="badge bg-danger">{{ __('locale.Lose')}}</span>
            @elseif($order->result == 3)
                <span class="badge bg-warning">{{ __('locale.Draw')}}</span>
            @endif
        </td>
    </tr>
    @empty
        <tr>
            <td class="text-muted text-center" colspan="100%">{{__($empty_message) }}</td>
        </tr>
    @endforelse
</tbody>
