<template>
    <div>
        <div class="row g-2">
            <div
                v-for="(data, index) in gatewayCurrency"
                :key="index"
                class="col-xl-3 col-lg-4 col-sm-6"
            >
                <div class="card custom-card deposit-card">
                    <div class="card-header">
                        <h5 class="card-title">{{ data.name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="deposit__thumb">
                            <img class="img-thumbnail" :alt="data.name" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <a
                            href="javascript:void(0)"
                            :data-id="data.id"
                            :data-resource="data"
                            :data-min_amount="data.min_amount"
                            :data-max_amount="data.max_amount"
                            :data-fix_charge="data.fixed_charge"
                            :data-percent_charge="data.percent_charge"
                            class="btn-sm d-block btn btn-primary text-center deposit"
                            data-bs-toggle="modal"
                            data-bs-target="#deposit-modal"
                        >
                            Deposit Now</a
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposit Modal -->
        <div
            id="deposit-modal"
            class="modal fade"
            tabindex="-1"
            aria-hidden="true"
            role="dialog"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter Deposit Amount</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form
                        class="deposite-form"
                        action="user/deposit/insert"
                        method="POST"
                    >
                        <input
                            type="hidden"
                            id="symbol"
                            name="symbol"
                            :value="track.symbol"
                        />
                        <input
                            type="hidden"
                            name="currency"
                            class="edit-currency"
                            value=""
                        />
                        <input
                            type="hidden"
                            name="method_code"
                            class="edit-method-code"
                            value=""
                        />
                        <div class="modal-body">
                            <ul>
                                <li>
                                    <span>Deposit Limit</span>
                                    <span
                                        class="text-success depositLimit"
                                    ></span>
                                </li>
                                <li>
                                    <span>Charge</span>
                                    <span
                                        class="text-danger depositCharge"
                                    ></span>
                                </li>
                                <li>
                                    <span>Rate</span>
                                    <span class="text-info"
                                        >1 {{ gnl.cur_text }} =
                                        {{ currency.rate }}
                                        {{ currency.symbol }}</span
                                    >
                                </li>
                            </ul>
                            <label class="form-control-label h6"
                                >Enter Amount
                            </label>
                            <div class="input-group">
                                <input
                                    class="form-control"
                                    type="number"
                                    id="amount"
                                    onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                    name="amount"
                                    placeholder="0.00"
                                    required=""
                                />
                                <span class="input-group-text">{{
                                    gnl.cur_text
                                }}</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm text-white btn-danger"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary btn-sm text-white btn-success"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [],
    // component list
    components: {},

    // component data
    data() {
        return {};
    },

    // custom methods
    methods: {
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
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
