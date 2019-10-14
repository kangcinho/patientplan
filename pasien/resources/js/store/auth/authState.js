const state = {
  dataUserLogin: JSON.parse(localStorage.getItem('userData')),
  token: localStorage.getItem('token')
}

export default state

