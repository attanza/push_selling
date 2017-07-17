<template>
  <div class="collapse" id="change_password">
    <form @submit.prevent="validateBeforeSubmit">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-danger">
          <div class="box-body">
            <div class="form-group" :class="{'has-error': errors.has('old_password'), 'has-feedback': errors.has('old_password') }">
              <label for="old_password" class="col-md-4">Old Password</label>
              <div class="col-md-8">
                <input name="old_password" v-model="old_password" v-validate:old_password="'required|min:6'"
                data-vv-as="Old Password" type="password" class="form-control" placeholder="Old Password">
                <span v-show="errors.has('old_password')" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
                <span class="help-block">{{ errors.first('old_password') }}</span>
              </div>
            </div>

            <div class="form-group" :class="{'has-error': errors.has('password'), 'has-feedback': errors.has('password') }">
              <label for="password" class="col-md-4">Password</label>
              <div class="col-md-8">
                <input name="password" v-model="password" v-validate:password="'required|min:6'"
                data-vv-as="Password" type="password" class="form-control" placeholder="Password">
                <span v-show="errors.has('password')" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
                <span class="help-block">{{ errors.first('password') }}</span>
              </div>
            </div>

            <div class="form-group" :class="{'has-error': errors.has('password_confirmation'), 'has-feedback': errors.has('password_confirmation') }">
              <label for="password_confirmation" class="col-md-4">Password</label>
              <div class="col-md-8">
                <input name="password_confirmation" v-model="password_confirmation" v-validate:password_confirmation="'required|min:6|confirmed:password'"
                data-vv-as="Password Confirmation" type="password" class="form-control" placeholder="Password Confirmation">
                <span v-show="errors.has('password_confirmation')" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
                <span class="help-block">{{ errors.first('password_confirmation') }}</span>
              </div>
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-info btn-sm" @click="reset_password()" :disabled="disabled">
                <i class="fa fa-key"></i> Reset Password
              </button>
              <button type="submit" class="btn btn-danger btn-sm pull-right" :disabled="disabled">
                <i class="fa" v-bind:class="button.class"></i> {{button.name}}
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
    </form>
    <div class="row">
      <div class="col-sm-12">
        <div class="callout callout-info">
          <h4>Info</h4>
          <p>If you forgot your password, click on the "Reset Password" Button, a temporary password will be generated and send to your email, then you can go back to this page and change your password.</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
export default {
  name: "change_password",
  props: ['user_id'],
  data: function data() {
    return {
      old_password: '', password: '', password_confirmation: '',
      button: {
				name: 'Change Password',
				class: 'fa-floppy-o'
			},
      disabled: false,
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.change_password()
          return;
        }
        toastr.error('Please correct the errors first')
      });
    },

    change_password(){
      this.button = {
        name: 'Processing',
        clas: 'fa-refresh fa-spin'
      }
      this.disabled = true;
      axios.post('/api/password/'+this.user_id, {
        password: this.password, old_password: this.old_password
      }).then((resp)=>{
        if(resp.status == 200){
          $("#change_password").collapse('hide')
          toastr.success('Password Changed')
          this.reset_button()
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

    reset_password(){
      this.disabled = true;
      axios.get('/api/password/'+this.user_id+'/reset').then((resp)=>{
        if(resp.status == 200){
          $("#change_password").collapse('hide')
          toastr.success('Email Sent');
          this.disabled = false;
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          $("#change_password").collapse('hide')
          this.disabled = false;
        }
      });
    },

    reset_button(){
      this.button = {
        name: 'Change Password',
				class: 'fa-floppy-o'
      }
      this.disabled = false;
    }
  }
}
</script>
<style lang="scss">
</style>
