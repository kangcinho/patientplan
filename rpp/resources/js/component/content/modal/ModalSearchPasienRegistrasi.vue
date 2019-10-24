<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">Daftar Nama Pasien</p>
    </header>
    <section class="modal-card-body">
      <b-field >
        <b-input placeholder="Search..."
          autofocus 
          type="search"
          ref="search"
          icon-pack="fas"
          icon="search" 
          expanded
          rounded
          v-model="searching">
        </b-input>
      </b-field>
      <b-table
          :data="isEmpty ? [] : dataSearch"
          icon-pack="fas"
          paginated
          per-page="5"
          sortIcon="chevron-up"
          sortIconSize="is-small"
          bordered
          striped
          narrowed
          hoverable
          mobile-cards
          style="font-size:11px"
          >

        <template slot-scope="props">
          <b-table-column field="noReg" label="NoReg" centered>
            {{ props.row.noReg }} 
            <span v-if="props.row.isDone">
              <b-icon
                icon="check-circle"
                pack="fas"
              >
              </b-icon>
            </span> 
          </b-table-column>

          <b-table-column field="nrm" label="NRM">
            {{ props.row.nrm }}
          </b-table-column>

          <b-table-column field="namaPasien" label="Nama Pasien">
            {{ props.row.namaPasien }}
          </b-table-column>

          <b-table-column field="kamar" label="Kamar" centered>
              {{ props.row.kamar }}
          </b-table-column>

          <b-table-column field="keterangan" label="Keterangan">
            {{ props.row.keterangan }}
          </b-table-column>

          <b-table-column field="noKartu" label="Kartu">
            {{ props.row.noKartu }}
          </b-table-column>

          <b-table-column label="Action" centered>
            <b-button
              type="is-primary"
              icon-pack="fas"
              size="is-small"
              icon-right="plus"
              @click="fetchData(props.row)">
            </b-button>
          </b-table-column>

          
        </template>

        <template slot="empty">
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
        </template>
      </b-table>
    </section>
  </div>
</template>

<script>
import EventBus from '../../../eventBus'

export default {
  name: "ModalSearchPasienRegistrasi",
  data(){
    return {
      searching: '',
      isEmpty: false
    }
  },
  computed:{
    dataSearch(){
      if(this.searching == ''){
        return this.dataPasienRegistrasi
      }else{
        return this.dataPasienRegistrasi.filter( (data) => {
          return data.namaPasien.toLowerCase().includes(this.searching.toLowerCase())
        })
      }
    },
    dataPasienRegistrasi(){
      return this.$store.getters.getPasienRegistrasi
    }
  },
  methods:{
    fetchData(data){
      EventBus.$emit('fetchData', data)
      this.searching = ''
    }
  },
  mounted(){
    this.$refs.search.focus()
  }
}
</script>

<style>

</style>