<template src="./outlet_form.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import vSelect from "vue-select"
export default {
  name: "outlet_create",
  components: {
    vSelect,
  },
  props: ['market_data'],
  data: () => ({
    code: '', name: '', owner: '', pic: '', phone1: '', phone2: '',
    email: '', address: '', lat: '', lng: '', market_id: '',
    markets: [], market: null, market_error: 'This Market field is required',
    button: {
      name: 'Submit',
      class: 'fa-floppy-o'
    },
  }),

  mounted(){
    this.markets = this.market_data
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

  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result && this.market != null) {
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
      axios.post('/api/outlet', this.get_data()).then((resp)=>{
        if(resp.status == 200){
          // console.log(resp);
          // window.location.replace('/outlet/'+resp.data.outlet.code)
          window.location.replace('/outlet');

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
        market_id: this.market.id,
        code: this.code,
        name: this.name,
        owner: this.owner,
        pic: this.pic,
        phone1: this.phone1,
        phone2: this.phone2,
        email: this.email,
        address: this.address,
        lat: -6.17511,
        lng:106.86503949999997
      }
    },
    get_back(){
      window.location.replace('/outlet');
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
