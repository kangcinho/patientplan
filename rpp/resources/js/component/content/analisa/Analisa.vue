<template>
  <div class="columns is-centered is-multiline">
    <AnalisaNavigate/>
    <AnalisaResult/>
  </div>
</template>

<script>
import AnalisaNavigate from './AnalisaNavigate'
import AnalisaResult from './AnalisaResult'
export default {
  name: "AnalisaMasterView",
  components:{
    AnalisaNavigate,
    AnalisaResult
  },
  created(){
    this.$store.dispatch('clearAnalisa')
  }
}
</script>

<style>

</style>