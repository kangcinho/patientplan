<template>
  <div class="columns is-multiline">
    <div class="container">
      <div class="column is-full">
        <TambahPasienComponent></TambahPasienComponent>
      </div>
    </div>
    
  </div>
</template>

<script>
import TambahPasienComponent from './pasien/TambahPasienComponent'
export default {
  name: 'AppComponent',
  components:{
    TambahPasienComponent
  },
}
</script>

<style>

</style>