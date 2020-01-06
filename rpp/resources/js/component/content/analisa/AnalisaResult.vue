<template>
  <div class="column is-11" v-if="tabelAnalisa.length > 0" >
    <h1 class="is-size-6">Kesesuaian Mutu Pelayanan Pasien Pulang</h1>
    <table class="table is-bordered is-striped is-narrow is-fullwidth" style="font-size:0.8em">
      <thead>
        <tr>
          <th>Waktu</th>
          <th>Pasien Umum Sesuai Mutu</th>
          <th>Pasien Umum Tidak Sesuai Mutu</th>
          <th>Pasien IKS Sesuai Mutu</th>
          <th>Pasien IKS Tidak Sesuai Mutu</th>
          <th>Pasien BPJS Sesuai Mutu</th>
          <th>Pasien BPJS Tidak Sesuai Mutu</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(analisa,index) in tabelAnalisa" :key="index">
          <td> {{ analisa.tanggal }} </td>
          <td> {{ Math.round(((analisa.umumMutuValid / analisa.umumMutu) * 100) * 100) / 100 }} % </td>
          <td> {{ Math.round(((analisa.umumMutuNonValid / analisa.umumMutu) * 100) * 100) / 100 }} % </td>
          <td> {{ Math.round(((analisa.iksMutuValid / analisa.iksMutu) * 100) * 100) / 100 }} % </td>
          <td> {{ Math.round(((analisa.iksMutuNonValid / analisa.iksMutu) * 100) * 100) / 100 }} % </td>
          <td> {{ Math.round(((analisa.bpjsMutuValid / analisa.bpjsMutu) * 100) * 100) / 100 }} % </td>
          <td> {{ Math.round(((analisa.bpjsMutuNonValid / analisa.bpjsMutu) * 100) * 100) / 100 }} %</td>
        </tr>
      </tbody>
    </table>

    <h1 class="is-size-6">Jumlah Pasien Pulang Rawat Inap</h1>
    <table class="table is-bordered is-striped is-narrow is-fullwidth" style="font-size:0.8em">
      <thead>
        <tr>
          <th>Waktu</th>
          <th>Pasien Umum</th>
          <th>Pasien IKS</th>
          <th>Pasien BPJS</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(analisa,index) in tabelAnalisa" :key="index">
          <td> {{ analisa.tanggal }} </td>
          <td> {{ analisa.umumMutu }} </td>
          <td> {{ analisa.iksMutu }} </td>
          <td> {{ analisa.bpjsMutu }} </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  name: "AnalisaResultComponent",
  computed:{
    tabelAnalisa(){
      return this.$store.getters.getTabelAnalisa.filter( (analisa) => {
        return analisa.tanggal != null
      })
    }
  },
}
</script>

<style>

</style>