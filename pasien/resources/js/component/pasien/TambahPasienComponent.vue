<template>
  <div class="card">
    <div class="card-header">
      <div class="card-header-title is-centered ">
        <b-collapse
          class="panel"
          style="width: 100%"
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
      </div>
    </div>
    <div class="card-content">
      <div class="media">
        <div class="media-left">
          <figure class="image is-48x48">
            <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
          </figure>
        </div>
        <div class="media-content">
          <p class="title is-4">John Smith</p>
          <p class="subtitle is-6">@johnsmith</p>
        </div>
      </div>

      <div class="content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Phasellus nec iaculis mauris. <a>@bulmaio</a>.
        <a href="#">#css</a> <a href="#">#responsive</a>
        <br>
        <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
      </div>
    </div>
  </div>
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