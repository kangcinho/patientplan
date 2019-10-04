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
      }
    })
  }
}

export default mutations