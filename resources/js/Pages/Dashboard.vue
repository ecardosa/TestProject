<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
// ckEditor
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const value = ref('');
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="carousel w-full">
  <div id="slide1" class="carousel-item relative w-full">
    <img src="https://daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.jpg" class="w-full" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide4" class="btn btn-circle">❮</a> 
      <a href="#slide2" class="btn btn-circle">❯</a>
    </div>
  </div> 
  <div id="slide2" class="carousel-item relative w-full">
    <img src="https://daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.jpg" class="w-full" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide1" class="btn btn-circle">❮</a> 
      <a href="#slide3" class="btn btn-circle">❯</a>
    </div>
  </div> 
  <div id="slide3" class="carousel-item relative w-full">
    <img src="https://daisyui.com/images/stock/photo-1414694762283-acccc27bca85.jpg" class="w-full" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide2" class="btn btn-circle">❮</a> 
      <a href="#slide4" class="btn btn-circle">❯</a>
    </div>
  </div> 
  <div id="slide4" class="carousel-item relative w-full">
    <img src="https://daisyui.com/images/stock/photo-1665553365602-b2fb8e5d1707.jpg" class="w-full" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide3" class="btn btn-circle">❮</a> 
      <a href="#slide1" class="btn btn-circle">❯</a>
    </div>
  </div>
</div>

        <div class="ckeditor">
            <ckeditor :editor="ClassicEditor" v-model="value" />
        </div>
        <p>{{ value }}</p>
    </AuthenticatedLayout>
</template>
