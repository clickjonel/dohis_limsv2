<template>
    <div class="relative w-full flex flex-col justify-start items-start">                         
       <input v-model="model" :type="props.type" class="w-[95%] bg-white p-2 outline-none shadow-slate-600 shadow-md font-lexend" placeholder="Search"/>
   </div>
</template>

<script setup>

   const props = defineProps({
       type: String,
       label: String,
   });

   const model = defineModel();
   
</script>