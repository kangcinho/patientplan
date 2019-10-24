<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">Login</p>
    </header>
    <section class="modal-card-body">
      <div class="column">
        <b-field label="Username"
          :type="errorLogin.usernameError?'is-danger':''"
          :message="errorLogin.usernameMessage">
          <b-input v-model="login.username"></b-input>
        </b-field>
        <b-field label="Password" 
          :type="errorLogin.passwordError?'is-danger':''"
          :message="errorLogin.passwordMessage">
          <b-input 
            v-model="login.password"
            type="password" 
            password-reveal
            icon-pack="fas"
            @keyup.native.enter="loginUser"
            ></b-input>
        </b-field>
        <b-button
          type="is-primary"
          icon-pack="fas"
          icon-left="sign-in-alt"
          @click="loginUser"
          >
          Login
        </b-button>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'LoginPage',
  data(){
    return {
      login:{
        username: null,
        password: null
      },
      errorLogin:{
        usernameError: false,
        usernameMessage: null,
        passwordError: false,
        passwordMessage: null
      }
    }
  },
  methods:{
    loginUser(){
      if(this.validasiLogin()){
        this.$store.dispatch('loginUser', this.login)
        .then( (respon) => {
          this.clearField()
          this.$buefy.notification.open({
            message: respon,
            type: 'is-info',
          })
          this.$router.push({'name': 'PasienPage'})
        })
        .catch( (respon) => {
          this.$buefy.notification.open({
            message: respon,
            type: 'is-danger',
          })
        })
      }
    },
    validasiLogin(){
      if(this.login.username == '' || this.login.username == null){
        this.errorLogin.usernameError = true
        this.errorLogin.usernameMessage = "Cukup Hatiku Sayang Kosong, Username jangan.."
        return false
      }else{
        this.errorLogin.usernameError = false
        this.errorLogin.usernameMessage = null
      }
      if(this.login.password == '' || this.login.password == null){
        this.errorLogin.passwordError = true
        this.errorLogin.passwordMessage = "Berat Jika Hati ini Kosong, Begitu Juga Jika Password ini"
        return false
      }else{
        this.errorLogin.passwordError = false
        this.errorLogin.passwordMessage = null
      }
      return true
    },
    clearField(){
      this.errorLogin.passwordError = this.errorLogin.usernameError = false
      this.errorLogin.passwordMessage = this.errorLogin.usernameMessage = this.login.username = this.login.password = null
    }
  }
}
</script>

<style>

</style>