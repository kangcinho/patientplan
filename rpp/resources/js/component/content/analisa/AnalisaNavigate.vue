<template>
<div class="column is-11">
  <b-field grouped>
    <b-field label="Pilih Awal Analisa Mutu" expanded>
      <b-datepicker
        placeholder="Pilih Awal Analisa Mutu"
        icon-pack="fas"
        icon="calendar"
        v-model="analisaMutu.awalAnalisa"
        :date-formatter="(date) => $moment(date).format('DD MMM YYYY')">
      </b-datepicker>
    </b-field>
    <b-field label="Pilih Akhir Analisa Mutu" expanded>
      <b-datepicker
        placeholder="Pilih Akhir Analisa Mutu"
        icon-pack="fas"
        icon="calendar"
        v-model="analisaMutu.akhirAnalisa"
        @input="analisa"
        :min-date="analisaMutu.awalAnalisa"
        :date-formatter="(date) => $moment(date).format('DD MMM YYYY')"
        :disabled="analisaMutu.awalAnalisa == null">
      </b-datepicker>
    </b-field>
  </b-field>
  <b-loading is-full-page :active.sync="isLoading" :can-cancel="false"></b-loading>
</div>
</template>

<script>
export default {
  name: "AnalisaNavigateComponent",
  data(){
    return {
      analisaMutu:{
        awalAnalisa: null,
        akhirAnalisa: null
      },
      isLoading: false
    }
  },
  methods:{
    analisa(){
      this.isLoading = true
      this.$store.dispatch('analisa',this.analisaMutu)
      .then( (respon) => {
        this.isLoading = false
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
    }
  }
}
</script>

<style>

</style>