import axios from 'axios'
import * as type from './authtypeMutations'

const actions = {
  loginUser({commit}, data){
    axios.post('/api/login', data)
    .then( (respon) => {
      commit(type.SET_DATA_USER_LOGIN, data)
      console.log("Berhasil")
    })
    .catch( (respon) => {
      console.log(respon)
    })
  }
}

export default actions