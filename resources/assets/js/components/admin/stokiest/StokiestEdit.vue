<template src="./stokiest_form.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import vSelect from "vue-select"
import AreaFormModal from './../area/AreaFormModal.vue'

export default {
  name: "stokiest_edit",
  components: {
    vSelect,
    'area-form-modal': AreaFormModal
  },
  props: ['area_data'],
  data: function data() {
    return {
      code: '', name: '', pic: '', owner: '', phone1: '', phone2: '',
      email: '', address: '', lat: '', lng: '',
      areas: [], area_id: '',
      old_code: '',
      button: {
				name: 'Save',
				class: 'fa-floppy-o'
			},
    }
  },
  mounted(){
    this.areas = this.area_data
    this.init_data()
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
      axios.put('/api/stokiest/'+this.stokiest.id,this.get_data()).then((resp)=>{
        // console.log(resp);
        if(resp.status == 200){
          this.reset_button()
          toastr.success('Stokiest Updated')
          this.$store.commit('current_stokiest_mutation', resp.data.stokiest)
          if(this.old_code != this.stokiest.code){
            window.location.replace('/stokiest/'+this.stokiest.code)
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
      let area_data = {
        id: '',
        name: ''
      }
      this.old_code = this.stokiest.code
      this.code = this.stokiest.code
      this.name = this.stokiest.name
      this.owner = this.stokiest.owner
      this.pic = this.stokiest.pic
      this.phone1 = this.stokiest.phone1
      this.phone2 = this.stokiest.phone2
      this.address = this.stokiest.address
      this.email = this.stokiest.email
      this.lat = this.stokiest.lat
      this.lng = this.stokiest.lng
      this.area_id = this.stokiest.area_id
    },

    get_data(){
      return {
        area_id: this.area_id,
        code: this.code,
        name: this.name,
        owner: this.owner,
        pic: this.pic,
        phone1: this.phone1,
        area: this.area,
        phone2: this.phone2,
        email: this.email,
        address: this.address,
        lat: this.lat,
        lng: this.lng
      }
    },

    show_insert_area_form(){
      $("#insert_area").modal('show')
    },

    after_insert_area(data){
      this.areas.unshift(data)
    },

    reset_button(){
      this.button = {
				name: 'Save',
				class: 'fa-floppy-o'
			}
    }
  },
  computed: {
    stokiest(){
      return this.$store.state.current_stokiest
    }
  }
}
</script>
<style lang="scss">
</style>
