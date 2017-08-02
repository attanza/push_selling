<template src="./market_edit.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import vSelect from "vue-select"
import AreaFormModal from './../area/AreaFormModal.vue'

export default {
  name: "market_edit",
  components: {
    vSelect,
    'area-form-modal': AreaFormModal
  },
  data: function data() {
    return {
      name: '', address: '', description: '', lat:'', lng: '',
      areas: [], area: null, area_id: '',
      button: {
				name: 'Edit detail',
				class: 'fa-floppy-o'
			},
      loading: false,
      area_error: 'The Area field is required',

    }
  },
  props: ['area_data'],
  watch: {
    area(){
      if (this.area == null) {
        this.area_error = 'The Area field is required'
      } else {
        this.area_error = ''
      }
    }
  },
  mounted(){
    this.areas = this.area_data;
    this.init_data()
    window.eventBus.$on('insert-area', this.after_insert_area)

  },

  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result && this.area != null) {
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
      axios.put('/api/market/'+this.market.id, this.get_data()).then((resp)=>{
        if(resp.status == 200){
          // this.reset_form()
          this.reset_button()
          toastr.success('Market Updated')
          this.$store.commit('current_market_mutation', resp.data.market)
          // this.init_data()
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
      this.name = this.market.name
      this.area = {
        id: this.market.area.id,
        name: this.market.area.name
      }
      this.area_id = this.market.area_id
      this.address = this.market.address
      this.description = this.market.description
      this.lat = this.market.lat
      this.lng = this.market.lng
    },

    get_data(){
      return {
        name: this.name,
        area_id: this.area.id,
        address: this.address,
        description: this.description,
        lat: this.lat,
        lng: this.lng,
      }
    },

    show_insert_form(){
      $("#insert_area").modal('show')
    },

    after_insert_area(data){
      this.areas.unshift(data)
    },

    reset_button(){
      this.button = {
				name: 'Edit detail',
				class: 'fa-floppy-o'
			}
    }
  },
  computed: {
    market(){
      return this.$store.state.current_market
    }
  }
}
</script>
<style lang="scss">
</style>
