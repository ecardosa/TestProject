<script setup>
import { defineProps } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

const value = ref('');

const props = defineProps({
  curso: Object,
  recursos: Array
});

const my_modal_3 = {
  showModal(cursoId) {
    const modal = document.getElementById(`my_modal_${cursoId}`);
    if (modal) {
      modal.showModal();
    } else {
      console.error("No se pudo encontrar el elemento modal.");
    }
  },
  closeModal(cursoId) {
    const modal = document.getElementById(`my_modal_${cursoId}`);
    if (modal) {
      modal.close();
    }
  }
};

const form = useForm({
  titol: '',
  contingut: '',
  curs_id: props.curso.id
});

const submit = () => {
  axios.post('/dashboard/recursos/add', form)
    .then(response => {
      console.log(response.data);
      
      props.curso.recursos = [...props.curso.recursos];
      props.curso.recursos.push(response.data);

      form.titol = '';
      form.contingut = '';
      my_modal_3.closeModal(form.curs_id);
    })
    .catch(error => {
      console.log(error);
    });
};
</script>

<template>
  <button class="btn" @click="my_modal_3.showModal(props.curso.id)">Afegir recurs</button>
  <dialog :id="'my_modal_' + props.curso.id" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>
      <h3 class="font-bold text-lg">Afegir recurs a {{ props.curso.nom }}</h3>
      <form @submit.prevent="submit">
        <div class="form-group">
          <label for="titol m-2">Títol</label>
          <input type="text" id="titol" v-model="form.titol" class="input input-primary m-2" />
        </div>

        <div class="ckeditor mt-4">
          <ckeditor :editor="ClassicEditor" v-model="form.contingut" />
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Afegir</button>
        </div>
      </form>
    </div>
  </dialog>
</template>

<style scoped>
/* Estilos del modal */
</style>
