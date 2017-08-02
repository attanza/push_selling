<template src="./outlet_list.html"></template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";

export default {
  name: "outlet_list",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return {
      outlets: [],
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
    this.get_outlets(this.pagination.current_page)
    this.$on('outlets', function(outlets) {
      this.outlets = outlets
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    })
    window.eventBus.$on('saved-outlet', this.update_outlet)
  },

  methods: {
    get_outlets(page) {
      var vm = this
      axios.post('/api/outlet/listing?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        vm.$emit('outlets', resp.data.outlets.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_outlets(page)
    },

    update_outlet(data) {
      this.outlets.unshift(data)
    },

    show_outlet(code) {
      window.location.replace('/outlet/' + code)
    },

    delete_outlet() {
      axios.delete('/api/outlet/' + this.cur_id).then((resp) => {
        if (resp.status == 200) {
          toastr.success(resp.data.msg)
          this.outlet = []
          this.get_outlets(this.pagination.current_page)
          this.showModal = false
        }
      })
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
