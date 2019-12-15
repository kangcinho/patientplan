<template>
  <div class="card" v-if="getDataUser != null">
    <div class="card-header" v-if="getDataUser.canInsert">
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
            <AddPasienPulang :dataMutu="dataMutu"></AddPasienPulang>
          </div>
        </b-collapse>
      </div>
    </div>
    <div class="card-content">
      <ListPasienPulang :dataMutu="dataMutu"></ListPasienPulang>
    </div>
  </div>
</template>

<script>
import AddPasienPulang from './AddPasienPulang'
import ListPasienPulang from './ListPasienPulang'
import EventBus from '../../../eventBus'
export default {
  name: "PasienMasterView",
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
  },
  computed:{
    getDataUser(){
      // console.log("akses")
      return this.$store.getters.getDataUserLogin
    },
    dataMutu(){
      return this.$store.getters.getMutu
    },
  }
}
</script>

<style>

</style>