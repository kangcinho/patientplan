<template>
  <div class="columns is-multiline">
    <div class="column is-4">
      <b-field grouped group-multiline>
        <div class="control">
          <b-taglist attached>
            <b-tag type="is-dark">Total Kamar Checkout</b-tag>
            <b-tag type="is-info">{{ totalKamarDibersihkan }}</b-tag>
          </b-taglist>
        </div>
      </b-field>
    </div>
    <div class="column is-4 is-offset-4">
      <b-button class="is-pulled-right"
        type="is-success"
        icon-pack="fas"
        icon-left="sync-alt"
        size="is-small"
        v-if="getDataUser.canInsert"
        @click="getPasienPulangFromKasir">
        Pasien Pulang
      </b-button>
    </div>
    <div class="column ">
      <b-field >
        <b-datepicker
          expanded
          icon-pack="fas"
          icon="calendar-alt"
          :date-formatter="(date) => $moment(date).format('DD MMM YYYY')"
          v-model="tanggalSearch"
          placeholder="Pilih Periode Pasien Pulang"
          rounded
          @keyup.native.enter="searchNamaPasienToDB"
          @input="searchNamaPasienToDB"
          >
        </b-datepicker>
        <b-button
          @click="clearTanggal"
          icon-pack="fas"
          icon-left="times"
          />
      </b-field>
    </div>
    <div class="column is-two-thirds">
      <b-input
        rounded
        icon-pack="fas"
        icon="search" 
        placeholder="Cari Nama Pasien Pulang"
        @keyup.native.enter="searchNamaPasienToDB"
        v-model="searchNamaPasien"
      >
      </b-input>
    </div>
    <div class="column is-full">
      <table class="table is-bordered is-striped is-narrow is-fullwidth" style="font-size:0.6em;">
        <thead>
          <tr>
            <th rowspan="2" class="has-text-centered sizeKeterangan">Tgl Pulang</th>
            <th rowspan="2" class="has-text-centered sizeKamar">Kmr</th>
            <th rowspan="2" class="has-text-centered sizeKeterangan">Nama Pasien</th>
            <th rowspan="2" class="has-text-centered sizeKeterangan">Keterangan</th>
            <th colspan="5" class="has-text-centered">Waktu Konfirmasi</th>
            <th colspan="2" class="has-text-centered">Petugas Jaga</th>
            <th rowspan="2" class="has-text-centered sizeKeterangan">Action</th>
          </tr>
        <tr>
          <th class="has-text-centered sizeWaktu">Verif</th>
          <th class="has-text-centered sizeWaktu">IKS</th>
          <th class="has-text-centered sizeWaktu">Selesai</th>
          <th class="has-text-centered sizeWaktu">Pasien</th>
          <th class="has-text-centered sizeWaktu">Lunas</th>
          <th class="has-text-centered sizePetugas">FO</th>
          <th class="has-text-centered sizePetugas">Perawat</th>
        </tr>
        </thead>
        <tbody v-if="getPasienPulang.length > 0">
          <tr v-for="pasien in getPasienPulang" :key="pasien.idPasien" :style="hitungWaktu(pasien)?'background-color : hsl(348, 100%, 61%)':''">
            <td class="has-text-centered wrapWord sizeKeterangan">
              {{ pasien.tanggal | moment("DD MMM YYYY") }}
              <br/>
              <span v-if="pasien.isTerencana && !pasien.isEdit" style="font-size: 10px">
                <b-icon
                  size="is-small"
                  icon="check-double"
                  pack="fas"
                >
                </b-icon>
              </span>
              <span v-if="pasien.isEdit">
                <b-checkbox v-model="dataPasienPulang.isTerencana">Terencana</b-checkbox>
              </span>
              </td>
            <td class="has-text-centered wrapWord sizeKamar">
              {{ pasien.kamar }}
              <br/>
              <span v-if="pasien.kodeKelas == '15'"><strong> Transisi </strong></span>
            </td>
            <td class="has-text-centered wrapWord sizeKeterangan">{{ pasien.namaPasien }}</td>
            <td class="has-text-centered wrapWord sizeKeterangan">
              {{ pasien.keterangan }} <br/>
              <strong>{{ pasien.namaDokter }}</strong> <br/>
              {{ pasien.noKartu }} <br/>
              <strong v-if="pasien.waktuTotal != 0"> {{ pasien.waktuTotal }} Menit </strong>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span v-if="!pasien.isEdit">{{ pasien.waktuVerif | showOnlyTime }}</span>
              <span v-else>
                <b-datetimepicker
                    rounded
                    v-model="dataPasienPulang.waktuVerif"
                    size="is-small"
                    icon-pack="fas"
                    icon="clock"
                    hour-format="24"
                    :datetime-formatter="(date) => $moment(date).format('HH:mm')"
                    >
                </b-datetimepicker>
                <!-- <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuVerif"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">
                  <button class="button is-primary"
                    @click="dataPasienPulang.waktuVerif = new Date()">
                    <b-icon pack="fas" icon="clock"></b-icon>
                    <span>Now</span>
                  </button>

                  <button class="button is-danger"
                      @click="dataPasienPulang.waktuVerif = null">
                      <b-icon pack="fas" icon="times"></b-icon>
                      <span>Clear</span>
                  </button>
                </b-clockpicker> -->
                <div class="buttons">
                  <b-button class="button is-success"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuVerif = new Date()"
                    icon-left="clock"
                    icon-pack="fas"
                    title="Set Waktu Verif">
                  </b-button>
                  <b-button class="button is-danger"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuVerif = null"
                    icon-left="trash"
                    icon-pack="fas"
                    title="Hapus Waktu Verif">
                  </b-button>
                </div>
              </span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span v-if="!pasien.isEdit">{{ pasien.waktuIKS | showOnlyTime }}</span>
              <span v-else>
                <b-datetimepicker
                    rounded
                    v-model="dataPasienPulang.waktuIKS"
                    size="is-small"
                    icon-pack="fas"
                    icon="clock"
                    hour-format="24"
                    :datetime-formatter="(date) => $moment(date).format('HH:mm')"
                    >
                </b-datetimepicker>
                <!-- <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuIKS"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">

                  <button class="button is-primary"
                    @click="dataPasienPulang.waktuIKS = new Date()">
                    <b-icon pack="fas" icon="clock"></b-icon>
                    <span>Now</span>
                  </button>

                  <button class="button is-danger"
                      @click="dataPasienPulang.waktuIKS = null">
                      <b-icon pack="fas" icon="times"></b-icon>
                      <span>Clear</span>
                  </button>
                </b-clockpicker> -->
                <div class="buttons">
                  <b-button class="button is-success"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuIKS = new Date()"
                    icon-left="clock"
                    icon-pack="fas"
                    title="Set Waktu IKS">
                  </b-button>
                  <b-button class="button is-danger"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuIKS = null"
                    icon-left="trash"
                    icon-pack="fas"
                    title="Hapus Waktu IKS">
                  </b-button>
                </div>
              </span>
              
            </td>
            <td class="has-text-centered sizeWaktu">
              <span v-if="!pasien.isEdit">{{ pasien.waktuSelesai | showOnlyTime }}</span>
              <span v-else>
                <b-datetimepicker
                    rounded
                    v-model="dataPasienPulang.waktuSelesai"
                    size="is-small"
                    icon-pack="fas"
                    icon="clock"
                    hour-format="24"
                    :datetime-formatter="(date) => $moment(date).format('HH:mm')"
                    >
                </b-datetimepicker>
                <!-- <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuSelesai"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">

                  <button class="button is-primary"
                    @click="dataPasienPulang.waktuSelesai = new Date()">
                    <b-icon pack="fas" icon="clock"></b-icon>
                    <span>Now</span>
                  </button>

                  <button class="button is-danger"
                      @click="dataPasienPulang.waktuSelesai = null">
                      <b-icon pack="fas" icon="times"></b-icon>
                      <span>Clear</span>
                  </button>
                </b-clockpicker> -->
                <div class="buttons">
                  <b-button class="button is-success"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuSelesai = new Date()"
                    icon-left="clock"
                    icon-pack="fas"
                    title="Set Waktu Selesai">
                  </b-button>
                  <b-button class="button is-danger"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuSelesai = null"
                    icon-left="trash"
                    icon-pack="fas"
                    title="Hapus Waktu Selesai">
                  </b-button>
                </div>
              </span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span v-if="!pasien.isEdit">{{ pasien.waktuPasien | showOnlyTime }}</span>
              <span v-else>
                <b-datetimepicker
                    rounded
                    v-model="dataPasienPulang.waktuPasien"
                    size="is-small"
                    icon-pack="fas"
                    icon="clock"
                    hour-format="24"
                    :datetime-formatter="(date) => $moment(date).format('HH:mm')"
                    >
                </b-datetimepicker>
                <!-- <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuPasien"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">

                  <button class="button is-primary"
                    @click="dataPasienPulang.waktuPasien = new Date()">
                    <b-icon pack="fas" icon="clock"></b-icon>
                    <span>Now</span>
                  </button>

                  <button class="button is-danger"
                      @click="dataPasienPulang.waktuPasien = null">
                      <b-icon pack="fas" icon="times"></b-icon>
                      <span>Clear</span>
                  </button>
                </b-clockpicker> -->

                <div class="buttons">
                  <b-button class="button is-success"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuPasien = new Date()"
                    icon-left="clock"
                    icon-pack="fas"
                    title="Set Waktu Pasien">
                  </b-button>
                  <b-button class="button is-danger"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuPasien = null"
                    icon-left="trash"
                    icon-pack="fas"
                    title="Hapus Waktu Pasien">
                  </b-button>
                </div>
              </span>             
            </td>
            <td class="has-text-centered sizeWaktu">
              <span v-if="!pasien.isEdit">{{ pasien.waktuLunas | showOnlyTime }}</span>
              <span v-else>
                <b-datetimepicker
                    rounded
                    v-model="dataPasienPulang.waktuLunas"
                    size="is-small"
                    icon-pack="fas"
                    icon="clock"
                    hour-format="24"
                    :datetime-formatter="(date) => $moment(date).format('HH:mm')"
                    >
                </b-datetimepicker>
                <!-- <b-clockpicker
                  rounded
                  v-model="dataPasienPulang.waktuLunas"
                  size="is-small"
                  icon-pack="fas"
                  icon="clock"
                  hour-format="24">
                  
                  <button class="button is-primary"
                    @click="dataPasienPulang.waktuLunas = new Date()">
                    <b-icon pack="fas" icon="clock"></b-icon>
                    <span>Now</span>
                  </button>

                  <button class="button is-danger"
                      @click="dataPasienPulang.waktuLunas = null">
                      <b-icon pack="fas" icon="times"></b-icon>
                      <span>Clear</span>
                  </button>
                </b-clockpicker> -->
                <div class="buttons">
                  <b-button class="button is-success"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuLunas = new Date()"
                    icon-left="clock"
                    icon-pack="fas"
                    title="Set Waktu Lunas">
                  </b-button>
                  <b-button class="button is-danger"
                    style="margin-top:5px"
                    size="is-small"
                    @click="dataPasienPulang.waktuLunas = null"
                    icon-left="trash"
                    icon-pack="fas"
                    title="Hapus Waktu Lunas">
                  </b-button>
                </div>
              </span>                
            </td>
            <td class="has-text-centered sizePetugas">
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
            <td class="has-text-centered sizePetugas">
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
            <td class="has-text-centered wrapWord sizeKeterangan" v-if="getDataUser != null">
              <b-button 
                type="is-info"
                size="is-small"
                icon-pack="fas"
                icon-right="edit"
                v-if="!pasien.isEdit && getDataUser.canUpdate && pasien.isGone == 0"
                title="Edit Data Pasien"
                @click="changeToEditMode(pasien, true)"/>
              <b-button
                type="is-info"
                size="is-small"
                icon-pack="fas"
                icon-right="save"
                v-if="pasien.isEdit && getDataUser.canUpdate && pasien.isGone == 0"
                title="Save Data Pasien"
                @click="updateDataPasien(pasien)"/>
              <b-button
                type="is-warning"
                size="is-small"
                icon-pack="fas"
                icon-right="ban"
                v-if="pasien.isEdit && getDataUser.canUpdate && pasien.isGone == 0"
                title="Batal Edit Data Pasien"
                @click="changeToEditMode(pasien, false)"/>
              <b-button
                type="is-danger"
                size="is-small"
                icon-pack="fas"
                icon-right="trash-alt" 
                v-if="getDataUser.canDelete && pasien.isGone == 0"
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
        <span>Total Data: <strong> {{totalPasien}} </strong> Data</span>
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
    <div class="buttons">
      <b-button
        type="is-primary"
        size="is-small"
        icon-pack="fas"
        icon-left="download"
        v-if="getDataUser.canEkspor"
        @click="modalEksportData"
        >
        Export
      </b-button>
      <b-button
        type="is-primary"
        size="is-small"
        icon-pack="fas"
        icon-left="print"
        v-if="getDataUser.canEkspor"
        @click="printDataPasienPulang"
        >
        Print
      </b-button>
    </div>
    <div id="printDataPasien" v-show=false v-if="getExportPasienPulang.length > 0">
      <TablePrintPasienPulang
        :getPasienPulang="getExportPasienPulang"
        :tanggalSearch="tanggalSearch"
        :totalKamarDibersihkan="totalKamarDibersihkanExport"
        :totalPasien="getExportPasienPulang.length"
        />
    </div>
    <b-loading is-full-page :active.sync="isLoading" :can-cancel="false"></b-loading>
  </div>
