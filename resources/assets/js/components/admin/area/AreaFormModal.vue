<!-- <template src="./area_form_modal.thml"></template> -->
<template>
  <div id="area_form_modal">
    <div class="modal modal-danger" id="insert_area">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Insert New Area</h4>
          </div>
          <div class="modal-body">
            <div class="form-group" :class="{'has-error': errors.has('name'), 'has-feedback': errors.has('name') }">
              <label for="name">Area Name</label>
              <input name="name" v-model="name" v-validate:name="'required|max:150'"
              data-vv-as="Area Name" type="text" class="form-control" placeholder="Area name"
              autofocus @keyup.enter="validateBeforeSubmit">
              <span v-show="errors.has('name')" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
              <span class="help-block">{{ errors.first('name') }}</span>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" v-model="description" class="form-control" placeholder="Description"></textarea>
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-default btn-block"
              @click="validateBeforeSubmit" :disabled="disabled">
              <i class="fa fa-floppy-o"></i> Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
export default {
  name: "area_form_modal",
  data: function data() {
    return {
      name:'', description:'',
      id: '',
      disabled: false
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.submit_data();
          return;
        }
        toastr.error('Please correct the errors first')
      });
    },

    submit_data(){
      this.disabled = true
      axios.post('/api/area', {
        name: this.name, description: this.description
      }).then((resp)=>{
        this.name = ''
        this.description = ''
        toastr.success('Area Saved')
        window.eventBus.$emit('insert-area', resp.data.area)
        $("#insert_area").modal('hide')
        this.disabled = false

      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          this.disabled = false
        }
      });
    },
  }
}
</script>
<style lang="scss" scoped>
.has-error .help-block,
.has-error .control-label,
.has-error .radio,
.has-error .checkbox,
.has-error .radio-inline,
.has-error .checkbox-inline {
  color: #fff;
}
.has-error .form-control {
  border-color: #fff;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
}
.has-error .form-control:focus {
  border-color: #843534;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
}
.has-error .input-group-addon {
  color: #fff;
  background-color: #f2dede;
  border-color: #a94442;
}
.has-error .form-control-feedback {
  color: #fff;
}
.form-group.has-error label {
    color: #fff;
}
</style>
