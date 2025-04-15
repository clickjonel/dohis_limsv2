<template>
    <AuthenticatedPage pageTitle="Properties (as of January 2025)">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full min-h-[10%] flex justify-between items-center border-b">
               <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                   <Input v-model="searchKeyword" type="text" label="Search Keyword" :errorMessage="''"/>
                   <Button @click="fetchProperties" text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
               </div>

           </div>

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black">
                   <span class="min-w-[10%]">Property #</span>
                   <span class="min-w-[35%]">Article</span>
                   <span class="min-w-[20%]">Cost</span>
                   <span class="min-w-[10%]">Acquisition Date</span>
                   <span class="min-w-[20%]">Actions</span>
               </div>
               
               <div v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400 text-black">
                   <span class="min-w-[10%]">{{ property.property_no }}</span>
                   <span class="min-w-[35%] max-w-[35%] text-xs">{{ property.particulars }}</span>
                   <span class="min-w-[20%] text-xs">{{ property.unit_cost }}</span>
                   <span class="min-w-[10%]">{{ property.user.issuance_date }}</span>
                   <div class="min-w-[20%] flex justify-center items-center gap-2">
                        <!-- <span title="Update Delivery"><Icon icon="flowbite:edit-solid" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
                        <span title="Print IAR"><Icon icon="material-symbols:print-rounded" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/></span> -->
                   </div>
               </div>
           </div>

       </div>

       <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchProperties"/>

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
    const properties = ref([]);
    const end_users = ref([])
    const measurements = ref([])
    const statuses = ref([
        {
            name:'Active',
        },
        {
            name:'Stock',
        },
        {
            name:'Waste',
        }
    ])

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

   onMounted(() => {
       fetchProperties();
   });


   function fetchProperties(){
       Loading.dots('Loading Data, Please Wait...',{
           clickToClose:false,
           fontFamily:'Lexend Deca'
       });
       
       axios.get('property/user',{
           params:{
                page:pagination.value.page,
                keyword:searchKeyword.value
           }
       })
       .then((response)=>{
           properties.value = response.data.properties
           pagination.value.total = response.data.total
           console.log(response.data)
       })
       .catch((error)=>{
           Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
           console.log(error.response.data)
       })
       .finally(()=>{
           Loading.remove()
       })
   }

   function handleNavigation(path){
      router.push({path:path})
   }

   function clearAddPropertyForm(){
        property.value.property_no =''
        property.value.measurement_unit =0
        property.value.particulars =''
        property.value.unit_cost =0
        property.value.status =''
        property.value.remarks =''
        property.value.end_user =0 
        property.value.acquisition_date = ''
   }


</script>