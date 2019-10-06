<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">Konfirmasi Hapus Data</p>
    </header>
    <section class="modal-card-body">
      Apa Anda Yakin Menghapus Data Pasien {{ dataPasien.namaPasien }} ?
    </section>
      <footer class="modal-card-foot">
          <button class="button" type="button" @click="$parent.close()">Batal</button>
          <b-button 
            type="is-danger"
            icon-left="trash"
            icon-pack="fas"
            @click="deleteDataPasienPulang">
            Hapus
          </b-button>
      </footer>
  </div>
</template>

<script>
export default {
  name:"ModalKonfirmasiHapusData",
  props:['dataPasien'],
  methods:{
    deleteDataPasienPulang(){
      this.$store.dispatch('deleteDataPasienPulang', this.dataPasien)
      .then( (respon) => {
        this.$parent.close()
        this.$buefy.notification.open({
          message: respon,
          type: 'is-success'
        })
      })
      .catch( (respon) => {
        this.$buefy.notification.open({
          message: respon,
          type: 'is-danger'
        })
      })
    }
  }
}
</script>

<style>

</style>