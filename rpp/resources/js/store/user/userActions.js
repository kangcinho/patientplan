import axios from 'axios'
import * as type from './userTypeMutations'

const actions = {
  getDataUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post(`/api/getDataUser`, data)
      .then( (respon) => {
        commit(type.SET_DATA_USER, respon.data.users)
        commit(type.SET_DATA_USER_TOTAL, respon.data.totalUser)
        berhasil("hore berhasil")
      })
      .catch( (error) => {
        gagal(error.response.data.error)
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
      .catch( (error) => {
        gagal(error.response.data.error)
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
      .catch( (error) => {
        gagal(error.response.data.error)
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
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    })
  },
}

export default actions