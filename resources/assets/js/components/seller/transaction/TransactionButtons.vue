<template>
  <div id="transaction_buttons">
    <div class="btn-group">
      <button class="btn btn-danger btn-sm" type="button" @click="create" v-show="canAdd"><i class="fa fa-plus"></i> Add Transaction</button>
      <button type="button" class="btn btn-success btn-sm" @click="showModal = true"><i class="fa fa-download"></i> Export</button>
    </div>
    <date-range v-if="showModal" @close="showModal = false" @next_process="export_data"></date-range>
  </div>
</template>
<script>
import VueDateRange from "./../../VueDateRange";
export default {
  name: "transaction_buttons",
  components: {
    'date-range': VueDateRange
  },
  data: function data() {
    return {
      canAdd: false,
      showModal: false
    }
  },

  mounted(){
    if (this.role == 'seller') {
      this.canAdd = true;
    }
    window.eventBus.$on('post-dates', this.export_data)
  },

  methods: {
    export_data(dates){
      this.showModal = false
      console.log(dates);
      window.location.replace('/export-data/transaction/'+dates);
    },
    create(){
      window.location.replace('/transaction/create');
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
