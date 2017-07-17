<template>
  <div id="market_form">
    add form
  </div>
</template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import vSelect from "vue-select"
import AreaFormModal from './../area/AreaFormModal.vue'
export default {
  components: {
    vSelect,
    'area-form-modal': AreaFormModal
  },
  data: function data() {
    return {
      name: '', address: '', description: '',
      areas: [], area: '',
    }
  },

  mounted(){
    this.get_area()
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
      axios.post('/api/market',{
        name: this.name, address: this.address, description: this.description, area_id: this.area.id
      }).then((resp)=>{
        if(resp.status == 200){
          this.reset_form()
          toastr.success('Market Saved')
          window.eventBus.$emit('saved-market', resp.data.market)

        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
        }
      });
    },

    reset_form(){
      this.name = ''
      this.address = ''
      this.description = ''
      $("#insert_market").modal('hide')
    },

    get_area(){
      axios.get('/api/area/for/dropdown').then((resp)=>{
        if(resp.status == 200){
          resp.data.areas.forEach((area)=>{
            this.areas.push(area)
          })
        }
      })
    },

    show_insert_form(){
      $("#insert_market").modal('hide')
      $("#insert_area").modal('show')
    },

    after_insert_area(data){
      this.areas.unshift(data)
      $("#insert_market").modal('show')
    }

  }
}
</script>
<style lang="scss">
</style>
