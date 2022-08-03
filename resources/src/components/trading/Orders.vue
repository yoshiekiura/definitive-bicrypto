<template>
    <div>
        <ul class="nav nav-tabs" id="orders-tab" role="tablist">
            <li class="nav-item">
                <a
                    class="nav-link"
                    @click.prevent="setActive('open-orders')"
                    :class="{ active: isActive('open-orders') }"
                    href="#open-orders"
                    >Open Orders</a
                >
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    @click.prevent="setActive('closed-orders')"
                    :class="{ active: isActive('closed-orders') }"
                    href="#closed-orders"
                    >Order History</a
                >
            </li>
        </ul>

        <div class="tab-content" id="orders-tabContent">
            <div
                class="tab-pane fade"
                :class="{ 'active show': isActive('open-orders') }"
                id="open-orders"
                role="tabpanel"
            >
                <div class="table-responsive">
                    <table class="table text-dark table-sm table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">TxHash</th>
                                <th scope="col">Date</th>
                                <th scope="col">Pair</th>
                                <th scope="col">Side</th>
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Filled</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody
                            v-if="orders.open != null && orders.open.length > 0"
                            :key="orders.open.order_id"
                        >
                            <tr
                                v-for="(order, index) in orders.open"
                                :key="index"
                            >
                                <td data-label="TxHash" class="text-uppercase">
                                    {{ order.order_id }}
                                </td>
                                <td data-label="Date" class="text-uppercase">
                                    {{
                                        order.created_at
                                            | moment("dddd, MMMM Do YYYY")
                                    }}
                                </td>
                                <td data-label="Pair" class="text-uppercase">
                                    {{ order.symbol }}
                                </td>
                                <td data-label="Side" class="text-uppercase">
                                    <span
                                        v-if="order.side == 'buy'"
                                        class="fw-bold text-success"
                                        >Buy</span
                                    >
                                    <span v-else class="fw-bold text-danger"
                                        >Sell</span
                                    >
                                </td>
                                <td data-label="Price">
                                    {{ order.price | toMoney2(4) }}
                                    {{ order.pair }}
                                </td>
                                <td data-label="Amount">
                                    {{ order.amount | toMoney2(4) }}
                                    {{ symbol }}
                                </td>
                                <td data-label="Filled">
                                    {{ order.filled | toMoney2(4) }}
                                    {{ symbol }}
                                </td>
                                <td data-label="Status">
                                    <span
                                        v-if="order.status == 'open'"
                                        class="badge bg-primary"
                                        >Live</span
                                    >
                                    <span
                                        v-else-if="order.status == 'filling'"
                                        class="badge bg-warning"
                                        >Filling</span
                                    >
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
        <div
            class="tab-pane fade"
            :class="{ 'active show': isActive('closed-orders') }"
            id="closed-orders"
            role="tabpanel"
        >
            <div class="table-responsive">
                <table class="table text-dark table-sm table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">TxHash</th>
                            <th scope="col">Date</th>
                            <th scope="col">Pair</th>
                            <th scope="col">Side</th>
                            <th scope="col">Price</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Filled</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody
                        v-if="orders.closed != null && orders.closed.length > 0"
                        :key="orders.closed.order_id"
                    >
                        <tr
                            v-for="(order, index) in orders.closed"
                            :key="index"
                        >
                            <td data-label="TxHash" class="text-uppercase">
                                {{ order.order_id }}
                            </td>
                            <td data-label="Date" class="text-uppercase">
                                {{
                                    order.created_at
                                        | moment("dddd, MMMM Do YYYY")
                                }}
                            </td>
                            <td data-label="Pair" class="text-uppercase">
                                {{ order.symbol }}
                            </td>
                            <td data-label="Side" class="text-uppercase">
                                <span
                                    v-if="order.side == 'buy'"
                                    class="fw-bold text-success"
                                    >Buy</span
                                >
                                <span v-else class="fw-bold text-danger"
                                    >Sell</span
                                >
                            </td>
                            <td data-label="Price">
                                {{ order.price | toMoney2(4) }} {{ order.pair }}
                            </td>
                            <td data-label="Amount">
                                {{ order.amount | toMoney2(4) }} {{ symbol }}
                            </td>
                            <td data-label="Filled">
                                {{ order.filled | toMoney2(4) }} {{ symbol }}
                            </td>
                            <td data-label="Status">
                                <span
                                    v-if="order.status == 'closed'"
                                    class="badge bg-success"
                                    >Filled</span
                                >
                                <span
                                    v-else-if="order.status == 'open'"
                                    class="badge bg-primary"
                                    >Live</span
                                >
                                <span v-else class="badge bg-danger"
                                    >Canceled</span
                                >
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td class="text-muted text-center" colspan="100%">
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
</template>

<script>
export default {
    props: ["symbol", "currency"],

    // component list
    components: {},

    // component data
    data() {
        return {
            activeItem: "open-orders",
            orders: [],
        };
    },

    // custom methods
    methods: {
        fetchOrders() {
            this.$http
                .post(
                    "/user/fetch/trade/orders/" +
                        this.symbol +
                        "/" +
                        this.currency
                )
                .then((response) => {
                    this.orders = response.data.orders;
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
        this.fetchOrders();
    },

    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
};
</script>
