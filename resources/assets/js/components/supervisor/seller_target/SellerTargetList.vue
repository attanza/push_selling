<template src="./seller_target_list.html"></template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";

export default {
  name: "seller_target_list",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return {
      seller_targets: [],
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
      cur_id: '',
      showModal: false,
    }
  },

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
    this.get_seller_targets(this.pagination.current_page)
    this.$on('seller_targets', function(seller_targets) {
      this.seller_targets = seller_targets
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    })
    window.eventBus.$on('update_seller_target', this.update_seller_targets);
  },

  methods: {
    get_seller_targets(page) {
      var vm = this
      axios.post('/api/seller-target/listing?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        vm.$emit('seller_targets', resp.data.seller_targets.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_seller_targets(page)
    },

    show_seller_target(username) {
      window.location.replace('profile/' + username)
    },

    update_seller_targets(){
      this.get_seller_targets(this.pagination.current_page);
    },
    delete_area(){
      axios.delete('/api/seller-target/'+this.cur_id).then((resp)=>{
        if (resp.status == 200) {
          toastr.success(resp.data.msg);
          this.showModal = false;
          this.get_seller_targets(this.pagination.current_page);
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value){
            toastr.error(value);
          })
        }
      });
    },
    edit_data(seller_target){
      window.eventBus.$emit('edit-seller-target', seller_target)
    }
  }
}
</script>
<style lang="scss" scoped>
table.sortable thead {
    background-color: #dd4b39;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
}
</style>
