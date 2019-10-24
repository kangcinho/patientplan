<template>
  <div class="column is-full">
      <div class="has-text-centered">
        <h3 class="is-size-5 has-text-weight-bold">Riwayat Pasien Pulang Tanggal {{ tanggalSearch | moment("DD MMM YYYY") }}</h3>
      </div>
      <span class="is-size-7 has-text-weight-bold">Clean Kamar: <strong>{{ totalKamarDibersihkan }}</strong></span>
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
          <tr v-for="pasien in getPasienPulang" :key="pasien.idPasien">
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
            <td class="has-text-centered wrapWord sizeKeterangan">{{ pasien.keterangan }}  <br/> <strong>{{ pasien.namaDokter }}</strong> <br/> {{ pasien.noKartu }}</td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuVerif  }}</span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuIKS  }}</span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuSelesai }}</span>
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuPasien  }}</span>           
            </td>
            <td class="has-text-centered sizeWaktu">
              <span>{{ pasien.waktuLunas  }}</span>         
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
      <span class="is-size-7 has-text-weight-bold">Total Data: <strong>{{totalPasien}}</strong></span>
    </div>
</template>

<script>
export default {
  name: 'TablePrintPasienPulang',
  props: ['getPasienPulang', 'tanggalSearch', 'totalKamarDibersihkan', 'totalPasien'],
  filters:{
    showOnlyTime: (datetime) => {
      if(datetime != null){
        return datetime.split(' ')[1]
      }
      return datetime
    },
  }
}
</script>

<style>

</style>