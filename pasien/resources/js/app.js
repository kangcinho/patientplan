import Vue from 'vue'
import App from './component/master/App'
import Buefy from 'buefy'
import store from './store/store'
import router from './router'

Vue.use(require('vue-moment'));
Vue.use(Buefy)

new Vue({
  el: '#app',
  store,
  router,
  render: (h) => h(App)
})