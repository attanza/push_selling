<template>
  <div id="market_insert_form" class="collapse">
    <div class="row">
      <div class="col-sm-12">
        <div class="form-group" :class="{'has-error': errors.has('name'), 'has-feedback': errors.has('name') }">
          <label for="name">Market Name</label>
          <input name="name" v-model="name" v-validate:name="'required|max:150'"
          data-vv-as="Market Name" type="text" class="form-control" placeholder="Market name"
          autofocus @keyup.enter="validateBeforeSubmit">
          <span v-show="errors.has('name')" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
          <span class="help-block">{{ errors.first('name') }}</span>
        </div>

        <div class="form-group">
          <label for="area">Area</label>
            <v-select label="name" :options="areas" v-model="area"></v-select>
            <p class="pull-right" style="margin-top: 8px;">
              <a href="javascript:void(0)" @click="show_insert_area_form">
                <i class="fa fa-plus"></i> Add Area
              </a>
            </p>
        </div>

        <div class="form-group">
          <label for="description">Address</label>
          <textarea name="address" v-model="address" class="form-control" placeholder="Address"></textarea>
        </div>

        <div class="form-group">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger btn-sm pull-right" @click="validateBeforeSubmit">
            <i class="fa" v-bind:class="button.class"></i> {{button.name}}
          </button>
        </div>
        <hr>
      </div>
    </div>
    <area-form-modal></area-form-modal>
  </div>
</template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import vSelect from "vue-select"
import AreaFormModal from './../area/AreaFormModal'
export default {
  components: {
    vSelect,
    'area-form-modal': AreaFormModal
  },
  data: function data() {
    return {
      name: '', address: '',
      areas: [], area: '',
      button: {
				name: 'Submit',
				class: 'fa-floppy-o'
			},
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
      this.button = {
				name: 'Processing',
				class: 'fa-refresh fa-spin'
			},
      axios.post('/api/market',{
        name: this.name, address: this.address, area_id: this.area.id, lat: -6.17511, lng:106.86503949999997
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
      this.button = {
				name: 'Save',
				class: 'fa-floppy-o'
			},
      $("#market_insert_form").collapse('hide')
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

    show_insert_area_form(){
      $("#insert_area").modal('show')
    },

    after_insert_area(data){
      this.areas.unshift(data)
    }

  }
}
</script>
<style lang="scss" scoped>
</style>
