<template>
  <div id="outlet_init">

  </div>
</template>
<script>
export default {
  name: "outlet_init",
  props: ['outlet'],
  mounted(){
    this.$store.commit('current_outlet_mutation', this.outlet)
  }
}
</script>
<style lang="scss">
</style>
