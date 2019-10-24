import * as type from './petugasTypeMutations'
const mutations = {
  [type.SET_DATA_PETUGAS](state, payload){
    state.dataPetugas = payload
  }
}

export default mutations