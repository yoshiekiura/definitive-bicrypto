<template>
    <li
        class="nav-item"
        :class="[
            menu.slug === pathname ? 'active' : '',
            showSub && checkSub(menu.slug) ? 'open' : '',
            checkSub(menu.slug) ? 'has-sub' : '',
        ]"
        :key="pathname"
    >
        <template v-if="menu.slug">
            <router-link
                :to="'../../../' + menu.url"
                class="d-flex align-items-center"
                :target="menu.newTab ? '_blank' : '_self'"
            >
                <i :class="'bi bi-' + menu.icon"></i>
                <span class="menu-title text-truncate">{{ menu.name }}</span>
            </router-link>
        </template>
        <template v-else>
            <a
                href="javascript:void(0)"
                class="d-flex align-items-center"
                :target="menu.newTab ? '_blank' : '_self'"
                @click="showSub = !showSub"
            >
                <i :class="'bi bi-' + menu.icon"></i>
                <span class="menu-title text-truncate">{{ menu.name }}</span>
            </a>
        </template>
        <template v-if="menu.submenu">
            <SubMenuItem :menu="menu.submenu" :pathname="pathname" />
        </template>
    </li>
</template>

<script>
import SubMenuItem from "./SubMenuItem.vue";

// component
export default {
    name: "side-menu",
    props: ["menu"],

    // component list
    components: {
        SubMenuItem,
    },
    // component data
    data() {
        return {
            showSub: false,
            pathname: window.location.hash.substring(1),
        };
    },
    // custom methods
    methods: {
        checkSub(sub) {
            if (!sub) {
                return true;
            }
        },
    },

    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                this.pathname = window.location.hash.substring(1);
                this.showSub = false;
            },
        },
    },
    // on component created
    created() {},

    // on component destroyed
    destroyed() {},
};
</script>
