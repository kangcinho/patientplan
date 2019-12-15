<template>
  <div class="column is-11">
    <b-field label="Pilih Bulan Analisa Mutu">
      <b-datepicker
        type="month"
        placeholder="Pilih Bulan Analisa Mutu"
        icon-pack="fas"
        icon="calendar"
        v-model="analisaMutu.bulanAnalisa"
        @input="analisa"
        :date-formatter="(date) => $moment(date).format('MMM YYYY')">
      </b-datepicker>
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
        bulanAnalisa: null
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