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
    commit(type.SET_DATA_USER_LOGIN, null)
    commit(type.SET_DATA_USER_TOKEN, null)
  },
  logoutUser({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/logout')
      .then( (respon) => {
        commit(type.SET_DATA_USER_LOGIN, null)
        commit(type.SET_DATA_USER_TOKEN, null)
        berhasil('User LogOut')
      })
    })
  },
  getUserLogin({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/getUserLogin')
      .then( (respon) => {
        commit(type.SET_DATA_USER_LOGIN, respon.data.user)
        berhasil('User Login')
        // router.push({'name': 'PasienPage'})
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  }
}

export default actions