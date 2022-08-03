@extends('layouts.app')

@section('page-style')
    <style>
.parent-chart {
  position: relative;
  width: 100%;
  padding-bottom: 50%;
}
.child-chart {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
    </style>
@endsection
@section('content')

<div class="row match-height">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">BTC @if($contract->hilow == 1) Rise @else Fall @endif</div><hr/>
                <div class="row">
                    <div class="col">
                        Profit/Loss:<br><div class="@if($contract->result == 1) text-success @elseif($contract->result == 2) text-danger @else text-secondary @endif"><b>@if($contract->result == 1)+ {{ $contract->amount * $fee }}@elseif($contract->result == 2) - {{ $contract->amount * $fee }}@else Draw @endif</b></div>
                    </div>
                    <div class="col">
                        Sell price:<br><b>{{ $contract->amount + ($contract->amount * $fee) }}</b>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col">
                        Buy price:<br><b>{{ getAmount($contract->amount) }}</b>
                    </div>
                    <div class="col">
                        Payout limit:<br><b>{{ $contract->amount * $fee }}</b>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="max-height:280px;overflow-y:auto;">
                <div class="row">
                    <div class="col-3"><i class="border-white bi bi-play btn btn-icon fs-3 rounded bg-light-secondary"></i></div>
                    <div class="col-9">Reference ID:<br><b>{{ $contract->id }}</b></div>
                </div><hr/>
                <div class="row">
                    <div class="col-3"><i class="bi bi-clock btn btn-icon fs-3 rounded bg-light-secondary"></i></div>
                    <div class="col-9">Duration:<br><b>@if($contract->duration >= 60 && $contract->duration < 3600) {{ $contract->duration / 60 }}</b> min @elseif($contract->duration > 3600) {{ $contract->duration / 3600 }}</b> hour @else {{ $contract->duration }}</b> sec @endif</div>
                </div><hr/>
                <div class="row">
                    <div class="col-3"><i class="bi bi-chevron-bar-contract btn btn-icon fs-3 rounded bg-light-secondary"></i></div>
                    <div class="col-9">Barrier:<br><b>{{ getAmount($data['0']['value']) }}</b></div>
                </div><hr/>
                <div class="row">
                    <div class="col-3"><i class="border-warning bi bi-geo-alt btn btn-icon fs-3 rounded bg-light-secondary"></i></div>
                    <div class="col-9">Start time:<br><b>{{ $contract->in_time }}</b></div>
                </div><hr/>
                <div class="row">
                    <div class="col-3"><i class="border-danger bi bi-record-circle btn btn-icon fs-3 rounded bg-light-secondary"></i></div>
                    <div class="col-9">Entry spot:<br><b>{{ getAmount($contract->price_was) }}</b></div>
                </div><hr/>
                <div class="row">
                    <div class="col-3"><i class="border-info bi bi-record-circle-fill btn btn-icon fs-3 rounded bg-light-secondary"></i></div>
                    <div class="col-9">Exit spot:<br><b>{{ $data[count($data) - 1]['value'] }}</b></div>
                </div><hr/>
                <div class="row">
                    <div class="col-3"><i class="border-success bi bi-flag btn btn-icon fs-3 rounded bg-light-secondary"></i></div>
                    <div class="col-9">Exit time:<br><b>{{ $duration }}</b></div>
                </div><hr/>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                    <!-- Line Chart Starts -->
    <div class="col-12">
        <div class="card">
          <div
            class="
              card-header
              d-flex
              flex-sm-row flex-column
              justify-content-md-between
              align-items-start
              justify-content-start
            "
          >
            <div>
              <h4 class="card-title mb-25">Contract details</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap mt-sm-0 mt-1">
              <h5 class="fw-bolder mb-0 me-1">$ {{ $data[count($data) - 1]['value'] }}</h5>
              <span class="badge badge-light-secondary">
                <i class="text-danger font-small-3 bi bi-arrow-down"></i>
                <span class="align-middle">{{ round(($data['0']['value'] / $data[count($data) - 1]['value']), 4) }}%</span>
              </span>
            </div>
          </div>
          <div class="card-body parent-chart">
            <div class="child-chart" id="chart"></div>
          </div>
        </div>
      </div>
      <!-- Line Chart Ends -->
            </div>
        </div>

    </div>
</div>

@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
@endsection

@push('script')
<script>
$(window).resize(function() {
    chart.applyOptions({
        width: $('.parent-chart').innerWidth(),
        height: $('.parent-chart').innerHeight()
    });
});

var chart = LightweightCharts.createChart(document.getElementById('chart'), {
    rightPriceScale: {
        scaleMargins: {
            top: 0.1,
            bottom: 0.1,
        },
    },
    layout: {
        backgroundColor: '#ffffff',
        textColor: 'rgba(33, 56, 77, 1)',
    },
    grid: {
        vertLines: {
            color: 'rgba(197, 203, 206, 0.4)',
        },
        horzLines: {
            color: 'rgba(197, 203, 206, 0.4)',
        },
    },
    timeScale: {
        timeVisible: true,
    secondsVisible: false,
    },
});

var lineSeries = chart.addBaselineSeries({
    baseValue: { type: 'price', price: {{ $data['0']['value'] }} },
    lastPriceAnimation: 1
});
var lineSeries1 = chart.addLineSeries({
    color: '#bdc3c7'
});

lineSeries1.setData([
        {
            time: {{ $data['0']['time'] }},
            value: {{ $data['0']['value'] }}
        },
],);

lineSeries.setData([
    @foreach ($data as $data => $log)
        {
            time: {{ $log['time'] }},
            value: {{ $log['value'] }}
        },
    @endforeach
]);
chart.timeScale().fitContent();
</script>
@endpush
