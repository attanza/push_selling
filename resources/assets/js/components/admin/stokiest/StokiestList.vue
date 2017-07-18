<template src="./stokiest_list.html"></template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";

export default {
  name: "user_list",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return{
        stokiests: [],
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
      },

  },

  mounted(){
      this.get_stokiests(this.pagination.current_page)
      this.$on('stokiests', function (stokiests) {
          this.stokiests = stokiests
      })
      this.$on('pagination', function (pagination) {
          this.pagination = pagination
      })
      window.eventBus.$on('saved-stokiest', this.update_stokiest)
  },

  methods: {
      get_stokiests(page){
          var vm = this
          axios.post('/api/stokiest/listing?page='+page,{
            paginate: this.paginate,
            query: this.query
          }).then((resp)=>{
              vm.$emit('stokiests', resp.data.stokiests.data)
              vm.$emit('pagination', resp.data.pagination)
          })
      },

      changePage(page){
          this.pagination.current_page = page
          this.get_stokiests(page)
      },

      update_stokiest(data){
        this.stokiests.unshift(data)
      },

      show_stokiest(code){
        window.location.replace('/stokiest/'+code)
      },

      delete_stokiest(){
        axios.delete('/api/stokiest/'+this.cur_id).then((resp)=>{
          if(resp.status == 200){
            toastr.success(resp.data.msg)
            this.stokiest = []
            this.get_stokiests(this.pagination.current_page)
            this.showModal = false
          }
        })
      }
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
