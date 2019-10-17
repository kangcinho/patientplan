import axios from 'axios'
import * as type from './authTypeMutations'
import store from '../store'
import router from '../../router'

axios.interceptors.response.use((respon) => {
  if(respon.data.error == "Unauthorized"){
    console.log('Intersepsion')
    store.dispatch('tokenExpr')
    delete axios.defaults.headers.common['Authorization']
    router.push({'name': 'LoginPageSecond'})
    return 
  }
  return respon
})

const actions = {
  loginUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/login', data)
      .then( (respon) => {
        commit(type.SET_DATA_USER_LOGIN, respon.data.user)
        commit(type.SET_DATA_USER_TOKEN, respon.data.token)
        axios.defaults.headers.common = {
          'Authorization': 'Bearer '+ respon.data.token,
        }
        berhasil("User Login")
      })
      .catch( (respon) => {
        gagal("Username / Password Salah")
      })
    })
  },
  tokenExpr({commit}){
    // return new Promise( (berhasil, gagal) => {
      // axios.get('/api/logout')
      // .then( (respon) => {
        commit(type.SET_DATA_USER_LOGIN, null)
        commit(type.SET_DATA_USER_TOKEN, null)
        // berhasil('Login User Sudah Mencapai Batas, Login Lagi Ya..')
      // })
    // })
  },
  logoutUser({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/logout')
      .then( (respon) => {
        commit(type.SET_DATA_USER_LOGIN, respon.data.user)
        commit(type.SET_DATA_USER_TOKEN, respon.data.token)
        berhasil('User LogOut')
      })
    })
  }
}

export default actions