<template src="./seller_form.html"></template>
<script>
import VeeValidate from 'vee-validate';
import moment from 'moment'
Vue.use(VeeValidate);
import vSelect from "vue-select"
import autosize from 'autosize'

export default {
  name: "seller_target_form",
  components: {
    vSelect,
  },
  data: function data() {
    return {
      id: '', seller: null, item: null, name: '', target_count: '', start_date: '', end_date: '',
      sellers: [], items: [], creator_id: '', description: '',
      disabled: false,
      item_error: 'This Item Field is required',
      seller_error: 'This Seller Field is required',

    }
  },
  props: ['item_data', 'seller_data'],
  mounted(){
    this.sellers = this.seller_data;
    this.items = this.item_data;
    this.creator_id = this.auth_user.id;
    autosize(document.querySelector('textarea'));
    window.eventBus.$on('edit-seller-target', this.edit_seller_target)
  },
  watch: {
    item(){
      if (this.item == null) {
        this.item_error = 'This Item Field is required';
      } else {
        this.item_error = '';
      }
    },
    seller(){
      if (this.seller == null) {
        this.seller_error = 'This Seller Field is required';
      } else {
        this.seller_error = '';
      }
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result && this.item != null && this.seller != null) {
          this.submit_data();
          return;
        }
        toastr.error('Please correct the errors first')
      });
    },

    submit_data(){
      this.disabled = true
      if(this.id != ''){
        this.update_seller_target()
        return
      }
      axios.post('/api/seller-target', this.get_data()).then((resp)=>{
        window.eventBus.$emit('update_seller_target')
        toastr.success('Seller Target Saved')
        this.handleCancel()
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
        id: this.id,
        creator_id: this.creator_id,
        name: this.name,
        user_id: this.seller.id,
        item_id: this.item.id,
        target_count: this.target_count,
        start_date: this.start_date,
        end_date: this.end_date,
        description: this.description,
      }
    },
    edit_seller_target(seller_target){
      this.id = seller_target.id;
      this.creator_id = seller_target.creator_id;
      this.name = seller_target.name;
      this.item = seller_target.item;
      this.seller = seller_target.seller;
      this.target_count = seller_target.target_count;
      this.description = seller_target.description;
      this.start_date = moment(seller_target.start_date).format('YYYY-MM-DD');
      this.end_date = moment(seller_target.end_date).format('YYYY-MM-DD');
      autosize.destroy(document.querySelectorAll('textarea'));
      $("#seller_target_form").collapse('show')
    },

    update_seller_target(){
      this.disabled = true
      axios.put('api/seller-target/'+this.id, this.get_data()).then((resp)=>{
        toastr.success('Seller Target Updated')
        window.eventBus.$emit('update_seller_target', resp.data.seller_target)
        this.handleCancel()
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          this.disabled = false
        }
      });
    },

    handleCancel(){
      this.id = '';
      this.seller = null;
      this.item = null;
      this.name = '';
      this.target_count = '';
      this.start_date = '';
      this.end_date = '';
      this.description = '';
      this.disabled = false;
      autosize.destroy(document.querySelectorAll('textarea'));
      $("#seller_target_form").collapse('hide');
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
