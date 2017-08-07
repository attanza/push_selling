<template src="./SellerCreate.html"></template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

export default {
  name: "seller_create",

  data: function data() {
    return {
      name: '',email:'',username:'',ktp:'',gender:'',
      yyyy:'',mm:'',dd:'',phone1:'',phone2:'',address:'',salery:'',
      email_error_message:'',username_error_message: '',
      role: 1,
      button: {
				name: 'Submit',
				class: 'fa-floppy-o'
			},
    }
  },

  props: ['roles'],

  watch: {
    name(){
        this.username = this.slugify(this.name)+'-'+$.now()
    },

    email(){
      if(this.email.length > 2){
        this.email_error_message = ''
      }
    },

    // username(){
    //   if(this.username.length > 2){
    //     this.username = ''
    //   }
    // }
  },

  methods: {
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


      axios.post('/api/user', this.get_data()).then((resp)=>{
        if(resp.status == 200){
          this.reset_button()
          window.location.replace('/seller')
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

    get_data(){
      let dob_data = '';
      if(this.dd != '' && this.mm != '' && this.yyyy != ''){
        dob_data = this.yyyy+'-'+this.mm+'-'+this.dd
      }
      return {
        name: this.name, username: this.username, email: this.email, ktp: this.ktp, gender: this.gender,
        dob: dob_data, phone1: this.phone1, phone2: this.phone2, address: this.address, role: this.role
      }
    },

    check_email(){
      if(this.email != ''){
        axios.get('/api/user/check-mail/'+this.email).then((resp)=>{
          if(resp.data == 1){
            this.email_error_message = 'This email has taken'
          }
        })
      }
    },

    check_username(){
      if(this.username != ''){
        axios.get('/api/user/check-username/'+this.username).then((resp)=>{
          if(resp.data == 1){
            this.username_error_message = 'This username has taken'
          }
        })
      }
    },

    reset_button(){
      this.button = {
        name: 'Submit',
        class: 'fa-floppy-o'
      }
    },

    slugify(text)
    {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    }
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
    }
  }
}
</script>
<style lang="scss">
</style>
