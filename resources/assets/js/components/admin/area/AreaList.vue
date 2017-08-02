<template src="./area_list.html"></template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";

export default {
  name: "area_list",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return{
        areas: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1,
        },
        offset: 2,
        paginate: 10,
        query: '',
        showModal: false,
        cur_id: ''
    }
  },

  computed: {
      isActived(){
          return this.pagination.current_page
      },

      pagesNumber(){
          if(!this.pagination.to){
              return []
          }

          var from = this.pagination.current_page - this.offset
          if(from < 1){
              from = 1
          }

          var to = from + (this.offset * 2)
          if(to >= this.pagination.last_page){
              to = this.pagination.last_page
          }

          var pagesArray = []
          while(from <= to){
              pagesArray.push(from)
              from++
          }

          return pagesArray
      }

  },

  mounted(){
      this.get_areas(this.pagination.current_page)
      this.$on('areas', function (areas) {
          this.areas = areas
      })
      this.$on('pagination', function (pagination) {
          this.pagination = pagination
      })

      window.eventBus.$on('insert-area', this.update_area)
  },

  methods: {
      get_areas(page){
          var vm = this
          axios.post('/api/area/listing?page='+page,{
            paginate: this.paginate,
            query: this.query
          }).then((resp)=>{
              vm.$emit('areas', resp.data.areas.data)
              vm.$emit('pagination', resp.data.pagination)
          })
      },

      changePage(page){
          this.pagination.current_page = page
          this.get_areas(page)
      },

      show_user(username){
        window.location.replace('profile/'+username)
      },

      update_area(area){
        // this.areas.unshift(area)
        this.get_areas(this.pagination.current_page)

      },

      edit_data(area){
        window.eventBus.$emit('edit-area', area)
      },

      char_limit(text,limit){
        var text_limited = text.substring(0,limit);
        return text_limited + '  ...'
      },

      check_before_delete(){
        axios.get('/api/area/'+this.cur_id+'/check').then((resp)=>{
          if (resp.status == 200) {
              if (resp.data.status == 'has stokiest') {
                  toastr.error('Area cannot be deleted because it is bound to a Stokiest or Markets')
                  this.showModal = false;
              } else {
                  this.delete_area();
              }
          }
        }).catch(error => {
          if (error.response) {
            $.each(error.response.data, function(key, value){
              toastr.error(value);
            })
          }
        });
      },

      delete_area() {
        axios.delete('/api/area/'+this.cur_id).then((resp) => {
          if (resp.status == 200) {
            this.showModal = false;
            this.get_areas(this.pagination.current_page);
            toastr.success(resp.data.msg);
          }
        })
      },

  }
}
</script>
<style lang="scss" scoped>
table.sortable thead {
    background-color:#dd4b39;
    color:#fff;
    font-weight: bold;
    cursor: pointer;
}
</style>
