<template>
  <div id="market_map">
    <label for="location">Location</label>
    <div id="location">
      <gmap-autocomplete @place_changed="setPlace"></gmap-autocomplete>
      <gmap-map :center="location" :zoom="10" style="width: 100%; height: 300px;">
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
    <div class="box">
      <div class="box-body">
        <button type="button" class="btn btn-danger btn-sm pull-right" @click="showModal = true">
          <i class="fa fa-map-marker"></i> Set Location
        </button>
        <confirm-dialog v-if="showModal" @close="showModal = false" @next_process="set_location"></confirm-dialog>
      </div>
    </div>

    <input type="hidden" name="lat" v-model="location.lat">
    <input type="hidden" name="long" v-model="location.lng">

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
  name: "market_map",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  props: ['market'],
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
    this.location.lat = this.market.lat
    this.location.lng = this.market.lng
  },

  methods: {
    setPlace(place){
      console.log(place);
      this.location = {
        lat: place.geometry.location.lat(),
        lng: place.geometry.location.lng()
      }
      console.log(this.location);
    },
    markerDrag(position){
      this.location = {
        lat: position.lat(),
        lng: position.lng()
      }
      console.log(this.location);

    },

    set_location(){
      axios.post('/api/market/'+this.market.id+'/set_location',{
        lat: this.location.lat, lng: this.location.lng
      }).then((resp)=>{
        this.showModal = false
        this.$store.commit('current_market_mutation', resp.data.market)
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
