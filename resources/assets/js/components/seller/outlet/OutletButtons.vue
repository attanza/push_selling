<template>
  <div id="outlet_buttons">
    <div class="btn-group">
      <button type="button" class="btn btn-danger btn-sm" @click="create_outlet()" v-if="canAdd">
        <i class="fa fa-plus"></i> Add outlet
      </button>
      <button type="button" class="btn btn-success btn-sm" @click="showModal = true"><i class="fa fa-download"></i> Export</button>
    </div>
    <confirm-dialog v-if="showModal" @close="showModal = false" @next_process="export_data"></confirm-dialog>
  </div>
</template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";
export default {
  name: "outlet_buttons",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return {
      showModal: false,
      canAdd: false,
    }
  },
  mounted(){
    if (this.role == 'seller') {
      this.canAdd = true;
    }
  },
  methods: {
    export_data(){
      this.showModal = false
      window.location.replace('/export-data/outlet')
    },

    create_outlet(){
      window.location.replace('/outlet/create')
    }
  },
  computed: {
    role(){
      return this.$store.getters.auth_user_role;
    }
  }
}
</script>
<style lang="scss">
</style>
