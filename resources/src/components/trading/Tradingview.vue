<template>
    <div class=" ">
        <div id="tradingview"></div>
    </div>
</template>

<script>
// component
export default {
    props: ["provide", "symbol", "currency"],

    // component list
    components: {},

    // component data
    data() {
        return {};
    },

    // custom methods
    methods: {},

    // on component created
    created() {},

    // on component mounted
    mounted() {
        new TradingView.widget({
            width: "100%",
            height: "100%",
            symbol: this.provide + ":" + this.symbol + this.currency,
            interval: "H",
            timezone: "Etc/UTC",
            theme: "dark",
            style: "1",
            locale: "en",
            toolbar_bg: "#f1f3f6",
            enable_publishing: false,
            hide_legend: true,
            save_image: false,
            container_id: "tradingview",
        });
    },

    // on component destroyed
    destroyed() {},
};
</script>
