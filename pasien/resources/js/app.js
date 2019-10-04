import Vue from 'vue'
import App from './component/master/App'
import Buefy from 'buefy'
import store from './store/store'

Vue.use(require('vue-moment'));
Vue.use(Buefy)


new Vue({
  el: '#app',
  store,
  render: (h) => h(App)
})