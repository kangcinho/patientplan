<template>
  <div class="columns is-multiline">
    <div class="column is-full">
      <b-input
        rounded
        icon-pack="fas"
        icon="search" 
        placeholder="Cari Nama Pasien Pulang"
        v-model="searchNamaPasien"
        @keyup.native.enter="searchNamaPasienToDB"
      >
      </b-input>
    </div>
    <div class="column">
      <table class="table is-bordered is-striped is-narrow" style="width:100%; font-size:11.5px">
        <thead>
          <tr>
            <th rowspan="2" class="has-text-centered width25">Tgl Pulang</th>
            <th rowspan="2" class="has-text-centered width11">Kmr</th>
            <th rowspan="2" class="has-text-centered" :class="classWidthRow">Nama Pasien</th>
            <th colspan="5" class="has-text-centered">Waktu Konfirmasi</th>
            <th colspan="2" class="has-text-centered">Petugas Jaga</th>
            <th rowspan="2" class="has-text-centered" :class="classWidthRow">Keterangan</th>
            <th rowspan="2" class="has-text-centered width30">Action</th>
          </tr>
        <tr>
          <th class="has-text-centered width25">Verif</th>
          <th class="has-text-centered width25">IKS</th>
          <th class="has-text-centered width25">Selesai</th>
          <th class="has-text-centered width25">Pasien</th>
          <th class="has-text-centered width25">Lunas</th>
          <th class="has-text-centered">FO</th>
          <th class="has-text-centered">Perawat</th>
        </tr>
        </thead>
        <tbody v-if="getPasienPulang.length > 0">
          <tr v-for="pasien in getPasienPulang" :key="pasien.idPasien">
            <td class="has-text-centered width25">{{ pasien.tanggal | moment("DD MMM YYYY") }}</td>
            <td class="has-text-centered width11">{{ pasien.kamar }}</td>
            <td class="has-text-centered" :class="classWidthRow">{{ pasien.namaPasien }}</td>
            <td class="has-text-centered width25">
              <span v-if="!pasien.isEdit">{{ pasien.waktuVerif | showOnlyTime }}</span>
              <span v-else>
                <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuVerif"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">
                </b-clockpicker>
              </span>
            </td>
            <td class="has-text-centered width25">
              <span v-if="!pasien.isEdit">{{ pasien.waktuIKS | showOnlyTime }}</span>
              <span v-else>
                <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuIKS"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">
                </b-clockpicker>
              </span>
              
            </td>
            <td class="has-text-centered width25">
              <span v-if="!pasien.isEdit">{{ pasien.waktuSelesai | showOnlyTime }}</span>
              <span v-else>
                <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuSelesai"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">
                </b-clockpicker>
              </span>
            </td>
            <td class="has-text-centered width25">
              <span v-if="!pasien.isEdit">{{ pasien.waktuPasien | showOnlyTime }}</span>
              <span v-else>
                <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuPasien"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">
                </b-clockpicker>
              </span>             
            </td>
            <td class="has-text-centered width25">
              <span v-if="!pasien.isEdit">{{ pasien.waktuLunas | showOnlyTime }}</span>
              <span v-else>
                <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuLunas"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">
                </b-clockpicker>
              </span>                
            </td>
            <td class="has-text-centered width60">
              <span v-if="!pasien.isEdit">{{ pasien.petugasFO }}</span>
              <span v-else>
                <b-autocomplete
                    rounded
                    size="is-small"
                    v-model="dataPasienPulang.petugasFO"
                    :data="filterDataPetugasFO"
                    placeholder="Cari Nama Petugas FO"
                    icon-pack="fas"
                    icon="search"
                    field="namaCustomer"
                    @select="option => selected = option">
                    <template slot="empty">Tidak ditemukan Nama Petugas FO</template>
                </b-autocomplete>
              </span>
            </td>
            <td class="has-text-centered width60">
              <span v-if="!pasien.isEdit">{{ pasien.petugasPerawat }}</span>
              <span v-else>
                <b-autocomplete
                  rounded
                  size="is-small"
                  v-model="dataPasienPulang.petugasPerawat"
                  :data="filterDataPetugasPerawat"
                  placeholder="Cari Nama Petugas Perawat"
                  icon-pack="fas"
                  icon="search"
                  field="namaCustomer"
                  @select="option => selected = option">
                  <template slot="empty">Tidak ditemukan Nama Petugas Perawat </template>
                </b-autocomplete>
              </span>
            </td>
            <td class="has-text-centered" :class="classWidthRow">{{ pasien.keterangan }}</td>
            <td class="has-text-centered width30">
              <b-button 
                type="is-info"
                size="is-small"
                icon-pack="fas"
                icon-right="edit" 
                v-if="!pasien.isEdit"
                title="Edit Data Pasien"
                @click="changeToEditMode(pasien, true)"/>
              <b-button 
                type="is-info"
                size="is-small"
                icon-pack="fas"
                icon-right="save" 
                v-if="pasien.isEdit"
                title="Save Data Pasien"
                @click="updateDataPasien(pasien)"/>
              <b-button 
                type="is-warning"
                size="is-small"
                icon-pack="fas"
                icon-right="ban"
                v-if="pasien.isEdit"
                title="Batal Edit Data Pasien"
                @click="changeToEditMode(pasien, false)"/>
              <b-button
                type="is-danger" 
                size="is-small"
                icon-pack="fas"
                icon-right="trash-alt" 
                @click="deleteDataPasienPulang(pasien)"/>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="12">
              <section class="section">
                <div class="content has-text-grey has-text-centered">
                  <p>
                    <b-icon
                      pack="fas"
                      icon="sad-cry"
                      size="is-large">
                    </b-icon>
                  </p>
                  <p>Tidak Ada Data Pasien</p>
                </div>
              </section>
            </td>
          </tr>
        </tbody>
      </table>
      <b-pagination
        icon-pack="fas"
        :total="pagging.total"
        :current.sync="pagging.current"
        :range-before="pagging.rangeBefore"
        :range-after="pagging.rangeAfter"
        :per-page="pagging.perPage"
        rounded
        icon-prev="chevron-left"
        icon-next="chevron-right"
        aria-next-label="Next page"
        aria-previous-label="Previous page"
        aria-page-label="Page"
        aria-current-label="Current page">
      </b-pagination>
    </div>

    <!-- <b-modal :active.sync="isModalKonfirmasiHapusData" >
      <ModalKonfirmasiHapusData></ModalKonfirmasiHapusData>
    </b-modal> -->
  </div>
