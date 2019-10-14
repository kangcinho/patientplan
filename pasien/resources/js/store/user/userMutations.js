import * as type from './userTypeMutations'
const mutations = {
  [type.SET_DATA_USER](state, payload){
    state.dataUser = payload
  },
  [type.ADD_DATA_USER](state, payload){
    state.dataUser.push(payload)
  },
  [type.UPDATE_DATA_USER](state, payload){
    state.dataUser.map( (user) => {
      if(user.idUser === payload.idUser){
        user.username = payload.username
        user.namaUser = payload.namaUser
        user.email = payload.email
        user.canInsert = payload.canInsert
        user.canUpdate = payload.canUpdate
        user.canDelete = payload.canDelete
        user.canAdmin = payload.canAdmin
        user.canEkspor = payload.canEkspor
      }
    })
  },
  [type.DELETE_DATA_USER](state, payload){
    state.dataUser.map( (user, index) => {
      if(user.idUser === payload.idUser){
        state.dataUser.splice(index, 1)
      }
    })
  },
  [type.SET_DATA_USER_TOTAL](state,payload){
    state.dataUserTotal = payload
  }
}

export default mutations