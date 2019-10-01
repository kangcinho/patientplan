<template>
  <b-collapse
    class="panel"
    :open.sync="isOpenFormTambahRiwayatPasienPulang">
    <div
      slot="trigger"
      class="panel-heading"
      role="button">
      <strong>
        <b-icon pack="fas" icon="plus"></b-icon>
        Daftar Riwayat Pasien Pulang
      </strong>
    </div>
    <div class="panel-tab">
      <FormTambahPasienComponent :dataPetugas="dataPetugas"></FormTambahPasienComponent>
    </div>
  </b-collapse>
</template>

<script>
import FormTambahPasienComponent from './FormTambahPasienComponent'
export default {
  name: "TambahPasienComponent",
  components:{
    FormTambahPasienComponent
  },
  data(){
    return {
      isOpenFormTambahRiwayatPasienPulang: false,
      dataPetugas: [
        'Angular',
        'Angular 2',
        'Aurelia',
        'Backbone',
        'Ember',
        'jQuery',
        'Meteor',
        'Node.js',
        'Polymer',
        'React',
        'RxJS',
        'Vue.js'
      ]
    }
  },
  
}
</script>

<style>

</style>