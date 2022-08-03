<template>
    <div :key="walletCur">
        <label
            for="basic-url"
            class="form-label mb-1 d-flex justify-content-between text-1 text-dark"
        >
            <a class="text-dark">{{ currency }} Wallet</a>
        </label>
        <form v-if="walletCur == null" @submit.prevent="createWallet(currency)">
            <button type="submit" class="btn btn-success btn-sm">
                Create Wallet
            </button>
        </form>
        <div v-else class="input-group input-group-sm mb-1">
            <input
                type="number"
                class="form-control text-dark border-0"
                :value="walletCur"
                readonly
                aria-label="Amount (to the nearest dollar)"
            />
            <span class="input-group-text text-dark border-0">{{
                currency
            }}</span>
        </div>
    </div>
</template>

<script>
// component
export default {
    props: ["currency"],

    // component list
    components: {},
    // component data
    data() {
        return {
            activeItem: "pills-market",
            walletCur: null,
        };
    },

    // custom methods
    methods: {
        fetchWallet(symbol) {
            this.$http
                .post("/user/fetch/wallet", {
                    type: "trading",
                    symbol: symbol,
                })
                .then((response) => {
                    (this.walletCur = response.data.balance),
                        this.$emit("walletCur", response.data.balance);
                });
        },
        createWallet(symbol) {
            (this.loading = true),
                this.$http
                    .post("/user/wallet/j/create", {
                        type: "trading",
                        symbol: symbol,
                    })
                    .then((response) => {
                        this.fetchWallet(symbol);
                        this.$toast[response.data.type](response.data.message);
                    })
                    .catch((error) => {
                        this.$toast.error(error.response.data);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
        },
    },

    // on component created
    created() {
        this.fetchWallet(this.currency);
    },

    // on component destroyed
    destroyed() {},
};
</script>
