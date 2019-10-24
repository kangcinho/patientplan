require("./bootstrap")
import Vue from 'vue'
import App from './component/master/App'
import Buefy from 'buefy'
import store from './store/store'
import router from './router'
import excel from 'vue-excel-export'
import IdleVue from 'idle-vue'
import VueHtmlToPaper from 'vue-html-to-paper'

const eventsHub = new Vue()
const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    '../css/app.css'
  ]
}

Vue.use(VueHtmlToPaper, options)

Vue.use(IdleVue, {
  eventEmitter: eventsHub,
  idleTime: 300000,
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