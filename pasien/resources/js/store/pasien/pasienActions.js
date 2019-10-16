import axios from 'axios'
import * as type from './pasienTypeMutations'

// axios.interceptors.response.use((respon) => {
//   if(respon.data.error == "Unauthorized"){
//     console.log('Intersepsion')
//     commit('SET_DATA_USER_LOGIN', null, {root: true})
//     commit('SET_DATA_USER_TOKEN', null, {root: true})
//     delete axios.defaults.headers.common['Authorization']
//   }
//   return respon
// })
const actions = {
  getDataPasienRegistrasiFromSanata({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/getDataPasienRegistrasiFromSanata' )
      .then( (respon) => {
        commit(type.SET_DATA_PASIEN_REGISTRASI, respon.data)
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  },
  saveDataPasienPulang( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/saveDataPasienPulang', data)
      .then( (respon) => {
        commit(type.ADD_DATA_PASIEN_PULANG, respon.data.dataPasien)
        if(respon.status == 200){
          berhasil(respon.data.status)
        }
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  },
  
  getDataPasienPulang( {commit}, data ){
    return new Promise( (berhasil, gagal) => {
      axios.post(`/api/getDataPasienPulang`, data)
      .then( (respon) => {
        commit(type.SET_DATA_PASIEN_PULANG, respon.data.dataPasien)
        commit(type.SET_DATA_TOTAL_PASIEN_PULANG, respon.data.totalDataPasien)
        berhasil('getDataPasienPulang berhasil')
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  },
  updateDataPasienPulang({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/updateDataPasienPulang', data)
      .then( (respon) => {
        if(respon.status == 200){
          commit(type.UPDATE_DATA_PASIEN_PULANG, respon.data.dataPasien)
          berhasil(respon.data.status)
        }
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  },
  deleteDataPasienPulang( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.get(`/api/deleteDataPasienPulang/${data.idPasien}`)
      .then( (respon) => {
        if(respon.status == 200){
          commit(type.DELETE_DATA_PASIEN_PULANG, data)
          berhasil(respon.data.status)
        }
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  },
  getDataExportPasienPulang( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/getDataExportPasienPulang', data)
      .then( (respon) => {
        commit(type.EXPORT_DATA_TO_EXCEL, respon.data.dataPasien)
        if(respon.data.dataPasien.length > 0){
          berhasil(respon.data.status)
        }else{
          berhasil("Data Riwayat Pulang Kosong, Tidak Ada Data Di Import")
        }
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  }
}

export default actions