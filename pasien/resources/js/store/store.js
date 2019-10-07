import Vue from 'vue'
import Vuex from 'vuex'
import pasien from './pasien/pasien'
import petugas from './petugas/petugas'
import user from './user/user'
Vue.use(Vuex)

export default new Vuex.Store({
  modules:{
    pasien,
    petugas,
    user
  }
})
