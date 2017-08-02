<template>
  <div id="vue_lightbox">
    <lightbox :images="images" ref="lightbox" :showLightBox="showLightBox"></lightbox>
  </div>
</template>
<script>
import Lightbox from 'vue-image-lightbox'
export default {
  name: "vue_lightbox",
  components: {
    Lightbox,
  },
  props: ['images'],
  data(){
    return {
      showLightBox: false,
    }
  },
  mounted() {
    window.eventBus.$on('showLightbox', this.showLightbox)

  },
  methods: {
    showLightbox(index){
      this.$refs.lightbox.showImage(index)
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
