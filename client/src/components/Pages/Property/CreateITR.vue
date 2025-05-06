<template>

    
    <div v-if="!preview" class="w-full flex flex-col justify-start items-start p-2 gap-4 font-lexend">
        <div class="w-full flex justify-between items-center">
            <span class="w-full text-2xl font-poppins font-bold uppercase mb-4">Selected Properties</span>
            <PrimevueButton @click="preview = true" label="Preview" class="font-lexend uppercase text-xs"/>
        </div>
       <div class="w-full flex flex-col justify-start items-start gap-2 font-light text-sm">
            <span v-for="property in properties" class="w-full border-y py-4 px-2 bg-emerald-900/50">{{ property.particulars }}</span>
       </div>

       <div class="w-full flex flex-col justify-start items-start gap-4">
           <div class="w-full flex justify-between items-center gap-2">
                <FloatLabel class="w-full" variant="on">
                    <Select v-model="itr.from" :options="userSelection" optionLabel="full_name" optionValue="full_name" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}" disabled/>
                    <label>From</label>
                </FloatLabel>

                <Icon icon="solar:round-arrow-right-bold" class="text-7xl"/>

                <FloatLabel class="w-full" variant="on">
                    <Select v-model="itr.to" :options="userSelection" optionLabel="full_name" optionValue="full_name" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>To</label>
                </FloatLabel>
           </div>

            <div class="w-full flex justify-between items-center gap-2">
                <FloatLabel variant="on" class="w-full">
                    <DatePicker v-model="itr.date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Date</label>
                </FloatLabel>

                <FloatLabel class="w-full" variant="on">
                    <Select v-model="itr.transferType" :options="transferTypes" optionLabel="name"  optionValue="name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Select Transfer Type</label>
                </FloatLabel>
           </div>

           <div class="w-full flex justify-between items-center gap-2">
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="itr.reason"  class="w-full"/>
                    <label>Reason for Transfer</label>
                </FloatLabel>
           </div>

           <div class="w-full flex justify-between items-center gap-2">
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="itr.entity_name"  class="w-full"/>
                    <label>Entity Name</label>
                </FloatLabel>
           </div>

       </div>

    </div>

    <div v-if="preview" class="w-full flex flex-col justify-start items-start gap-4 p-4 font-lexend">
        <div id="header-preview" class="w-full flex justify-between items-center">
            <PrimevueButton @click="preview = false" label="Edit Details" class="font-lexend uppercase text-xs"/>
            <PrimevueButton @click="print" label="Print ITR" class="font-lexend uppercase text-xs"/>
        </div>
        <div class="w-full flex flex-col justify-center items-center">
            <span class="w-full text-end font-light">Annex A.5</span>
            <span class="uppercase text-2xl font-bold">Inventory Transfer Report</span>
        </div>
        <div class="w-full flex flex-col justify-start items-start gap-2">
            <span class="w-full text-left font-noto">Entity Name:</span>
            <span class="w-full text-center uppercase text-xl font-medium">{{ itr.entity_name }}</span>
        </div>

       <div class="w-full flex flex-col justify-start items-start gap-4 border-2 p-2">
            <div class="w-full flex justify-start items-start gap-4 text-xs">
                <span class="w-[10%] font-noto">From:</span>
                <span class="w-[60%] uppercase">{{ itr.from }}</span>
                <span class="w-[10%] text-end font-noto">ITR No.</span>
                <span class="w-[20%]"></span>
            </div>
            <div class="w-full flex justify-start items-start gap-4 text-xs">
                <span class="w-[10%] font-noto">To:</span>
                <span class="w-[60%] uppercase">{{ itr.to }}</span>
                <span class="w-[10%] text-end font-noto">Date:</span>
                <span class="w-[20%]">{{ new Date(itr.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
            </div>
       </div>

       <div class="w-full flex flex-col justify-start items-start gap-2 font-light text-xs">
           <span class=" px-2 font-noto">Transfer Type: (Check Only One)</span>
           <div class="w-full grid grid-cols-4 justify-center items-center gap-2 p-2"> 
                <div class="flex justify-center items-center">
                    <input type="checkbox" class="" :checked="itr.transferType === 'Donation'">
                </div>
                <span class="w-full font-medium font-noto">Donation</span>
                <div class="flex justify-center items-center">
                    <input type="checkbox" class="" :checked="itr.transferType === 'Relocate'">
                </div>
                <span class="w-full font-medium font-noto">Relocate</span>
           </div>
           <div class="w-full grid grid-cols-4 justify-center items-center gap-2 p-2"> 
                <div class="flex justify-center items-center">
                    <input type="checkbox" class="" :checked="itr.transferType === 'Reassignment'">
                </div>
                <span class="w-full font-medium font-noto">Reassignment</span>
                <div class="flex justify-center items-center">
                    <input type="checkbox" class="" :checked="itr.transferType === 'Others'">
                </div>
                <span class="w-full font-medium font-noto">Others(Specify:)</span>
           </div>
       </div>

       <div class="w-full flex flex-col justify-start items-start font-light text-xs outline divide-y divide-black">
          <div class="w-full flex justify-center items-stretch divide-x divide-black">
                <span class="w-[10%] flex justify-center items-center text-center">Date Acquired</span>
                <span class="w-[4%]  flex justify-center items-center text-center">No.</span>
                <span class="w-[15%] flex justify-center items-center text-center">Property No.</span>
                <span class="w-[30%] flex justify-center items-center text-center">Description</span>
                <span class="w-[6%] flex justify-center items-center text-center">Quantity</span>
                <span class="w-[5%] flex justify-center items-center text-center">Unit</span>
                <span class="w-[10%] flex justify-center items-center text-center">Unit Cost</span>
                <span class="w-[10%] flex justify-center items-center text-center">Amount</span>
                <span class="w-[10%] flex justify-center items-center text-center">Condition of Inventory</span>
          </div>
          <div v-for="(property,index) in properties" class="w-full flex justify-center items-stretch divide-x divide-black">
                <span class="w-[10%] flex justify-center items-center text-center">{{ property.user.acquisition_date }}</span>
                <span class="w-[4%]  flex justify-center items-center text-center">{{ index+1 }}</span>
                <span class="w-[15%] flex justify-center items-center text-center">{{ property.property_no }}</span>
                <span class="w-[30%] flex justify-center items-center text-center">{{property.particulars}}</span>
                <span class="w-[6%] flex justify-center items-center text-center">1</span>
                <span class="w-[5%] flex justify-center items-center text-center">{{ property.measurement_unit.name }}</span>
                <span class="w-[10%] flex justify-center items-center text-center">{{ property.unit_cost }}</span>
                <span class="w-[10%] flex justify-center items-center text-center">{{property.unit_cost}}</span>
                <span class="w-[10%] flex justify-center items-center text-center"></span>
          </div>
          <div class="w-full flex flex-col justify-start items-center gap-2 text-xs p-2">
                <span class="w-full text-left font-medium font-noto">Reason for Transfer:</span>
                <span class="w-full text-left px-4">{{ itr.reason }}</span>
          </div>
         <div class="w-full flex flex-col justify-center items-center gap-2">
            <div class="w-full flex justify-center items-center gap-2">
                <span class="w-[10%] p-1 font-noto font-medium">Signature:</span>
                <div class="w-[30%] flex justify-center items-center p-1">
                    <span class="w-[30%] font-noto font-medium">Approved By:</span>
                    <input type="text" class="w-full outline-0 border-b py-4" disabled>
                </div>
                <div class="w-[30%] flex justify-center items-center p-1">
                    <span class="w-[30%] font-noto font-medium">Issued By:</span>
                    <input type="text" class="w-full outline-0 border-b py-4" disabled>
                </div>
                <div class="w-[30%] flex justify-center items-center p-1">
                    <span class="w-[30%] font-noto font-medium">Received By:</span>
                    <input type="text" class="w-full outline-0 border-b py-4" disabled>
                </div>
            </div>
            <div class="w-full flex justify-center items-center gap-2">
                    <div class="w-[10%] flex flex-col justify-center items-center p-1">
                        <span class="w-full font-noto font-medium">Printed Name:</span>
                        <span class="w-full font-noto font-medium">Designation:</span>
                    </div>
                    <div class="w-[30%] flex flex-col justify-center items-center p-1">
                        <span class="w-full font-noto font-medium text-center underline">Atty. Veronica Zandra L. de Jesus Sowaken</span>
                        <span class="w-full font-lexend font-light text-center text-[10px]">Chief Administrative Officer</span>
                    </div>
                    <div class="w-[30%] flex flex-col justify-center items-center p-1">
                        <span class="w-full font-noto font-medium text-center underline">Felina S. Carlos</span>
                        <span class="w-full font-lexend font-light text-center text-[10px]">Administrative Officer V</span>
                    </div>
                    <div class="w-[30%] flex flex-col justify-end items-end p-1">
                        <input class="w-[70%] border-b outline-0 text-center"/>
                        <input class="w-[70%] border-b outline-0 text-[10px] text-center"/>
                    </div>
            </div>
            <div class="w-full flex justify-center items-center gap-2">
                <div class="w-[10%] flex flex-col justify-center items-center p-1">
                    <span class="w-full font-noto font-medium">Date:</span>
                </div>
                <div class="w-[30%] flex flex-col justify-end items-end p-1">
                    <input class="w-[80%] border-b outline-0 text-center"/>
                </div>
                <div class="w-[30%] flex flex-col justify-end items-end p-1">
                    <input class="w-[70%] border-b outline-0 text-center"/>
                </div>
                <div class="w-[30%] flex flex-col justify-end items-end p-1">
                    <input class="w-[70%] border-b outline-0 text-center"/>
                </div>
            </div>
         </div>
       </div>
    </div>
 
 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import { useRouter,useRoute } from 'vue-router';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import InputText from 'primevue/inputtext';
    import Button from '../../Button.vue';
    import axios from '../../../axios/axios';
    import Dialog from 'primevue/dialog';
    import { Notify,Loading, Report } from 'notiflix';
    import { useAuthStore } from '../../../stores/authStore';
    import PrimevueButton from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import FloatLabel from 'primevue/floatlabel';
    import Select from 'primevue/select';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import DatePicker from 'primevue/datepicker';


     const route = useRoute()
     const router = useRouter()
     const store = useAuthStore()

     var preview = ref(false)

     var userSelection = ref([])

     var properties = ref([]);
     var transferTypes = [
        {name:'Donation',code:1},
        {name:'Reassignment',code:2},
        {name:'Relocate',code:3},
        {name:'Others',code:4},
     ];

     var itr = ref({
        to:'',
        from:store.user.full_name,
        date:'',
        reason:'',
        transferType:'',
        entity_name:'Department of Health - Center for Health Development - CAR'
     })


     onMounted(()=>{
       fetchProperties()
       fetchUserSelection()
     })
 

    function fetchProperties(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });
        
        axios.get('properties/find',{
            params:{
                ids:route.query.selectedProperties,
            }
        })
        .then((response)=>{
            properties.value = response.data.properties
            // console.log(properties.value)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
            console.log(error.response.data)
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
            userSelection.value = response.data.users
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function print(){
        window.print()
    }


 
 </script>


<style scoped>
    @media print{
        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        #header-preview {
            display: none;
        }
      
    }
</style>