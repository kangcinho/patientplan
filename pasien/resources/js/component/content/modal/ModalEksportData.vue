<template>
  <div class="modal-card" >
    <header class="modal-card-head">
      <p class="modal-card-title">Periode Pasien Pulang</p>
    </header>
    <section class="modal-card-body">
      <div class="column">
        <b-field class="is-grouped">
          <b-datepicker
            expanded
            rounded
            placeholder="Periode Awal"
            v-model="tanggal.awal"
            icon-pack="fas"
            icon="calendar-check"
            :date-formatter="(date) => $moment(date).format('DD MMM YYYY')"
            >
          </b-datepicker>

          <b-datepicker
            expanded
            rounded
            v-model="tanggal.akhir"
            placeholder="Periode Akhir"
            icon-pack="fas"
            icon="calendar-check"
            :date-formatter="(date) => $moment(date).format('DD MMM YYYY')"
            >
          </b-datepicker>
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
        class="button is-primary is-hidden"
        :data = "getExportPasienPulang"
        :fields = "fields"
        worksheet = "Riwayat Pasien Pulang"
        :name = filename
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
      fields: {
        'No Reg': 'noReg',
        'Tanggal': 'tanggal',
        'NRM': 'nrm',
        'No Kartu': 'noKartu',
        'Nama Pasien': 'namaPasien',
        'Kamar': 'kamar',
        'Waktu Verif': 'waktuVerif',
        'Waktu IKS': 'waktuIKS',
        'Waktu Selesai': 'waktuSelesai',
        'Waktu Pasien': 'waktuPasien',
        'Waktu Lunas': 'waktuLunas',
        'Petugas FO': 'petugasFO',
        'Petugas Perawat': 'petugasPerawat',
        'Keterangan': 'keterangan'
      },
    }
  },
  methods:{
    exportDataToExcel(){
      this.$store.dispatch('getDataExportPasienPulang', this.tanggal)
      .then( (respon) => {
        this.$refs.ekspor.click()
      })
      .catch( (respon) => {

      })
    }
  },
  computed: {
    getExportPasienPulang(){
      return this.$store.getters.getExportPasienPulang
    },
    filename(){
      return `Riwayat Pasien Pulang Periode ${this.tanggal.awal} - ${this.tanggal.akhir}.xls`
    }
  }
}
</script>

<style>

</style>