<template>

    <AuthenticatedPage pageTitle="Update Property">
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll">
 
            <div class="w-full flex justify-end items-center p-2">
            <Button buttonType="update" text="Save Updates"/>
            </div>

            <div class="w-full flex flex-col justify-start items-start gap-4 p-2">
                <div class="w-full flex flex-col justify-start items-start gap-4 p-4 border-y">
                    <span class="w-full text-2xl uppercase font-poppins font-bold">Property</span>
                    
                    <div class="min-w-full flex justify-start items-start gap-4">
                        <FloatLabel variant="on" class="font-light max-w-[25%] w-[25%]">
                            <InputText v-model="property.property_no" :invalid="errors.property_no" class="w-full"/>
                            <label class="font-poppins" style="font-weight: 300; font-size: small;">Property Number</label>
                        </FloatLabel>

                        <FloatLabel variant="on" class="font-light max-w-[25%] w-[25%]">
                            <DatePicker v-model="property.acquisition_date" class="w-full"/>
                            <label class="font-poppins" style="font-weight: 300; font-size: small;">Acquisition Date</label>
                        </FloatLabel>

                        <FloatLabel class="max-w-[25%] w-[25%]" variant="on">
                            <Select v-model="property.measurement_unit" :options="measurements" optionLabel="name" class="w-full font-light font-poppins">
                                <template #option="slotProps">
                                    <div class="flex items-center font-poppins font-light text-sm">
                                        <div>{{ slotProps.option.name }}</div>
                                    </div>
                                </template>
                            </Select>
                            <label class="font-poppins" style="font-weight: 300; font-size: small;">Measurement Unit</label>
                        </FloatLabel>

                        <FloatLabel variant="on"  class="max-w-[25%] w-[25%]">
                            <InputNumber v-model="property.unit_cost" mode="decimal" class="w-full font-light"/>
                            <label class="font-poppins" style="font-weight: 300; font-size: small;">Unit Cost</label>
                        </FloatLabel>

                    </div>

                    <div class="min-w-full flex justify-start items-start gap-4">
                        <FloatLabel variant="on" class="font-light w-3/4">
                            <InputText v-model="property.remarks" :invalid="errors.remarks" class="w-full"/>
                            <label class="font-poppins" style="font-weight: 300; font-size: small;">Remarks</label>
                        </FloatLabel>

                        <FloatLabel class="w-1/4" variant="on">
                            <Select v-model="property.status" :options="statuses" optionLabel="name" class="w-full font-light font-poppins">
                                <template #option="slotProps">
                                    <div class="flex items-center font-poppins font-light text-sm">
                                        <div>{{ slotProps.option.name }}</div>
                                    </div>
                                </template>
                            </Select>
                            <label class="font-poppins" style="font-weight: 300; font-size: small;">Measurement Unit</label>
                        </FloatLabel>

                    </div>

                </div>

                <div class="w-full flex flex-col justify-start items-start gap-4">
                    <span class="w-full text-2xl uppercase font-poppins font-bold">Property User</span>
                </div>
                <div class="w-full flex flex-col justify-start items-start gap-4">
                    <span class="w-full text-2xl uppercase font-poppins font-bold">Property History</span>
                </div>
            </div>

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


     const route = useRoute()

     var property = ref({
        property_no:'',
        unit_cost:0,
        remarks:'',
        acquisition_date:'',
        measurement_unit:null,
        status:null,
        particulars:'',
        user:null,
        history:[]
     })
     var errors = ref({})

     var measurements = ref([])
     var users = ref([])
     var statuses = ref([])
 
     onMounted(()=>{
        fetchMeasurements()
        fetchProperty()
        // fetchUserSelection()
        fetchPropertyStatuses()
     })
 

    function fetchProperty(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });
        
        axios.get('property/find',{
            params:{
                id:route.params.id,
            }
        })
        .then((response)=>{
            property.value.property_no =response.data.property.property_no
            property.value.unit_cost =response.data.property.unit_cost
            property.value.remarks =response.data.property.remarks
            property.value.acquisition_date =response.data.property.issuance_date
            property.value.measurement_unit =response.data.property.measurement_unit
            property.value.status =response.data.property.status
            property.value.particulars =response.data.property.particulars
            console.log(response.data.property)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
            console.log(error.response.data)
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function fetchMeasurements(){
       Loading.dots('Loading Data, Please Wait...',{
           clickToClose:false,
           fontFamily:'Lexend Deca'
       });

       axios.get('measurement/selection',{})
       .then((response)=>{
           measurements.value = response.data.measurements
           console.log()
       })
       .catch((error)=>{
           Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
       })
       .finally(()=>{
           Loading.remove()
       })
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
            console.log(response.data)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function fetchPropertyStatuses(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });
        
        axios.get('property/statuses',{})
        .then((response)=>{
            statuses.value = response.data.statuses
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
            console.log(error.response.data)
        })
        .finally(()=>{
            Loading.remove()
        })
    }

 
 </script>