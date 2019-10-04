import state from './petugasState'
import actions from './petugasActions'
import getters from './petugasGetters'
import mutations from './petugasMutations'

const store = {
  state,
  mutations,
  actions,
  getters
}

export default store