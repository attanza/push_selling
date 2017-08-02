<template>
  <div id="init_item">

  </div>
</template>
<script>
export default {
  name: "init_item",
  props: ['item'],
  mounted(){
    this.$store.commit('current_item_mutation', this.item)
  }
}
</script>
<style lang="scss">
</style>
