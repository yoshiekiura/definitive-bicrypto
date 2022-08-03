<template></template>

<script>
export default {
    props: [],
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
