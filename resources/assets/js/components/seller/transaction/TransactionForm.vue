<template src="./transaction_form.html"></template>
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
  props: ['item_data', 'outlet_data'],
  mounted(){
    this.items = this.item_data;
    this.outlets = this.outlet_data;
    autosize(document.querySelector('textarea'));
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
      axios.post('/api/transaction', this.get_data()).then((resp)=>{
        if (resp.status == 200) {
          window.location.replace('/transaction');
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
