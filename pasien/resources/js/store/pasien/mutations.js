import * as type from './type_mutations'
const mutations = {
  [type.SET_DATA_PASIEN_ALL](state, payload){
    state.dataPasienAll = payload
  }
}

export default mutations