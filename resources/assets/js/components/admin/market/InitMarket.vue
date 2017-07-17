<template>
  <div id="ini_market">

  </div>
</template>
<script>
export default {
  name: "ini_market",
  props: ['market'],
  mounted(){
    this.$store.commit('current_market_mutation', this.market)
  }
}
</script>
<style lang="scss">
</style>
