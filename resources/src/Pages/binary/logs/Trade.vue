<template>
    <div>
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Binary Trade Contracts Log</h4>
                        <div class="input-group w-50">
                            <span class="input-group-text" id="symbol-search"
                                >Symbol</span
                            >
                            <input
                                class="form-control"
                                v-model="filters.symbol.value"
                            />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <v-table
                            :data="contracts"
                            :filters="filters"
                            :hideSortIcons="true"
                            :currentPage.sync="currentPage"
                            :pageSize="10"
                            @totalPagesChanged="totalPages = $event"
                            class="table table-hover"
                        >
                            <thead slot="head">
                                <tr>
                                    <v-th sortKey="symbol" scope="col"
                                        >Symbol</v-th
                                    >
                                    <v-th sortKey="amount" scope="col"
                                        >Amount</v-th
                                    >
                                    <v-th sortKey="margin" scope="col"
                                        >Profit</v-th
                                    >
                                    <v-th sortKey="hilow" scope="col"
                                        >Rise/Fall</v-th
                                    >
                                    <v-th sortKey="result" scope="col"
                                        >Result</v-th
                                    >
                                    <v-th sortKey="status" scope="col"
                                        >Status</v-th
                                    >
                                    <v-th sortKey="created_at" scope="col"
                                        >Date</v-th
                                    >
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{ displayData }">
                                <template v-if="contracts != null">
                                    <tr
                                        v-for="row in displayData"
                                        :key="row.id"
                                    >
                                        <td data-label="Symbol">
                                            {{ row.symbol }}/{{ row.pair }}
                                        </td>
                                        <td data-label="Amount">
                                            {{ row.amount | toMoney }}
                                            {{ row.pair }}
                                        </td>
                                        <td data-label="Profit">
                                            <span
                                                v-if="row.result == 1"
                                                class="badge bg-success"
                                                >{{ row.margin | toMoney }}
                                                {{ row.pair }}</span
                                            >
                                            <span
                                                v-else-if="row.result == 2"
                                                class="badge bg-danger"
                                                >-
                                                {{ row.amount | toMoney }}
                                                {{ row.pair }}</span
                                            >
                                            <span
                                                v-else-if="row.result == 3"
                                                class="badge bg-warning"
                                                >0</span
                                            >
                                            <span
                                                v-else
                                                class="badge bg-warning"
                                                >Pending</span
                                            >
                                        </td>
                                        <td data-label="High/Low">
                                            <span
                                                v-if="row.hilow == 1"
                                                class="badge bg-success"
                                                >Rise</span
                                            >
                                            <span
                                                v-else-if="row.hilow == 2"
                                                class="badge bg-danger"
                                                >Fall</span
                                            >
                                        </td>
                                        <td data-label="Result">
                                            <span
                                                v-if="row.result == 1"
                                                class="badge bg-success"
                                                >Win</span
                                            >
                                            <span
                                                v-else-if="row.result == 2"
                                                class="badge bg-danger"
                                                >Lose</span
                                            >
                                            <span
                                                v-else-if="row.result == 3"
                                                class="badge bg-warning"
                                                >Draw</span
                                            >
                                            <span
                                                v-else
                                                class="badge bg-warning"
                                                >Pending</span
                                            >
                                        </td>
                                        <td data-label="Status">
                                            <span
                                                v-if="row.status == 0"
                                                class="badge bg-primary"
                                                >Running</span
                                            >
                                            <span
                                                v-else-if="row.status == 1"
                                                class="badge bg-success"
                                                >Complete</span
                                            >
                                        </td>
                                        <td data-label="Date">
                                            {{
                                                row.created_at
                                                    | moment(
                                                        "dddd, MMMM Do YYYY"
                                                    )
                                            }}
                                        </td>
                                        <template v-if="row.result != null">
                                            <td v-if="datas[user.id][row.id]">
                                                <router-link
                                                    :to="
                                                        '/binary/contract/view/trade/' +
                                                        row.id
                                                    "
                                                    class="btn btn-icon btn-sm btn-outline-info"
                                                    ><i
                                                        class="bi bi-info-lg"
                                                    ></i
                                                ></router-link>
                                            </td>
                                            <td v-else>
                                                <span
                                                    class="badge bg-danger"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="Contract chart data was lost because you closed the trade page before it complete"
                                                    >Not Data Recorded</span
                                                >
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                        <td colspan="100%">
                                            No results found!
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </v-table>
                    </div>
                    <div class="card-footer ms-auto pb-0">
                        <smart-pagination
                            :currentPage.sync="currentPage"
                            :totalPages="totalPages"
                        />
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
            contracts: [],
            datas: [],
            filters: {
                symbol: { value: "", keys: ["symbol"] },
            },
            currentPage: 1,
            totalPages: 0,
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
                .post("/user/fetch/binary/trade/contracts")
                .then((response) => {
                    (this.contracts = response.data.contracts),
                        (this.datas = response.data.datas);
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
};
</script>
