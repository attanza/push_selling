<template src="./item_edit.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import moment from 'moment'
export default {
  name: "item_edit",
  data: function data() {
    return {
      code: '', name: '', measurement: '', price: '',
      target_by: '', target_count: '', start_date: '', end_date: '',
      old_code: '',
      button: {
				name: 'Edit detail',
				class: 'fa-floppy-o'
			},
      loading: false,
    }
  },
  mounted(){
    this.init_data()
  },

  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.submit_data()
          return;
        }
        toastr.error('Please correct the errors first')
      });
    },
    submit_data(){
      this.button = {
				name: 'Processing',
        class: 'fa-refresh fa-spin'
			},
      axios.put('/api/items/'+this.item.id, this.get_data()).then((resp)=>{
        if(resp.status == 200){
          this.reset_button()
          toastr.success('Item Updated')
          this.$store.commit('current_item_mutation', resp.data.item)
          if (resp.data.item.code != this.old_code) {
            window.location.replace('/items/'+resp.data.item.code)
          }
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
        }
        this.reset_button()

      });
    },

    init_data(){
      this.old_code = this.item.code;
      this.code = this.item.code;
      this.name = this.item.name;
      this.measurement = this.item.measurement;
      this.price = this.item.price;
      this.target_by = this.item.target_by;
      this.target_count = this.item.target_count;
      this.start_date = moment(this.item.start_date).format('YYYY-MM-DD');
      this.end_date = moment(this.item.end_date).format('YYYY-MM-DD');
    },

    get_data(){
      return {
        code: this.code, name: this.name, measurement: this.measurement, price: this.price,
        target_by: this.target_by, target_count: this.target_count, start_date: this.start_date, end_date: this.end_date,
      }
    },

    reset_button(){
      this.button = {
				name: 'Edit detail',
				class: 'fa-floppy-o'
			}
    }
  },
  computed: {
    item(){
      return this.$store.state.current_item
    }
  }
}
</script>
<style lang="scss">
</style>
