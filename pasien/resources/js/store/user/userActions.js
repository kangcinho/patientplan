import axios from 'axios'
import * as type from './userTypeMutations'

const actions = {
  getDataUser({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get(`/api/getDataUser`, ).then( (respon) => {
        commit(type.SET_DATA_USER, respon.data)
      })
    })
  },
  saveDataUser( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/saveDataUser', data)
      .then( (respon) => {
        commit(type.ADD_DATA_USER, respon.data)
        berhasil(`Data User ${data.namaUser} Berhasil Disimpan!`)
      })
      .catch( (respon) => {
        gagal(`Data User ${data.namaUser} Gagal Disimpan!`)
      })
    })
  },
  updateDataUser( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/updateDataUser', data)
      .then( (respon) => {
        commit(type.UPDATE_DATA_USER, respon.data)
        berhasil(`Data User ${data.namaUser} Berhasil Disimpan!`)
      })
      .catch( (respon) => {
        gagal(`Data User ${data.namaUser} Gagal Disimpan!`)
      })
    })
  },
  deleteDataUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.get(`/api/deleteDataUser/${data.idUser}`)
      .then( (respon) => {
        commit(type.DELETE_DATA_USER, data)
        berhasil(`Data User ${data.namaUser} Berhasil Dihapus!`)
      })
      .catch( (respon) => {
        gagal(`Data User ${data.namaUser} Gagal Disimpan!`)
      })
    })
  }
}

export default actions