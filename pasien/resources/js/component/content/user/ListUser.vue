<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">List User</p>
    </header>
    <section class="modal-card-body">
      <div class="columns is-multiline">
        <div class="column is-full">
          <b-field >
            <b-input placeholder="Search Nama User.."
              autofocus 
              type="search"
              ref="search"
              icon-pack="fas"
              icon="search" 
              expanded
              rounded
              v-model="searchNamaUser"
              @keyup.native.enter="searchNamaUserToDB"
              >
            </b-input>
          </b-field>
        </div>
        
        <div class="column is-full">
          <b-button
          icon-pack="fas"
          icon-left="users"
          size="is-small"
          type="is-primary"
          @click="isTambahData? isTambahData = false: isTambahData = true "
          >
            <span v-if="!isTambahData">Tambah User</span>
            <span v-else>Batal Tambah User</span>
          </b-button>
          <table class="table is-bordered is-striped is-narrow" style="width:100%"> 
            <thead>
              <tr>
                <th class="has-text-centered">Username</th>
                <th class="has-text-centered">Email</th>
                <th class="has-text-centered">Nama User</th>
                <th class="has-text-centered">Admin</th>
                <th class="has-text-centered">Insert</th>
                <th class="has-text-centered">Update</th>
                <th class="has-text-centered">Delete</th>
                <th class="has-text-centered">Report</th>
                <th class="has-text-centered">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="isTambahData">
                <td>
                  <b-field :type="errorDataUserNew.username?'is-danger':''">
                    <b-input 
                      size="is-small"
                      placeholder="Username"
                      rounded
                      v-model="dataUserNew.username"
                      >
                    </b-input>
                  </b-field>
                </td>
                <td>
                  <b-field :type="errorDataUserNew.email?'is-danger':''">
                    <b-input 
                      size="is-small"
                      placeholder="kangcinho@gmail.com"
                      rounded
                      type="email"
                      v-model="dataUserNew.email"
                      >
                    </b-input>
                  </b-field>
                </td>
                <td>
                  <b-field :type="errorDataUserNew.namaUser?'is-danger':''"> 
                    <b-input 
                      size="is-small"
                      placeholder="Nama User"
                      rounded
                      v-model="dataUserNew.namaUser"
                      >
                    </b-input>
                  </b-field>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserNew.canAdmin"></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserNew.canInsert"></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserNew.canUpdate"></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserNew.canDelete"></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserNew.canEkspor"></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-button
                    size="is-small"
                    type="is-info"
                    icon-pack="fas"
                    icon-left="save"
                    @click="saveDataUser"
                  >
                  </b-button>
                </td>
              </tr>
              <tr v-for="user in dataUsers" :key="user.idUser">
                <td>
                  <b-field :type="errorDataUserEdit.username?'is-danger':''">
                    <b-input 
                      size="is-small"
                      placeholder="Username"
                      rounded
                      v-model="dataUserEdit.username"
                      v-if="user.isEdit"
                      >
                    </b-input>
                    <span v-else> {{ user.username }} </span>
                  </b-field>
                </td>
                <td>
                  <b-field :type="errorDataUserEdit.email?'is-danger':''">
                    <b-input 
                      size="is-small"
                      placeholder="kangcinho@gmail.com"
                      rounded
                      type="email"
                      v-model="dataUserEdit.email"
                      v-if="user.isEdit"
                      >
                    </b-input>
                    <span v-else> {{ user.email }} </span>
                  </b-field>
                </td>
                <td>
                  <b-field :type="errorDataUserEdit.namaUser?'is-danger':''">
                    <b-input 
                      size="is-small"
                      placeholder="Nama User"
                      rounded
                      v-model="dataUserEdit.namaUser"
                      v-if="user.isEdit"
                      >
                    </b-input>
                    <span v-else> {{ user.namaUser }} </span>
                  </b-field>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserEdit.canAdmin" v-if="user.isEdit"></b-switch>
                  <b-switch type="is-info" v-model="user.canAdmin" v-else disabled></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserEdit.canInsert" v-if="user.isEdit"></b-switch>
                  <b-switch type="is-info" v-model="user.canInsert" v-else disabled></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserEdit.canUpdate" v-if="user.isEdit"></b-switch>
                  <b-switch type="is-info" v-model="user.canUpdate" v-else disabled></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserEdit.canDelete" v-if="user.isEdit"></b-switch>
                  <b-switch type="is-info" v-model="user.canDelete" v-else disabled></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-switch type="is-info" v-model="dataUserEdit.canEkspor" v-if="user.isEdit"></b-switch>
                  <b-switch type="is-info" v-model="user.canEkspor" v-else disabled></b-switch>
                </td>
                <td class="has-text-centered">
                  <b-button 
                    type="is-info"
                    size="is-small"
                    icon-pack="fas"
                    icon-right="edit" 
                    v-if="!user.isEdit"
                    title="Edit Data Pasien"
                    @click="changeToEditMode(user, true)"/>
                  <b-button 
                    type="is-info"
                    size="is-small"
                    icon-pack="fas"
                    icon-right="save" 
                    v-if="user.isEdit"
                    title="Save Data Pasien"
                    @click="updateDataUser(user)"/>
                  <b-button 
                    type="is-warning"
                    size="is-small"
                    icon-pack="fas"
                    icon-right="ban"
                    v-if="user.isEdit"
                    title="Batal Edit Data Pasien"
                    @click="changeToEditMode(user, false)"/>
                  <b-button
                    type="is-danger" 
                    size="is-small"
                    icon-pack="fas"
                    icon-right="trash-alt" 
                    @click="deleteDataUser(user)"/>
                </td>
              </tr>
            </tbody>
          </table>
          <b-pagination
            icon-pack="fas"
            :total="pagging.total"
            :current.sync="pagging.current"
            :range-before="pagging.rangeBefore"
            :range-after="pagging.rangeAfter"
            :per-page="pagging.perPage"
            rounded
            icon-prev="chevron-left"
            icon-next="chevron-right"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page">
          </b-pagination>
        </div>
      </div>
    </section>
    <b-loading is-full-page :active.sync="isLoading" :can-cancel="false"></b-loading>
  </div>
