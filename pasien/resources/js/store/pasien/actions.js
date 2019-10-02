import axios from 'axios'
import * as type from './type_mutations'

const actions = {
  setDataPasienAll({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get(`/api/getPasien`, ).then( (respon) => {
        commit(type.SET_DATA_PASIEN_ALL, respon.data)
      })
    }) 
  }
}

export default actions