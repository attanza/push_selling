<template src="./market_list.html"></template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";

export default {
  name: "user_list",
  components: {
    'confirm-dialog': ConfirmDialog
  },
  data: function data() {
    return {
      markets: [],
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
    this.get_markets(this.pagination.current_page)
    this.$on('markets', function(markets) {
      this.markets = markets
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    })
    window.eventBus.$on('saved-market', this.update_market)
  },

  methods: {
    get_markets(page) {
      var vm = this
      axios.post('/api/market/listing?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        vm.$emit('markets', resp.data.markets.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_markets(page)
    },

    update_market() {
      this.get_markets(this.pagination.current_page)
    },

    show_market(slug) {
      window.location.replace('/market/' + slug)
    },

    delete_market() {
      axios.delete('/api/market/' + this.cur_id).then((resp) => {
        if (resp.status == 200) {
          this.showModal = false;
          this.get_markets(this.pagination.current_page);
          toastr.success(resp.data.msg);
        }
      })
    },
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
