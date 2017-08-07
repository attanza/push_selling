<template>
  <div id="user_list">

    <!--  Table Utility -->
    <div class="row" style="margin-bottom:20px;">
      <div class="col-sm-4">
        Show
        <select v-model="paginate" @change="get_users(pagination.current_page)">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        entries
      </div>
      <div class="col-sm-4">

      </div>
      <div class="col-sm-4">
        <div class="pull-right">
          <input type="text" v-model="query" value="" placeholder="Search ... " @keyup.enter="get_users(pagination.current_page)">
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-condensed sortable" id="user_table">
        <thead>
          <tr>
            <th>Name</th><th>Email</th><th>Last Login</th><th>Roles</th><th>Status</th><th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users">
            <td>{{user.name}}</td>
            <td>{{user.email}}</td>
            <td>{{user.last_login}}</td>
            <td>
              <span v-for="role in user.roles">
                <span class="label label-default">{{role.name}}</span>

              </span>
            </td>
            <td>
              <span v-if="user.is_active">Active</span>
              <span v-else>Not Active</span>
            </td>
            <td>
              <button type="button" class="btn btn-default btn-sm" @click="show_user(user.username)"><i class="fa fa-eye"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Table Navigation -->
    <div class="row">
      <div class="col-sm-6">
        <p>Showing {{pagination.from}} to {{pagination.to}} of {{pagination.total}} entries</p>
      </div>
      <div class="col-sm-6">
        <nav class="pull-right">
            <ul class="pagination">
                <li v-if="pagination.current_page > 1">
                    <a href="javascript:void(0)" aria-label="First" @click.prevent="changePage(pagination.current_page = 1)">
                        <i class="fa fa-step-backward"></i>
                    </a>
                </li>
                <li v-if="pagination.current_page > 1">
                    <a href="javascript:void(0)" aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                </li>
                <li v-for="page in pagesNumber" v-bind:class="[page == isActived ? 'active' : '']">
                    <a href="#" @click.prevent="changePage(page)">{{page}}</a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="javascript:void(0)" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                    <a href="javascript:void(0)" aria-label="Last" @click.prevent="changePage(pagination.current_page = pagination.last_page)">
                        <i class="fa fa-step-forward"></i>
                    </a>
                </li>
            </ul>
        </nav>
      </div>
    </div>

  </div>
</template>
<script>
export default {
  name: "user_list",
  data: function data() {
    return{
        users: [],
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
      this.get_users(this.pagination.current_page)
      this.$on('users', function (users) {
          this.users = users
      })
      this.$on('pagination', function (pagination) {
          this.pagination = pagination
      })
  },

  methods: {
      get_users(page){
          var vm = this
          axios.post('/api/user/listing?page='+page,{
            paginate: this.paginate,
            query: this.query
          }).then((resp)=>{
              vm.$emit('users', resp.data.users.data)
              vm.$emit('pagination', resp.data.pagination)
          })
      },

      changePage(page){
          this.pagination.current_page = page
          this.get_users(page)
      },

      show_user(username){
        window.location.replace('profile/'+username)
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
