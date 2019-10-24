import state from './userState'
import actions from './userActions'
import getters from './userGetters'
import mutations from './userMutations'

const store = {
  state,
  mutations,
  actions,
  getters
}

export default store