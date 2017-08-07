<template src="./seller_list.html"></template>
<script>
export default {
  name: "seller_list",
  data: function data() {
    return {
      sellers: [],
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
    this.get_sellers(this.pagination.current_page)
    this.$on('sellers', function(sellers) {
      this.sellers = sellers
    })
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    })
  },

  methods: {
    get_sellers(page) {
      var vm = this
      axios.post('/api/seller/listing?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        vm.$emit('sellers', resp.data.sellers.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_sellers(page)
    },

    show_seller(username) {
      window.location.replace('profile/' + username)
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
