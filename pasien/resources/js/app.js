require("./bootstrap")
import Vue from 'vue'
import App from './component/master/App'
import Buefy from 'buefy'
import store from './store/store'
import router from './router'
import excel from 'vue-excel-export'

Vue.use(require('vue-moment'))
Vue.use(Buefy)
Vue.use(excel)

new Vue({
  el: '#app',
  store,
  router,
  render: (h) => h(App)
})