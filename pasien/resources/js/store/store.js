import Vue from 'vue'
import Vuex from 'vuex'
import pasien from './pasien/pasien'
Vue.use(Vuex)

export default new Vuex.Store({
  modules:{
    pasien
  }
})
