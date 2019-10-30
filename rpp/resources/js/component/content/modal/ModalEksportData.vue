<template>
  <div class="modal-card" >
    <header class="modal-card-head">
      <p class="modal-card-title">Periode Pasien Pulang</p>
    </header>
    <section class="modal-card-body">
      <div class="column">
        <b-field class="is-grouped">
          <b-field 
            :type="{'is-danger': tanggalError.errorAwal}"
            :message="tanggalError.errorAwalMessage"
            expanded
            >
            <b-datepicker
              rounded
              placeholder="Periode Awal"
              v-model="tanggal.awal"
              icon-pack="fas"
              icon="calendar-check"
              :date-formatter="(date) => $moment(date).format('DD MMM YYYY')"
              >
            </b-datepicker>
          </b-field>
          <b-field 
            :type="{'is-danger': tanggalError.errorAkhir}"
            :message="tanggalError.errorAkhirMessage"
            expanded
            >
            <b-datepicker
              expanded
              rounded
              v-model="tanggal.akhir"
              placeholder="Periode Akhir"
              icon-pack="fas"
              icon="calendar-check"
              :min-date="tanggal.awal"
              :date-formatter="(date) => $moment(date).format('DD MMM YYYY')"
              :disabled="tanggal.awal == null"
              >
            </b-datepicker>
          </b-field>
        </b-field>
        <b-button
          type="is-primary"
          icon-pack="fas"
          icon-left="download"
          @click="exportDataToExcel"
          >
          Excel
        </b-button>
        <b-button
          type="is-danger"
          icon-pack="fas"
          icon-left="ban"
          @click="$parent.close()"
          >
          Cancel
        </b-button>
      </div>

      <export-excel
        class = "button is-primary is-hidden"
        :data = "getExportPasienPulang"
        :fields = "fields"
        :title = "[title,cleanKamar]"
        worksheet = "Riwayat Pasien Pulang"
        :name = "filename"
        >
        <span ref="ekspor">Download!</span>
      </export-excel>
    </section>
  </div>
</template>

<script>
export default {
  name: "ModalEksportData",
  data() {
    return {
      tanggal:{
        awal: null,
        akhir: null
      },
      tanggalError:{
        errorAwal: false,
        errorAwalMessage: null,
        errorAkhir: false,
        errorAkhirMessage: null,
      },
      fields: {
        'Terencana Pulang': 'isTerencana',
        'Kode Kelas': 'kodeKelas',
        'No Reg': 'noReg',
        'Tanggal': 'tanggal',
        'NRM': 'nrm',
        'No Kartu': 'noKartu',
        'Nama Pasien': 'namaPasien',
        'Kamar': 'kamar',
        'Keterangan': 'keterangan',
        'Nama Dokter': 'namaDokter',
        'Waktu Verif': 'waktuVerif',
        'Waktu IKS': 'waktuIKS',
        'Waktu Selesai': 'waktuSelesai',
        'Waktu Pasien': 'waktuPasien',
        'Waktu Lunas': 'waktuLunas',
        'Petugas FO': 'petugasFO',
        'Petugas Perawat': 'petugasPerawat',
        'Waktu Total(menit)': 'waktuTotal'
      },
    }
  },
  methods:{
    exportDataToExcel(){
      if(this.validasiData()){     
        this.$store.dispatch('getDataExportPasienPulang', this.tanggal)
        .then( (respon) => {
          this.$refs.ekspor.click()
          this.hapusData()
          this.$parent.close()
          this.$buefy.notification.open({
            message: respon,
            type: 'is-success'
          })
        })
        .catch( (respon) => {
          this.$parent.close()
          this.$buefy.notification.open({
            message: respon,
            type: 'is-danger'
          })
        })
      }
    },
    validasiData(){
      if(this.tanggal.awal == null || this.tanggal.awal == ''){
        this.tanggalError.errorAwal = true
        this.tanggalError.errorAwalMessage = "Ini Jangan Lupa Diisi ya Sayang..."
        return false
      }else{
        this.tanggalError.errorAwal = false
        this.tanggalError.errorAwalMessage = null
      }

      if(this.tanggal.akhir == null || this.tanggal.akhir == ''){
        this.tanggalError.errorAkhir = true
        this.tanggalError.errorAkhirMessage = "Sayang, Aku sedih kalau kamu lupain aku"
        return false
      }else{
        this.tanggalError.errorAkhir = false
        this.tanggalError.errorAkhirMessage = null
      }
      return true
    },
    hapusData(){
      this.tanggal.awal = this.tanggal.akhir = this.tanggalError.errorAwalMessage = this.tanggalError.errorAkhirMessage = null
      this.tanggalError.errorAwal = this.tanggalError.errorAkhir = false
    }
  },
  computed: {
    getExportPasienPulang(){
      const dataExportPasienPulang =  this.$store.getters.getExportPasienPulang
      dataExportPasienPulang.map( (dataPasien) => {
        dataPasien.tanggal = this.$moment(dataPasien.tanggal).format("DD MMM YYYY")
        // if(dataPasien.waktuVerif != null){
        //   console.log(dataPasien.waktuVerif)
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
    getJumlahKamarDibersihkan(){
      return this.$store.getters.getTotalKamarDibersihkanExport
    },
    filename(){
      return `Riwayat Pasien Pulang Periode ${this.$moment(this.tanggal.awal).format("DD MMM YYYY")} - ${this.$moment(this.tanggal.akhir).format("DD MMM YYYY")}.xls`
    },
    title(){
      return `Riwayat Pasien Pulang Periode ${this.$moment(this.tanggal.awal).format("DD MMM YYYY")} - ${this.$moment(this.tanggal.akhir).format("DD MMM YYYY")}`
    },
    cleanKamar(){
      return `Jumlah Kamar Yang Dibersihkan: ${this.getJumlahKamarDibersihkan} `
    }
  }
}
</script>

<style>

</style>