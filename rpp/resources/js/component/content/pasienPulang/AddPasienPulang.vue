<template>
  <div>
    <form>
      <b-field :type="{'is-danger': errorValidasi.tanggal }" :message="errorValidasi.tanggalMessage">
        <b-datepicker
          placeholder="Tanggal Rencana Pasien Pulang"
          icon-pack="fas"
          icon="calendar-check"
          :date-formatter="(date) => $moment(date).format('DD MMM YYYY')"
          v-model="dataPasienPulang.tanggal"
          rounded
          >
          
        </b-datepicker>
        
      </b-field>

      <b-field  :type="{'is-danger': errorValidasi.noReg }" :message="errorValidasi.noRegMessage">
        <b-input placeholder="Nomor Registrasi" 
          icon="search" 
          icon-pack="fas" 
          v-model="dataPasienPulang.noReg"
          @focus="isComponentModal = true"
          rounded
          readonly
          ></b-input>
      </b-field>

      <b-field grouped>
        <b-field>
          <b-input
            type="text"
            placeholder="Nomor Rekam Medis"
            validation-message="Nomor Rekam Medis Harus Diisi"
            v-model="dataPasienPulang.nrm"
            required
            readonly
            rounded
            >
          </b-input>
        </b-field>

        <b-field expanded>
          <b-input
            type="text"
            placeholder="Nama Pasien"
            validation-message="Nama Pasien Harus Diisi"
            v-model="dataPasienPulang.namaPasien"
            required
            rounded
            readonly
            >
          </b-input>
        </b-field>

        <b-field>
          <b-input
            type="text"
            placeholder="Kamar Pasien"
            validation-message="Kamar Pasien Harus Diisi"
            v-model="dataPasienPulang.kamar"
            required
            rounded
            readonly
            >
          </b-input>
        </b-field>

        <b-field>
          <b-input
            type="text"
            placeholder="Keterangan Pasien"
            validation-message="Keterangan Pasien Harus Diisi"
            v-model="dataPasienPulang.keterangan"
            required
            rounded
            readonly
            >
          </b-input>
        </b-field>
        <b-field>
          <b-input
            type="text"
            placeholder="Nomor Kartu Kepersertaan"
            validation-message="Nomor Kartu Harus Diisi"
            v-model="dataPasienPulang.noKartu"
            required
            rounded
            readonly
            >
          </b-input>
        </b-field>
      </b-field>

      <b-field>
        <b-checkbox v-model="dataPasienPulang.isWaktu">Saya Ingin Menambahkan Waktu</b-checkbox>
        <b-checkbox v-model="dataPasienPulang.isTerencana">Pasien Pulang Sesuai Rencana</b-checkbox>
      </b-field>

      <b-field grouped v-if="dataPasienPulang.isWaktu">
        <b-field label="Waktu Verif">
          <b-clockpicker
            rounded
            placeholder="Waktu Verif"
            v-model="dataPasienPulang.waktuVerif"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu IKS">
          <b-clockpicker
            rounded
            placeholder="Waktu IKS"
            v-model="dataPasienPulang.waktuIKS"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Selesai">
          <b-clockpicker
            rounded
            placeholder="Waktu Selesai"
            v-model="dataPasienPulang.waktuSelesai"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Pasien">
          <b-clockpicker
            rounded
            placeholder="Waktu Pasien"
            v-model="dataPasienPulang.waktuPasien"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Lunas">
          <b-clockpicker
            rounded
            placeholder="Waktu Lunas"
            v-model="dataPasienPulang.waktuLunas"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>
      </b-field>

      <b-field grouped v-if="dataPasienPulang.isWaktu">
        <b-field label="Cari Petugas FO" expanded>
            <b-autocomplete
                rounded
                v-model="dataPasienPulang.petugasFO"
                :data="filterDataPetugasFO"
                placeholder="Cari Nama Petugas FO"
                icon-pack="fas"
                icon="search"
                field="namaCustomer"
                @select="option => selected = option">
                <template slot="empty">Tidak ditemukan Nama Petugas FO</template>
            </b-autocomplete>
        </b-field>
        <b-field label="Cari Petugas Perawat" expanded>
          <b-autocomplete
            rounded
            v-model="dataPasienPulang.petugasPerawat"
            :data="filterDataPetugasPerawat"
            placeholder="Cari Nama Petugas Perawat"
            icon-pack="fas"
            icon="search"
            field="namaCustomer"
            @select="option => selected = option">
            <template slot="empty">Tidak ditemukan Nama Petugas Perawat </template>
          </b-autocomplete>
        </b-field>
      </b-field>

      <b-button 
        type="is-primary"
        size="is-medium"
        icon-left="save"
        icon-pack="fas"
        @click="saveDataPasienPulang"
        >
        SAVE
      </b-button> 
    </form>
    <b-modal :active.sync="isComponentModal" >
      <ModalSearchPasienRegistrasi></ModalSearchPasienRegistrasi>
    </b-modal>

  </div>
