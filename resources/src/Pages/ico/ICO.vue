<template>
    <div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="card card-profile">
                    <img
                        src="assets/images/ico/stage-3.jpg"
                        class="card-img-top"
                        alt="Profile Cover Photo"
                    />
                    <div class="card-body">
                        <div class="profile-image-wrapper">
                            <div class="profile-image">
                                <div class="avatar">
                                    <img
                                        class="round"
                                        v-if="user.profile_photo_path != null"
                                        :src="
                                            user.profile_photo_path
                                                ? 'assets/images/profile/' +
                                                  user.profile_photo_path
                                                : '/market/notification.png'
                                        "
                                        alt="avatar"
                                    />
                                </div>
                            </div>
                        </div>
                        <h3>{{ user.firstname }}</h3>
                        <div>
                            <h6 class="badge badge-light-success profile-badge">
                                Verified Trader
                            </h6>
                            <h6
                                class="badge badge-light-info profile-badge"
                                v-if="ico_logs != null"
                            >
                                {{ ico_logs.length }} Contributions
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="card card-transaction">
                    <div class="card-header">
                        <h4 class="card-title">Your Contributions</h4>
                    </div>
                    <div
                        v-if="ico_logs != null && ico_logs.length > 0"
                        class="card-body"
                        style="max-height: 280px; overflow-y: auto"
                    >
                        <div
                            v-for="(ico_log, index) in ico_logs"
                            :key="index"
                            class="transaction-item"
                        >
                            <div class="d-flex">
                                <div
                                    class="avatar icon-bg bg-light-primary rounded float-start"
                                >
                                    <div class="avatar-content">
                                        <span class="text-success font-medium-5"
                                            ><i
                                                class="bi bi-journal-arrow-up"
                                            ></i
                                        ></span>
                                    </div>
                                </div>
                                <div class="transaction-percentage">
                                    <div>
                                        <span class="text-success fw-bold"
                                            >Token Purchase</span
                                        >
                                        <p>
                                            <small>
                                                {{
                                                    ico_log.created_at
                                                        | moment(
                                                            "dddd, MMMM Do YYYY"
                                                        )
                                                }}
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="fw-bolder">
                                <span
                                    v-if="ico_log.status == 0"
                                    class="badge bg-warning"
                                    >Pending</span
                                >
                                <span
                                    v-else-if="ico_log.status == 1"
                                    class="badge bg-success"
                                    >{{ ico_log.recieved | toMoney }}
                                    {{ getICO(ico_log.ico_id).symbol }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-muted text-center" colspan="100%">
                        <img
                            height="128px"
                            width="128px"
                            src="https://assets.staticimg.com/pro/2.0.4/images/empty.svg"
                            alt=""
                        />
                        <p class="">No Data Found</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div
                        class="col-lg-6 col-md-12 col-12"
                        v-for="(ico, index) in icos"
                        :key="index"
                    >
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column">
                                    <div class="card-content flex-grow-1">
                                        <div
                                            class="d-flex justify-content-between align-items-center"
                                        >
                                            <v-lazy-image
                                                class="avatar"
                                                :height="48"
                                                :width="48"
                                                :src="
                                                    ico.icon
                                                        ? '/assets/images/ico/' +
                                                          ico.icon
                                                        : '/market/notification.png'
                                                "
                                                alt=""
                                                style="filter: grayscale(0)"
                                            />
                                            <span
                                                v-if="ico.status == 0"
                                                class="badge bg-warning"
                                                >Upcoming</span
                                            >
                                            <span
                                                v-else-if="ico.status == 1"
                                                class="badge bg-success"
                                                >Sale Live</span
                                            >
                                            <span
                                                v-else-if="ico.status == 2"
                                                class="badge bg-danger"
                                                >Sale Ended</span
                                            >
                                            <span
                                                v-else-if="ico.status == 3"
                                                class="badge bg-secondary"
                                                >Canceled</span
                                            >
                                        </div>
                                        <div class="mt-1">
                                            <span class="fs-3">{{
                                                ico.name
                                            }}</span>
                                            <p class="fs-5 text-muted">
                                                {{
                                                    ico.soft_price | toMoney(4)
                                                }}
                                                {{ ico.network_symbol }}
                                            </p>
                                        </div>
                                        <div class="flex-column">
                                            <span v-if="ico.type == 1"
                                                >Soft</span
                                            >
                                            <span v-else-if="ico.type == 2"
                                                >Hard</span
                                            >
                                            <span v-else-if="ico.type == 3"
                                                >Soft/Hard</span
                                            >
                                            <p
                                                v-if="ico.type == 1"
                                                class="text-success fw-bold fs-4"
                                            >
                                                {{ ico.soft_cap | toMoney(4) }}
                                            </p>
                                            <p
                                                v-else-if="ico.type == 2"
                                                class="text-success fw-bold fs-4"
                                            >
                                                {{ ico.hard_cap | toMoney(4) }}
                                            </p>
                                            <p
                                                v-else-if="ico.type == 3"
                                                class="text-success fw-bold fs-4"
                                            >
                                                {{ ico.soft_cap | toMoney(4) }}
                                            </p>
                                        </div>
                                        <div class="mb-1">
                                            <p
                                                v-if="ico.type == 1"
                                                class="title"
                                            >
                                                Progress ({{
                                                    ((ico.soft_raised /
                                                        ico.soft_cap) *
                                                        100)
                                                        | toMoney(2)
                                                }}%)
                                            </p>
                                            <p
                                                v-else-if="ico.type == 2"
                                                class="title"
                                            >
                                                Progress ({{
                                                    (ico.hard_raised /
                                                        ico.hard_cap) *
                                                    100
                                                }}%)
                                            </p>
                                            <p
                                                v-else-if="ico.type == 3"
                                                class="title"
                                            >
                                                Progress ({{
                                                    (ico.soft_raised /
                                                        ico.soft_cap) *
                                                    100
                                                }}%)
                                            </p>
                                            <span
                                                v-if="ico.type == 1"
                                                class="mb-1"
                                            >
                                                <div
                                                    id="myRangeColor"
                                                    class="progress"
                                                >
                                                    <div
                                                        id="myRange"
                                                        class="progress-bar progress-bar-striped progress-bar-animated"
                                                        role="progressbar"
                                                        aria-valuenow="50"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        :style="
                                                            'width:' +
                                                            (ico.soft_raised /
                                                                ico.soft_cap) *
                                                                100 +
                                                            '%'
                                                        "
                                                    ></div>
                                                </div>
                                            </span>
                                            <span
                                                v-else-if="ico.type == 2"
                                                class="mb-1"
                                            >
                                                <div
                                                    id="myRangeColor"
                                                    class="progress"
                                                >
                                                    <div
                                                        id="myRange"
                                                        class="progress-bar progress-bar-striped progress-bar-animated"
                                                        role="progressbar"
                                                        aria-valuenow="50"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        :style="
                                                            'width:' +
                                                            (ico.hard_raised /
                                                                ico.hard_cap) *
                                                                100 +
                                                            '%'
                                                        "
                                                    ></div>
                                                </div>
                                            </span>
                                            <span
                                                v-else-if="ico.type == 3"
                                                class="mb-1"
                                            >
                                                <div
                                                    id="myRangeColor"
                                                    class="progress"
                                                >
                                                    <div
                                                        id="myRange"
                                                        class="progress-bar progress-bar-striped progress-bar-animated"
                                                        role="progressbar"
                                                        aria-valuenow="50"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        :style="
                                                            'width:' +
                                                            (ico.soft_raised /
                                                                ico.soft_cap) *
                                                                100 +
                                                            '%'
                                                        "
                                                    ></div>
                                                </div>
                                            </span>
                                            <small
                                                class="d-flex justify-content-between"
                                            >
                                                <span v-if="ico.type == 1"
                                                    >{{
                                                        ico.soft_raised
                                                            | toMoney(4)
                                                    }}
                                                    {{ ico.symbol }}</span
                                                >
                                                <span v-else-if="ico.type == 2"
                                                    >{{
                                                        ico.hard_raised
                                                            | toMoney(4)
                                                    }}
                                                    {{ ico.symbol }}</span
                                                >
                                                <span v-else-if="ico.type == 3"
                                                    >{{
                                                        ico.soft_raised
                                                            | toMoney(4)
                                                    }}
                                                    {{ ico.symbol }}</span
                                                >
                                                <span v-if="ico.type == 1"
                                                    >{{
                                                        ico.soft_cap
                                                            | toMoney(4)
                                                    }}
                                                    {{ ico.symbol }}</span
                                                >
                                                <span v-else-if="ico.type == 2"
                                                    >{{
                                                        ico.hard_cap
                                                            | toMoney(4)
                                                    }}
                                                    {{ ico.symbol }}</span
                                                >
                                                <span v-else-if="ico.type == 3"
                                                    >{{
                                                        ico.soft_cap
                                                            | toMoney(4)
                                                    }}
                                                    {{ ico.symbol }}</span
                                                >
                                            </small>
                                        </div>
                                        <div
                                            class="d-flex justify-content-between align-items-center"
                                        >
                                            <span class="fw-bold"
                                                >Liquidity %:</span
                                            >
                                            <span class=""
                                                >{{ ico.liquidity }}%</span
                                            >
                                        </div>
                                        <div
                                            class="d-flex justify-content-between align-items-center"
                                        >
                                            <span class="fw-bold"
                                                >Lockup Time:</span
                                            >
                                            <span class=""
                                                >{{ ico.lockup }} days</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <div
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    <span v-if="ico.stage == 0"
                                        >Sale Starts In:</span
                                    >
                                    <span v-else-if="ico.stage == 1"
                                        >Sale Ends In:</span
                                    >
                                    <span v-else-if="ico.stage == 2"
                                        >Ended</span
                                    >
                                    <span v-else>Canceled</span>
                                    <router-link
                                        :to="'ico/' + ico.symbol"
                                        class="btn btn-outline-warning btn-sm"
                                    >
                                        View Pool
                                    </router-link>
                                </div>
                                <Countdown
                                    v-if="ico.stage == 0"
                                    class="mt-1"
                                    :deadline="ico.soft_start"
                                ></Countdown>
                                <Countdown
                                    v-else-if="ico.stage == 1"
                                    class="mt-1"
                                    :deadline="ico.soft_end"
                                ></Countdown>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Countdown from "vuejs-countdown";

export default {
    props: ["user"],
    // component list
    components: {
        Countdown,
    },

    // component data
    data() {
        return {
            icos: [],
            meta: [],
            wallets: [],
            ico_logs: [],
            ico_balance: [],
            currency: [],
        };
    },

    // custom methods
    methods: {
        getICO(id) {
            if (this.icos.find((icos) => icos.id === id) != null) {
                return this.icos.find((icos) => icos.id === id);
            } else {
                return null;
            }
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        fetchData() {
            this.$http
                .post("/user/fetch/ico")
                .then((response) => {
                    (this.icos = response.data.icos),
                        (this.meta = response.data.meta),
                        (this.wallets = response.data.wallets),
                        (this.ico_logs = response.data.ico_logs),
                        (this.ico_balance = response.data.ico_balance),
                        (this.currency = response.data.currency);
                })
                .catch((error) => {
                    if (error.response.data.message == "nokyc") {
                        window.location.href = "/user/kyc";
                    }
                });
        },
        timer(time) {
            moment.tz(time, "Greenwich");
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
};
</script>
