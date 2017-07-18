<template src="./stokiest_form.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import vSelect from "vue-select"
import AreaFormModal from './../area/AreaFormModal'
export default {
  name: "stokiest_create",
  components: {
    vSelect,
    'area-form-modal': AreaFormModal
  },
  props: ['area_data'],
  data: () => ({
    code: '', name: '', owner: '', pic: '', phone1: '', phone2: '',
    email: '', address: '', lat: '', lng: '',
    areas: [], area: [],
    button: {
      name: 'Submit',
      class: 'fa-floppy-o'
    },
  }),

  mounted(){
    this.areas = this.area_data
    window.eventBus.$on('insert-area', this.after_insert_area)

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
      axios.post('/api/stokiest', this.get_data()).then((resp)=>{
        if(resp.status == 200){
          window.location.replace('/stokiest/'+resp.data.stokiest.code)
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
        }
      });
    },

    get_data(){
      return {
        code: this.code,
        name: this.name,
        owner: this.owner,
        pic: this.pic,
        phone1: this.phone1,
        area: this.area,
        phone2: this.phone2,
        email: this.email,
        address: this.address,
        lat: -6.17511,
        lng:106.86503949999997
      }
    },

    reset_form(){
      this.name = ''
      this.address = ''
      this.button = {
				name: 'Save',
				class: 'fa-floppy-o'
			},
      $("#market_insert_form").collapse('hide')
    },

    show_insert_area_form(){
      $("#insert_area").modal('show')
    },

    after_insert_area(data){
      this.areas.unshift(data)
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
