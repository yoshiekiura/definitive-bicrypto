<template>
    <div>
        <template v-if="userkyc == null">
            <div class="card">
                <div
                    class="card-body text-center d-flex justify-content-center align-items-center border-light rounded"
                >
                    <div class="status-empty">
                        <div
                            class="status-icon d-flex justify-content-center align-items-center"
                        >
                            <i class="bi bi-files"></i>
                        </div>
                        <span class="status-text-d text-dark"
                            >You have not submitted your necessary documents to
                            verify your identity. In order to trade in our
                            platform, please verify your identity.</span
                        >
                        <p class="">
                            It would great if you please submit the form. If you
                            have any question, please feel free to contact our
                            support team.
                        </p>
                        <a
                            href="user/kyc/application?state=new"
                            class="btn btn-primary"
                            >Click here to complete your KYC</a
                        >
                    </div>
                </div>
            </div>
        </template>
        <!-- <template v-else-if="userkyc !== null && $_GET['thank_you']">
            <div class="card">
                <div
                    class="card-body text-center d-flex justify-content-center align-items-center border-warning rounded"
                >
                    <div class="status-thank">
                        <div
                            class="status-icon d-flex justify-content-center align-items-center"
                        >
                            <i class="bi bi-check"></i>
                        </div>
                        <span class="status-text-d large text-dark"
                            >You have completed the process of KYC</span
                        >
                        <p class="">
                            We are still waiting for your identity verification.
                            Once our team verified your identity, you will be
                            notified by email. You can also check your KYC
                            compliance status from your profile page.
                        </p>
                    </div>
                </div>
            </div>
        </template> -->
        <template v-else-if="userkyc !== null && userkyc.status == 'pending'">
            <div class="card">
                <div
                    class="card-body text-center d-flex justify-content-center align-items-center border-info rounded d-flex align-items-center"
                >
                    <div class="status-process">
                        <div
                            class="status-icon d-flex justify-content-center align-items-center"
                        >
                            <i class="bi bi-infinity"></i>
                        </div>
                        <span class="text-dark"
                            >Your application verification under process.</span
                        >
                        <p class="">
                            We are still working on your identity verification.
                            Once our team verified your identity, you will be
                            notified by email.
                        </p>
                    </div>
                </div>
            </div>
        </template>
        <template
            v-else-if="
                userkyc.status == 'missing' || userkyc.status == 'rejected'
            "
        >
            <div class="card">
                <div
                    class="card-body text-center d-flex justify-content-center align-items-center border-warning rounded"
                >
                    <div
                        :class="
                            userkyc.status == 'missing'
                                ? 'status-warnning'
                                : 'status-canceled'
                        "
                    >
                        <div
                            class="status-icon d-flex justify-content-center align-items-center"
                        >
                            <i class="bi bi-exclamation-lg"></i>
                        </div>
                        <span class="status-text-d text-dark">
                            {{
                                userkyc.status == "missing"
                                    ? "We found some information to be missing."
                                    : "Sorry! Your application was rejected."
                            }}
                        </span>
                        <p class="">
                            In our verification process, we found information
                            that is incorrect or missing. Please resubmit the
                            form. In case of any issues with the submission
                            please contact our support team.
                        </p>
                        <a
                            :href="
                                'user/kyc/application?state=' +
                                    userkyc.status ==
                                'missing'
                                    ? 'missing'
                                    : 'resubmit'
                            "
                            class="btn btn-primary mt-0"
                            >Submit Again</a
                        >
                    </div>
                </div>
            </div>
        </template>
        <template v-else-if="userkyc.status == 'approved'"></template>
    </div>
</template>

<script>
export default {
    props: ["userkyc"],
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
