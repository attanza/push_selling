<template>
  <div id="init_transaction">

  </div>
</template>
<script>
export default {
  name: "init_transaction",
  props: ['transaction'],
  mounted(){
    this.$store.commit('current_transaction_mutation', this.transaction)
  }
}
</script>
<style lang="scss">
</style>
