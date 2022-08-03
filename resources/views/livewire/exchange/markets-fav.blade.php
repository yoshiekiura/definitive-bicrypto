<div class="tab-pane" id="fav" role="tabpanel" aria-labelledby="fav-tab">
    <script>
        document.addEventListener ("DOMContentLoaded", function () {
            var tr_elements = $('.custom-data-table-fav tbody tr');
            $(document).on('input', 'input[name=search_table]', function () {
                var search = $(this).val().toUpperCase();
                var match = tr_elements.filter(function (idx, elem) {
                    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
                }).sort();
                var table_content = $('.custom-data-table-fav tbody');
                if (match.length == 0) {
                    table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
                } else {
                    table_content.html(match);
                }
            });
        });
    </script>
    <div class="table-responsive" style="max-height:300px;min-height:300px;overflow-y:auto;">
        <table class="table text-dark table-sm table-borderless tableFixHead custom-data-table-fav">
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
                @foreach($favs as $fav)
                <tr>
                    <td>
                        <div class="d-flex justify-content-start">
                            <form action="{{ route('user.watchlist.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $fav->id }}">
                                <button type="submit" style="background: none;padding: 0px;border: none;">
                                    <i class="me-1 text-warning bi bi-star-fill"></i>
                                </button>
                            </form>
                            <a href="{{ route('user.trade.now',[$fav->currency,$fav->pair]) }}">
                                <span class="text-dark fw-bold">{{ $fav->currency }}</span>/<span class="text-secondary fw-bold">{{ $fav->pair }}</span>
                            </a>
                        </div>
                    </td>

                    @if (getPlatform('trading')->pair_prices == 1)
                    <td class="d-lg-none d-xl-block">
                        <span class="change-{{ $fav->currency }}{{ $fav->pair }}"></span>
                    </td>
                    <td>
                        <span class="tic-{{ $fav->currency }}{{ $fav->pair }}"></span><i class="tic-{{ $fav->currency }}{{ $fav->pair }}-icon bi"></i>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
