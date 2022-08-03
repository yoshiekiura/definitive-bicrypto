<template>
    <div>
        <div class="row match-height">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-congratulation-medal mh-22vh">
                    <div class="card-body">
                        <h5>Welcome 🎉 {{ user.firstname }}</h5>
                        <router-link
                            to="/bot/BTC/USDT"
                            type="button"
                            class="mt-3 btn btn-primary"
                            >New Bot</router-link
                        >
                        <img
                            src="/images/illustration/badge.svg"
                            class="congratulation-medal"
                            alt="Medal Pic"
                        />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="row">
                    <div class="col">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i
                                            class="bi bi-robot font-medium-5"
                                        ></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">
                                    {{ bot_contracts_count_running }}
                                </h2>
                                <p class="card-text">Running Bots</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-success p-50 mb-1">
                                    <div class="avatar-content">
                                        <i
                                            class="bi bi-check-lg font-medium-5"
                                        ></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">
                                    {{ bot_contracts_count_completed }}
                                </h2>
                                <p class="card-text">Completed Bots</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="row">
                    <div class="col">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i
                                            class="bi bi-robot font-medium-5"
                                        ></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">
                                    {{
                                        bot_contracts_count_amount *
                                        currency.rate
                                    }}
                                    {{ currency.symbol }}
                                </h2>
                                <p class="card-text">Total Investment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-success p-50 mb-1">
                                    <div class="avatar-content">
                                        <i
                                            class="bi bi-check-lg font-medium-5"
                                        ></i>
                                    </div>
                                </div>
                                <h2 v-if="profit > 0" class="text-success">
                                    {{ profit * currency.rate }}
                                    {{ currency.symbol }}
                                </h2>
                                <h2
                                    v-else-if="profit < 0"
                                    class="fw-bolder text-danger"
                                >
                                    {{ profit * currency.rate }}
                                    {{ currency.symbol }}
                                </h2>
                                <h2 v-else class="fw-bolder">
                                    {{ profit * currency.rate }}
                                    {{ currency.symbol }}
                                </h2>
                                <p class="card-text">Total Profit/Lose</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div
                        class="card-header d-flex justify-content-between align-items-center"
                    >
                        <h4 class="card-title">Your Bots</h4>
                        <div class="card-search"></div>
                    </div>
                    <div
                        class="table-responsive"
                        style="max-height: 280px; overflow-y: auto"
                    >
                        <table class="table custom-data-bs-table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Bot</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">View</th>
                                </tr>
                            </thead>
                            <tbody
                                v-if="
                                    bot_contracts != null &&
                                    bot_contracts.length > 0
                                "
                                :key="bot_contracts.length"
                            >
                                <tr
                                    v-for="(bot, index) in bot_contracts"
                                    :key="index"
                                >
                                    <td
                                        data-label="Bot"
                                        class="d-flex flex-column"
                                    >
                                        <div class="fw-bold fs-4">
                                            {{ bot.bot_name }}
                                        </div>
                                        <small
                                            class="text-warning"
                                            style="margin-top: 4px"
                                            >({{ bot.symbol }}/{{
                                                bot.pair
                                            }})</small
                                        >
                                    </td>
                                    <td data-label="Duration">
                                        <div>
                                            Start:
                                            <span class="fw-bold">{{
                                                bot.start_date
                                            }}</span>
                                        </div>
                                        <div>
                                            End:
                                            <span class="fw-bold">{{
                                                bot.end_date
                                            }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Status">
                                        <span
                                            v-if="bot.status != 1"
                                            class="badge bg-warning"
                                            >Running</span
                                        >
                                        <span
                                            v-else-if="bot.status == 1"
                                            class="badge bg-success"
                                            >Completed</span
                                        >
                                    </td>
                                    <td data-label="View">
                                        <router-link
                                            v-if="bot.status != 1"
                                            :to="
                                                '/bot/' +
                                                bot.symbol +
                                                '/' +
                                                bot.pair
                                            "
                                            class="btn btn-icon btn-info btn-sm"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="View"
                                        >
                                            <i class="bi bi-display"></i>
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td
                                        class="text-muted text-center"
                                        colspan="100%"
                                    >
                                        <img
                                            height="128px"
                                            width="128px"
                                            src="https://assets.staticimg.com/pro/2.0.4/images/empty.svg"
                                            alt=""
                                        />
                                        <p class="">No Data Found</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"],
    // component list
    components: {},

    // component data
    data() {
        return {
            bot_contracts: {},
            bot_contracts_count_running: {},
            bot_contracts_count_completed: {},
            bot_contracts_count_amount: {},
            profit: {},
            gnl: gnl,
            currency: {},
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
                .post("/user/fetch/bot")
                .then((response) => {
                    (this.bot_contracts = response.data.bot_contracts),
                        (this.bot_contracts_count_running =
                            response.data.bot_contracts_count_running),
                        (this.bot_contracts_count_completed =
                            response.data.bot_contracts_count_completed),
                        (this.bot_contracts_count_amount =
                            response.data.bot_contracts_count_amount),
                        (this.profit = response.data.profit),
                        (this.currency = response.data.currency);
                })
                .catch((error) => {
                    if (error.response.data.message == "nokyc") {
                        window.location.href = "/user/kyc";
                    }
                });
        },
    },

    // on component created
    created() {
        this.fetchData();
    },

    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
    updated() {},
};
</script>
