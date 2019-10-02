<template>
  <div>
    <form>
      <b-field>
        <b-datepicker
          placeholder="Tanggal Rencana Pasien Pulang"
          icon-pack="fas"
          icon="calendar-check"
          v-model="data.tanggal"
          rounded
          >
        </b-datepicker>
      </b-field>
      
      <b-field >
        <b-input placeholder="Nomor Registrasi" 
          icon="search" 
          icon-pack="fas" 
          v-model="data.noreg"
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
            v-model="data.nrm"
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
            v-model="data.namaPasien"
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
            v-model="data.kamar"
            required
            rounded
            readonly
            >
          </b-input>
        </b-field>

        <b-field expanded>
          <b-input
            type="text"
            placeholder="Keterangan Pasien"
            validation-message="Keterangan Pasien Harus Diisi"
            v-model="data.keterangan"
            required
            rounded
            readonly
            >
          </b-input>
        </b-field>
      </b-field>   

      <b-field>
        <b-checkbox v-model="isWaktu">Saya Ingin Menambahkan Waktu</b-checkbox>
      </b-field>

      <b-field grouped v-if="isWaktu">
        <b-field label="Waktu Verif">
          <b-clockpicker
            rounded
            placeholder="Waktu Verif"
            v-model="data.waktuVerif"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu IKS">
          <b-clockpicker
            rounded
            placeholder="Waktu IKS"
            v-model="data.waktuIKS"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Selesai">
          <b-clockpicker
            rounded
            placeholder="Waktu Selesai"
            v-model="data.waktuSelesai"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Pasien">
          <b-clockpicker
            rounded
            placeholder="Waktu Pasien"
            v-model="data.waktuPasien"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Lunas">
          <b-clockpicker
            rounded
            placeholder="Waktu Lunas"
            v-model="data.waktuLunas"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>
      </b-field>

      <b-field grouped v-if="isWaktu">
        <b-field label="Cari Petugas FO" expanded>
            <b-autocomplete
                rounded
                v-model="data.petugasFO"
                :data="filterDataPetugasFO"
                placeholder="Cari Nama Petugas FO"
                icon-pack="fas"
                icon="search"
                @select="option => selected = option">
                <template slot="empty">Tidak ditemukan Nama Petugas FO</template>
            </b-autocomplete>
        </b-field>
        <b-field label="Cari Petugas Perawat" expanded>
          <b-autocomplete
            rounded
            v-model="data.petugasPerawat"
            :data="filterDataPetugasPerawat"
            placeholder="Cari Nama Petugas Perawat"
            icon-pack="fas"
            icon="search"
            @select="option => selected = option">
            <template slot="empty">Tidak ditemukan Nama Petugas Perawat </template>
          </b-autocomplete>
        </b-field>
      </b-field>
    </form>
    <b-modal :active.sync="isComponentModal" >
      <FormSearchPasienComponent></FormSearchPasienComponent>
    </b-modal>
  </div>
</template>

<script>
import FormSearchPasienComponent from '../modal/FormSearchPasienComponent'
import EventBus from '../../eventBus'
export default {
  name: "FormTambahPasienComponent",
  props: ['dataPetugas'],
  components:{
    FormSearchPasienComponent
  },
  data(){
    return {
      data:{
        tanggal: new Date(),
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
      isWaktu: false,
      isComponentModal: false,
    }
  },
  computed:{
    filterDataPetugasFO(){
      return this.dataPetugas.filter( (petugas) => {
        return petugas
          .toString()
          .toLowerCase()
          .indexOf(this.data.petugasFO.toLowerCase()) >= 0
      })
    },
    filterDataPetugasPerawat(){
      return this.dataPetugas.filter( (petugas) => {
        return petugas
          .toString()
          .toLowerCase()
          .indexOf(this.data.petugasPerawat.toLowerCase()) >= 0
      })
    }
  },
  methods:{
    fillData(data){
      this.data.noreg = data.noReg
      this.data.nrm = data.nrm
      this.data.namaPasien = data.namaPasien
      this.data.kamar = data.kamar
      this.data.keterangan = data.keterangan
      this.isComponentModal = false
    }
  },
  created(){
    EventBus.$on('fetchData', data => this.fillData(data))
  }
}
</script>

<style>

</style>