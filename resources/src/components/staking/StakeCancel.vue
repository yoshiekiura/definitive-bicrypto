<template>
    <div
        id="cancelModal"
        class="modal fade text-start"
        tabindex="-1"
        aria-hidden="true"
        role="dialog"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Staking {{ coin.symbol }}</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form @submit.prevent="CancelStake()">
                    <div class="modal-body">
                        <p>
                            Are you sure to cancel
                            <span class="fw-bold">{{ coin.symbol }}</span>
                            Stake?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-dark"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="submit"
                            class="btn btn-danger"
                            :disabled="loading"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "StakeCanel",

    props: ["coin"],
    // component list
    components: {},

    // component data
    data() {
        return {
            loading: false,
        };
    },

    // custom methods
    methods: {
        CancelStake() {
            (this.loading = true),
                this.$http
                    .post("/user/staking/cancel", {
                        symbol: this.coin.symbol,
                        coin_id: this.coin.id,
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
                        $("#cancelModal").modal("hide");
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
