import axios from 'axios'
import * as type from './authTypeMutations'

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