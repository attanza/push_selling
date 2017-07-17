<template>
  <div id="init">

  </div>
</template>
<script>
export default {
  name: "init",
  props: ['user'],
  mounted(){
    this.$store.commit('user_mutation', this.user);
    this.$store.commit('avatar_mutation', this.user.avatar);
  }
}
</script>
<style lang="scss">
</style>
