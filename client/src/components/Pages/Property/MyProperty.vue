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
                   <span class="min-w-[30%] max-w-[30%]">Article</span>
                   <span class="min-w-[20%]">Cost</span>
                   <span class="min-w-[15%]">Acquisition Date</span>
                   <span class="min-w-[10%]">Status</span>
                   <span class="min-w-[15%]">Actions</span>
               </div>
               
               <div v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400 text-black">
                   <span class="min-w-[10%]">{{ property.property_no }}</span>
                   <span class="min-w-[30%] max-w-[30%] text-xs">{{ property.particulars }}</span>
                   <span class="min-w-[20%] text-xs">{{ property.unit_cost }}</span>
                   <span class="min-w-[15%]">{{ property.user.issuance_date }}</span>
                   <span class="min-w-[10%]">{{ property.status }}</span>
                   <div class="min-w-[15%] flex justify-center items-start gap-2">
                      
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
    import InputText from 'primevue/inputtext';
    import FloatLabel from 'primevue/floatlabel';
    import InputNumber from 'primevue/inputnumber';
    import DatePicker from 'primevue/datepicker';
    import { useAuthStore } from '../../../stores/authStore';

    const router = useRouter();
    const properties = ref([]);
    const users = ref([]);
    const authStore = useAuthStore();
    

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

    var errors = ref({})

   onMounted(() => {
       fetchProperties();
       fetchUserSelection();
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

    function fetchUserSelection(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('user/selection',{
            params:{
                
            }
        })
        .then((response)=>{
            users.value = response.data.users
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }


</script>