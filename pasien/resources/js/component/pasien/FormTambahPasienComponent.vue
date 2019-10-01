<template>
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

      <b-field>
        <b-input placeholder="Nomor Registrasi" icon="search" icon-pack="fas" readonly rounded></b-input>
      </b-field>

      <b-field grouped>
        <b-field>
          <b-input
            type="text"
            placeholder="Nomor Rekam Medis"
            validation-message="Nomor Rekam Medis Harus Diisi"
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

      <b-field grouped :class="isWaktu?'':'is-hidden'">
        <b-field label="Waktu Verif">
          <b-clockpicker
            rounded
            placeholder="Waktu Verif"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu IKS">
          <b-clockpicker
            rounded
            placeholder="Waktu IKS"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Selesai">
          <b-clockpicker
            rounded
            placeholder="Waktu Selesai"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Pasien">
          <b-clockpicker
            rounded
            placeholder="Waktu Pasien"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>

        <b-field label="Waktu Lunas">
          <b-clockpicker
            rounded
            placeholder="Waktu Lunas"
            icon-pack="fas"
            icon="clock"
            hour-format="24">
          </b-clockpicker>
        </b-field>
      </b-field>

      <b-field grouped>
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
      <h1>
        {{ data }}
      </h1>
    </form>
</template>

<script>
export default {
  name: "FormTambahPasienComponent",
  props: ['dataPetugas'],
  data(){
    return {
      data:{
        tanggal:'',
        noreg:'',
        nrm:'',
        namaPasien:'',
        kamar:'',
        waktuVerif:'',
        waktuIKS:'',
        waktuSelesai:'',
        waktuPasien:'',
        waktuLunas:'',
        petugasFO:'',
        petugasPerawat:'',
        keterangan:'',
      },
      isWaktu: false,
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
  }
}
</script>

<style>

</style>