</template>

<script>
import ModalKonfirmasiHapusData from '../modal/ModalKonfirmasiHapusData'
import ModalEksportData from '../modal/ModalEksportData'
import TablePrintPasienPulang from './TablePrintPasienPulang'
import EventBus from '../../../eventBus'

export default {
  name: "ListPasienPulang",
  props:['dataMutu'],
  components:{
    ModalKonfirmasiHapusData,
    ModalEksportData,
    TablePrintPasienPulang
  },
  data(){
    return {
      dataPasienPulang:{
        idPasien:'',
        tanggal: null,
        noReg:'',
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
        isTerencana: false,
        mutuUmum: '',
        mutuIKS: '',
        mutuBPJS: '',
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
      isAllPeriode: false,
      tanggalSearch: new Date(),
      isLoading: false,
    }
  },
  computed:{

    getExportPasienPulang(){
      const dataExportPasienPulang =  this.$store.getters.getExportPasienPulang
      dataExportPasienPulang.map( (dataPasien) => {
        dataPasien.tanggal = this.$moment(dataPasien.tanggal).format("DD MMM YYYY")
        // if(dataPasien.waktuVerif != null){
        //   dataPasien.waktuVerif = this.$moment(dataPasien.waktuVerif).format("H:mm:ss")
        // }
        // if(dataPasien.waktuSelesai != null){
        //   dataPasien.waktuSelesai = this.$moment(dataPasien.waktuSelesai).format("H:mm:ss")
        // }
        // if(dataPasien.waktuIKS != null){
        //   dataPasien.waktuIKS = this.$moment(dataPasien.waktuIKS).format("H:mm:ss")
        // }
        // if(dataPasien.waktuPasien != null){
        //   dataPasien.waktuPasien = this.$moment(dataPasien.waktuPasien).format("H:mm:ss")
        // }
        // if(dataPasien.waktuLunas != null){
        //   dataPasien.waktuLunas = this.$moment(dataPasien.waktuLunas).format("H:mm:ss")
        // }
      })
      return dataExportPasienPulang
    },
    totalKamarDibersihkan(){
      return this.$store.getters.getTotalKamarPasienPulang
    },
    totalKamarDibersihkanExport(){
      return this.$store.getters.getTotalKamarDibersihkanExport
    },
    totalPasien(){
      return this.$store.getters.getTotalPasienPulang
    },
    getPasienPulang(){
      return this.$store.getters.getPasienPulang.sort( (a,b) => {
        if(a.keterangan < b.keterangan){
          return 1
        }else if(a.keterangan > b.keterangan){
          return -1
        }
        return 0
      })
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
    },
    getDataUser(){
      return this.$store.getters.getDataUserLogin
    }
  },
  watch:{
    'pagging.current'(newVal, oldVal){
      this.disableEdit = false
      let firstPage,lastPage
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      this.isLoading = true
      this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien, tanggalSearch: this.tanggalSearch})
      .then( (respon) => {
        this.isLoading = false
        this.pagging.total =  this.$store.getters.getTotalPasienPulang
      })
      .catch( (respon) => {
        this.isLoading = false
      })
    },
  },
  created(){
    // console.log("LIST PASIEN PULANG CREATED")
  },
  methods:{
    getPasienPulangFromKasir(){
      this.isLoading = true
      this.$store.dispatch('getDataPasienPulangFromKasir')
      .then( (respon) =>{
        this.$buefy.notification.open({
          message: respon,
          type: 'is-success'
        })
        this.searchNamaPasienToDB()
        this.$store.dispatch('getDataPasienRegistrasiFromSanata')
      })
      .catch( (respon) => {
        this.isLoading = false
      })
    },
    clearTanggal(){
      this.tanggalSearch = null
      this.searchNamaPasienToDB()
    },
    modalEksportData(){
      this.disableEdit = false
      this.$buefy.modal.open({
        parent: this,
        component: ModalEksportData,
        hasModalCard: true,
        fullScreen: true
      })
    },
    changeToEditMode(dataPasien, mode){
       //Can Edit Only One Field Live
      if(mode){
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
              this.fillData(dataPasien)
            }
          }
        })
      }
    },
    updateDataPasien(dataPasien){
      dataPasien.isEdit = false
      this.disableEdit = false
      this.dataPasienPulang.noReg = dataPasien.noReg
      this.dataPasienPulang.idPasien = dataPasien.idPasien
      this.isLoading = true
      this.dataPasienPulang.mutuUmum = this.dataMutu.mutuUmum
      this.dataPasienPulang.mutuIKS = this.dataMutu.mutuIKS
      this.dataPasienPulang.mutuBPJS = this.dataMutu.mutuBPJS
      this.$store.dispatch('updateDataPasienPulang', this.dataPasienPulang)
      .then( (respon) => {
        this.isLoading = false
        this.hapusFieldAll()
        this.$buefy.notification.open({
          message: respon,
          type: 'is-success'
        })
      })
      .catch( (respon) => {
        this.isLoading = false
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
      this.dataPasienPulang.noReg = this.dataPasienPulang.nrm = this.dataPasienPulang.namaPasien = this.dataPasienPulang.kamar = this.dataPasienPulang.petugasFO = this.dataPasienPulang.petugasPerawat = this.dataPasienPulang.keterangan = ''
      this.dataPasienPulang.waktuVerif = this.dataPasienPulang.waktuIKS = this.dataPasienPulang.waktuSelesai = this.dataPasienPulang.waktuPasien = this.dataPasienPulang.waktuLunas = null
      this.dataPasienPulang.isTerencana = this.dataPasienPulang.isWaktu = this.isComponentModal = false
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
      if(data.isTerencana){
        this.dataPasienPulang.isTerencana = true
      }else{
        this.dataPasienPulang.isTerencana = false
      }
        
    },
    searchNamaPasienToDB(){
      this.disableEdit = false
      let firstPage,lastPage
      firstPage = 0
      lastPage = this.pagging.perPage
      this.isLoading = true
      this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien, tanggalSearch: this.tanggalSearch})
      .then( (respon) => {
        this.isLoading = false
        this.pagging.total =  this.$store.getters.getTotalPasienPulang
        this.pagging.current = 1
      })
      .catch((respon) => {
        this.isLoading = false
        this.$buefy.notification.open({
          message: respon,
          type: 'is-danger',
        })
      })
    },
    deleteDataPasienPulang(dataPasien){
      const nama = dataPasien.namaPasien
      // dataPasien.isEdit = false
      this.$buefy.modal.open({
        parent: this,
        component: ModalKonfirmasiHapusData,
        hasModalCard: true,
        props:{
          'nama': dataPasien.namaPasien,
          'data': dataPasien,
          'method': 'deleteDataPasienPulang',
        }
      })
    },
    printDataPasienPulang(){
      this.disableEdit = false
      let tanggal = null
      if(this.tanggalSearch != null){
        tanggal = {
          awal : this.tanggalSearch,
          akhir: this.tanggalSearch
        }
      }else{
        tanggal = {
          awal : new Date(),
          akhir: new Date()
        }
      }
      // console.log(tanggal)
      this.$store.dispatch('getDataExportPasienPulang', tanggal)
      .then( (respon) => {
        this.$htmlToPaper('printDataPasien');
        this.$buefy.notification.open({
          message: "Data Siap Dicetak",
          type: 'is-success'
        })
      })
      .catch( (respon) => {
        this.$buefy.notification.open({
          message: "Error",
          type: 'is-danger'
        })
      })
    },
    hitungWaktu(pasien){
      if(pasien.waktuVerif == null || pasien.waktuVerif == ''){
        // console.log('verif')
        return false
      }
      // if(pasien.waktuIKS == null || pasien.waktuIKS == ''){
      //   // console.log('iks')
      //   return false
      // }
      // if(pasien.waktuSelesai == null || pasien.waktuSelesai == ''){
      //   // console.log('selesai')
      //   return false
      // }
      // if(pasien.waktuPasien == null || pasien.waktuPasien == ''){
      //   // console.log('pasien')
      //   return false
      // }
      if(pasien.waktuLunas == null || pasien.waktuLunas == ''){
        // console.log('lunas')
        return false
      }

      const waktuVerif = new Date(pasien.waktuVerif)
      const waktuLunas = new Date(pasien.waktuLunas)
      const perbedaanWaktu = (waktuLunas.getTime() - waktuVerif.getTime())/(1000 * 60)
      
      if(pasien.keterangan.includes('BPJS')){
        // console.log('BPJS__')
        if(perbedaanWaktu > pasien.mutuBPJS){
          return true
        }
      }else if(pasien.keterangan.includes('IKS')){
        // console.log('IKS')
        if(perbedaanWaktu > pasien.mutuIKS){
          return true
        }
      }else if(pasien.keterangan.includes('Umum')){
        // console.log('UMUM')
        if(perbedaanWaktu > pasien.mutuUmum){
          return true
        }
      }
      // console.log(perbedaanWaktu);
      return false
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
    this.isLoading = true
    let firstPage,lastPage
    firstPage = (this.pagging.current - 1) * this.pagging.perPage
    lastPage = this.pagging.perPage
    this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien, tanggalSearch: this.tanggalSearch})
    .then( (respon) => {
      this.isLoading = false
      this.pagging.total =  this.$store.getters.getTotalPasienPulang
    })
    .catch( (respon) => {
      this.isLoading = false
    })

    EventBus.$on('changeDisableEdit', (data) => {
      if(data.isEdit){
        this.disableEdit = false
        this.hapusFieldAll()
      }
    })
  },
  onIdle() {
    // console.log('onIdle')
    this.isLoading = true
    let firstPage,lastPage
    firstPage = (this.pagging.current - 1) * this.pagging.perPage
    lastPage = this.pagging.perPage
    this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien, tanggalSearch: this.tanggalSearch})
    .then( (respon) => {
      this.isLoading = false
      this.pagging.total =  this.$store.getters.getTotalPasienPulang
    })
    .catch( (respon) => {
      this.isLoading = false
    })
  },
  onActive() {
    this.isLoading = true
    let firstPage,lastPage
    firstPage = (this.pagging.current - 1) * this.pagging.perPage
    lastPage = this.pagging.perPage
    this.$store.dispatch('getDataPasienPulang', {firstPage,lastPage, searchNamaPasien: this.searchNamaPasien, tanggalSearch: this.tanggalSearch})
    .then( (respon) => {
      this.isLoading = false
      this.pagging.total =  this.$store.getters.getTotalPasienPulang
    })
    .catch( (respon) => {
      this.isLoading = false
    })
  },
}
</script>

<style>

</style>