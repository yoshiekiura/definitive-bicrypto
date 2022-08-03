<div>
    <script>
        document.addEventListener ("DOMContentLoaded", function () {
            var tr_elements = $('.custom-data-table-{{ $pair }} tbody tr');
            $(document).on('input', 'input[name=search_table]', function () {
                var search = $(this).val().toUpperCase();
                var match = tr_elements.filter(function (idx, elem) {
                    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
                }).sort();
                var table_content = $('.custom-data-table-{{ $pair }} tbody');
                if (match.length == 0) {
                    table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
                } else {
                    table_content.html(match);
                }
            });
        });
    </script>
    <div class="table-responsive" style="max-height:300px;min-height:300px;overflow-y:auto;">
        <table class="table text-dark table-sm table-borderless tableFixHead custom-data-table-{{ $pair }}">
            <thead class="text-muted">
                <tr>
                    <th scope="col">Pair</th>
                    @if (getPlatform('trading')->pair_prices == 1)
                    <th class="d-lg-none d-xl-block" scope="col">Change</th>
                    <th scope="col">Price</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($markets as $market)
                <tr>
                    <td>
                        <div class="d-flex justify-content-start">
                            <form action="{{ route('user.watchlist.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="currency" value="{{ $market['currency'] }}">
                                <input type="hidden" name="pair" value="{{ $market['pair'] }}">
                                <button type="submit" style="background: none;padding: 0px;border: none;">
                                    <i class="me-1 text-warning icon-unlock bi bi-star"></i>
                                </button>
                            </form>
                            <a href="{{ route('user.trade.now',[$market['currency'],$market['pair']]) }}">
                                <span class="text-dark fw-bold">{{ $market['currency'] }}</span>/<span class="text-secondary fw-bold">{{ $market['pair'] }}</span>
                            </a>
                        </div>
                    </td>

                    @if (getPlatform('trading')->pair_prices == 1)
                    <td class="d-lg-none d-xl-block">
                        <span class="change-{{ $market['currency'] }}{{ $market['pair'] }}"></span>
                    </td>
                    <td>
                        <span class="tic-{{ $market['currency'] }}{{ $market['pair'] }}"></span><i class="tic-{{ $market['currency'] }}{{ $market['pair'] }}-icon bi"></i>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
