<template>
  <div id="stokiest_init">

  </div>
</template>
<script>
export default {
  name: "stokiest_init",
  props: ['stokiest'],
  mounted(){
    this.$store.commit('current_stokiest_mutation', this.stokiest)
  }
}
</script>
<style lang="scss">
</style>
