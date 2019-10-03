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
      <div class="panel-tab" style="margin-top:10px">
        <FormTambahPasienComponent></FormTambahPasienComponent>
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
    }
  },
  created(){
    console.log("TambahPasienComponent Created")
    this.$store.dispatch('getDataPasienFromSanata').then((respon) => {
      console.log("Fetch Data All Registrasi Done!")
    })
    this.$store.dispatch('getDataPetugasFromSanata').then((respon) => {
      console.log("Fetch Data All Petugas Done!")
    })
  },
}
</script>

<style>

</style>