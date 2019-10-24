import * as type from './authTypeMutations'
const mutations = {
  [type.SET_DATA_USER_LOGIN](state, payload){
    state.dataUserLogin =  payload
    // localStorage.setItem('userData', JSON.stringify(payload))
  },
  [type.SET_DATA_USER_TOKEN](state, payload){
    state.token = payload
    localStorage.setItem('token', payload)
  }
}

export default mutations