</template>

<script>
import ModalKonfirmasiHapusData from '../modal/ModalKonfirmasiHapusData'
export default {
  name: "ListPasienPulang",
  components:{
    ModalKonfirmasiHapusData
  },
  data(){
    return {
      dataPasienPulang:{
        idPasien:'',
        tanggal: null,
        noreg:'',
        nrm:'',
        namaPasien:'',
        kamar:'',
        waktuVerif: null,
        waktuIKS:null,
        waktuSelesai:null,
        waktuPasien:null,
        waktuLunas:null,
        petugasFO:'',
        petugasPerawat:'',
        keterangan:'',
      },
      disableEdit: false,
      classWidthRow: 'width60',
      pagging:{
        total: 0,
        current: 1,
        perPage: 8,
        rangeBefore: 2,
        rangeAfter: 2
      },
      searchNamaPasien: '',
      isModalKonfirmasiHapusData: false,
    }
  },
  computed:{
    getPasienPulang(){
      return this.$store.getters.getPasienPulang
    },
    dataPetugas(){
      return this.$store.getters.getDataPetugas
    },
    filterDataPetugasFO(){
      return this.dataPetugas.filter( (petugas) => {
        return petugas.namaCustomer
          .toString()
          .toLowerCase()
          .indexOf(this.dataPasienPulang.petugasFO.toLowerCase()) >= 0
      })
    },
    filterDataPetugasPerawat(){
      return this.dataPetugas.filter( (petugas) => {
        return petugas.namaCustomer
          .toString()
          .toLowerCase()
          .indexOf(this.dataPasienPulang.petugasPerawat.toLowerCase()) >= 0
      })
    }
  },
  watch:{
    'pagging.current'(newVal, oldVal){
      let firstPage,lastPage      
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      // console.log(firstPage,lastPage)
      this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien})
      .then( (respon) => {
        this.pagging.total =  this.$store.getters.getTotalPasienPulang
      })
    },
  },
  methods:{
    changeToEditMode(dataPasien, mode){
       //Can Edit Only One Field Live
      if(mode){
        this.fillData(dataPasien)
        this.classWidthRow = 'width25'
      }else{
        this.hapusFieldAll()
        this.classWidthRow = 'width60'
        this.disableEdit = false
      }
      if(!this.disableEdit){
        this.getPasienPulang.map( (pasien) => {
          if(pasien.idPasien === dataPasien.idPasien){
            pasien.isEdit = mode
            if(mode){
              this.disableEdit = true
            }
          }
        })
      }
    },
    updateDataPasien(dataPasien){
      dataPasien.isEdit = false
      this.disableEdit = false
      this.dataPasienPulang.noreg = dataPasien.noreg
      this.dataPasienPulang.idPasien = dataPasien.idPasien
      
      this.$store.dispatch('updateDataPasienPulang', this.dataPasienPulang)
      .then( (respon) => {
        this.hapusFieldAll()
        this.$buefy.notification.open({
          message: respon,
          type: 'is-success'
        })
      })
      .catch( (respon) => {
        this.$buefy.notification.open({
          message: respon,
          type: 'is-danger',
        })
      })
    },
    searchPetugas(namaPetugas){
      return this.dataPetugas.filter( (petugas) => {
        return petugas.namaCustomer
          .toString()
          .toLowerCase()
          .indexOf(namaPetugas.toLowerCase()) >= 0
      })
    },
    hapusFieldAll(){
      this.dataPasienPulang.tanggal= null
      this.dataPasienPulang.noreg = this.dataPasienPulang.nrm = this.dataPasienPulang.namaPasien = this.dataPasienPulang.kamar = this.dataPasienPulang.petugasFO = this.dataPasienPulang.petugasPerawat = this.dataPasienPulang.keterangan = ''
      this.dataPasienPulang.waktuVerif = this.dataPasienPulang.waktuIKS = this.dataPasienPulang.waktuSelesai = this.dataPasienPulang.waktuPasien = this.dataPasienPulang.waktuLunas = null
      this.dataPasienPulang.isWaktu = this.isComponentModal = false
    },
    fillData(data){
      if(data.waktuVerif != null){
        const time = new Date(Date.parse(data.waktuVerif))
        this.dataPasienPulang.waktuVerif = time
      }
      if(data.waktuSelesai != null){
        const time = new Date(Date.parse(data.waktuSelesai))
        this.dataPasienPulang.waktuSelesai = time
      }
      if(data.waktuIKS != null){
        const time = new Date(Date.parse(data.waktuIKS))
        this.dataPasienPulang.waktuIKS = time
      }
      if(data.waktuPasien != null){
        const time = new Date(Date.parse(data.waktuPasien))
        this.dataPasienPulang.waktuPasien = time
      }
      if(data.waktuLunas != null){
        const time = new Date(Date.parse(data.waktuLunas))
        this.dataPasienPulang.waktuLunas = time
      }
      if(data.petugasFO != null){
        this.dataPasienPulang.petugasFO = data.petugasFO
      }
      if(data.petugasPerawat != null){
        this.dataPasienPulang.petugasPerawat = data.petugasPerawat
      }
    },
    searchNamaPasienToDB(){
      let firstPage,lastPage
      firstPage = 0
      lastPage = this.pagging.perPage
      this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien})
      .then( (respon) => {
        this.pagging.total =  this.$store.getters.getTotalPasienPulang
        this.pagging.current = 1
      })
    },
    deleteDataPasienPulang(dataPasien){
      this.$buefy.modal.open({
        parent: this,
        component: ModalKonfirmasiHapusData,
        hasModalCard: true,
        props:{
          dataPasien
        }
      })
      // this.$store.dispatch('deleteDataPasienPulang', dataPasien)
      // .then( (respon) => {
      //   this.$buefy.notification.open({
      //     message: respon,
      //     type: 'is-success'
      //   })
      // })
      // .catch( (respon) => {
      //   this.$buefy.notification.open({
      //     message: respon,
      //     type: 'is-danger'
      //   })
      // })
    }
  },
  filters:{
    showOnlyTime: (datetime) => {
      if(datetime != null){
        return datetime.split(' ')[1]
      }
      return datetime
    },
  },
  mounted(){
    let firstPage,lastPage
    firstPage = (this.pagging.current - 1) * this.pagging.perPage
    lastPage = this.pagging.perPage
    this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien})
    .then( (respon) => {
      this.pagging.total =  this.$store.getters.getTotalPasienPulang
    })
  }
}
</script>

<style>

</style>