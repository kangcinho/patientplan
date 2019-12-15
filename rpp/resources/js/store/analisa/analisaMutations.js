import * as type from './analisaTypeMutations'
const mutations = {
  [type.SET_DATA_ANALISA](state, payload){
    state.tabelAnalisa =  payload
  },
}

export default mutations