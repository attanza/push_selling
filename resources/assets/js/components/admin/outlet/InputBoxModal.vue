<template>
  <div class="modal modal-danger" id="input_box_modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Edit Caption</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="caption">Caption</label>
            <input type="text" class="form-control" id="caption" placeholder="Caption"
            v-model="caption" autofocus @keyup.enter="save_caption">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" @click="close_modal()">Close</button>
          <button type="button" class="btn btn-outline" :disabled="disabled" @click="save_caption()">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>
<script>
export default {
  name: "input_box_modal",
  data: () => ({
    caption: '',
    id: '',
    disabled: true
  }),
  props: ['cur_image'],
  mounted(){
    window.eventBus.$on('showEditor', this.set_modal_attr)
  },

  watch: {
    caption(){
      if (this.caption.length == 0) {
          this.disabled = true
      } else if (this.caption.length >= 3) {
          this.disabled = false
      }
    }
  },

  methods: {
    set_modal_attr(media){
      this.caption = media.caption
      this.id = media.id
    },
    close_modal(){
      this.caption = ''
      this.id = ''
      $("#input_box_modal").modal('hide');
    },
    save_caption(){
      if (this.caption.length >= 3) {
        axios.put('/api/gallery/'+this.id+'/edit_caption', {
          caption: this.caption
        }).then((resp)=>{
          if(resp.status == 200) {
            window.eventBus.$emit('insert-outlet-media', resp.data.media)
            toastr.success('Caption Saved');
            this.close_modal();
          }
        })

      }
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
