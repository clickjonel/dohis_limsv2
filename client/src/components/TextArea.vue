<template>
    <div class="w-full flex flex-col justify-start items-start font-lexend">       
       <span class="ml-3 translate-y-1/2 bg-gray-300 rounded-sm text-sm px-2 text-black">{{ props.label }}</span>                  
       <textarea v-model="model" class="w-[95%] bg-white px-2 py-3 outline-none shadow-slate-600 shadow-md text-black" :class="props.errorMessage !== '' ? 'border-2 border-rose-900' : 'border-none' "></textarea>
       <span v-if="errorMessage !== ''" class="w-full text-xs text-rose-900 mt-1">{{ props.errorMessage }}</span>
   </div>
</template>

<script setup>

   const props = defineProps({
       label: String,
       errorMessage:String
   });

   const model = defineModel();
   
</script>