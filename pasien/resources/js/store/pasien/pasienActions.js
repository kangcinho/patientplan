import axios from 'axios'
import * as type from './pasienTypeMutations'

const actions = {
  getDataPasienRegistrasiFromSanata({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/getDataPasienRegistrasiFromSanata', ).then( (respon) => {
        commit(type.SET_DATA_PASIEN_REGISTRASI, respon.data)
      })
    })
  },
  saveDataPasienPulang( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/saveDataPasienPulang', data)
      .then( (respon) => {
        commit(type.ADD_DATA_PASIEN_PULANG, respon.data)
        if(respon.status == 200){
          berhasil(`BERHASIL! Data ${respon.data.namaPasien} Berhasil Disimpan!`)
        }
      })
      .catch( (respon) => {
        gagal(`GAGAL! Data Sudah Ditemukan Di Database`)
      })      
    })
  },
  
  getDataPasienPulang( {commit} ){
    axios.get('/api/getDataPasienPulang')
    .then( (respon) => {
      commit(type.SET_DATA_PASIEN_PULANG, respon.data)
    })
  },
  updateDataPasienPulang({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/updateDataPasienPulang', data)
      .then( (respon) => {
        if(respon.status == 200){
          commit(type.UPDATE_DATA_PASIEN_PULANG, respon.data)
          berhasil(`Berhasil! Data ${respon.data.namaPasien} Berhasil DiUpdate!`)
        }
      })
      .catch( (respon) => {
        gagal(`Data Gagal Di Update`)
      })
    })
  }
}

export default actions