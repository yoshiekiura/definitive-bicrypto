<div class="table-responsive">
    <table class="table table-hover custom-data-bs-table">
        <thead class="table-dark">
            <tr>
                <th scope="col">{{ __('locale.Pair')}}</th>
                <th scope="col">{{ __('locale.Taker')}}</th>
                <th scope="col">{{ __('locale.Maker')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feess as $fee)
                <tr>
                    <td data-label="{{ __('locale.Pair')}}">{{ $fee->symbol }}</td>
                    <td data-label="{{ __('locale.Taker')}}">{{ $fee->taker }} %</td>
                    <td data-label="{{ __('locale.Maker')}}">{{ $fee->maker }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
