<template src="./transaction_list.html"></template>
<script>
import ConfirmDialog from "./../../ConfirmDialog";
import moment from 'moment'
export default {
  name: "transaction_list",
  components: {
    'confirm-dialog': ConfirmDialog,
    'verify-dialog': ConfirmDialog
  },
  data: function data() {
    return {
      transactions: [],
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
      cur_id: '',
      showVerifyModal: false,
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

    role(){
      return this.$store.getters.auth_user_role;
    }

  },

  mounted() {
    this.get_transactions(this.pagination.current_page)
    this.$on('transactions', function(transactions) {
      this.transactions = transactions;
    });
    this.$on('pagination', function(pagination) {
      this.pagination = pagination
    });
  },

  methods: {
    get_transactions(page) {
      var vm = this
      axios.post('/api/transaction/listing?page=' + page, {
        paginate: this.paginate,
        query: this.query
      }).then((resp) => {
        vm.$emit('transactions', resp.data.transactions.data)
        vm.$emit('pagination', resp.data.pagination)
      })
    },

    changePage(page) {
      this.pagination.current_page = page
      this.get_transactions(page)
    },

    show_transaction(code){
      window.location.replace('/transaction/'+code);
    },

    delete_transaction() {
      axios.delete('/api/transaction/' + this.cur_id).then((resp) => {
        if (resp.status == 200) {
          this.showModal = false;
          this.get_transactions(this.pagination.current_page);
          toastr.success(resp.data.msg);
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value) {
            toastr.error(value);
          })
          this.showModal = false;
        }
      });
    },

    setVerify(){
      axios.get('/api/transaction/'+this.cur_id+'/verified').then((resp)=>{
        if (resp.status == 200) {
          this.get_transactions(this.pagination.current_page);
          this.showVerifyModal = false;
        }
      }).catch(error => {
        if (error.response) {
          $.each(error.response.data, function(key, value) {
            toastr.error(value);
          })
          this.showVerifyModal = false;
        }
      });
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
