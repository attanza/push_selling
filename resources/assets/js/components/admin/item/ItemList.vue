<template src="./item_list.html"></template>
<script>
import moment from 'moment'
import ConfirmDialog from "./../../ConfirmDialog";

export default {
  name: "user_list",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return {
      items: [],
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
    this.get_items(this.pagination.current_page)
    this.$on('items', function(items) {
      this.items = items
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    })
    window.eventBus.$on('saved-item', this.update_item)
  },

  methods: {
    get_items(page) {
      var vm = this
      axios.post('/api/items/listing?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        vm.$emit('items', resp.data.items.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_items(page)
    },

    update_item(data) {
      this.items.unshift(data)
    },

    show_item(code) {
      window.location.replace('/items/' + code)
    },

    delete_item(id) {
      axios.delete('/api/items/'+this.cur_id).then((resp) => {
        if (resp.status == 200) {
          this.showModal = false;
          this.get_items(this.pagination.current_page);
          toastr.success(resp.data.msg);
        }
      })
    },

    num_format(n) {
      return String(n).replace(/(.)(?=(\d{3})+$)/g, '$1,')
    },

    target_conf(n) {
      if (n == 1) {
        return "Quantity"
      } else if (n == 2) {
        return "Outlet"
      }
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
