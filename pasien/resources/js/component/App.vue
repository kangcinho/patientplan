<template>
  <div class="columns is-multiline">
    <div class="container">
      <div class="column is-full">
        <TambahPasienComponent></TambahPasienComponent>
        {{ dataPasienAll }}
      </div>
    </div>
    
  </div>
</template>

<script>
import TambahPasienComponent from './pasien/TambahPasienComponent'
export default {
  name: 'AppComponent',
  data(){
    return {
      // dataPasienAll: ''
    }
  },
  components:{
    TambahPasienComponent
  },
  created(){
    this.$store.dispatch('setDataPasienAll').then((respon) => {
      // this.dataPasienAll =  this.$store.getters.getPasienAll
    })
  },
  computed:{
    dataPasienAll(){
      return this.$store.getters.getPasienAll
    }
  }
}
</script>

<style>

</style>