</template>

<script>
import ModalKonfirmasiHapusData from '../modal/ModalKonfirmasiHapusData'
import EventBus from '../../../eventBus'
export default {
  name: 'ListUser',
  components:{
    ModalKonfirmasiHapusData
  },
  data(){
    return {
      isTambahData: false,
      errorDataUserNew:{
        username: false,
        email: false,
        namaUser: false
      },
      dataUserNew:{
        username: null,
        email: null,
        namaUser: null,
        canAdmin: false,
        canInsert: false,
        canUpdate: false,
        canDelete: false,
        canEkspor: false
      },
      errorDataUserEdit:{
        username: false,
        email: false,
        namaUser: false
      },
      dataUserEdit:{
        idUser: null,
        username: null,
        email: null,
        namaUser: null,
        canAdmin: false,
        canInsert: false,
        canUpdate: false,
        canDelete: false,
        canEkspor: false
      },
      pagging:{
        total: 0,
        current: 1,
        perPage: 8,
        rangeBefore: 2,
        rangeAfter: 2
      },
      disableEdit: false,
      searchNamaUser: null,
      isLoading: false
    }
  },
  mounted(){
    let firstPage,lastPage      
    firstPage = (this.pagging.current - 1) * this.pagging.perPage
    lastPage = this.pagging.perPage
    this.isLoading = true
    this.$store.dispatch('getDataUser', {firstPage,lastPage, searchNamaUser: this.searchNamaUser})
    .then( (respon) => {
      this.isLoading = false
      this.pagging.total =  this.$store.getters.getDataUserTotal
    })
    .catch( (respon) => {
      this.isLoading = false
      this.$buefy.notification.open({
        message: respon,
        type: 'is-danger',
      })
    })
  },
  computed:{
    dataUsers(){
      return this.$store.getters.getDataUser
    }
  },
  watch:{
    'pagging.current'(newVal, oldVal){
      let firstPage,lastPage      
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      this.isLoading = true
      this.$store.dispatch('getDataUser', {firstPage,lastPage, searchNamaUser: this.searchNamaUser})
      .then( (respon) => {
        this.isLoading = false
        this.pagging.total =  this.$store.getters.getDataUserTotal
        console.log(this.pagging.total)
      })
      .catch( (respon) => {
        this.isLoading = false
      })
    },
  },
  methods:{
    saveDataUser(){
      if(this.validasiSaveData(this.dataUserNew, this.errorDataUserNew)){
        this.isLoading = true
        this.$store.dispatch('saveDataUser', this.dataUserNew)
        .then( (respon) => {
          this.isLoading = false
          this.isTambahData = false
          this.hapusFieldAll()
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
    },
    updateDataUser(userData){
      this.dataUserEdit.idUser = userData.idUser
      if(this.validasiSaveData(this.dataUserEdit, this.errorDataUserEdit)){
        userData.isEdit = false
        this.isLoading = true
        this.$store.dispatch('updateDataUser', this.dataUserEdit)
        .then( (respon) => {
          this.isLoading = false
          this.isTambahData = false
          this.disableEdit = false
          this.hapusFieldAll()
          this.$buefy.notification.open({
            message: respon,
            type: 'is-success'
          })
        })
        .catch( (respon) => {
          this.isLoading = false
          this.isTambahData = false
          this.disableEdit = false
          this.$buefy.notification.open({
            message: respon,
            type: 'is-danger',
          })
        })
      }
    },
    deleteDataUser(userData){
      const nama = userData.namaUser
      const id = userData.isUser
      this.$buefy.modal.open({
        parent: this,
        component: ModalKonfirmasiHapusData,
        hasModalCard: true,
        props:{
          'nama': userData.namaUser,
          'data': userData,
          'method': 'deleteDataUser'
        }
      })
    },
    validasiSaveData(dataUser, errorDataUser){
      if(dataUser.username == null || dataUser.username == ''){
        errorDataUser.username = true
        return false
      }else{
        errorDataUser.username = false
      }
      if(dataUser.email == null || dataUser.email == ''){
        errorDataUser.email = true
        return false
      }else{
        errorDataUser.email = false
      }
      if(dataUser.namaUser == null || dataUser.namaUser == ''){
        errorDataUser.namaUser = true
        return false
      }else{
        errorDataUser.namaUser = false
      }
      return true
    },
    changeToEditMode(userData, mode){
       //Can Edit Only One Field Live
      if(!mode){
        this.hapusFieldAll()
        this.disableEdit = false
      }
      if(!this.disableEdit){
        this.dataUsers.map( (pasien) => {
          if(pasien.idUser === userData.idUser){
            pasien.isEdit = mode
            if(mode){
              this.disableEdit = true
              this.fillData(userData)
            }
          }
        })
      }
    },
    hapusFieldAll(){
      this.dataUserNew.username = this.dataUserNew.email = this.dataUserNew.namaUser = this.dataUserEdit.username = this.dataUserEdit.email = this.dataUserEdit.namaUser = this.dataUserEdit.idUser = null 
      this.dataUserNew.canAdmin = this.dataUserNew.canInsert = this.dataUserNew.canUpdate = this.dataUserNew.canDelete = this.dataUserNew.canEkspor = this.dataUserEdit.canAdmin = this.dataUserEdit.canInsert = this.dataUserEdit.canUpdate = this.dataUserEdit.canDelete = this.dataUserEdit.canEkspor = this.errorDataUserNew.username = this.errorDataUserNew.email = this.errorDataUserNew.namaUser = false    
    },
    fillData(userData){
      this.dataUserEdit.idUser = userData.idUser
      this.dataUserEdit.username = userData.username
      this.dataUserEdit.email = userData.email
      this.dataUserEdit.namaUser = userData.namaUser
      this.dataUserEdit.canAdmin = userData.canAdmin
      this.dataUserEdit.canInsert = userData.canInsert
      this.dataUserEdit.canUpdate = userData.canUpdate
      this.dataUserEdit.canDelete = userData.canDelete
      this.dataUserEdit.canEkspor = userData.canEkspor
    },
    searchNamaUserToDB(){
      let firstPage,lastPage      
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      this.isLoading = true
      this.$store.dispatch('getDataUser', {firstPage,lastPage, searchNamaUser: this.searchNamaUser})
      .then( (respon) => {
        this.isLoading = false
        this.pagging.total =  this.$store.getters.getDataUserTotal
        this.pagging.current = 1
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