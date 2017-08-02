<template>
  <div class="box box-danger box-solid" id="stokiests_map">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-building"></i> Stokiest Locations</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
      <div id="location">
        <gmap-map :center="center" :zoom="8" style="width: 100%; height: 300px;">
          <gmap-marker
           :key="index"
           v-for="(m, index) in markers"
           :position="m.position"
           :clickable="true"
           :draggable="false"
           @click="center=m.position"
         ></gmap-marker>
        </gmap-map>
      </div>
    </div>
    <div class="overlay" v-show="loading">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>
</template>
<script>

import * as VueGoogleMaps from 'vue2-google-maps';
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyCYUffiM_hEO-sLHdpeKx3UHvTp6tm9i8s',
    libraries: 'places'
  }
});
export default {
  name: "stokiests_map",
  props: ['stokiest_maps_data'],
  data: () => ({
    center: {},
    markers: [],
    loading: true,
  }),
  mounted(){
    this.addMarker();
    this.setCenter();
    setTimeout(this.setOffLoader, 1500);

  },
  methods: {
    addMarker () {
      if (this.stokiest_maps_data.length > 0) {
        this.stokiest_maps_data.forEach((map) => {
          this.markers.push({
            position: { lat: map.lat, lng: map.lng },
            draggable: true,
            enabled: true
          })
        })
      }
    },
    setCenter(){
      if (this.stokiest_maps_data.length > 0) {
        this.center = {
          lat: this.stokiest_maps_data[0].lat,
          lng: this.stokiest_maps_data[0].lng,
        }
      }
    },
    setOffLoader(){
      this.loading = false;
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
