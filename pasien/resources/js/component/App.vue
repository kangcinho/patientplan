<template>
  <div>
    <b-navbar type="is-primary">
      <template slot="start">
          <b-navbar-item href="#">
            <b-icon 
              pack="fas"
              icon="users"
            ></b-icon>
          </b-navbar-item>
          <b-navbar-item href="#">
              Login
          </b-navbar-item>
      </template>
    </b-navbar>
      <!-- <TambahPasienComponent></TambahPasienComponent>
      <TableComponent></TableComponent> -->
    <div class="columns">
      <div class="column container" style="margin-top: 5px">
        <TambahPasienComponent></TambahPasienComponent>
      </div>
    </div>
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