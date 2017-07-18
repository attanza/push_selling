<template>
  <div id="stokiest_buttons">
    <div class="btn-group">
      <button type="button" class="btn btn-danger btn-sm" @click="create_stokiest()">
        <i class="fa fa-plus"></i> Add Stokiest
      </button>
      <button type="button" class="btn btn-success btn-sm" @click="showModal = true"><i class="fa fa-download"></i> Export</button>
    </div>
    <confirm-dialog v-if="showModal" @close="showModal = false" @next_process="export_data"></confirm-dialog>
  </div>
</template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";
export default {
  name: "stokiest_buttons",
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
      window.location.replace('/export-data/stokiest')
    },

    create_stokiest(){
      console.log('add');
      window.location.replace('/stokiest/create')
    }
  }
}
</script>
<style lang="scss">
</style>
