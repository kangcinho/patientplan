<template>
  <div>
      <Header></Header>
      <router-view></router-view>
  </div>
</template>

<script>
import Header from './Header'
import Content from './Content'
import ListUser from '../content/user/ListUser'
export default {
  name: 'AppComponent',
  components:{
    Header,
    Content,
    ListUser
  },
  computed:{
    isAuth(){
      return this.$store.getters.getAuth
    }
  },
  created(){
    // if(this.isAuth){
      // this.$router.push({ 'name': PasienPage})
    // }
  }
}
</script>

<style>

</style>