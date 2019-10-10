import * as type from './pasienTypeMutations'
const mutations = {
  [type.SET_DATA_PASIEN_REGISTRASI](state, payload){
    state.dataPasienRegistrasi = payload
  },
  [type.SET_DATA_PASIEN_PULANG](state, payload){
    state.dataPasienPulang = payload
  },
  [type.ADD_DATA_PASIEN_PULANG](state, payload){
    state.dataPasienPulang.push(payload)
    state.dataPasienRegistrasi.map( (data) => {
      if(data.noReg == payload.noReg){
        data.isDone = true
      }
    })
  },
  [type.UPDATE_DATA_PASIEN_PULANG](state, payload){
    state.dataPasienPulang.map( (dataPasien) => {
      if(dataPasien.idPasien === payload.idPasien){
        dataPasien.waktuVerif = payload.waktuVerif
        dataPasien.waktuIKS = payload.waktuIKS
        dataPasien.waktuSelesai = payload.waktuSelesai
        dataPasien.waktuPasien = payload.waktuPasien
        dataPasien.waktuLunas = payload.waktuLunas
        dataPasien.petugasFO = payload.petugasFO
        dataPasien.petugasPerawat = payload.petugasPerawat
        dataPasien.isTerencana = payload.isTerencana
      }
    })
  },
  [type.SET_DATA_TOTAL_PASIEN_PULANG](state, payload){
    state.totalPasienPulang = payload
  },
  [type.DELETE_DATA_PASIEN_PULANG](state, payload){
    state.dataPasienPulang.map( (dataPasien, index) => {
      if(dataPasien.idPasien == payload.idPasien){
        state.dataPasienPulang.splice(index, 1)
      }
    })
  },
  [type.EXPORT_DATA_TO_EXCEL](state, payload){
    state.dataExportPasienPulang = payload
  }
}

export default mutations