<script setup>
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { defineProps, onMounted, ref } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

const cursos = ref([]);

// get cursos
onMounted(() => {
    axios.get('/cursos')
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

    <Head title="Welcome" />
    <div class="bg-white text-black/50 dark:bg-black dark:text-white/50">

        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <img src="../../assets/img/Emma.png" alt="Emma" class="w-24 h-24" />
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                        </Link>

                        <template v-else>

                            <Link :href="route('dashboard')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Gestió de cursos
                            </Link>

                            <Link :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Iniciar sessió
                            </Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Registrar-se
                            </Link>
                        </template>
                    </nav>
                </header>
                <div class="carousel w-full">
                    <div id="slide1" class="carousel-item relative w-full flex justify-center">
                        <img src="../../assets/img/img1.jpg" class="" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide4" class="btn btn-circle">❮</a>
                            <a href="#slide2" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide2" class="carousel-item relative w-full flex justify-center">
                        <img src="../../assets/img/img2.jpg" class="" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide1" class="btn btn-circle">❮</a>
                            <a href="#slide3" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide3" class="carousel-item relative w-full flex justify-center">
                        <img src="../../assets/img/img3.jpg" class="" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide2" class="btn btn-circle">❮</a>
                            <a href="#slide4" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                    <div id="slide4" class="carousel-item relative w-full flex justify-center">
                        <img src="../../assets/img/img4.jpg" class="" />
                        <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                            <a href="#slide3" class="btn btn-circle">❮</a>
                            <a href="#slide1" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                </div>
                <div class="resume mt-10 text-center">
                    <p class="text-lg text-black dark:text-white/70">
                        Benvingut a la revolució educativa en línia! En aquest entorn virtual d'aprenentatge (EVA),
                        trobaràs una
                        plataforma dinàmica i atractiva per explorar cursos emocionants i gestionar el teu aprenentatge
                        com mai abans.
                        Deixa't inspirar i motiva't per descobrir noves oportunitats d'aprenentatge d'una manera
                        divertida i
                        interactiva. Comença ara i embarca't en el teu viatge d'aprenentatge personalitzat!
                    </p>
                </div>

                <div v-if="cursos.length > 0" class="cursos">
                    <h2 class="text-2xl font-bold text-center mt-10">Cursos</h2>
                    <div class="cursos" v-for="curso in cursos" :key="curso.id">
                        <div class="card w-full bg-base-100 shadow-xl mt-6">
                            <div class="card-body">
                                <h2 class="card-title"> {{ curso.nom }} </h2>
                                <textarea class="textarea textarea-ghost textarea-md resize-none" rows="3" readonly
                                    resize="none"> {{
                    curso.descripcio }} </textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Emma Cardosa | Test Project 2
                </footer>
            </div>
        </div>
    </div>
</template>

<style scoped>
.carousel {
    overflow: hidden;
    position: relative;
    height: 400px;
}
</style>