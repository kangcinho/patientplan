import * as type from './authtypeMutations'
const mutations = {
  [type.SET_DATA_USER_LOGIN](state, payload){
    state.dataUserLogin =  payload
  },
}

export default mutations