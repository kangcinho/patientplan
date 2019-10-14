const getters = {
  getAuth: (state) => { 
    return state.token != null && state.token != '' && state.token != 'null'
  },
  getDataUserLogin: (state) => state.dataUserLogin
}

export default getters