import * as type from './type_mutations'
const mutations = {
  [type.SET_DATA_PETUGAS](state, payload){
    state.dataPetugasAll = payload
  }
}

export default mutations