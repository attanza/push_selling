<template>
  <div class="box box-danger box-solid" id="stokiest_map">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-map-marker"></i> Stokiest Map</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
      <div id="location">
        <gmap-autocomplete @place_changed="setPlace"></gmap-autocomplete>
        <gmap-map :center="location" :zoom="12" style="width: 100%; height: 300px;">
          <gmap-marker
            :position="location"
            :clickable="true"
            :draggable="true"
            @click="center=location"
            @place_changed="setPlace"
            @position_changed="markerDrag($event)"
          ></gmap-marker>
        </gmap-map>
      </div>
    </div>
    <div class="box-footer">
      <button type="button" class="btn btn-danger btn-sm pull-right" @click="showModal = true">
        <i class="fa fa-map-marker"></i> Set Location
      </button>
      <confirm-dialog v-if="showModal" @close="showModal = false" @next_process="set_location"></confirm-dialog>
      <input type="hidden" name="lat" v-model="location.lat">
      <input type="hidden" name="long" v-model="location.lng">
    </div>
  </div>
</template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";

import * as VueGoogleMaps from 'vue2-google-maps';
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyCYUffiM_hEO-sLHdpeKx3UHvTp6tm9i8s',
    libraries: 'places'
  }
});
export default {
  name: "stokiest_map",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  props: ['stokiest'],
  data: () => ({
    location: {
      lat: 10.0,
      lng: 10.0
    },
    markers: [{
      position: {lat: 10.0, lng: 10.0}
    }],
    showModal: false,
  }),
  mounted(){
    this.location.lat = this.stokiest.lat
    this.location.lng = this.stokiest.lng
  },

  methods: {
    setPlace(place){
      this.location = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng()
      }
    },
    markerDrag(position){
      this.location = {
        lat: position.lat(),
        lng: position.lng()
      }
    },

    set_location(){
      axios.post('/api/stokiest/'+this.stokiest.id+'/set_location',{
        lat: this.location.lat, lng: this.location.lng
      }).then((resp)=>{
        this.showModal = false
        this.$store.commit('current_stokiest_mutation', resp.data.stokiest)
        toastr.success('Location set')
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
          this.showModal = false
        }
      });
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
