<template>

    <main class="w-full min-h-screen h-screen flex justify-start items-center bg-[url('./assets/bg-image-honeycomb.png')] bg-cover bg-center bg-no-repeat gap-4">
       <Sidebar></Sidebar>

       <RouterView/>

   </main>

</template>

<script setup>
    import { RouterView } from 'vue-router';
    import Sidebar from '../Sidebar.vue'
</script>