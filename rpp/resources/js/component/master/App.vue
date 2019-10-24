<template>
  <div>
      <Header></Header>
      <router-view></router-view>
  </div>
</template>

<script>
import Header from './Header'
export default {
  name: 'AppComponent',
  components:{
    Header,
  },
  computed:{
    isAuth(){
      return this.$store.getters.getAuth
    }
  },
  created(){
    this.$store.dispatch('getUserLogin')
    .then( (respon) => {
      
    })
    .catch( (respon) => {

    })
  }
}
</script>

<style>

</style>