<template>
  <section>
    <button class="button is-primary is-medium"
      @click="isComponentModal = true">
      Launch component modal
    </button>

    <b-modal :active.sync="isComponentModal" >
      <FormInputComponent></FormInputComponent>
    </b-modal>
  </section>
</template>

<script>
import FormInputComponent from './FormInputComponent'
export default {
  name: 'ModalComponent',
  components:{
    FormInputComponent
  },
  data(){
    return {
      isComponentModal: false
    }
  }
}
</script>

<style>

</style>