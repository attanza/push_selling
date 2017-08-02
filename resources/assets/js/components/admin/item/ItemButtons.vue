<template>
  <div id="item_buttons">
    <div class="btn-group">
      <button type="button" class="btn btn-danger btn-sm" data-toggle="collapse" data-target="#item_insert_form" aria-expanded="false" aria-controls="item_insert_form">
        <i class="fa fa-plus"></i> Add item
      </button>
      <button type="button" class="btn btn-success btn-sm" @click="showModal = true"><i class="fa fa-download"></i> Export</button>
    </div>
    <confirm-dialog v-if="showModal" @close="showModal = false" @next_process="export_data"></confirm-dialog>
  </div>
</template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";
export default {
  name: "item_buttons",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return {
      showModal: false
    }
  },
  methods: {
    export_data(){
      this.showModal = false
      window.location.replace('/export-data/item')
    }
  }
}
</script>
<style lang="scss">
</style>
