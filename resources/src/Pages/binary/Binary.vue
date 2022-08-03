<template>
    <div>
        <ul class="nav nav-tabs border" role="tablist">
            <li class="nav-item w-50">
                <button
                    class="nav-link w-100"
                    @click.prevent="setActive('practice')"
                    :class="{ active: isActive('practice') }"
                    href="#practice"
                >
                    Binary Practice
                </button>
            </li>
            <li class="nav-item w-50">
                <button
                    class="nav-link w-100"
                    @click.prevent="setActive('trading')"
                    :class="{ active: isActive('trading') }"
                    href="#trading"
                >
                    Binary Trading
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div
                class="tab-pane"
                :class="{ 'active show': isActive('practice') }"
                id="practice"
                aria-labelledby="practice-tab"
                role="tabpanel"
            >
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <!-- Medal Card -->
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-congratulation-medal">
                                <div class="card-body">
                                    <h5>Welcome 🎉 {{ user.firstname }}</h5>
                                    <p class="card-text font-small-3">
                                        You have earned
                                    </p>
                                    <h3 class="mb-75 mt-2 pt-50">
                                        <a href="#"
                                            >{{ symbol }}
                                            {{
                                                trade.practice_Won | toMoney
                                            }}</a
                                        >
                                    </h3>
                                    <router-link
                                        to="/binary/practice/BTC/USDT"
                                        type="button"
                                        class="btn btn-primary"
                                        >Practice Now</router-link
                                    >
                                    <img
                                        src="/images/illustration/badge.svg"
                                        class="congratulation-medal"
                                        alt="Medal Pic"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card earnings-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title mb-2">
                                                Earnings
                                            </h4>
                                            <div class="font-small-3">
                                                This Week
                                            </div>
                                            <h5 class="mb-1">
                                                {{
                                                    perc.tradeWon_last_week
                                                        | toMoney
                                                }}
                                                {{ symbol }}
                                            </h5>
                                            <p
                                                class="card-text text-muted font-small-3"
                                            >
                                                <span> Total Trades: </span>
                                                <span class="fw-bolder">{{
                                                    practice_totaltrades
                                                }}</span>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <VueApexCharts
                                                width="180"
                                                type="donut"
                                                :options="practice"
                                                :series="practice.series"
                                            >
                                            </VueApexCharts>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div
                                    class="card-body"
                                    style="
                                        background: url('/images/slider/wallet.png');
                                        background-position: right;
                                        background-repeat: no-repeat;
                                    "
                                >
                                    <p class="mb-1 fs-14 text-warning">
                                        Balance
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div
                                            class="h2 text-warning mb-1"
                                            v-if="
                                                user.practice_balance !== null
                                            "
                                            :key="user.practice_balance"
                                        >
                                            {{
                                                user.practice_balance | toMoney
                                            }}
                                            {{ symbol }}
                                        </div>
                                    </div>
                                    <div class="d-flex mt-1">
                                        <button
                                            type="button"
                                            class="btn btn-outline-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#practiceAmount"
                                        >
                                            + Top Up
                                        </button>
                                    </div>

                                    <div class="modal fade" id="practiceAmount">
                                        <div
                                            class="modal-dialog modal-dialog-scrollable"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">
                                                        Add Practice Balance
                                                    </h6>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    >
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                                <form
                                                    class="deposit-form"
                                                    @submit.prevent="
                                                        AddPracticeBalance()
                                                    "
                                                >
                                                    <div class="modal-body">
                                                        <p>
                                                            Are you sure you
                                                            want to add practice
                                                            balance?
                                                        </p>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-primary text-white btn-danger"
                                                            data-bs-dismiss="modal"
                                                        >
                                                            Close
                                                        </button>
                                                        <button
                                                            type="submit"
                                                            class="btn btn-primary text-white btn-success"
                                                        >
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height">
                        <div class="col-lg-4 col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-info p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-bar-chart font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.practice_Log }}
                                            </h2>
                                            <p class="card-text">
                                                Total Trade Log
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-success p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-graph-up-arrow font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.practice_Win }}
                                            </h2>
                                            <p class="card-text">
                                                Total Wining Trade
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-warning p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-slash-lg font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.practice_Draw }}
                                            </h2>
                                            <p class="card-text">
                                                Total Draw Trade
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-danger p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-graph-down-arrow font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.practice_Lose }}
                                            </h2>
                                            <p class="card-text">
                                                Total Losing Trade
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Report Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-transaction">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Practice Contracts
                                    </h4>
                                </div>
                                <div
                                    class="card-body"
                                    style="max-height: 280px; overflow-y: auto"
                                >
                                    <template
                                        v-for="(
                                            practicelog, index
                                        ) in practicelogs"
                                    >
                                        <div
                                            v-if="practicelog"
                                            :key="index"
                                            class="transaction-item"
                                        >
                                            <div class="d-flex">
                                                <div
                                                    class="avatar bg-light-primary rounded float-start"
                                                >
                                                    <div class="avatar-content">
                                                        <span
                                                            v-if="
                                                                practicelog.hilow ==
                                                                1
                                                            "
                                                            class="text-success font-medium-5"
                                                            ><i
                                                                class="bi bi-graph-up-arrow"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            v-else-if="
                                                                practicelog.hilow ==
                                                                2
                                                            "
                                                            class="text-danger font-medium-5"
                                                            ><i
                                                                class="bi bi-graph-down-arrow"
                                                            ></i
                                                        ></span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="transaction-percentage"
                                                >
                                                    <h6
                                                        class="transaction-title"
                                                    >
                                                        <span
                                                            v-if="
                                                                practicelog.hilow ==
                                                                1
                                                            "
                                                            class="text-success"
                                                            >Rise</span
                                                        >
                                                        <span
                                                            v-if="
                                                                practicelog.hilow ==
                                                                2
                                                            "
                                                            class="text-danger"
                                                            >Fall</span
                                                        >
                                                    </h6>
                                                    <small
                                                        >{{
                                                            practicelog.symbol
                                                        }}
                                                        /
                                                        {{
                                                            practicelog.pair
                                                        }}</small
                                                    >
                                                </div>
                                            </div>
                                            <div class="fw-bolder">
                                                <span
                                                    v-if="
                                                        practicelog.result == 1
                                                    "
                                                    class="badge bg-success"
                                                    >+
                                                    {{
                                                        (practicelog.amount *
                                                            (gnl.profit / 100))
                                                            | toMoney
                                                    }}
                                                    {{ practicelog.pair }}</span
                                                >
                                                <span
                                                    v-else-if="
                                                        practicelog.result == 2
                                                    "
                                                    class="badge bg-danger"
                                                    >-
                                                    {{
                                                        practicelog.amount
                                                            | toMoney
                                                    }}
                                                    {{ practicelog.pair }}</span
                                                >
                                                <span
                                                    v-else-if="
                                                        practicelog.result == 3
                                                    "
                                                    class="badge bg-warning"
                                                    >Draw</span
                                                >
                                                <span
                                                    v-else
                                                    class="badge bg-warning"
                                                    >Pending</span
                                                >
                                            </div>
                                        </div>
                                        <div v-else colspan="100%" :key="index">
                                            No results found!
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <Refer
                                v-if="gnl.referal_status == 1"
                                :pathname="pathname"
                                :user="user"
                                :key="gnl.referal_status"
                            />
                        </div>
                    </div>
                </section>
            </div>
            <div
                class="tab-pane"
                :class="{ 'active show': isActive('trading') }"
                id="trading"
                aria-labelledby="trading-tab"
                role="tabpanel"
            >
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <!-- Medal Card -->
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card card-congratulation-medal">
                                <div class="card-body">
                                    <h5>Welcome 🎉 {{ user.firstname }}</h5>
                                    <p class="card-text font-small-3">
                                        You have earned
                                    </p>
                                    <h3 class="mb-75 mt-2 pt-50">
                                        <a href="#"
                                            >{{ symbol }}
                                            {{ trade.Won | toMoney }}</a
                                        >
                                    </h3>
                                    <router-link
                                        to="/binary/trade/BTC/USDT"
                                        type="button"
                                        class="btn btn-primary"
                                        >Start Trading</router-link
                                    >
                                    <img
                                        src="/images/illustration/badge.svg"
                                        class="congratulation-medal"
                                        alt="Medal Pic"
                                    />
                                </div>
                            </div>
                        </div>
                        <!--/ Medal Card -->
                        <!-- Earnings Card -->
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card earnings-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title mb-2">
                                                Earnings
                                            </h4>
                                            <div class="font-small-3">
                                                This Week
                                            </div>
                                            <h5 class="mb-1">
                                                {{ symbol }}
                                                {{
                                                    perc.tradeWon_last_week
                                                        | toMoney
                                                }}
                                            </h5>
                                            <p
                                                class="card-text text-muted font-small-3"
                                            >
                                                <span> Total Trades: </span>
                                                <span class="fw-bolder">{{
                                                    totaltrades
                                                }}</span>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <VueApexCharts
                                                width="180"
                                                type="donut"
                                                :options="trade"
                                                :series="trade.series"
                                            >
                                            </VueApexCharts>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Earnings Card -->
                        <!-- CCard -->
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card">
                                <div
                                    class="card-body"
                                    style="
                                        background: url('images/slider/wallet.png');
                                        background-position: right;
                                        background-repeat: no-repeat;
                                    "
                                >
                                    <p class="mb-1 fs-14 text-success">
                                        Balance
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div class="h2 text-success mb-1">
                                            {{ funding_wallets | toMoney }}
                                            {{ symbol }}
                                        </div>
                                    </div>
                                    <div class="d-flex mt-1">
                                        <router-link
                                            to="/wallets"
                                            class="btn btn-outline-success"
                                            >+ Deposit</router-link
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row match-height">
                        <div class="col-lg-4 col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-info p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-bar-chart font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.Log }}
                                            </h2>
                                            <p class="card-text">
                                                Total Trade Log
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-success p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-graph-up-arrow font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.Win }}
                                            </h2>
                                            <p class="card-text">
                                                Total Wining Trade
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-warning p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-slash-lg font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.Draw }}
                                            </h2>
                                            <p class="card-text">
                                                Total Draw Trade
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div
                                                class="avatar bg-light-danger p-50 mb-1"
                                            >
                                                <div class="avatar-content">
                                                    <i
                                                        class="bi bi-graph-down-arrow font-medium-5"
                                                    ></i>
                                                </div>
                                            </div>
                                            <h2 class="fw-bolder">
                                                {{ trade.Lose }}
                                            </h2>
                                            <p class="card-text">
                                                Total Losing Trade
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Report Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-transaction">
                                <div class="card-header">
                                    <h4 class="card-title">Trade Contracts</h4>
                                </div>
                                <div
                                    class="card-body"
                                    style="max-height: 280px; overflow-y: auto"
                                >
                                    <template
                                        v-for="(tradelog, index) in tradelogs"
                                    >
                                        <div
                                            v-if="tradelog"
                                            :key="index"
                                            class="transaction-item"
                                        >
                                            <div class="d-flex">
                                                <div
                                                    class="avatar bg-light-primary rounded float-start"
                                                >
                                                    <div class="avatar-content">
                                                        <span
                                                            v-if="
                                                                tradelog.hilow ==
                                                                1
                                                            "
                                                            class="text-success font-medium-5"
                                                            ><i
                                                                class="bi bi-graph-up-arrow"
                                                            ></i
                                                        ></span>
                                                        <span
                                                            v-else-if="
                                                                tradelog.hilow ==
                                                                2
                                                            "
                                                            class="text-danger font-medium-5"
                                                            ><i
                                                                class="bi bi-graph-down-arrow"
                                                            ></i
                                                        ></span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="transaction-percentage"
                                                >
                                                    <h6
                                                        class="transaction-title"
                                                    >
                                                        <span
                                                            v-if="
                                                                tradelog.hilow ==
                                                                1
                                                            "
                                                            class="text-success"
                                                            >Rise</span
                                                        >
                                                        <span
                                                            v-if="
                                                                tradelog.hilow ==
                                                                2
                                                            "
                                                            class="text-danger"
                                                            >Fall</span
                                                        >
                                                    </h6>
                                                    <small
                                                        >{{ tradelog.symbol }} /
                                                        {{
                                                            tradelog.pair
                                                        }}</small
                                                    >
                                                </div>
                                            </div>
                                            <div class="fw-bolder">
                                                <span
                                                    v-if="tradelog.result == 1"
                                                    class="badge bg-success"
                                                    >+
                                                    {{
                                                        (tradelog.amount *
                                                            (gnl.profit / 100))
                                                            | toMoney
                                                    }}
                                                    {{ tradelog.pair }}</span
                                                >
                                                <span
                                                    v-else-if="
                                                        tradelog.result == 2
                                                    "
                                                    class="badge bg-danger"
                                                    >-
                                                    {{
                                                        tradelog.amount
                                                            | toMoney
                                                    }}
                                                    {{ tradelog.pair }}</span
                                                >
                                                <span
                                                    v-else-if="
                                                        tradelog.result == 3
                                                    "
                                                    class="badge bg-warning"
                                                    >Draw</span
                                                >
                                                <span
                                                    v-else
                                                    class="badge bg-warning"
                                                    >Pending</span
                                                >
                                            </div>
                                        </div>
                                        <div v-else colspan="100%" :key="index">
                                            No results found!
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div
                            class="col-lg-4 col-md-6"
                            v-if="plat.kyc.kyc_status == 1"
                        >
                            <KYC :userkyc="userkyc" />
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import Refer from "../../components/Refer.vue";
import KYC from "../../components/KYC.vue";
import AddPracticeBalance from "../../components/binary/AddPracticeBalance.vue";
export default {
    props: ["user"],
    // component list
    components: {
        VueApexCharts,
        Refer,
        KYC,
        AddPracticeBalance,
    },

    // component data
    data() {
        return {
            plat: plat,
            gnl: gnl,
            funding_wallets: {},
            perc: {},
            userkyc: null,
            trade: {},
            tradelogs: {},
            practicelogs: {},
            deposit: {},
            withdraw: {},
            transaction: {},
            tradePositive: 0,
            totaltrades: 0,
            practice_Positive: 0,
            practice_totaltrades: 0,
            pathname:
                window.location.protocol + "//" + window.location.hostname,
            symbol: "USD",
            activeItem: "practice",
            trade: {
                chart: {
                    type: "donut",
                    height: 120,
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                series: [],
                legend: {
                    show: false,
                },
                comparedResult: [2, -3, 8],
                labels: ["Wins", "Draws", "Loses"],
                stroke: {
                    width: 0,
                },
                colors: [window.colors.solid.success, "#28c76f33", "#EA5455"],
                grid: {
                    padding: {
                        right: -20,
                        bottom: -8,
                        left: -20,
                    },
                },
                responsive: [
                    {
                        breakpoint: 1325,
                        options: {
                            chart: {
                                height: 100,
                            },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 120,
                            },
                        },
                    },
                    {
                        breakpoint: 1045,
                        options: {
                            chart: {
                                height: 100,
                            },
                        },
                    },
                    {
                        breakpoint: 992,
                        options: {
                            chart: {
                                height: 120,
                            },
                        },
                    },
                ],
            },
            practice: {
                chart: {
                    type: "donut",
                    height: 120,
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                series: [],
                legend: {
                    show: false,
                },
                comparedResult: [2, -3, 8],
                labels: ["Wins", "Draws", "Loses"],
                stroke: {
                    width: 0,
                },
                colors: [window.colors.solid.success, "#28c76f33", "#EA5455"],
                grid: {
                    padding: {
                        right: -20,
                        bottom: -8,
                        left: -20,
                    },
                },
                responsive: [
                    {
                        breakpoint: 1325,
                        options: {
                            chart: {
                                height: 100,
                            },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 120,
                            },
                        },
                    },
                    {
                        breakpoint: 1045,
                        options: {
                            chart: {
                                height: 100,
                            },
                        },
                    },
                    {
                        breakpoint: 992,
                        options: {
                            chart: {
                                height: 120,
                            },
                        },
                    },
                ],
            },
        };
    },
    // custom methods
    methods: {
        AddPracticeBalance() {
            this.$http
                .post("/user/binary/add/practice/balance")
                .then((response) => {
                    this.$toast[response.data.type](response.data.message);
                })
                .catch((error) => {
                    this.$toast.error(error.response.data);
                })
                .finally(() => {
                    $("#practiceAmount").modal("hide");
                    this.user.practice_balance = 10000;
                });
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
        fetchBinary() {
            this.$http.post("/user/fetch/dashboard/binary").then((response) => {
                (this.userkyc = response.data.userkyc),
                    (this.funding_wallets = response.data.funding_wallets),
                    (this.perc = response.data.perc),
                    (this.trade = response.data.trade),
                    (this.tradelogs = response.data.tradelogs),
                    (this.practicelogs = response.data.practicelogs),
                    (this.deposit = response.data.deposit),
                    (this.withdraw = response.data.withdraw),
                    (this.transaction = response.data.transaction);
                (this.trade.series = [
                    response.data.trade.Win,
                    response.data.trade.Draw,
                    response.data.trade.Lose,
                ]),
                    (this.practice.series = [
                        response.data.trade.practice_Win,
                        response.data.trade.practice_Draw,
                        response.data.trade.practice_Lose,
                    ]),
                    (this.totaltrade =
                        (response.data.trade.Win
                            ? response.data.trade.Win
                            : 0) +
                        (response.data.trade.Lose
                            ? response.data.trade.Lose
                            : 0) +
                        (response.data.trade.Draw
                            ? response.data.trade.Draw
                            : 0)),
                    (this.tradePositive =
                        this.tradePositive === "undefined"
                            ? "0"
                            : response.data.trade.Win -
                              response.data.trade.Lose),
                    (this.totaltrades =
                        this.totaltrades === "undefined"
                            ? "0"
                            : response.data.trade.Win +
                              response.data.trade.Lose +
                              response.data.trade.Draw),
                    (this.practice_totaltrades =
                        this.practice_totaltrades === "undefined"
                            ? "0"
                            : response.data.trade.practice_Win +
                              response.data.trade.practice_Lose +
                              response.data.trade.practice_Draw),
                    (this.practice_Positive =
                        this.practice_Positive === "undefined"
                            ? "0"
                            : response.data.trade.practice_Win -
                              response.data.trade.practice_Lose);
            });
        },
        isActive(menuItem) {
            return this.activeItem === menuItem;
        },
        setActive(menuItem) {
            this.activeItem = menuItem;
        },
    },

    // on component created
    created() {
        this.fetchBinary();
    },

    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
};
</script>
