<template>
  <b-navbar type="is-primary">
    <template slot="start" v-if="getDataUser != null">
        <b-navbar-item v-if="isAuth && getDataUser.canAdmin" tag="router-link" :to="{ name: 'UserPage' }" >
          <b-icon 
            pack="fas"
            icon="users"
          ></b-icon>
        </b-navbar-item>
        <b-navbar-item v-if="isAuth"  tag="router-link" :to="{ name: 'PasienPage' }" >
          Pasien
        </b-navbar-item>
        <b-navbar-item v-if="isAuth && getDataUser.canEkspor"  tag="router-link" :to="{ name: 'AnalisaPage' }" >
          Analisa
        </b-navbar-item>
        <b-navbar-item v-if="!isAuth" tag="router-link" :to="{ name: 'LoginPageSecond' }">
          Login
        </b-navbar-item>
        <b-navbar-item v-else @click.native="logout">
          Logout
        </b-navbar-item>
    </template>
    <template slot="end">
      <b-navbar-item v-if="getDataUser != null">
        Welcome, {{getDataUser.namaUser}}
      </b-navbar-item>
    </template>
  </b-navbar>
</template>

<script>
export default {
  name: "HeaderComponent",
  computed:{
    isAuth(){
      return this.$store.getters.getAuth
    },
    getDataUser(){
      return this.$store.getters.getDataUserLogin
    }
  },
  methods:{
    logout(){
      this.$store.dispatch('logoutUser')
      .then( (respon) => {
        this.$buefy.notification.open({
          message: respon,
          type: 'is-info',
        })
        this.$router.push({'name': 'LoginPageSecond'})
      })
    }
  }
}
</script>

<style>

</style>