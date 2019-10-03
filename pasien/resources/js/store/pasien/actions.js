import axios from 'axios'
import * as type from './type_mutations'

const actions = {
  getDataPasienFromSanata({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/getDataPasienFromSanata', ).then( (respon) => {
        commit(type.SET_DATA_PASIEN_REGISTRASI, respon.data)
      })
    })
  },
  saveDataPasienPulang( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/saveDataPasienPulang', data)
      .then( (respon) => {
        commit(type.ADD_DATA_PASIEN_PULANG_SAVE, respon.data)
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
      commit(type.ADD_DATA_PASIEN_PULANG, respon.data)
    })
  }
}

export default actions