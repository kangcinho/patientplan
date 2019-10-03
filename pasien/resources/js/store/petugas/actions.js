import axios from 'axios'
import * as type from './type_mutations'

const actions = {
  getDataPetugasFromSanata({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get(`/api/getDataPetugasFromSanata`, ).then( (respon) => {
        commit(type.SET_DATA_PETUGAS, respon.data)
      })
    }) 
  }
}

export default actions