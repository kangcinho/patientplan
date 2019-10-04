<template>
  <div>
      <Header></Header>
      <Content></Content>
  </div>

</template>

<script>
import Header from './Header'
import Content from './Content'
export default {
  name: 'AppComponent',
  components:{
    Header,
    Content
  }
}
</script>

<style>

</style>