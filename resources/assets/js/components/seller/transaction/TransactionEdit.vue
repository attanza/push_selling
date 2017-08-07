<template src="./transaction_edit.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import autosize from 'autosize'
import vSelect from "vue-select"
export default {
  name: "transaction_form",
  components: {
    vSelect,
  },
  data: function data() {
    return {
      code: '', seller: null, item: null, outlet: null, qty: null, description: '',
      items: [], outlets: [],
      item_error: '',
      outlet_error: '',
      id: '',
      disabled: false
    }
  },
  props: ['item_data', 'outlet_data', 'transaction_data'],
  mounted(){
    autosize(document.querySelector('textarea'));
    this.items = this.item_data;
    this.outlets = this.outlet_data;
    this.init_data();
  },
  watch: {
    item(){
      if (this.item == null) {
        this.item_error = 'Please select one Item';
      } else {
        this.item_error = '';
      }
    },
    outlet(){
      if (this.outlet == null) {
        this.outlet_error = 'Please select one Outlet';
      } else {
        this.outlet_error = '';
      }
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result && this.item != null && this.outlet != null) {
          this.submit_data();
          return;
        }
        toastr.error('Please correct the errors first')
      });
    },

    submit_data(){
      this.disabled = true
      axios.put('/api/transaction/'+this.id, this.get_data()).then((resp)=>{
        if (resp.status == 200) {
          let code = resp.data.transaction.code
          window.location.replace('/transaction/'+code);
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          this.disabled = false
        }
      });
    },
    init_data(){
      this.id = this.transaction_data.id;
      this.code = this.transaction_data.code;
      this.item = this.transaction_data.item;
      this.outlet = this.transaction_data.outlet;
      this.qty = this.transaction_data.qty;
      this.description = this.transaction_data.description;
    },
    get_data(){
      return {
        code: this.code,
        item_id: this.item.id,
        outlet_id: this.outlet.id,
        seller_id: this.auth_user.id,
        qty: this.qty,
        description: this.description,
      }
    },
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
