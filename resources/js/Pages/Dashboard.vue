<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, defineEmits, defineProps } from 'vue';
import axios from 'axios';
import AddRecursModal from '@/Components/AddRecursModal.vue';
import { useForm } from '@inertiajs/vue3';




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

function getCursos() {
    axios.get('/dashboard/cursos')
        .then(response => {
            console.log(response.data);
            cursos.value = response.data;
        })
        .catch(error => {
            console.log(error);
        });
}

// delete curso

const deleteCurso = (id) => {
    if (confirm("¿Estas segur de que vols eliminar aquest curs?")) {
        axios.delete(`/dashboard/cursos/delete/${id}`)
            .then(response => {
                console.log(response.data);
                cursos.value = cursos.value.filter(curso => curso.id !== id);
            })
            .catch(error => {
                console.log(error);
            });
    }
};

// delete recurs

const deleteRecurso = (id) => {
    if (confirm("¿Estas segur de que vols eliminar aquest recurs?")) {
        axios.delete(`/dashboard/recursos/delete/${id}`)
            .then(response => {
                console.log(response.data);
                cursos.value = cursos.value.map(curso => {
                    curso.recursos = curso.recursos.filter(recurso => recurso.id !== id);
                    return curso;
                });
            })
            .catch(error => {
                console.log(error);
            });
    }
};


// modal afegir curs  id="my_modal_3_afegircurs"
const afegircurs = {
    showModal() {
        const modal = document.getElementById('my_modal_3_afegircurs');
        if (modal) {
            modal.showModal();
        } else {
            console.error("No se pudo encontrar el elemento modal.");
        }
    },
    closeModal() {
        const modal = document.getElementById('my_modal_3_afegircurs');
        if (modal) {
            modal.close();
        }
    }
};

const afegirCursForm = useForm({
    nom: '',
    etapa: '',
    descripcio: ''
});

const submit = () => {
    console.log(afegirCursForm);
    axios.post('/dashboard/cursos/add', afegirCursForm)
        .then(response => {
            console.log(response.data);
            getCursos();
            afegirCursForm.nom = '';
            afegirCursForm.descripcio = '';
            afegircurs.closeModal();
        })
        .catch(error => {
            console.log(error);
        });
};


// edit curs
const editarCursForm = useForm({
    nom: '',
    etapa: '',
    descripcio: '',
    id: '',
    visible: 1
});

const editarcurs = {
    showModal(cursoId) {
        const curso = cursos.value.find(curso => curso.id === cursoId);
        editarCursForm.nom = curso.nom;
        editarCursForm.etapa = curso.etapa;
        editarCursForm.descripcio = curso.descripcio;
        editarCursForm.visible = curso.visible;
        const modal = document.getElementById(`my_modal_3_editarcurs_${cursoId}`);
        if (modal) {
            modal.showModal();
        } else {
            console.error("No se pudo encontrar el elemento modal.");
        }
    },
    closeModal(cursoId) {
        const modal = document.getElementById(`my_modal_3_editarcurs_${cursoId}`);
        if (modal) {
            modal.close();
        }
    }
};

const submitEdit = (cursoId) => {
    editarCursForm.id = cursoId;
    editarCursForm.post('/dashboard/cursos/edit'), {
        onSuccess: response => {
            console.log(response.data);
            getCursos();
            
            editarcurs.closeModal(cursoId);
        }
    };
    getCursos();
    editarcurs.closeModal(cursoId);
};

// handle checkbox visible, if checked, visible = 1, else visible = 0, by id
const handleCheckbox = (cursoId) => {
    const checkbox = document.getElementById(`visible_${cursoId}`);
    if (checkbox.checked) {
        editarCursForm.visible = 1;
        console.log(editarCursForm.visible);
    } else {
        editarCursForm.visible = 0;
        console.log(editarCursForm.visible);
    }
};



// edit recurs
const editarrecurs = {
    showModal(recursId) {
        const recurs = cursos.value.reduce((acc, curso) => {
            const recurs = curso.recursos.find(recurs => recurs.id === recursId);
            if (recurs) {
                acc = recurs;
            }
            return acc;
        }, {});

        editarRecursForm.titol = recurs.titol;
        editarRecursForm.contingut = recurs.contingut;
        editarRecursForm.id = recurs.id;
        editarRecursForm.curs_id = recurs.curs_id;
        editarRecursForm.visible = recurs.visible;

        const modal = document.getElementById(`my_modal_3_editarrecurs_${recursId}`);
        if (modal) {
            modal.showModal();
        } else {
            console.error("No se pudo encontrar el elemento modal.");
        }
    },
    closeModal(recursId) {
        const modal = document.getElementById(`my_modal_3_editarrecurs_${recursId}`);
        if (modal) {
            modal.close();
        }
    }
};

const editarRecursForm = useForm({
    titol: '',
    contingut: '',
    id: '',
    curs_id: '',
    visible: 1

});



const submitEditRecurs = (recursId) => {
    editarRecursForm.id = recursId;
    editarRecursForm.post('/dashboard/recursos/edit'), {
        onSuccess: response => {
            console.log(response.data);
            getCursos();
            editarrecurs.closeModal(recursId);
        }
    };
    getCursos();
    editarrecurs.closeModal(recursId);
};

// handle checkbox recurs
const handleCheckboxrecurs = (recursId) => {
    const checkbox = document.getElementById(`visible_${recursId}`);
    if (checkbox.checked) {
        editarRecursForm.visible = 1;
        console.log(editarRecursForm.visible);
    } else {
        editarRecursForm.visible = 0;
        console.log(editarRecursForm.visible);
    }
};


