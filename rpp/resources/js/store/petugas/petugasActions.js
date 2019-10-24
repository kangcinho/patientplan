import axios from 'axios'
import * as type from './petugasTypeMutations'

const actions = {
  getDataPetugasFromSanata({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get(`/api/getDataPetugasFromSanata`, )
      .then( (respon) => {
        commit(type.SET_DATA_PETUGAS, respon.data)
      })
      .catch( (error) => {
        gagal(error.response.data.error)
      })
    }) 
  }
}

export default actions