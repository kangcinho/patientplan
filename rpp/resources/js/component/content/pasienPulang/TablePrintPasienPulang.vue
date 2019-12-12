<template>
  <div class="column is-full">
      <div class="has-text-centered">
        <h3 class="is-size-5 has-text-weight-bold" v-if="tanggalSearch != null">Riwayat Pasien Pulang Tanggal {{ tanggalSearch | moment("DD MMM YYYY") }}</h3>
        <h3 class="is-size-5 has-text-weight-bold" v-else >Riwayat Pasien Pulang Tanggal {{ tgl | moment("DD MMM YYYY") }}</h3>
      </div>
      <span class="is-size-6 has-text-weight-bold">Total Kamar Checkout: <strong>{{ totalKamarDibersihkan }}</strong></span>
      <table class="table is-bordered is-striped is-narrow is-fullwidth" style="font-size:0.6em;">
        <thead>
          <tr>
            <th rowspan="2" class="has-text-centered sizeKeterangan">Tgl Pulang</th>
            <th rowspan="2" class="has-text-centered sizeKamar">Kmr</th>
            <th rowspan="2" class="has-text-centered sizeKeterangan">Nama Pasien</th>
            <th rowspan="2" class="has-text-centered sizeKeterangan">Keterangan</th>
            <th colspan="5" class="has-text-centered">Waktu Konfirmasi</th>
            <th colspan="2" class="has-text-centered">Petugas Jaga</th>
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
              <span v-if="pasien.isTerencana" style="font-size: 10px">
                <b-icon
                  size="is-small"
                  icon="check-double"
                  pack="fas"
                >
                </b-icon>
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
              <strong> {{ pasien.waktuTotal }} Menit </strong>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuVerif | showOnlyTime  }}</span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuIKS | showOnlyTime  }}</span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuSelesai | showOnlyTime }}</span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuPasien | showOnlyTime  }}</span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuLunas | showOnlyTime  }}</span>
            </td>
            <td class="has-text-centered sizePetugas">
              <span>{{ pasien.petugasFO }}</span>
            </td>
            <td class="has-text-centered sizePetugas">
              <span>{{ pasien.petugasPerawat }}</span>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="11">
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
      <!-- <span class="is-size-7 has-text-weight-bold">Total Data: <strong>{{totalPasien}}</strong></span> -->
    </div>
</template>

<script>
export default {
  name: 'TablePrintPasienPulang',
  props: ['getPasienPulang', 'tanggalSearch', 'totalKamarDibersihkan', 'totalPasien'],
  data(){
    return {
      tgl: new Date()
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
  methods:{
    hitungWaktu(pasien){
      // console.log("hitung waktu")
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
      // console.log(waktuVerif, waktuLunas)
      if(pasien.keterangan.includes('BPJS')){
        // console.log('BPJS__')
        if(perbedaanWaktu > 240){
          return true
        }
      }else if(pasien.keterangan.includes('IKS')){
        // console.log('IKS')
        if(perbedaanWaktu > 240){
          return true
        }
      }else if(pasien.keterangan.includes('Umum')){
        // console.log('UMUM')
        if(perbedaanWaktu > 120){
          return true
        }
      }
      return false
    }
  }
}
</script>

<style>

</style>