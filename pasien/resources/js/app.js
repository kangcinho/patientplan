import Vue from 'vue'
import App from './component/App'
import Buefy from 'buefy'

Vue.use(Buefy)

new Vue({
  el: '#app',
  render: (h) => h(App)
})