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
  }
}
</script>

<style>

</style>