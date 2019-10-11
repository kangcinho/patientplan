import axios from 'axios'
import * as type from './userTypeMutations'

const actions = {
  getDataUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post(`/api/getDataUser`, data).then( (respon) => {
        commit(type.SET_DATA_USER, respon.data.users)
        commit(type.SET_DATA_USER_TOTAL, respon.data.totalUser)
        berhasil("hore berhasil")
      })
    })
  },
  saveDataUser( {commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/saveDataUser', data)
      .then( (respon) => {
        commit(type.ADD_DATA_USER, respon.data.user)
        berhasil(respon.data.status)
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
        commit(type.UPDATE_DATA_USER, respon.data.user)
        berhasil(respon.data.status)
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
        berhasil(respon.data.status)
      })
      .catch( (respon) => {
        gagal(`Data User ${data.namaUser} Gagal Disimpan!`)
      })
    })
  },
}

export default actions