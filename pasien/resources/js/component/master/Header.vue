<template>
  <b-navbar type="is-primary">
    <template slot="start">
        <b-navbar-item tag="router-link" :to="{ name: 'UserPage' }" >
          <b-icon 
            pack="fas"
            icon="users"
          ></b-icon>
        </b-navbar-item>
        <b-navbar-item tag="router-link" :to="{ name: 'LoginPageSecond' }">
            Login
        </b-navbar-item>
    </template>
  </b-navbar>
</template>

<script>
export default {
  name: "HeaderComponent"
}
</script>

<style>

</style>