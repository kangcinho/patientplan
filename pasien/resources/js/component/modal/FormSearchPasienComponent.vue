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
          >

        <template slot-scope="props">
          <b-table-column field="noReg" label="NoReg" centered>
            {{ props.row.noReg }}
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
import SearchNoRegComponent from './SearchNoRegComponent'
import EventBus from '../../eventBus'

export default {
  name: "FromInputComponent",
  components:{
    SearchNoRegComponent
  },
  data(){
    return {
      isComponentModal: false,
      searching: '',
      datas: [
        { 'noReg': 1, 'namaPasien': 'Nama Pasien', 'nrm': '12.12.12', 'kamar': 'Kamar',  'keterangan': 'Keterangan' },
        { 'noReg': 2, 'namaPasien': 'John', 'nrm': '12.12.12', 'kamar': 'Jacobs',  'keterangan': 'Male' },
        { 'noReg': 3, 'namaPasien': 'Tina', 'nrm': '12.12.12', 'kamar': 'Gilbert',  'keterangan': 'Female' },
        { 'noReg': 4, 'namaPasien': 'Clarence', 'nrm': '12.12.12', 'kamar': 'Flores',  'keterangan': 'Male' },
        { 'noReg': 5, 'namaPasien': 'Anne', 'nrm': '12.12.12', 'kamar': 'Lee',  'keterangan': 'Female' },
        { 'noReg': 1, 'namaPasien': 'Jesse', 'nrm': '12.12.12', 'kamar': 'Simmons',  'keterangan': 'Male' },
        { 'noReg': 2, 'namaPasien': 'John', 'nrm': '12.12.12', 'kamar': 'Jacobs',  'keterangan': 'Male' },
        { 'noReg': 3, 'namaPasien': 'Tina', 'nrm': '12.12.12', 'kamar': 'Gilbert',  'keterangan': 'Female' },
        { 'noReg': 4, 'namaPasien': 'Clarence', 'nrm': '12.12.12', 'kamar': 'Flores',  'keterangan': 'Male' },
        { 'noReg': 5, 'namaPasien': 'Anne', 'nrm': '12.12.12', 'kamar': 'Lee',  'keterangan': 'Female' },
        { 'noReg': 1, 'namaPasien': 'Jesse', 'nrm': '12.12.12', 'kamar': 'Simmons',  'keterangan': 'Male' },
        { 'noReg': 2, 'namaPasien': 'Agus Setiawan', 'nrm': '12.12.12', 'kamar': 'Jacobs',  'keterangan': 'Male' },
        { 'noReg': 3, 'namaPasien': 'Tina', 'nrm': '12.12.12', 'kamar': 'Gilbert',  'keterangan': 'Female' },
        { 'noReg': 4, 'namaPasien': 'Clarence', 'nrm': '12.12.12', 'kamar': 'Flores',  'keterangan': 'Male' },
        { 'noReg': 5, 'namaPasien': 'Anne', 'nrm': '12.12.12', 'kamar': 'Lee',  'keterangan': 'Female' }
      ],
      isEmpty: false
    }
  },
  computed:{
    dataSearch(){
      if(this.searching == ''){
        return this.datas
      }else{
        return this.datas.filter( (data) => {
          return data.namaPasien.toLowerCase().includes(this.searching.toLowerCase())
        })
      }
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