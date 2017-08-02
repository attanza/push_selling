<template src="./item_gallery.html"></template>
<script>
import VueLightbox from './../../VueLightbox'
import InputBoxModal from './InputBoxModal'
import ConfirmDialog from "./../../ConfirmDialog";

export default {
  name: "item_gallery",
  components: {
    'vue-lightbox': VueLightbox,
    'input-box-modal': InputBoxModal,
    'confirm-dialog': ConfirmDialog
  },
  data() {
    return {
      medias: [],
      pagination: {
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      offset: 2,
      images: [],
      imageLightbox: false,
      cur_image: '',
      showModal: false,

    }
  },

  props: ['item_id'],

  computed: {
    isActived() {
      return this.pagination.current_page
    },

    pagesNumber() {
      if (!this.pagination.to) {
        return []
      }

      var from = this.pagination.current_page - this.offset
      if (from < 1) {
        from = 1
      }

      var to = from + (this.offset * 2)
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page
      }

      var pagesArray = []
      while (from <= to) {
        pagesArray.push(from)
        from++
      }

      return pagesArray
    },

  },

  mounted() {
    this.get_medias(this.pagination.current_page)
    this.$on('medias', function(medias) {
      let image_data;
      this.medias = _.chunk(medias, 12)
      medias.forEach((media)=>{
        image_data = {
          thumb: media.path,
          src: media.path,
          caption: media.caption,
        }
        this.images.push(image_data);
      });
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    })

    window.eventBus.$on('insert-item-media', this.update_media)
    window.eventBus.$on('close-lightbox', this.close_lightbox)

  },

  methods: {
    get_medias(page) {
      var vm = this
      axios.get('/api/gallery/'+this.item_id+'/item?page=' + page).then((resp) => {
        vm.$emit('medias', resp.data.medias)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_medias(page)
    },

    update_media(media){
      this.get_medias(this.pagination.current_page)
    },

    show_lightbox(index){
      window.eventBus.$emit('showLightbox', index)
    },
    char_limit(text,limit){
      var text_limited = text.substring(0,limit);
      return text_limited + '  ...'
    },
    edit_media(media){
      window.eventBus.$emit('showEditor', media)
      $("#input_box_modal").modal('show');
    },

    delete_media(){
      axios.delete('/api/gallery/'+this.cur_image.id).then((resp) => {
        if (resp.status == 200) {
          this.showModal = false;
          this.get_medias(this.pagination.current_page)
          toastr.success(resp.data.msg)
        }
      })
    }
  }
}
</script>
<style lang="scss" scoped>
  .item-image-wrapper {
    height: 25vh;
    /*width: 400px;*/
    overflow: hidden;
  }

  .item-image-wrapper img {
    height: auto;
    width: 100%;
  }
  .item-media-footer{
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    margin-top: -5px;
    margin-bottom: 10px;

    .item-caption {
      font-weight: 400;
      word-wrap: break-word;
    }
  }
</style>
