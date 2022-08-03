<template>
    <div class="modal modal-slide-in fade" id="subscribeModal">
        <div class="modal-dialog sidebar-sm">
            <form
                class="add-new-record modal-content pt-0"
                @submit.prevent="Stake()"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    ×
                </button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Staking <span>{{ coin.symbol }}</span>
                    </h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <label for="amount">Stake Amount</label>
                        <span class="text-light"
                            >{{ wallet.balance }} USDT</span
                        >
                    </div>
                    <div class="input-group w-auto mb-1">
                        <input
                            type="number"
                            class="form-control"
                            step="0.00000001"
                            required=""
                            v-model="amount"
                            placeholder="Amount"
                        />
                        <span class="input-group-text text-light">{{
                            coin.symbol
                        }}</span>
                    </div>
                    <div class="card bg-black">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Est. apr</span>
                                <span class="text-success"
                                    >{{ coin.apr }}%</span
                                >
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>staked Amount</span>
                                <span>{{ coin.staked }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>max Available</span>
                                <span>{{ coin.max_stake }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Staking period</span>
                                <span>{{ coin.period }}</span
                                ><span> Days</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Staking method</span>
                                <span>{{ coin.method }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Coin network</span>
                                <span>{{ coin.network }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Profit Distribution</span>
                                <span>{{ coin.profit_unit }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Est. Daily Profits</span>
                                <span>{{ coin.daily_profit }}</span>
                            </div>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="btn btn-dark"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary ms-1"
                        :disabled="loading"
                    >
                        Stake
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Stake",
    props: ["coin", "wallet"],
    // component list
    components: {},

    // component data
    data() {
        return {
            amount: 0,
            loading: false,
        };
    },

    // custom coin.methods
    methods: {
        Stake() {
            (this.loading = true),
                this.$http
                    .post("/user/staking/store", {
                        symbol: this.coin.symbol,
                        coin_id: this.coin.id,
                        amount: this.amount,
                    })
                    .then((response) => {
                        this.$toast[response.data.type](response.data.message),
                            this.$emit("Staked");
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                        $("#subscribeModal").modal("hide");
                    });
        },
    },

    // on component created
    created() {},

    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
};
</script>
