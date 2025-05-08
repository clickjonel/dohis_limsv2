<template>
    <AuthenticatedPage pageTitle="Pre Inspection Requests">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full min-h-[10%] flex justify-between items-center border-b">
               <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                   <Input v-model="searchKeyword" type="text" label="Search Keyword" :errorMessage="''"/>
                   <Button text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
               </div>

               <div class="flex justify-start items-center gap-2 p-2">
                   <!-- <Button @click="addPropertyModal = true" text="Add A Property" buttonType="info" icon="material-symbols:add-rounded" class="translate-y-2.5"/> -->
               </div>
           </div>

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black">
                   <span class="min-w-[10%]">Equipment</span>
                   <span class="min-w-[25%]">Property #</span>
                   <span class="min-w-[20%]">Requested By</span>
                   <span class="min-w-[15%]">Defects</span>
                   <span class="min-w-[10%]">Date</span>
                   <span class="min-w-[20%]">Actions</span>
               </div>
               
               
           </div>

       </div>

       <!-- <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchProperties"/> -->

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
   import Select from 'primevue/select';
   import TextArea from '../../TextArea.vue';

    const router = useRouter();

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

   onMounted(() => {
      
   });




</script>