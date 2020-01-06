import axios from 'axios'
import * as type from './analisaTypeMutations'

const actions = {
  analisa({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/analisa', data)
      .then( (respon) => {
        commit(type.SET_DATA_ANALISA, respon.data.tabelAnalisa)
        berhasil(respon.data.status)
      })
      .catch( (respon) => {
        gagal("GAGAL Request Data Analisa")
      })
    })
  },
  clearAnalisa({commit}){
    commit(type.SET_DATA_ANALISA, [])
  }
}

export default actions