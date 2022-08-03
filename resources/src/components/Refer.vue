<template>
    <div>
        <div class="card">
            <div class="card-body text-center mt-3">
                <i class="bi bi-gift text-warning font-large-2 mb-1"></i>
                <h5 class="card-title">Refer & Earn</h5>
                <p class="card-text">
                    Refer your friends & Earn for 5% of every customer that
                    complete 1 deposit in the platform.
                </p>
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#referEarnModal"
                >
                    Invite
                </button>
            </div>
        </div>
        <div
            class="modal fade"
            id="referEarnModal"
            tabindex="-1"
            aria-labelledby="referEarnTitle"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg modal-refer-earn"
            >
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-0">
                        <div class="px-sm-4 mx-50">
                            <h1 class="text-center mb-1" id="referEarnTitle">
                                Refer & Earn
                            </h1>
                            <p class="text-center mb-5">
                                Invite your friend here, if thay sign up and
                                complete 1 successful deposit,
                                <br />
                                you will earn 5% of their future deposits
                            </p>

                            <div class="row mb-4">
                                <div class="col-12 col-lg-4">
                                    <div
                                        class="d-flex justify-content-center mb-1"
                                    >
                                        <div
                                            class="modal-refer-earn-step d-flex width-100 height-100 rounded-circle justify-content-center align-items-center bg-light-primary"
                                        >
                                            <i
                                                class="bi bi-chat-left display-4 text-warning"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h6 class="fw-bolder mb-1">
                                            Send Invitation 🤟🏻
                                        </h6>
                                        <p>
                                            Send your referral link to your
                                            friend
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div
                                        class="d-flex justify-content-center mb-1"
                                    >
                                        <div
                                            class="modal-refer-earn-step d-flex width-100 height-100 rounded-circle justify-content-center align-items-center bg-light-primary"
                                        >
                                            <i
                                                class="bi bi-card-checklist display-4 text-info"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h6 class="fw-bolder mb-1">
                                            Registration 👩🏻‍💻
                                        </h6>
                                        <p>
                                            Let them register to our trading
                                            platform
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div
                                        class="d-flex justify-content-center mb-1"
                                    >
                                        <div
                                            class="modal-refer-earn-step d-flex width-100 height-100 rounded-circle justify-content-center align-items-center bg-light-primary"
                                        >
                                            <i
                                                class="bi bi-award display-4 text-success"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h6 class="fw-bolder mb-1">
                                            Earn 5% 🎉
                                        </h6>
                                        <p>
                                            from each successful deposit from
                                            your friends
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="px-sm-5 mx-50">
                            <h4 class="fw-bolder mt-4 mb-1">
                                Share the referral link
                            </h4>
                            <form class="row g-1" onsubmit="return false">
                                <div class="col-lg-8">
                                    <label class="form-label" for="referralURL">
                                        You can also copy and send it or share
                                        it on your social media. 🥳
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="text"
                                            class="form-control"
                                            :value="
                                                pathname +
                                                '/register/' +
                                                user.username
                                            "
                                            id="referralURL"
                                            readonly
                                        />
                                        <a
                                            class="input-group-text btn btn-outline-primary"
                                            @click="Copy()"
                                            id="copyBoard"
                                            >Copy link</a
                                        >
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-end">
                                    <div class="social-btns">
                                        <a
                                            :href="
                                                'https://www.facebook.com/sharer/sharer.php?u=' +
                                                pathname +
                                                '/register/' +
                                                user.username
                                            "
                                            type="button"
                                            class="btn btn-icon btn-facebook me-50"
                                        >
                                            <i
                                                class="bi bi-facebook font-medium-2"
                                            ></i>
                                        </a>
                                        <a
                                            :href="
                                                'https://twitter.com/intent/tweet?url=' +
                                                pathname +
                                                '/register/' +
                                                user.username
                                            "
                                            type="button"
                                            class="btn btn-icon btn-twitter me-50"
                                        >
                                            <i
                                                class="bi bi-twitter font-medium-2"
                                            ></i>
                                        </a>
                                        <a
                                            :href="
                                                'https://www.linkedin.com/shareArticle?mini=true&url=' +
                                                pathname +
                                                '/register/' +
                                                user.username
                                            "
                                            type="button"
                                            class="btn btn-icon btn-linkedin me-50"
                                        >
                                            <i
                                                class="bi bi-linkedin font-medium-2"
                                            ></i>
                                        </a>
                                        <a
                                            :href="
                                                'https://pinterest.com/pin/create/button/?url=' +
                                                pathname +
                                                '/register/' +
                                                user.username
                                            "
                                            type="button"
                                            class="btn btn-icon btn-pinterest"
                                        >
                                            <i
                                                class="bi bi-pinterest font-medium-2"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user", "pathname"],
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
        Copy() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            this.$toast.success("Referral Url Copied");
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
