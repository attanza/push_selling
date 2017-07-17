<template src="./activity_table.html"></template>
<script>
export default {
  data: function data() {
    return{
        activities: [],
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

  props: ['user_id'],

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
      this.get_activities(this.pagination.current_page)
      this.$on('activities', function (activities) {
          this.activities = activities
      })
      this.$on('pagination', function (pagination) {
          this.pagination = pagination
      })
  },

  methods: {
      get_activities(page){
          var vm = this
          axios.post('/api/profile/listing/'+this.user_id+'?page='+page,{
            paginate: this.paginate,
            query: this.query
          }).then((resp)=>{
              vm.$emit('activities', resp.data.activities.data)
              vm.$emit('pagination', resp.data.pagination)
          })
      },

      changePage(page){
          this.pagination.current_page = page
          this.get_activities(page)
      },

      char_limit(text,limit){
        var text_limited = text.substring(0,limit);
        return text_limited + '  ...'
      },
  }
}
</script>
<style lang="scss">
</style>
