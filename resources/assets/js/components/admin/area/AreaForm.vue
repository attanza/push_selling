<template>
  <div class="collapse" id="area_form">
    <div class="row">
      <div class="col-sm-12">
        <div class="form-group" :class="{'has-error': errors.has('name'), 'has-feedback': errors.has('name') }">
          <label for="name">Area Name</label>
          <input name="name" v-model="name" ref="name" v-validate:name="'required|max:150'"
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
          <button type="button" class="btn btn-default" @click="handleCancel()">Cancel</button>
          <button type="button" class="btn btn-danger pull-right"
          @click="validateBeforeSubmit" :disabled="disabled">
          <i class="fa fa-floppy-o"></i> Save</button>
        </div>
      </div>
    </div>
    <hr>
  </div>
</template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import autosize from 'autosize'
export default {
  name: "area_form",
  data: function data() {
    return {
      name:'', description:'',
      id: '',
      disabled: false
    }
  },
  mounted(){
    autosize(document.querySelector('textarea'));
    window.eventBus.$on('edit-area', this.edit_area)
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
      if(this.id != ''){
        this.update_area()
        return
      }
      axios.post('/api/area', {
        name: this.name, description: this.description
      }).then((resp)=>{
        if (resp.status == 200) {
          window.eventBus.$emit('insert-area', resp.data.area)
          toastr.success('Area Saved')
          this.handleCancel()
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          this.disabled = false
        }
      });
    },
    edit_area(data){
      autosize(document.querySelector('textarea'));
      this.name = data.name
      this.description = data.description
      this.id = data.id
      $("#area_form").collapse('show')
    },

    update_area(){
      this.disabled = true
      axios.put('api/area/'+this.id,{
        name: this.name, description: this.description
      }).then((resp)=>{
        toastr.success('Area Updated')
        window.eventBus.$emit('insert-area', resp.data.area)
        this.handleCancel()

      })
    },

    handleCancel(){
      this.name = ''
      this.description = ''
      this.disabled = false
      autosize.destroy(document.querySelectorAll('textarea'));
      $("#area_form").collapse('hide')
    }

  }
}
</script>
<style lang="scss">
</style>
