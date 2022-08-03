<template>
  <section>

    <!-- notifications and audio options -->
    <div class="mb-1">
      <div class="form-label mb-1">
        Browser Notifications <i class="bi bi-chevron-down"></i>
      </div>
      <div class="mb-1">
        <Toggle :text="'Grant permission for browser notifications'" v-model="canNotify" @click="askNotifyPermission"></Toggle>
        <Toggle :text="'Enable browser notifications for all events'" v-model="options.notify.enabled" @change="saveOptions()"></Toggle>
        <Toggle :text="'Play a notification sound effect'" v-model="options.audio.enabled" @change="saveOptions()"></Toggle>
      </div>
      <div class="flex-row flex-middle flex-stretch">
        <div class="flex-1 form-input me-1">
          <SelectMenu class="flex-1 me-1" :options="audioFiles" v-model="options.audio.file" @change="saveOptions( true )"></SelectMenu>
          <button class="text-bright bi bi-play-circle" @click="playSound()"></button>
        </div>
        <div class="flex-1 form-input me-1">
          <span class="text-grey me-1">Volume</span>
          <input type="range" min="0.1" max="1.0" step="0.1" v-model="options.audio.volume" @change="saveOptions( true )" />
          <span class="ms-1">{{ options.audio.volume }}</span>
        </div>
        <div class="flex-1 form-input">
          <span class="text-grey me-1">Visible</span>
          <input type="range" min="5" max="30" step="1" v-model="options.notify.duration" @change="saveOptions()" />
          <span class="ms-1">{{ options.notify.duration }}s</span>
        </div>
      </div>
    </div>

    <hr />

    <!-- search options -->
    <div class="mb-1">
      <div class="form-label mb-1">
        Search Options (Affects sentiment analysis) <i class="bi bi-chevron-down"></i>
      </div>
      <Toggle :text="'Must type full search words to see results'" v-model="options.search.fullword" @change="saveOptions()"></Toggle>
      <Toggle :text="'Must type upper/lower case word letters'" v-model="options.search.fullcase" @change="saveOptions()"></Toggle>
    </div>

  </section>
</template>

<script>
// sub components
import Toggle from './Toggle.vue';
import SelectMenu from './SelectMenu.vue';

export default {

  // component list
  components: { Toggle, SelectMenu },

  // component props
  props: {
    options: { type: Object, required: true },
  },

  // component data
  data() {
    return {
      canNotify: false,
      urlSuccess: true,
      testing: false,
      // notification choices
      audioFiles: [
        { text: 'Audio 1', value: '../../../../market/audio/audio_1.mp3' },
        { text: 'Audio 2', value: '../../../../market/audio/audio_2.mp3' },
        { text: 'Audio 3', value: '../../../../market/audio/audio_3.mp3' },
        { text: 'Audio 4', value: '../../../../market/audio/audio_4.mp3' },
        { text: 'Audio 5', value: '../../../../market/audio/audio_5.mp3' },
      ]
    }
  },

  // computed methods
  computed: {

  },

  // custom methods
  methods: {

    // play selected notification sound
    playSound() {
      let { file, volume } = this.options.audio;
      this.$utils.playAudio( file, volume );
    },

    // apply options
    saveOptions( audio ) {
      let options = Object.assign( {}, this.options, { proxy: this.corsProxy } );
      if ( audio === true ) this.playSound();
      this.$opts.saveOptions( options );
    },

    // ask user for notification permission
    askNotifyPermission( e ) {
      e.preventDefault();
      this.canNotify = false;
      this.$notify.permission( status => {
        this.canNotify = ( status === 'granted' ) ? true : false;
      });
    },
  },

  // on component mounted
  mounted() {
    this.canNotify = this.$notify.canNotify();
  },
}
</script>