</template>

<script>
import ModalSearchPasienRegistrasi from '../modal/ModalSearchPasienRegistrasi'
import EventBus from '../../../eventBus'
export default {
  name: "FormTambahPasienComponent",
  props:['dataMutu'],
  components:{
    ModalSearchPasienRegistrasi
  },
  data(){
    return {
      dataPasienPulang:{
        tanggal: null,
        noReg:null,
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
        isWaktu: false,
        isTerencana: false,
        noKartu: null,
        namaDokter: null,
        kodeKelas: null,
        mutuUmum: '',
        mutuIKS: '',
        mutuBPJS: '',
      },
      errorValidasi:{
        tanggal: null,
        tanggalMessage: null,
        noReg: null,
        noRegMessage: null,
      },
      isComponentModal: false,
    }
  },
  computed:{
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
  methods:{
    fillData(data){
      this.dataPasienPulang.noReg = data.noReg
      this.dataPasienPulang.nrm = data.nrm
      this.dataPasienPulang.namaPasien = data.namaPasien
      this.dataPasienPulang.kamar = data.kamar
      this.dataPasienPulang.keterangan = data.keterangan
      this.dataPasienPulang.noKartu = data.noKartu
      this.dataPasienPulang.namaDokter = data.namaDokter
      this.dataPasienPulang.kodeKelas = data.kodeKelas
      this.isComponentModal = false
    },
    hapusFieldAll(){
      this.dataPasienPulang.tanggal= null
      this.dataPasienPulang.noKartu = this.dataPasienPulang.noReg = this.dataPasienPulang.nrm = this.dataPasienPulang.namaPasien = this.dataPasienPulang.kamar = this.dataPasienPulang.petugasFO = this.dataPasienPulang.petugasPerawat = this.dataPasienPulang.keterangan = this.dataPasienPulang.namaDokter = this.dataPasienPulang.kodeKelas = ''
      this.dataPasienPulang.waktuVerif = this.dataPasienPulang.waktuIKS = this.dataPasienPulang.waktuSelesai = this.dataPasienPulang.waktuPasien = this.dataPasienPulang.waktuLunas = null
      this.dataPasienPulang.isTerencana = this.dataPasienPulang.isWaktu = this.isComponentModal = false
    },
    saveDataPasienPulang(){
      this.dataPasienPulang.mutuUmum = this.dataMutu.mutuUmum
      this.dataPasienPulang.mutuIKS = this.dataMutu.mutuIKS
      this.dataPasienPulang.mutuBPJS = this.dataMutu.mutuBPJS
      
      if(this.validateDataPasienPulang(this.dataPasienPulang)){
        this.$store.dispatch('saveDataPasienPulang', this.dataPasienPulang)
        .then( (respon) => {
          this.hapusFieldAll()
          EventBus.$emit('expandForm')
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
      } 
    },
    validateDataPasienPulang(dataPasien){
      if(dataPasien.tanggal == null || dataPasien.tanggal == ''){
        this.errorValidasi.tanggal = true
        this.errorValidasi.tanggalMessage = "Oh my baby, kamu melupakan ini"
      }else{
        this.errorValidasi.tanggal = false
        this.errorValidasi.tanggalMessage = null
      }
      if(dataPasien.noReg == null || dataPasien.noReg == ''){
        this.errorValidasi.noReg = true
        this.errorValidasi.noRegMessage = "Sayang, ini harus diisi yaa..."
      }else{
        this.errorValidasi.noReg = false
        this.errorValidasi.noRegMessage = null
      }
      if(!this.errorValidasi.tanggal && !this.errorValidasi.noReg){
        return true
      }
      return false
    }
  },
  created(){
    // console.log("FormTambahPasienComponent Created")
    EventBus.$on('fetchData', data => this.fillData(data))
  }
}
</script>

<style>

</style>