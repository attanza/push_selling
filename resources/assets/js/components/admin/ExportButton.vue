<template>
    <button type="button" class="btn btn-success btn-sm" @click="export_data()"><i class="fa fa-download"></i> Export</button>
</template>
<script>
export default {
  name: "export_button",
  props: ['export_type'],
  data: function data() {
    return {

    }
  },

  methods: {
    export_data(){
      window.eventBus.$emit('show-confirm-dialog', 1)
    }
  }
}
</script>
<style lang="scss">
</style>
