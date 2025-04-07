<template>
    <AuthenticatedPage pageTitle="Measurements">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full min-h-[10%] flex justify-between items-center border-b">
               <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                   <Input type="text" label="Search Keyword" :errorMessage="''" v-model="searchKeyword"/>
                   <Button @click="fetchMeasurements" text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
               </div>

               <div class="flex justify-start items-center gap-2 p-2">
                   <Button text="Add Measurement" buttonType="info" icon="material-symbols:add-rounded" class="translate-y-2.5"/>
               </div>
           </div>

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0">
                   <span class="min-w-[100%] text-left px-2 font-noto font-bold">Name</span>
               </div>
               
               <div v-for="measurement in measurements" v-bind:key="measurement.id" class="w-full flex justify-between items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
                   <span class="text-left px-2 font-medium">{{ measurement.name }}</span>
                   <span title="Update Delivery" class="px-2"><Icon icon="flowbite:edit-solid" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
               </div>
           </div>

       </div>

       <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchMeasurements"/>

   </AuthenticatedPage>

</template>

<script setup>
   import { ref,onMounted } from 'vue';
   import { useRouter } from 'vue-router';
   import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
   import Pagination from '../../Pagination.vue';
   import Input from '../../Form/Input.vue';
   import Button from '../../Button.vue';
   import axios from '../../../axios/axios';
   import { Icon } from '@iconify/vue/dist/iconify.js';
   import Dialog from 'primevue/dialog';
   import { Notify,Loading, Report } from 'notiflix';

   const router = useRouter();
   const measurements = ref([]);

   var pagination = ref({
       page:1,
       total:0
   })

   var searchKeyword = ref('');

   onMounted(() => {
       fetchMeasurements();
   });


   function fetchMeasurements(){
       Loading.dots('Loading Data, Please Wait...',{
           clickToClose:false,
           fontFamily:'Lexend Deca'
       });

       axios.get('measurement/list',{
           params:{
               page:pagination.value.page,
               keyword:searchKeyword.value
           }
       })
       .then((response)=>{
           measurements.value = response.data.measurements
           pagination.value.total = response.data.total
           console.log(response.data)
       })
       .catch((error)=>{
           Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
       })
       .finally(()=>{
           Loading.remove()
       })
   }

   function handleNavigation(path){
      router.push({path:path})
   }


</script>