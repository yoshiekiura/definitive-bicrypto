<template>
    <div class="blog-list-wrapper">
        <div class="row">
            <template v-if="feeds != null">
                <div
                    v-for="(item, index) in feeds"
                    :key="index"
                    class="col-md-6 col-12"
                >
                    <div class="card">
                        <div class="card-header">
                            <div class="col-md-10">
                                <h4 class="card-title">{{ item.title }}</h4>
                            </div>
                            <div class="col-md-2 text-end">
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <a data-action="collapse"
                                            ><i
                                                class="text-info bi bi-chevron-down"
                                            ></i
                                        ></a>
                                        <a data-action="reload"
                                            ><i
                                                class="text-warning bi bi-arrow-repeat"
                                            ></i
                                        ></a>
                                        <a data-action="close"
                                            ><i
                                                class="btn-icon btn-danger rounded font-medium-1 bi bi-x"
                                            ></i
                                        ></a>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="avatar me-50">
                                            <img
                                                src="images/portrait/small/avatar-s-7.jpg"
                                                alt="Avatar"
                                                width="24"
                                                height="24"
                                            />
                                        </div>
                                        <div class="author-info">
                                            <span class="text-muted ms-50 me-25"
                                                >|</span
                                            >
                                            <small class="text-muted">{{
                                                item.pubDate
                                                    | moment(
                                                        "dddd, MMMM Do YYYY"
                                                    )
                                            }}</small>
                                        </div>
                                    </div>
                                    <p
                                        class="card-text blog-content-truncate"
                                    ></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <h2>No item found</h2>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    // component list
    components: {},

    // component data
    data() {
        return {
            feeds: [],
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
            this.$http.post("/user/fetch/news").then((response) => {
                this.feeds = response.data.feeds;
            });
        },
        getDesc(content) {
            return str_replace(
                "<a",
                "<a target=_bank",
                preg_replace("/<img[^>]+\>/i", "", content)
            );
        },
        getEx(content) {
            return implode(
                " ",
                array_slice(
                    explode(
                        " ",
                        str_replace(
                            "<a",
                            "<a target=_bank",
                            preg_replace("/<img[^>]+\>/i", "", content)
                        ),
                        0,
                        20
                    )
                )
            );
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