</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>

<div class="flex items-center justify-end mt-4">
        <button class="btn flex items-center justify-center btn-outline p-4"
         @click="afegircurs.showModal()">Afegir curs</button>
    </div>
        <dialog id="my_modal_3_afegircurs" class="modal">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="font-bold text-lg">Afegir nou curs</h3>
                <form @submit.prevent="submit">


                    <label for="nom" class="label">Nom del curs</label>
                    <input type="text" id="nom" v-model="afegirCursForm.nom" class="input input-bordered mb-4 w-full"
                        placeholder="Nom del curs" />

                    <label for="etapa" class="label">Etapa del curs</label>
                    <input type="text" id="etapa" v-model="afegirCursForm.etapa" class="input input-bordered mb-4 w-full"
                        placeholder="Etapa del curs" />

                    <label for="descripcio" class="label">Descripció del curs</label>
                    <textarea id="descripcio" v-model="afegirCursForm.descripcio"
                        class="textarea textarea-bordered mb-4 w-full" placeholder="Descripció del curs"></textarea>

                    <button class="btn btn-primary" type="submit">Afegir</button>
                </form>
            </div>
        </dialog>


        <div v-if="cursos.length > 0" class="cursos p-10">
            <h2 class="text-2xl font-bold text-center">Cursos</h2>
            <div class="cursos" v-for="curso in cursos" :key="curso.id">
                <div class="card w-full bg-base-100 shadow-xl mt-6 border-2 border-base-200">
                    <div class="card-body">
                        <h2 class="card-title"> {{ curso.nom }} </h2>
                        <div class="form-control">

                        </div>
                        <textarea class="textarea textarea-ghost textarea-md resize-none" rows="3" readonly
                            resize="none"> {{
                                curso.descripcio }} 
                        </textarea>

                        <h2 v-if="curso.recursos.length > 0"
                        class="text-2xl font-bold text-center mt-10">Recursos del curs
                           </h2>
                        <div v-for="recurs in curso.recursos" :key="recurs.id">
                            <div class="bg-base-200 p-4 mt-4 rounded-box">


                                <h3 class="text-xl font-bold">
                                    {{ recurs.titol }} </h3>
                                <p v-html="recurs.contingut"></p>

                                <div class="card-actions justify-center">
                                    <button class="btn btn-outline" @click="editarrecurs.showModal(recurs.id)">Editar
                                        recurs</button>
                                    <dialog :id="'my_modal_3_editarrecurs_' + recurs.id" class="modal">
                                        <div class="modal-box">
                                            <form method="dialog">
                                                <button
                                                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                            </form>
                                            <h3 class="font-bold text-lg">Editar recurs {{ recurs.id }}</h3>
                                            <form @submit.prevent="submitEditRecurs(recurs.id)">
                                                <label for="titol" class="label">Títol del recurs</label>
                                                <input type="text" id="titol" v-model="editarRecursForm.titol"
                                                    class="input input-bordered mb-4" placeholder="Títol del recurs" />

                                                <div class="form-control">
                                                    <label class="label cursor-pointer">
                                                <span class="label-text">Visible</span>
                                                <input type="checkbox" class="checkbox" :id="'visible_' + recurs.id"
                                                    @change="handleCheckboxrecurs(recurs.id)">
                                            </label>
                                                </div>
                                                <label for="contingut" class="label">Contingut del recurs</label>
                                                <Ckeditor :editor="ClassicEditor"
                                                    v-model="editarRecursForm.contingut" />


                                                <button class="btn btn-primary" type="submit">Editar</button>
                                            </form>

                                        </div>
                                    </dialog>
                                    <button class="btn btn-error" @click="deleteRecurso(recurs.id)">Eliminar</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-actions justify-center mt-4">

                            <button class="btn btn-outline" @click="editarcurs.showModal(curso.id)">Editar</button>
                            <dialog :id="'my_modal_3_editarcurs_' + curso.id" class="modal">
                                <div class="modal-box">
                                    <form method="dialog">
                                        <button
                                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                    </form>
                                    <h3 class="font-bold text-lg">Editar curs {{ curso.id }}</h3>
                                    <form @submit.prevent="submitEdit(curso.id)">
                                        <label for="nom" class="label">Nom del curs</label>
                                        <input type="text" id="nom" v-model="editarCursForm.nom"
                                            class="input input-bordered mb-4 w-full" placeholder="Nom del curs" />

                                        <label for="etapa" class="label">Etapa del curs</label>
                                        <input type="text" id="etapa" v-model="editarCursForm.etapa"
                                            class="input input-bordered mb-4 w-full" placeholder="Etapa del curs" />

                                        <div class="form-control">
                                            <label class="label cursor-pointer">
                                                <span class="label-text">Visible</span>
                                                <input type="checkbox" class="checkbox" :id="'visible_' + curso.id"
                                                    @change="handleCheckbox(curso.id)">
                                            </label>
                                        </div>

                                        <label for="descripcio" class="label">Descripció del curs</label>
                                        <textarea id="descripcio" v-model="editarCursForm.descripcio"
                                            class="textarea textarea-bordered mb-4 w-full"
                                            placeholder="Descripció del curs"></textarea>

                                        <button class="btn btn-primary" type="submit">Editar</button>
                                    </form>
                                </div>
                            </dialog>
                            <button class="btn btn-error" @click="deleteCurso(curso.id)">Eliminar</button>
                            <AddRecursModal :curso="curso" :recursos="curso.recursos" />
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
