<template>
    <!-- BEGIN: Footer-->
    <footer
        class="footer footer-light"
        :class="
            configData['footerType'] === 'footer-hidden'
                ? 'd-none'
                : '' + ' ' + configData['footerType']
        "
    >
        <div class="col d-flex justify-content-between">
            <span class="float-md-start d-none d-md-inline-block mt-25"
                >COPYRIGHT &copy;
                {{ setDate() }}
                <a class="ms-25" target="_blank">{{ siteName }}</a
                >,
                <span class="d-none d-sm-inline-block"
                    >All rights Reserved</span
                >
            </span>
            <div
                class="float-md-end d-block d-md-inline-block ms-auto my-auto px-1"
            >
                {{ time }}
            </div>
            <div class="d-none d-lg-block my-auto border-start">
                <a
                    class="nav-link fs-4 mx-1"
                    style="
                        padding-top: 0 !important;
                        padding-bottom: 0 !important;
                    "
                >
                    <i
                        id="toggleFullScreen"
                        class="bi bi-aspect-ratio"
                        @click="toggleFullScreen()"
                    ></i>
                </a>
            </div>
            <dark-light />
        </div>
        <button class="btn scroll-top" style="z-index: 10000" type="button">
            <i class="bi bi-arrow-up-square-fill font-medium-5"></i>
        </button>
    </footer>
    <!-- END: Footer-->
</template>
<script>
import DarkLight from "./DarkLight.vue";
export default {
    props: ["configData"],
    components: {
        DarkLight,
    },
    setup() {},
    // component data
    data() {
        return {
            siteName: siteName,
            interval: null,
            time: null,
        };
    },
    methods: {
        setDate() {
            return new Date().getFullYear();
        },
        toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                $("#toggleFullScreen")
                    .removeClass("bi-aspect-ratio")
                    .addClass("bi-fullscreen-exit");
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                    $("#toggleFullScreen")
                        .removeClass("bi-fullscreen-exit")
                        .addClass("bi-aspect-ratio");
                }
            }
        },
    },
    // on component created
    created() {
        this.interval = setInterval(() => {
            // Concise way to format time according to system locale.
            // In my case this returns "3:48:00 am"
            this.time = Intl.DateTimeFormat(navigator.language, {
                hour: "numeric",
                minute: "numeric",
                second: "numeric",
            }).format();
        }, 1000);
    },
    beforeDestroy() {
        // prevent memory leak
        clearInterval(this.interval);
    },
};
</script>
