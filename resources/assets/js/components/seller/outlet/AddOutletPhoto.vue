<template>
  <div class="collapse" id="add_outlet_photo">
    <dropzone id="myVueDropzone" ref="myVueDropzone"
      :url="upload_url" v-on:vdropzone-success="showSuccess"
      v-on:vdropzone-sending="sending"
      acceptedFileTypes="image/*" :useFontAwesome="useFontAwesome"
      :headers="token" :maxFileSizeInMB="maxFileSizeInMB">
    </dropzone>
    <div class="overlay" v-show="loading">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>
</template>
<script>
import Dropzone from 'vue2-dropzone'
export default {
  name: "add_outlet_photo",
  components: {
    Dropzone
  },
  props: ['outlet_id'],
  data: function data() {
    return {
      upload_url: '/api/gallery/'+this.outlet_id+'/outlet',
      useFontAwesome: true, maxFileSizeInMB: 5,
      token: {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
      },
      loading: false,
    }
  },

  methods: {
    'sending': function() {
      this.loading = true
    },
    'showSuccess': function (file, response) {
      let vm = this
      vm.$refs.myVueDropzone.removeFile(file)
      this.loading = false
      toastr.success('Photo Uploaded')
      $("#add_outlet_photo").collapse('hide')
      window.eventBus.$emit('insert-outlet-media', response.medias)
    }
  },
}
</script>
<style lang="scss">
</style>
