(function (t, e) {
    typeof exports == "object" && typeof module != "undefined"
        ? (module.exports = e())
        : typeof define == "function" && define.amd
        ? define(e)
        : ((t = typeof globalThis != "undefined" ? globalThis : t || self),
          (t.VLazyImage = e()));
})(this, function () {
    "use strict";
    return {
        props: {
            src: { type: String, required: !0 },
            srcPlaceholder: {
                type: String,
                default:
                    "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",
            },
            srcset: { type: String },
            intersectionOptions: { type: Object, default: () => ({}) },
            usePicture: { type: Boolean, default: !1 },
        },
        inheritAttrs: !1,
        data: () => ({ observer: null, intersected: !1, loaded: !1 }),
        computed: {
            srcImage() {
                return this.intersected && this.src
                    ? this.src
                    : this.srcPlaceholder;
            },
            srcsetImage() {
                return this.intersected && this.srcset ? this.srcset : !1;
            },
        },
        methods: {
            load() {
                this.$el &&
                    this.$el.getAttribute("src") !== this.srcPlaceholder &&
                    ((this.loaded = !0), this.$emit("load", this.$el));
            },
            error() {
                this.$emit("error", this.$el);
            },
        },
        render(e) {
            let s = e("img", {
                attrs: { src: this.srcImage, srcset: this.srcsetImage },
                domProps: this.$attrs,
                class: {
                    "v-lazy-image": !0,
                    "v-lazy-image-loaded": this.loaded,
                },
                on: { load: this.load, error: this.error },
            });
            return this.usePicture
                ? e(
                      "picture",
                      { on: { load: this.load } },
                      this.intersected ? [this.$slots.default, s] : [s]
                  )
                : s;
        },
        mounted() {
            "IntersectionObserver" in window &&
                ((this.observer = new IntersectionObserver((e) => {
                    e[0].isIntersecting &&
                        ((this.intersected = !0),
                        this.observer.disconnect(),
                        this.$emit("intersect"));
                }, this.intersectionOptions)),
                this.observer.observe(this.$el));
        },
        destroyed() {
            "IntersectionObserver" in window && this.observer.disconnect();
        },
    };
});
