<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">Login</p>
    </header>
    <section class="modal-card-body">
      <div class="column">
        <b-field label="Username">
          <b-input v-model="login.username"></b-input>
        </b-field>
        <b-field label="Password">
          <b-input 
            v-model="login.password"
            type="password" 
            password-reveal
            icon-pack="fas"
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
      }
    }
  },
  methods:{
    loginUser(){
      this.$store.dispatch('loginUser', this.login)
      .then( (respon) => {
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
  }
}
</script>

<style>

</style>