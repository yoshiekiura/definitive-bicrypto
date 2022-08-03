<template>
  <section class="history-page">

    <div class="flex-row flex-middle flex-stretch mb-1">
      <div class="flex-1 text-clip me-1">Recent price alert activity history ({{ historyData.length }})</div>
      <button class="form-btn bg-info-hover bi bi-x-lg iconLeft" :class="{ 'disabled': !historyData.length }" @click="flushHistory"> Flush</button>
    </div>

    <div class="flex-list">
      <div v-if="!historyData.length" class="flex-item">
        <div class="flex-1 text-secondary text-faded">
          <span class="bi bi-info-circle"> There's nothing here right now.</span>
        </div>
      </div>
      <div v-for="e in historyData" :key="e.id" class="flex-item">
        <div class="me-1" :class="{ 'alert-bubble': e.isNew }">
          <TokenIcon :image="e.icon"></TokenIcon>
        </div>
        <div class="flex-1 me-1">
          <div class="text-default">{{ e.title }}</div>
          <div class="text-secondary">{{ formatInfo( e.info ) }}</div>
        </div>
        <div class="text-clip text-end">
          <button class="bi bi-x-lg" title="Delete" @click="deleteHistory( e.id )" v-tooltip></button>
          <div class="text-default">{{ e.time | toElapsed }} ago</div>
        </div>
      </div>
    </div>

  </section>
</template>

<script>
import TokenIcon from './TokenIcon.vue';

// component
export default {

  // component list
  components: { TokenIcon },

  // component props
  props: {
    historyData: { type: Array, default() { return [] }, required: true },
    modalData: { type: Object, default() { return {} } },
  },

  // custom methods
  methods: {

    // delete item from history
    deleteHistory( id ) {
      this.$history.remove( id );
    },

    // flush history list
    flushHistory() {
      this.$history.flush();
    },

    // format info string
    formatInfo( info ) {
      return String( info || '' ).replace( /[\r\n]+/g, ', ' ) + '.';
    }
  },

  // on component destroyed
  destroyed() {
    this.$history.reset();
  }
}
</script>

