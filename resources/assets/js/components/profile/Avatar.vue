<template>
    <img :src="avatar" :class="image_class" :alt="image_alt">
</template>
<script>
export default {
  name: "avatar",
  props: ['image_class','image_alt'],
  computed: {
    avatar(){
      return this.$store.state.avatar
    }
  }
}
</script>
<style lang="scss">
</style>
