<template>
  <div id="item_buttons">
    <div class="btn-group">
      <button type="button" class="btn btn-danger btn-sm" data-toggle="collapse" data-target="#item_insert_form" aria-expanded="false" aria-controls="item_insert_form" v-if="canSee">
        <i class="fa fa-plus"></i> Add Item
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
      showModal: false,
      canSee: false
    }
  },
  mounted(){
    if (this.auth_user.roles && this.auth_user.roles[0].slug == 'admin') {
      this.canSee = true;
    }
  },
  methods: {
    export_data(){
      this.showModal = false
      window.location.replace('/export-data/item')
    }
  },
  computed: {
    auth_user(){
      return this.$store.state.user;
    }
  }
}
</script>
<style lang="scss">
</style>
