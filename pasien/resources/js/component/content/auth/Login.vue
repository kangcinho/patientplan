<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">Login</p>
    </header>
    <section class="modal-card-body">
      <div class="column">
        <b-field label="Username">
          <b-input></b-input>
        </b-field>
        <b-field label="Password">
          <b-input 
            type="password" 
            password-reveal
            icon-pack="fas"
            ></b-input>
        </b-field>
        <b-button
          type="is-primary"
          icon-pack="fas"
          icon-left="sign-in-alt"
          >
          Login
        </b-button>
      </div>
    </section>
  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>