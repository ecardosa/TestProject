<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
// ckEditor
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
const value = ref('');
const cursos = ref([]);

onMounted(() => {
    axios.get('/dashboard/cursos')
        .then(response => {
            console.log(response.data);
            cursos.value = response.data;
        })
        .catch(error => {
            console.log(error);
        });
});


</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div v-if="cursos.length > 0" class="cursos">
            <h2 class="text-2xl font-bold text-center mt-10">Cursos</h2>
            <div class="cursos" v-for="curso in cursos" :key="curso.id">
                <div class="card w-full bg-base-100 shadow-xl mt-6">
                    <div class="card-body">
                        <h2 class="card-title"> {{ curso.nom }} </h2>
                        <textarea class="textarea textarea-ghost textarea-md resize-none" rows="3" readonly
                            resize="none"> {{
                                curso.descripcio }} 
                        </textarea>
                        <div v-for="recurs in curso.recursos" :key="recurs.id">
                            <div class="bg-base-200 p-4 mt-4 rounded-box">
                            
                              
                           <h3 class="text-xl font-bold"> 
                            {{ recurs.titol }} </h3>
                            <p v-html="recurs.contingut"></p>
                        </div>
                        </div>

                        <div class="card-actions justify-center">

                            <button class="btn btn-primary">Editar</button>
                            <button class="btn btn-error">Eliminar</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- <div class="ckeditor">
            <ckeditor :editor="ClassicEditor" v-model="value" />
        </div>
        <p>{{ value }}</p> -->
    </AuthenticatedLayout>
</template>
