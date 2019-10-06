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
            <AddPasienPulang></AddPasienPulang>
          </div>
        </b-collapse>
      </div>
    </div>
    <div class="card-content">
      <ListPasienPulang></ListPasienPulang>
    </div>
  </div>
</template>

<script>
import AddPasienPulang from '../content/pasienPulang/AddPasienPulang'
import ListPasienPulang from '../content/pasienPulang/ListPasienPulang'
import EventBus from '../../eventBus'
export default {
  name:"ContentComponent",
  data(){
    return {
      isOpenFormTambahRiwayatPasienPulang: false
    }
  },
  components:{
    AddPasienPulang,
    ListPasienPulang
  },
  created(){
    this.$store.dispatch('getDataPasienRegistrasiFromSanata')
    this.$store.dispatch('getDataPetugasFromSanata')
    EventBus.$on('expandForm', () => { this.isOpenFormTambahRiwayatPasienPulang = false })
  }
}
</script>

<style>

</style>