import state from './authState'
import actions from './authActions'
import getters from './authGetters'
import mutations from './authMutations'

const store = {
  state,
  mutations,
  actions,
  getters
}

export default store