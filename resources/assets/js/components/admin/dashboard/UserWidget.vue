<template>
  <div class="small-box bg-yellow" id="user_widget">
    <div class="inner">
      <h3>{{count_user}}</h3>

      <p>Registered Users</p>
    </div>
    <div class="icon">
      <a :href="add_user_url"><i class="ion ion-person-add"></i></a>

    </div>
    <a :href="info_url" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</template>
<script>
export default {
  name: "user_widget",
  data: function data() {
    return {
      count_user: 0,
      info_url: '/users',
      add_user_url: '/users/create'
    }
  },
  mounted(){
    axios.get('/api/dashboard/get-user-count').then((resp)=>{
      this.count_user = resp.data.user_count
    })
  }
}
</script>
<style lang="scss">
</style>
