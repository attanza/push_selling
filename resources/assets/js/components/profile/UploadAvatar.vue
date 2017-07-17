<template>
  <div class="collapse" id="upload_avatar">

    <div class="form-group" :class="{'has-error': errors.has('avatar'), 'has-feedback': errors.has('avatar') }">
      <input name="avatar" id="avatar" v-validate:avatar="'image|size:3000'"
      data-vv-as="Avatar" type="file" class="form-control" placeholder="Avatar" @change="validateBeforeSubmit"
      accept="image/*">
      <span v-show="errors.has('avatar')" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
      <span class="help-block">{{ errors.first('avatar') }}</span>
    </div>
    <br>
    <div class="image-container">
      <img :src="image" alt="" id="image">
    </div>
    <div class="upload-btn">
      <center>
        <button class="btn btn-primary" id="uploadFileCall" v-on:click="uploadFile" v-show="upload">
      		<i class="fa" v-bind:class="button.class"></i> {{button.name}}
      	</button>
      </center>
    </div>

  </div>
</template>
<script>
import VeeValidate, { Validator } from 'vee-validate';
Vue.use(VeeValidate);
import Cropper from 'cropperjs'

export default {
  name: "upload_avatar",
  props: ['user'],
  data: function data() {
    return {
      image: null,
      cropper: null,
      upload: false,
      button: {
        name: 'Upload',
  			class: 'fa-upload'
			},
    }
  },
  mounted () {
    this.image = this.user.avatar
    this.setUpCropper()
    this.$on('imgUploaded', function (imageData) {
      this.image = imageData
      this.cropper.replace(imageData)
		})
  },
  methods: {
    validateBeforeSubmit(e){
      this.$validator.validateAll().then((result) => {
        if(result){
          this.onFileChange(e)
        }
	    })
    },
    setUpCropper(){
      var image = document.getElementById('image');
      this.cropper = new Cropper(image, {
        aspectRatio: 1 / 1,
        viewMode: 1,
        dragMode: 'move',
      });
    },
    onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length)
			return;
			this.createImage(files[0]);
			this.upload = true;
		},

		createImage(file) {
			var image = new Image();
			var reader = new FileReader();
			var vm = this;
			reader.onload = (e) => {
				vm.image = e.target.result;
				vm.$emit('imgUploaded', e.target.result)
			};
			reader.readAsDataURL(file);
		},
    uploadFile () {
			this.button = {
				name: 'Uploading...',
				class: 'fa-refresh fa-spin'
			}

      axios.post('/api/upload/avatar/'+this.user.id,{file: this.cropper.getCroppedCanvas().toDataURL()})
        this.$store.commit('avatar_mutation', this.cropper.getCroppedCanvas().toDataURL())
        toastr.success('Avatar Uploaded')
        this.reset_modal()
		},
    reset_modal(){
      $("#upload_avatar").collapse('hide')
      // this.cropper.destroy()
      this.image = null,
      this.cropper = null,
      this.upload = false,
      this.button = {
				name: 'Upload',
				class: 'fa-upload'
			}
      $("#avatar").val('');
      this.setUpCropper()
    }
  }
}
</script>
<style lang="scss">
.upload-btn{
  margin-top: 10px;
  margin-bottom: 10px;

}
.image-container{
  margin: 0 auto;
  width: 300px;
  overflow: scroll;
  img{
    width: 100%;
  }
}
</style>
