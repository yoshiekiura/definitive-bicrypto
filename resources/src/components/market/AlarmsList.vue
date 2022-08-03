<template>
    <section>
        <form
            v-if="pairData.symbol"
            class="flex-row flex-middle flex-stretch mb-1"
            action="#"
            @submit.prevent="saveAlarm"
        >
            <div
                class="form-input flex-1 me-1"
                style="background: rgb(255 255 255 / 6%)"
            >
                <i class="bi bi-graph-up me-1 text-dark"></i>
                <input
                    class="me-1 text-dark"
                    placeholder="0.00000000"
                    name="price"
                    v-model="curPrice"
                />
                <div class="text-dark">{{ pairData.asset }}</div>
            </div>
            <button
                type="submit"
                class="btn btn-sm btn-success bi bi-plus-lg iconLeft"
            >
                Set Alarm
            </button>
        </form>

        <div class="flex-list">
            <div class="flex-header">
                <div class="me-1">
                    <span class="bi bi-alarm text-faded"></span>
                </div>
                <div class="flex-1 me-1">Symbol</div>
                <div class="flex-1 me-1">Alarm</div>
                <div class="flex-1 me-1">Status</div>
                <div class="flex-1 me-1">Created</div>
                <div>
                    <button
                        class="bi bi-x-lg text-danger-hover"
                        title="Delete All"
                        @click="flushAlarms"
                        v-tooltip
                    ></button>
                </div>
            </div>

            <div v-if="!alarmsList.length" class="flex-item">
                <div class="flex-1 text-secondary text-faded">
                    <span class="bi bi-info-circle">&nbsp;</span>
                    <span v-if="pairData.symbol"
                        >There are no alarms for {{ pairData.symbol }}.</span
                    >
                    <span v-else>There are no alarms.</span>
                </div>
            </div>

            <div v-for="a in alarmsList" :key="a.id" class="flex-item">
                <div class="me-1">
                    <button
                        class="bi bi-alarm"
                        :class="{
                            'text-gain': a.active,
                            'text-secondary': !a.active,
                        }"
                        title="Toggle"
                        @click="toggleAlarm(a.id, a.symbol, !a.active)"
                        v-tooltip
                    ></button>
                </div>
                <div class="flex-1 me-1">
                    <router-link
                        class="text-dark"
                        :to="'/symbol/' + a.symbol"
                        >{{ a.pair }}</router-link
                    >
                </div>
                <div class="flex-1 me-1">
                    <span class="text-big" :class="['text-' + a.check]">{{
                        a.sign
                    }}</span>
                    <span class="text-dark">{{
                        a.price | toFixed(a.asset)
                    }}</span>
                    <span class="text-secondary">{{ a.asset }}</span>
                </div>
                <div class="flex-1 me-1">
                    <span
                        :class="{
                            'text-success': a.active,
                            'text-secondary': !a.active,
                        }"
                        >{{ a.active ? "Active" : "Triggered" }}</span
                    >
                </div>
                <div class="flex-1 me-1">
                    <span class="text-grey">{{ a.time | toDate }}</span>
                </div>
                <div>
                    <button
                        class="bi bi-x-lg text-dark"
                        title="Delete"
                        @click="deleteAlarm(a.id, a.symbol)"
                        v-tooltip
                    ></button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
// component
export default {
    // component props
    props: {
        alarmsData: {
            type: Array,
            default() {
                return [];
            },
            required: true,
        },
        pairData: {
            type: Object,
            default() {
                return {};
            },
        },
    },

    // comonent data
    data() {
        return {
            curPrice: "",
        };
    },

    // computed methods
    computed: {
        // filter alarms for this token
        alarmsList() {
            let list = this.alarmsData.slice();
            let symbol = this.pairData.symbol || "";

            // sort all alarms by symbol
            list = this.$utils.sort(list, "symbol", "asc");

            // sort alarms for a specific symbol by status
            if (symbol) {
                list = list.filter((a) => a.symbol === symbol);
                list = this.$utils.sort(list, "active", "desc");
            }
            // update count outside
            this.$emit("listCount", list.length);
            return list;
        },
    },

    // component methods
    methods: {
        // save a new alert for this token
        saveAlarm(e) {
            let { symbol, token, close } = this.pairData;
            let price = parseFloat(e.target.price.value) || 0;
            let saved = this.$alarms.add(this.pairData, price);
            if (!saved)
                return this.$bus.emit(
                    "showNotice",
                    "Please enter a different " + token + " alarm price.",
                    "warning"
                );
            this.$bus.emit(
                "showNotice",
                "New alarm for " +
                    symbol +
                    " set for " +
                    price.toFixed(8) +
                    " " +
                    token +
                    ".",
                "success"
            );
        },

        // toggle existing alarm for as symbol by id
        toggleAlarm(id, symbol, toggle) {
            let action = toggle ? "enabled" : "disabled";
            this.$alarms.toggle(id, toggle);
            this.$bus.emit(
                "showNotice",
                "Alarm for " + symbol + " has been " + action + ".",
                "success"
            );
        },

        // remove an alert from the list by id
        deleteAlarm(id, symbol) {
            this.$alarms.remove(id);
            this.$bus.emit(
                "showNotice",
                "Alarm for " + symbol + " has been removed.",
                "success"
            );
        },

        // flush all alarms from the list
        flushAlarms() {
            if (!confirm("Delete all alarms from the list?")) return;
            this.$alarms.flush();
            this.$bus.emit(
                "showNotice",
                "All alarms have been deleted.",
                "success"
            );
        },
    },

    // component mounted
    mounted() {
        if (this.pairData.symbol) {
            this.curPrice = Number(this.pairData.close).toFixed(8);
        }
    },
};
</script>
