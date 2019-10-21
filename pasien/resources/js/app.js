require("./bootstrap")
import Vue from 'vue'
import App from './component/master/App'
import Buefy from 'buefy'
import store from './store/store'
import router from './router'
import excel from 'vue-excel-export'
import IdleVue from 'idle-vue'

const eventsHub = new Vue()

Vue.use(IdleVue, {
  eventEmitter: eventsHub,
  idleTime: 30000,
  keepTracking: true,
})

Vue.use(require('vue-moment'))
Vue.use(Buefy)
Vue.use(excel)
new Vue({
  el: '#app',
  store,
  router,
  render: (h) => h(App)
})


