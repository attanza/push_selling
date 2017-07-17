<template>
  <div class="box box-primary" id="market_photo">
    <div class="box-body box-profile">
      <center>
        <img class="img-responsive pad" :src="market.photo" :alt="market.name" v-if="market">
      </center>
      <p class="text-center">
        <button type="button" class="btn btn-primary" role="button" data-toggle="collapse" href="#upload_photo" aria-expanded="false" aria-controls="upload_photo"> <i class="fa fa-upload"></i> Change Photo</button>
      </p>
      <div class="collapse" id="upload_photo">
        <dropzone id="myVueDropzone" ref="myVueDropzone"
          :url="upload_url" v-on:vdropzone-success="showSuccess" v-on:vdropzone-sending="sending"        acceptedFileTypes="image/*" :useFontAwesome="useFontAwesome"
          :headers="token" :maxFileSizeInMB="maxFileSizeInMB" :maxNumberOfFiles="maxNumberOfFiles">
        </dropzone>
      </div>
    </div>
    <div class="overlay" v-show="loading">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>
</template>
<script>
import Dropzone from 'vue2-dropzone'
export default {
  name: "market_photo",
  components: {
    Dropzone
  },
  props: ['market_id'],
  data: function data() {
    return {
      upload_url: '/api/market/'+this.market_id+'/upload',
      useFontAwesome: true, maxFileSizeInMB: 5, maxNumberOfFiles: 1,
      token: {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
      },
      loading: false,
    }
  },
  mounted(){

  },
  methods: {
    'sending': function() {
      this.loading = true
    },
    'showSuccess': function (file, response) {
      let vm = this
      vm.$refs.myVueDropzone.removeFile(file)
      this.$store.commit('current_market_mutation', response.market)
      this.loading = false
      toastr.success('Photo Uploaded')
      $("#upload_photo").collapse('hide')
    }
  },
  computed: {
    market(){
      return this.$store.state.current_market
    }
  }
}
</script>
<style lang="scss">
</style>
