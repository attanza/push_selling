<template>
  <div id="area_change">
    <div class="stokiest-wrapper" v-show="cur_area.stokiest">
      <strong>Stokiest: </strong>
      <hr>
      <div class="form-group" :class="{'has-error': errors.has('stokiest_area_id'), 'has-feedback': errors.has('stokiest_area_id') }">
        <label for="stokiest_area_id" class="col-sm-2" v-if="cur_area.stokiest">{{cur_area.stokiest.name}}</label>
        <div class="col-sm-10">
          <select class="form-control" name="stokiest_area_id" id="stokiest_area_id" v-model="stokiest_area_id"
          v-validate:stokiest_area_id="'required|numeric'" data-vv-as="Stokiest Area" style="width: 80%" placeholder="Select area ">
            <option :value="area.id" v-for="area in stokiest_areas">{{area.name}}</option>
          </select>
          <p class="pull-right" style="margin-top: 8px;">
            <a href="javascript:void(0)" @click="show_insert_area_form"><i class="fa fa-plus"></i> Add Area</a>
          </p>
          <span v-show="errors.has('stokiest_area_id')" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
          <span class="help-block">{{ errors.first('stokiest_area_id') }}</span>
        </div>
      </div>
      <hr>
    </div>
    <div class="market-wrapper" v-show="cur_area.markets">
      <strong>Markets: </strong>
      <div class="market-form" v-if="cur_area.markets" v-for="market in cur_area.markets">
        <div class="form-group">
          <label for="market" class="col-sm-2">{{market.name}}</label>
          <div class="col-sm-10">
            <select class="form-control" name="market_area_id" style="width: 80%">
              <option :value="area.id" v-for="area in market_areas" v-if="area.id != market.area_id">{{area.name}}</option>
            </select>
          </div>
        </div>
      </div>

    </div>
    <area-form-modal></area-form-modal>
  </div>
</template>
<script>
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
import AreaFormModal from './../area/AreaFormModal'
export default {
  name: "area_change",
  components: {
    'area-form-modal': AreaFormModal
  },
  props: ['stokiest_area_data', 'market_area_data', 'market_data', 'cur_area_data'],
  data: () => ({
    stokiest_area_id: '',
    stokiest_areas: [],
    market_area_id: '',
    market_areas: [],
    cur_area: {},
    button: {
      name: 'Update',
      class: 'fa-floppy-o'
    },
  }),
  mounted(){
    this.stokiest_areas = this.stokiest_area_data;
    this.market_areas = this.market_area_data;
    this.cur_area = this.cur_area_data;
  },
  methods: {
    show_insert_area_form(){
      $("#insert_area").modal('show')
    },

    after_insert_area(data){
      this.stokiest_areas.unshift(data)
      this.market_areas.unshift(data)

    }
  }
}
</script>
<style lang="scss" scoped>
.market-form{
  margin-bottom: 10px;
}
</style>
