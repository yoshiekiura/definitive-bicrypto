/**
 * Main app entry file.
 */
window.DEBUG = false;
const cors = cors;
// app dependencies
import Toast from "vue-toastification";

import defOpts from "./configs/defaultOptions";
import Options from "./modules/options";
import Ajax from "./modules/ajax";
import Binance from "./modules/binance";
import Coincap from "./modules/coincap";
import Alarms from "./modules/alarms";
import History from "./modules/history";
import Notify from "./modules/notify";
import News from "./modules/news";
import Messenger from "./modules/messenger";
import Bus from "./modules/bus";
import Sorter from "./modules/sorter";
import Scroller from "./modules/scroller";
import Tooltip from "./modules/tooltip";
import store from "./modules/store";
import sentiment from "./modules/sentiment";
import utils from "./modules/utils";

import VueAppend from "vue-append";
import VLazyImage from "./modules/v-lazy-image/v-lazy-image";
import VueMobileDetection from "vue-mobile-detection";
import SmartTable from "vuejs-smart-table";
import VueSkeletonLoader from "skeleton-loader-vue";
import VueRouter from "vue-router";

const Dashboard = () => import("./Pages/Dashboard.vue");
const Trading = () => import("./Pages/Trading.vue");
const Swap = () => import("./Pages/Swap.vue");
const Market = () => import("./Pages/Market.vue");
const Wallets = () => import("./Pages/Wallets.vue");
const WalletDetail = () => import("./components/wallets/WalletDetail.vue");
const Network = () => import("./Pages/Network.vue");
const DepositHistory = () => import("./Pages/logs/Deposit.vue");
const WithdrawHistory = () => import("./Pages/logs/Withdraw.vue");
const TransactionsHistory = () => import("./Pages/logs/Transactions.vue");

import App from "./App.vue";
import Vue from "vue";

Vue.config.productionTip = false;

Vue.use(VueMobileDetection);
Vue.use(VueRouter);
Vue.use(VueAppend);

const routes = [
    { path: "/", component: Dashboard, meta: { title: "Dashboard" } },
    { path: "/trade", component: Dashboard, meta: { title: "Dashboard" } },
    {
        path: "/trade/:symbol/:currency",
        component: Trading,
        meta: { title: "Trading" },
    },
    { path: "/swap", component: Swap, meta: { title: "Swap Dashboard" } },
    { path: "/market", component: Market, meta: { title: "Market Analysis" } },
    {
        path: "/wallets",
        component: Wallets,
        meta: { title: "My Wallets" },
        children: [
            {
                path: ":type/:symbol/:address",
                component: WalletDetail,
                meta: { title: "Wallet Details" },
            },
        ],
    },
    { path: "/network", component: Network, meta: { title: "My Network" } },
    {
        path: "/deposit/history",
        component: DepositHistory,
        meta: { title: "Deposit History" },
    },
    {
        path: "/withdraw/history",
        component: WithdrawHistory,
        meta: { title: "Withdraw History" },
    },
    {
        path: "/transaction/history",
        component: TransactionsHistory,
        meta: { title: "Transactions History" },
    },
];
const router = new VueRouter({
    routes, // short for `routes: routes`
});
router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = to.meta.title || "Dashboard";
    });
});
Vue.use(Toast, {
    hideProgressBar: true,
    closeOnClick: false,
    closeButton: false,
    icon: true,
    timeout: 2000,
    toastClassName: ["bg-light"],
    bodyClassName: [],
    transition: "Vue-Toastification__fade",
});
Vue.use(require("vue-moment"));
Vue.use(SmartTable);
Vue.component("vue-skeleton-loader", VueSkeletonLoader);
Vue.component("v-lazy-image", VLazyImage);

window.axios = require("axios");
Vue.prototype.$http = window.axios;

// setup common helper classes
const _options = new Options(defOpts);
const _ajax = new Ajax();
const _binance = new Binance();
const _coincap = new Coincap();
const _alarms = new Alarms();
const _history = new History();
const _notify = new Notify();
const _news = new News();
const _messenger = new Messenger();
const _bus = new Bus();
const _sorter = new Sorter();
const _scroller = new Scroller();
const _tooltip = new Tooltip();

// create custom global vue properties
Object.defineProperties(Vue.prototype, {
    $opts: {
        get() {
            return _options;
        },
    },
    $ajax: {
        get() {
            return _ajax;
        },
    },
    $binance: {
        get() {
            return _binance;
        },
    },
    $coincap: {
        get() {
            return _coincap;
        },
    },
    $alarms: {
        get() {
            return _alarms;
        },
    },
    $history: {
        get() {
            return _history;
        },
    },
    $notify: {
        get() {
            return _notify;
        },
    },
    $news: {
        get() {
            return _news;
        },
    },
    $messenger: {
        get() {
            return _messenger;
        },
    },
    $scroller: {
        get() {
            return _scroller;
        },
    },
    $bus: {
        get() {
            return _bus;
        },
    },
    $sorter: {
        get() {
            return _sorter;
        },
    },
    $store: {
        get() {
            return store;
        },
    },
    $sentiment: {
        get() {
            return sentiment;
        },
    },
    $utils: {
        get() {
            return utils;
        },
    },
});

// single tooltip instance for entire app
Vue.directive("tooltip", {
    bind: (el) => {
        _tooltip.select(el);
    },
    unbind: (el) => {
        _tooltip.unselect(el);
    },
});

// global filters used to format currency and price change values
Vue.filter("toLinks", (text) => utils.linkUrl(text));
Vue.filter("toNoun", (num, s, p) => utils.noun(num, s, p));
Vue.filter("toElapsed", (time, suffix, short) =>
    utils.elapsed((Date.now() - time) / 1000, suffix, short)
);
Vue.filter("toDate", (time, full) => utils.date(time, full));
Vue.filter("toMoney", (num, decimals) => utils.money(num, decimals));
Vue.filter("toMoney2", (num, decimals) => utils.money_ccxt(num, decimals));
Vue.filter("toFixed", (num, asset) => utils.fixed(num, asset));

window.addEventListener("load", (e) => {
    if (window.top !== window) return;
    document.body.setAttribute("tabindex", "0");
    new Vue({
        el: "#app",
        router,
        render: (h) => h(App),
    });
});
