<template>
    <div class="max-w-[95%] w-full h-[98%] flex flex-col justify-center items-center bg-white rounded-lg shadow-md shadow-slate-400">
        <RouterView/>
    </div>
    
</template>

<script setup>
      import { RouterView } from 'vue-router';
</script>