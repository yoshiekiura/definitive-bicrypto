<div>
    <div class="table-responsive ask_orderbooks">
        <div class="ask_orderbook">
            <table class="table ask_table text-dark table-sm table-borderless" style="overflow-x:hidden;">
                <thead class="text-muted">
                    <tr>
                        <th class="text-start" scope="col">Price</th>
                        <th class="text-start" scope="col">Amount</th>
                        <th class="text-end" scope="col">Total</th>
                    </tr>
                </thead>
                <tbody class="asks">
                    <tr class="ask">
                        <td class="text-start"><span class="price"></span></td>
                        <td class="text-start"><span class="size"></span></td>
                        <td class="text-end"><span class="total"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="table-responsive bordered-y">
        <table class="table text-dark table-sm table-borderless my-auto">
            <tbody>
                <tr>
                    <td class="text-mute ">
                        <span class="fs-5">Last Price: </span>
                        <span class="fs-3 best_ask"></span><i class="fs-3 best_ask_icon bi"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive bid_orderbooks">
        <div class="bid_orderbook">
            <table class="table bid_table text-dark table-sm table-borderless" style="overflow-x:hidden;">
                <tbody class="bids">
                    <tr class="bid">
                        <td class="text-start"><span class="price"></span></td>
                        <td class="text-start"><span class="size"></span></td>
                        <td class="text-end"><span class="total"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function () {
        demo.startOrderbook ()
    })
</script>
