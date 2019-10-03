<template>
  <div class="columns is-multiline">
    <div class="container">
      <div class="column is-full">
        <TambahPasienComponent></TambahPasienComponent>
      </div>
    </div>
    <TableComponent></TableComponent>
  </div>
</template>

<script>
import TambahPasienComponent from './pasien/TambahPasienComponent'
import TableComponent from './table/TableComponent'
export default {
  name: 'AppComponent',
  data(){
    return {

    }
  },
  components:{
    TambahPasienComponent,
    TableComponent
  },
  created(){
    console.log("APP Created")
  }
}
</script>

<style>

</style>