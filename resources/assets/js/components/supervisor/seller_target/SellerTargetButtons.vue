<template>
  <div id="seller_target_buttons">
    <div class="btn-group">
      <button class="btn btn-danger btn-sm" type="button" data-toggle="collapse" data-target="#seller_target_form" aria-expanded="false" aria-controls="seller_target_form"><i class="fa fa-plus"></i> Add Seller Target</button>
      <button type="button" class="btn btn-success btn-sm" @click="showModal = true"><i class="fa fa-download"></i> Export</button>
    </div>
    <confirm-dialog v-if="showModal" @close="showModal = false" @next_process="export_data"></confirm-dialog>
  </div>
</template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";
export default {
  name: "seller_target_buttons",
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
      window.location.replace('/export-data/seller-target')
    }
  }
}
</script>
<style lang="scss">
</style>
