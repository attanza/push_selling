<template>
  <div id="area_list">
    <!--  Table Utility -->
    <div class="row" style="margin-bottom:20px;">
      <div class="col-sm-4">
        Show
        <select v-model="paginate" @change="get_areas(pagination.current_page)">
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
          <input type="text" v-model="query" value="" placeholder="Search ... " @keyup.enter="get_areas(pagination.current_page)">
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-condensed sortable" id="user_table">
        <thead>
          <tr>
            <th>Area name</th><th>Desciption</th><th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="area in areas">
            <td>{{area.name}}</td>
            <td>
              <span v-tooltip="area.description" v-if="area.description != null && area.description.length > 50">{{char_limit(area.description,50)}}</span>
              <span v-else>{{area.description}}</span>
            </td>
            <td>
              <button type="button" class="btn btn-default btn-sm" @click="edit_data(area)" v-tooltip="'Edit Area'"><i class="fa fa-pencil"></i></button>
              <button type="button" class="btn btn-danger btn-sm" @click="confirm_delete(area.id)" v-tooltip="'Delete Area'"><i class="fa fa-trash"></i></button>

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
  name: "area_list",
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

      confirm_delete(id){
        noty({
          layout: 'center',
          theme: 'defaultTheme', // or relax
          type: 'error',
          text: 'Are you sure?',
          buttons: [
            {addClass: 'btn btn-danger', text: 'Ok', onClick: function($noty) {
                axios.delete('/api/area/'+id).then((resp)=>{
                  if(resp.status == 200){
                    toastr.success(resp.data.msg)
                    window.location.reload()

                  }
                })
                $noty.close();

              }
            },
            {addClass: 'btn btn-default', text: 'Cancel', onClick: function($noty) {
                $noty.close();
              }
            }
          ]
        });
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
