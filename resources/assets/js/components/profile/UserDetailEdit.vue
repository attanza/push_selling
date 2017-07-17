<template src="./user_detail_edit.html"></template>
<script>
import VeeValidate from 'vee-validate';
import moment from 'moment'
Vue.use(VeeValidate);

export default {
  name: "user_create",

  data: function data() {
    return {
      name: '',email:'',username:'',ktp:'',gender:'',role:'', dob: '', is_active: '',
      yyyy:'',mm:'',dd:'',phone1:'',phone2:'',address:'',salery:'',
      email_error_message:'',username_error_message: '',
      button: {
				name: 'Save',
				class: 'fa-floppy-o'
			},
      checkAdmin: false,
    }
  },

  props: ['user', 'roles'],

  mounted(){
    this.init_data()
    if(this.auth_user.roles[0].slug == 'admin'){
      this.checkAdmin = true
    }
  },

  methods: {
    init_data(){
      // name: '',email:'',username:'',ktp:'',gender:'',role:'',
      // yyyy:'',mm:'',dd:'',phone1:'',phone2:'',address:'',salery:'',
      this.name = this.user.name
      this.email = this.user.email
      this.username = this.user.username
      this.ktp = this.user.detail.ktp
      this.gender = this.user.detail.gender
      this.dob = this.user.detail.dob
      this.yyyy = moment(this.dob).format('YYYY')
      this.mm = moment(this.dob).format('MM')
      this.dd = moment(this.dob).format('DD')
      this.role = this.user.roles[0].id
      this.phone1 = this.user.detail.phone1
      this.phone2 = this.user.detail.phone2
      this.address = this.user.detail.address
      this.is_active = this.user.is_active
    },

    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result && this.email_error_message == '' && this.username_error_message == '') {
          this.submit_data();
          return;
        }
        toastr.error('Please correct the errors first')
      });
    },

    submit_data(){
      this.button = {
				name: 'Processing...',
				class: 'fa-refresh fa-spin'
			}

      let dob_data = '';
      if(this.dd != '' && this.mm != '' && this.yyyy != ''){
        dob_data = this.yyyy+'-'+this.mm+'-'+this.dd
      }
      axios.put('/api/profile/'+this.user.id,{
        name: this.name, username: this.username, email: this.email, ktp: this.ktp, gender: this.gender,
        dob: dob_data, phone1: this.phone1, phone2: this.phone2, address: this.address, role: this.role,
        is_active: this.is_active
      }).then((resp)=>{
        if(resp.status == 200){
          this.reset_button()
          window.location.reload()
        }

      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          this.reset_button()
        }
      });
    },

    reset_button(){
      this.button = {
        name: 'Submit',
        class: 'fa-floppy-o'
      }
    },
  },

  computed: {
  	years () {
  		var year = new Date().getFullYear()
  		var years = [];
  		var i;
  		for(i = (year - 15); i > (year - 80 ); i--){
  			years.push(i);
  		}

  		return years;
  	},

    months(){
      let i;
      let months = [];
      for(i=1; i<13; i++){
        if(i < 10){
          months.push('0'+i);
        } else {
          months.push(i);
        }
      }
      return months;
    },

    dates(){
      let i;
      let dates = [];
      for(i=1; i<32; i++){
        if(i < 10){
          dates.push('0'+i);
        } else {
          dates.push(i);
        }
      }
      return dates;
    },

    auth_user(){
      return this.$store.state.user
    }
  }
}
</script>
<style lang="scss">
</style>
