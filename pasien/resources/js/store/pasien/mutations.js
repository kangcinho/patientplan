import * as type from './type_mutations'
const mutations = {
  [type.SET_DATA_PASIEN_REGISTRASI](state, payload){
    state.dataPasienRegistrasi = payload
  },
  [type.ADD_DATA_PASIEN_PULANG](state, payload){
    state.dataPasienPulang = payload
  },
  [type.ADD_DATA_PASIEN_PULANG_SAVE](state, payload){
    state.dataPasienPulang.push(payload)
  }
}

export default mutations