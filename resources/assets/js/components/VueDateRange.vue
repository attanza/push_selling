<template>
  <div id="vue_date_range">
    <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                  <h4>Select dates: </h4>
              </div>
              <div class="modal-body">
                <date-picker v-model="dates" range :lang="lang" width="90vh"></date-picker>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" @click="$emit('close')">Cancel</button>
                  <button type="button" class="btn btn-danger pull-right" @click="post_dates()">OK</button>
              </div>
            </div>
          </div>
        </div>
      </transition>
  </div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
export default {
  name: "vue_date_range",
  components: { DatePicker },
  data: () => ({
    dates: '',
    lang: 'en',
  }),
  methods: {
    post_dates(){
      if (this.dates != '') {
        window.eventBus.$emit('post-dates', this.dates)
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  // padding: 10px 20px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header {
  margin-top: 0;
  background-color: #dd4b39;
  color: #fff;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
.datepicker{
  width: 100%;
}
</style>
