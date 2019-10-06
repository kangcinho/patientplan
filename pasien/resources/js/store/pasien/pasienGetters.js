const getters = {
  getPasienRegistrasi: (state) => state.dataPasienRegistrasi,
  getPasienPulang: (state) => {
    return state.dataPasienPulang.sort( (a,b) => {
      if(a.tanggal < b.tanggal){
        return 1
      }else if(a.tanggal > b.tanggal){
        return -1
      }
      return 0
    })
  },
  getTotalPasienPulang: (state) => state.totalPasienPulang
}

export default getters