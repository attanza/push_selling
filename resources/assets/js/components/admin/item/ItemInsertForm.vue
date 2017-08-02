<template src="./item_form.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
export default {
  data: function data() {
    return {
      code: '', name: '', measurement: '', price: '',
      target_by: '', target_count: '', start_date: '', end_date: '',
      button: {
				name: 'Save',
				class: 'fa-floppy-o'
			},
    }
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
      axios.post('/api/items', this.get_data()).then((resp)=>{
        if(resp.status == 200){
          console.log(resp);
          this.reset_form()
          toastr.success('Item Saved')
          window.eventBus.$emit('saved-item', resp.data.item)
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          this.button = {
            name: 'Save',
            class: 'fa-floppy-o'
          };
        }
      });
    },

    get_data(){
      return {
        code: this.code, name: this.name, measurement: this.measurement, price: this.price,
        target_by: this.target_by, target_count: this.target_count, start_date: this.start_date, end_date: this.end_date,
      }
    },

    reset_form(){
      this.code = ''
      this.name = ''
      this.measurement = ''
      this.price = ''
      this.target_by = ''
      this.target_count = ''
      this.start_date = ''
      this.end_date = ''
      this.button = {
				name: 'Save',
				class: 'fa-floppy-o'
			},
      $("#item_insert_form").collapse('hide')
    },

  }
}
</script>
<style lang="scss" scoped>
</style>
