<template>

    <AuthenticatedPage>
         <div class="w-full flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll p-2">
             <Panel header="Property" class="w-full font-poppins" style="background-color:aquamarine">
                <FloatLabel variant="on" class="w-full">
                    <Textarea v-model="property.particulars" rows="2" class="w-full"/>
                    <label>Particulars</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full mt-4">
                    <InputNumber v-model="property.unit_cost"class="w-full"/>
                    <label>Acquisition Cost</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full mt-4">
                    <InputText v-model="property.property_no"class="w-full"/>
                    <label>Property No.</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full mt-4">
                    <InputText v-model="property.status"class="w-full"/>
                    <label>Status</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full mt-4">
                    <DatePicker v-model="property.acquisition_date" dateFormat="mm/dd/yy" class="w-full"/>
                    <label>Acquisition Date</label>
                </FloatLabel>
            </Panel>
            <Panel v-if="property.user" header="Current Property User" class="w-full mt-4" style="background-color:aquamarine">
               <div class="w-full flex flex-col justify-between items-center gap-2">
                    <FloatLabel variant="on" class="w-full mt-4">
                        <InputText v-model="property.user.full_name"class="w-full"/>
                        <label>Name of User</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full mt-4">
                        <DatePicker v-model="property.user.issuance_date" dateFormat="mm/dd/yy" class="w-full"/>
                        <label>Acquisition Date</label>
                    </FloatLabel>
               </div>
            </Panel>
            <Panel header="Property User History" class="w-full mt-4" style="background-color:aquamarine">
                <div class="w-full flex flex-col justify-between items-center gap-2">
                    <Panel v-for="history in property.user_history" :header="history.full_name" class="w-full">
                        <div class="w-full flex flex-col justify-between items-center gap-2">
                            <FloatLabel variant="on" class="w-full mt-4">
                                <DatePicker v-model="history.acquisition_date" dateFormat="mm/dd/yy" class="w-full"/>
                                <label>Acquisition Date</label>
                            </FloatLabel>
                        </div>
                    </Panel>
               </div>
            </Panel>
         </div>
    </AuthenticatedPage>
 
 
 
 </template>
 
 <script setup> 
     import { ref,onMounted } from 'vue';
     import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
     import Select from 'primevue/select';
     import axios from '../../../axios/axios';
     import { Notify,Loading, Report } from 'notiflix';
     import Input from '../../Form/Input.vue';
     import Button from '../../Button.vue';
     import Dialog from 'primevue/dialog';
     import TextArea from '../../TextArea.vue';
     import { useRouter,useRoute } from 'vue-router';
     import { Icon } from '@iconify/vue/dist/iconify.js';
     import InputText from 'primevue/inputtext';
     import FloatLabel from 'primevue/floatlabel';
     import InputNumber from 'primevue/inputnumber';
     import DatePicker from 'primevue/datepicker';
     import Textarea from 'primevue/textarea';
     import Panel from 'primevue/panel';
     import useApi from '../../../composables/api_calls';


     const route = useRoute()
     const router = useRouter()
     const { fetchRequest } = useApi()

     var property = ref({})
 
     onMounted(()=>{
       fetchProperty()
     })

    async function fetchProperty(){
        var response = await fetchRequest('properties/qr/view',{id: route.params.id})
        response.toast()
        if(response.data.property){
            property.value = response.data.property
            console.log(response.data.property)
        }

    }
    





 
 </script>