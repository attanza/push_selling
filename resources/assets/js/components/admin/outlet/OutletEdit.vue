<template src="./outlet_form.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import vSelect from "vue-select"

export default {
  name: "outlet_edit",
  components: {
    vSelect,
  },
  props: ['market_data'],
  data: function data() {
    return {
      code: '', name: '', pic: '', owner: '', phone1: '', phone2: '',
      email: '', address: '', lat: '', lng: '',
      markets: [], market: null, market_error: 'This Market field is required',
      old_code: '',
      button: {
				name: 'Save',
				class: 'fa-floppy-o'
			},
    }
  },

  watch: {
    market(){
      if (this.market != null) {
        this.market_error = ''
      } else {
        this.market_error = 'This Market field is required';

      }
    }
  },

  mounted(){
    this.markets = this.market_data
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
      axios.put('/api/outlet/'+this.outlet.id,this.get_data()).then((resp)=>{
        if(resp.status == 200){
          // console.log(resp);
          this.reset_button()
          toastr.success('Outlet Updated')
          this.$store.commit('current_outlet_mutation', resp.data.outlet)
          if(this.old_code != this.outlet.code){
            window.location.replace('/outlet/'+this.outlet.code)
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
      this.old_code = this.outlet.code
      this.code = this.outlet.code
      this.name = this.outlet.name
      this.owner = this.outlet.owner
      this.pic = this.outlet.pic
      this.phone1 = this.outlet.phone1
      this.phone2 = this.outlet.phone2
      this.address = this.outlet.address
      this.email = this.outlet.email
      this.lat = this.outlet.lat
      this.lng = this.outlet.lng
      this.market = this.outlet.market
    },

    get_data(){
      return {
        market_id: this.market.id,
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

    get_back(){
      window.location.replace('/outlet');
    },

    reset_button(){
      this.button = {
				name: 'Save',
				class: 'fa-floppy-o'
			}
    }
  },
  computed: {
    outlet(){
      return this.$store.state.current_outlet
    }
  }
}
</script>
<style lang="scss">
</style>
