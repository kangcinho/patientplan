<template>
  <div>
    {{ dataPasienPulang }}
  </div>
</template>

<script>
export default {
  name: 'TableComponent',
  data(){
    return {

    }
  },
  created(){
    this.$store.dispatch('getDataPasienPulang')
    console.log("TableComponent Created")
  },
  computed:{
    dataPasienPulang(){
      return this.$store.getters.getPasienPulan
    }
  }
}
</script>

<style>

</style>