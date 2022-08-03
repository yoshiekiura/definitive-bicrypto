<template>
    <div>
        <div class="my-2 text-end">
            <router-link to="ticket/open" class="btn btn-primary btn-sm"
                >New Ticket</router-link
            >
        </div>
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Support Tickets</h4>
                        <div class="input-group w-50">
                            <span class="input-group-text" id="trx-search"
                                >Ticket ID</span
                            >
                            <input
                                class="form-control"
                                v-model="filters.ticket.value"
                            />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <v-table
                            v-if="supports != null"
                            :data="supports"
                            :filters="filters"
                            :currentPage.sync="currentPage"
                            :pageSize="10"
                            @totalPagesChanged="totalPages = $event"
                            class="table table-hover"
                        >
                            <thead slot="head">
                                <tr>
                                    <v-th sortKey="ticket" scope="col"
                                        >Subject</v-th
                                    >
                                    <v-th sortKey="status" scope="col"
                                        >Status</v-th
                                    >
                                    <v-th sortKey="last_reply" scope="col"
                                        >Last Reply</v-th
                                    >
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{ displayData }">
                                <template v-if="supports != null">
                                    <tr
                                        v-for="row in displayData"
                                        :key="row.id"
                                    >
                                        <td data-label="Subject">
                                            <router-link
                                                :to="
                                                    '/support/ticket/' +
                                                    row.ticket
                                                "
                                                class="fw-bold"
                                                >[Ticket#{{ row.ticket }}]
                                                {{ row.subject }}
                                            </router-link>
                                        </td>
                                        <td data-label="Status">
                                            <span
                                                v-if="row.status == 0"
                                                class="badge bg-success"
                                                >Open</span
                                            >
                                            <span
                                                v-else-if="row.status == 1"
                                                class="badge bg-primary"
                                                >Answered</span
                                            >
                                            <span
                                                v-else-if="row.status == 2"
                                                class="badge bg-warning"
                                                >Customer Reply</span
                                            >
                                            <span
                                                v-else-if="row.status == 3"
                                                class="badge bg-danger"
                                                >Closed</span
                                            >
                                        </td>
                                        <td data-label="Last Reply">
                                            {{ row.last_reply }}
                                        </td>

                                        <td data-label="Action">
                                            <router-link
                                                :to="
                                                    '/support/ticket/' +
                                                    row.ticket
                                                "
                                                class="btn btn-primary btn-sm"
                                            >
                                                <i class="bi bi-display"></i>
                                            </router-link>
                                        </td>
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
    props: [],
    // component list
    components: {},

    // component data
    data() {
        return {
            supports: null,
            filters: {
                ticket: { value: "", keys: ["ticket"] },
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
            this.$http.post("/user/fetch/support").then((response) => {
                this.supports = response.data.supports;
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
