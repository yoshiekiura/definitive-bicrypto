<template>
    <div class=" ">
        <div class="d-flex justify-content-between align-items-center p-1">
            <span class="text-warning fw-bold">Market Trades</span>
        </div>

        <div class="table-responsive">
            <table class="table text-dark table-sm table-borderless">
                <thead class="text-muted">
                    <tr>
                        <th class="text-start" scope="col">Price</th>
                        <th class="text-start" scope="col">Amount</th>
                        <th class="text-end" scope="col">Time</th>
                    </tr>
                </thead>
                <tbody id="tradeTable" class="trade"></tbody>
            </table>
        </div>
    </div>
</template>

<script>
// component
export default {
    props: ["symbol", "currency"],

    // component list
    components: {},

    // component data
    data() {
        return {
            status: true,
        };
    },

    watch: {
        $route(to, from) {
            this.loopTrades();
        },
    },
    computed: {},

    // custom methods
    methods: {
        updateTrades(res) {
            let lastId = "";
            let color = "";
            var tabled = document.getElementById("tradeTable");
            for (let i = 0; i < res.length; i++) {
                if (res[i]["id"] > lastId) {
                    if (res[i]["side"] == "sell") {
                        color = "rgb(246,70,93)";
                    } else {
                        color = "rgb(14,203,129)";
                    }
                    let row = $("<tr>")
                        .append(
                            $("<td>")
                                .css("color", color)
                                .addClass("price")
                                .append($("<span>").text(res[i]["price"]))
                        )
                        .append(
                            $("<td>")
                                .addClass("amount")
                                .append($("<span>").text(res[i]["amount"]))
                        )
                        .append(
                            $('<td class="text-end">')
                                .addClass("time")
                                .append(
                                    $("<span>").text(
                                        this.formatTime(res[i]["datetime"])
                                    )
                                )
                        );
                    $(".trade").prepend(row);
                    lastId = res[i]["id"];
                }
                if (tabled.rows.length > 20) {
                    tabled.deleteRow(tabled.rows.length - 1);
                }
            }
        },
        contains(target, pattern) {
            var value = 0;
            pattern.forEach(function (word) {
                value = value + target.includes(word);
            });
            return value === 1;
        },
        async loopTrades() {
            while (
                this.contains(this.$route.path, [
                    this.$route.params.symbol +
                        "/" +
                        this.$route.params.currency,
                ])
            ) {
                if (document.hidden) {
                    await ccxt.sleep(1000);
                    continue;
                }
                try {
                    const res = await exchange.watchTrades(
                        this.symbol + "/" + this.currency
                    );
                    this.updateTrades(res);
                } catch (e) {
                    break;
                }
            }
        },
        formatTime(time) {
            return time.split("T")[1].split(".")[0];
        },
        async wsClose() {
            this.status = false;
            await exchange.close();
        },
    },

    // on component created
    created() {},

    // on component mounted
    mounted() {
        this.loopTrades();
    },

    // on component destroyed
    destroyed() {},
};
</script>
