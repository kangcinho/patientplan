const getters = {
  getDataUser: (state) => {
    return state.dataUser.sort( (a,b) => {
      if(a.updated_at < b.updated_at){
        return 1
      }else if(a.updated_at > b.updated_at){
        return -1
      }
      return 0
    })
  },
  getDataUserTotal: (state) => state.dataUserTotal
}

export default getters