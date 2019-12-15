import Vue from 'vue'
import Vuex from 'vuex'
import pasien from './pasien/pasien'
import petugas from './petugas/petugas'
import user from './user/user'
import auth from './auth/auth'
import analisa from './analisa/analisa'
Vue.use(Vuex)

export default new Vuex.Store({
  modules:{
    pasien,
    petugas,
    user,
    auth,
    analisa
  }
})
