<template>
    <div class="row match-height">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        BTC <span v-if="contract.hilow">Rise</span
                        ><span v-else>Fall</span>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col">
                            Profit/Loss:<br />
                            <div
                                :class="
                                    contract.result == 1
                                        ? 'text-success'
                                        : contract.result == 2
                                        ? 'text-danger'
                                        : 'text-secondary'
                                "
                            >
                                <b
                                    ><span v-if="contract.result == 1"
                                        >+
                                        {{ contract.amount * gnl.profit }}</span
                                    ><span v-else-if="contract.result == 2"
                                        >-
                                        {{ contract.amount * gnl.profit }}</span
                                    ><span v-else>Draw</span>
                                </b>
                            </div>
                        </div>
                        <div class="col">
                            Sell price:<br /><b>{{
                                (contract.amount + contract.amount * gnl.profit)
                                    | toMoney(4)
                            }}</b>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col">
                            Buy price:<br /><b>{{
                                contract.amount | toMoney(4)
                            }}</b>
                        </div>
                        <div class="col">
                            Payout limit:<br /><b>{{
                                contract.amount * gnl.profit
                            }}</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div
                    class="card-body"
                    style="max-height: 280px; overflow-y: auto"
                >
                    <div class="row">
                        <div class="col-3">
                            <i
                                class="border-white bi bi-play btn btn-icon fs-3 rounded bg-light-secondary"
                            ></i>
                        </div>
                        <div class="col-9">
                            Reference ID:<br /><b>{{ contract.id }}</b>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-3">
                            <i
                                class="bi bi-clock btn btn-icon fs-3 rounded bg-light-secondary"
                            ></i>
                        </div>
                        <div class="col-9">
                            Duration:<br /><span
                                v-if="
                                    contract.duration >= 60 &&
                                    contract.duration < 3600
                                "
                                ><b> {{ contract.duration / 60 }}</b> min</span
                            >
                            <span v-else-if="contract.duration > 3600"
                                ><b> {{ contract.duration / 3600 }}</b> hour
                            </span>
                            <span v-else
                                ><b>{{ contract.duration }}</b> sec</span
                            >
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-3">
                            <i
                                class="bi bi-chevron-bar-contract btn btn-icon fs-3 rounded bg-light-secondary"
                            ></i>
                        </div>
                        <div class="col-9">
                            Barrier:<br /><b>{{
                                data["0"].value | toMoney(4)
                            }}</b>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-3">
                            <i
                                class="border-warning bi bi-geo-alt btn btn-icon fs-3 rounded bg-light-secondary"
                            ></i>
                        </div>
                        <div class="col-9">
                            Start time:<br /><b>{{ contract.in_time }}</b>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-3">
                            <i
                                class="border-danger bi bi-record-circle btn btn-icon fs-3 rounded bg-light-secondary"
                            ></i>
                        </div>
                        <div class="col-9">
                            Entry spot:<br /><b>{{
                                contract.price_was | toMoney(4)
                            }}</b>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-3">
                            <i
                                class="border-info bi bi-record-circle-fill btn btn-icon fs-3 rounded bg-light-secondary"
                            ></i>
                        </div>
                        <div class="col-9">
                            Exit spot:<br /><b>{{
                                data[data.length - 1].value
                            }}</b>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-3">
                            <i
                                class="border-success bi bi-flag btn btn-icon fs-3 rounded bg-light-secondary"
                            ></i>
                        </div>
                        <div class="col-9">
                            Exit time:<br /><b>{{ duration }}</b>
                        </div>
                    </div>
                    <hr />
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
                                class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start"
                            >
                                <div>
                                    <h4 class="card-title mb-25">
                                        Contract details
                                    </h4>
                                </div>
                                <div
                                    class="d-flex align-items-center flex-wrap mt-sm-0 mt-1"
                                >
                                    <h5 class="fw-bolder mb-0 me-1">
                                        $ {{ data[data.length - 1].value }}
                                    </h5>
                                    <span class="badge badge-light-secondary">
                                        <i
                                            class="text-danger font-small-3 bi bi-arrow-down"
                                        ></i>
                                        <span class="align-middle"
                                            >{{
                                                (data["0"].value /
                                                    data[data.length - 1].value)
                                                    | toMoney(4)
                                            }}%</span
                                        >
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
</template>

<script>
import { loadScript } from "vue-plugin-load-script";
$(window).resize(function () {
    chart.applyOptions({
        width: $(".parent-chart").innerWidth(),
        height: $(".parent-chart").innerHeight(),
    });
});

export default {
    props: [],
    // component list
    components: {},

    // component data
    data() {
        return {
            gnl: gnl,
            contract: [],
            data: [],
            duration: [],
        };
    },

    // custom methods
    methods: {
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        fetchData() {
            this.$http
                .post(
                    "/user/fetch/binary/contract/view/" +
                        this.$route.params.type +
                        "/" +
                        this.$route.params.id
                )
                .then((response) => {
                    (this.contract = response.data.contract),
                        (this.data = response.data.data),
                        (this.duration = response.data.duration);
                    loadScript(
                        "https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"
                    )
                        .then(() => {
                            console.log(this.data[0].value);
                            var chart = LightweightCharts.createChart(
                                document.getElementById("chart"),
                                {
                                    rightPriceScale: {
                                        scaleMargins: {
                                            top: 0.1,
                                            bottom: 0.1,
                                        },
                                    },
                                    layout: {
                                        backgroundColor: "#ffffff",
                                        textColor: "rgba(33, 56, 77, 1)",
                                    },
                                    grid: {
                                        vertLines: {
                                            color: "rgba(197, 203, 206, 0.4)",
                                        },
                                        horzLines: {
                                            color: "rgba(197, 203, 206, 0.4)",
                                        },
                                    },
                                    timeScale: {
                                        timeVisible: true,
                                        secondsVisible: false,
                                    },
                                }
                            );
                            var lineSeries = chart.addBaselineSeries({
                                baseValue: {
                                    type: "price",
                                    price: this.data[0].value,
                                },
                                lastPriceAnimation: 1,
                            });
                            lineSeries.setData(this.data);

                            var lineSeries1 = chart.addLineSeries({
                                color: "#bdc3c7",
                            });

                            lineSeries1.setData(this.data[0]);
                            chart.timeScale().fitContent();
                        })
                        .catch(() => {
                            // Failed to fetch script
                        });
                });
        },
    },

    // on component created
    created() {},

    // on component mounted
    mounted() {
        this.fetchData();
    },

    // on component destroyed
    destroyed() {},
};
</script>
<style scoped>
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
