<template>

    
    <div v-if="!preview" class="w-full flex flex-col justify-start items-start p-2 gap-4 font-lexend">
        <div class="w-full flex justify-between items-center">
            <span class="w-full text-2xl font-poppins font-bold uppercase mb-4">Create RIS</span>
            <PrimevueButton @click="preview = true" label="Preview" class="font-lexend uppercase text-xs"/>
        </div>
        <div class="w-full flex justify-center items-center gap-4 mt-4">
            <FloatLabel variant="on" class="w-full">
                <InputText v-model="ris.entity_name"  class="w-full"/>
                <label>Entity Name</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-full">
                <InputText v-model="ris.responsibility_center_code"  class="w-full"/>
                <label>Responsibility Center Code</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-full">
                <DatePicker v-model="ris.date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Date</label>
            </FloatLabel>
        </div>
        <div class="w-full flex justify-center items-center gap-4 mt-4">
           <FloatLabel class="w-full" variant="on">
                <Select v-model="ris.division" :options="selections.divisions" optionLabel="division_name"  optionValue="division_name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Select Division</label>
            </FloatLabel>
            <FloatLabel class="w-full" variant="on">
                <Select v-model="ris.office" :options="selections.offices" optionLabel="section_name"  optionValue="section_name" filter class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Select Office</label>
            </FloatLabel>
            <FloatLabel class="w-full" variant="on">
                <Select v-model="ris.fund_cluster" :options="selections.fund_cluster" optionLabel="name"  optionValue="name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Select Fund Cluster</label>
            </FloatLabel>
        </div>

        <span class="font-poppins font-bold uppercase text-xl">Signatories</span>
        <div class="w-full flex justify-center items-center gap-4 border-y p-4">
            <div class="w-full flex flex-col justify-center items-center gap-2">
                <span class="w-full text-left font-poppins font-medium">Requesting Entity Signatory</span>
                <FloatLabel class="w-full" variant="on">
                    <Select v-model="ris.requested_by.name" :options="selections.users" optionLabel="full_name"  optionValue="full_name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Select Person that Requested</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full mt-2">
                    <InputText v-model="ris.requested_by.position"  class="w-full"/>
                    <label>Position</label>
                </FloatLabel>
            </div>

            <div class="w-full flex flex-col justify-center items-center gap-2">
                <span class="w-full text-left font-poppins font-medium">Issuing Entity Signatory</span>
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="ris.issued_by.name"  class="w-full"/>
                    <label>Select Person to Issue</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full mt-2">
                    <InputText v-model="ris.issued_by.position"  class="w-full"/>
                    <label>Position</label>
                </FloatLabel>
            </div>

            <div class="w-full flex flex-col justify-center items-center gap-2">
                <span class="w-full text-left font-poppins font-medium">Approving Entity Signatory</span>
                <FloatLabel class="w-full" variant="on">
                    <Select v-model="ris.approved_by.name" :options="selections.users" optionLabel="full_name"  optionValue="full_name" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Select Person to Approve</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full mt-2">
                    <InputText v-model="ris.approved_by.position"  class="w-full"/>
                    <label>Position</label>
                </FloatLabel>
            </div>

        </div>

       
        <div class="w-full flex flex-col justify-start items-start">
            <div class="w-full flex  justify-start items-center gap-4">
                <span class="font-poppins font-bold uppercase text-xl">Inventory/ies Requested</span>
               <Icon @click="risItemFormModal = true" icon="material-symbols:add-circle-outline" class="text-blue-900 text-xl hover:scale-125 cursor-pointer"/>
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <div v-for="item in ris.items" class="w-full flex justify-start items-start gap-2 border-y p-2 bg-emerald-900/40 shadow-md shadow-slate-600">
                    <span>{{ item.description }}</span>
                </div>
            </div>
        </div>
    </div>

    <div v-if="preview" class="w-full flex flex-col justify-start items-start gap-4 p-4 font-lexend">
        <div id="header-preview" class="w-full flex justify-between items-center">
            <PrimevueButton @click="preview = false" label="Edit Details" class="font-lexend uppercase text-xs"/>
            <PrimevueButton @click="print" label="Print RIS" class="font-lexend uppercase text-xs"/>
        </div>
        
        <div class="w-full grid grid-cols-5 gap-4">
            <div></div>
            <div class="col-span-3 w-full flex flex-col justify-center items-center font-noto font-medium">
                <span>Republic of the Philippines</span>
                <span>Center for Health Development</span>
                <span>Department of Health</span>
                <span class="font-bold">Cordillera Administrative Regional Office</span>
                <span>Baguio City</span>
            </div>
            <div></div>
        </div>

        <span class="w-full flex justify-end items-end font-light italic text-sm"><span class="outline px-2 py-1 font-noto">Annex 23</span></span>

        <div class="w-full flex flex-col justify-center items-center mt-4 font-noto font-bold uppercase">
           <span>Requisition and Issue Slip</span>
           <span>Department of Health</span>
        </div>

        <div class="w-full flex flex-col justify-start items-start outline-1 divide-y-1 text-xs">
            <div class="w-full grid grid-cols-5 divide-x">
                <span class="p-1 col-span-3">Entity Name: {{ ris.entity_name }}</span>
                <span class="p-1 col-span-2">Fund Cluster: {{ ris.fund_cluster }}</span>
            </div>
            <div class="w-full grid grid-cols-5 divide-x">
                <span class="p-1 col-span-3">Office: {{ ris.office }}</span>
                <span class="p-1 col-span-2">Responsibility Center Code: {{ ris.responsibility_center_code }}</span>
            </div>
            <div class="w-full grid grid-cols-5 divide-x">
                <span class="p-1 col-span-3">Division: {{ ris.division }}</span>
                <div class="col-span-2 w-full flex justify-start items-stretch divide-x">
                    <span class="w-[60%] p-1">RIS Control Number: </span>
                    <span class="w-[40%] p-1">Date Prepared: <br> {{ new Date(ris.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
                </div>
            </div>
            <div class="w-full grid grid-cols-5 divide-x">
                <span class="col-span-3 w-full text-center font-semibold p-1">Requisition</span>
                <div class="col-span-2 w-full flex justify-start items-stretch divide-x">
                    <span class="w-[20%] p-1">Stocks Available?</span>
                    <span class="w-[80%] p-1"></span>
                </div>
            </div>
            <div class="w-full grid grid-cols-5 divide-x">
                <div class="col-span-3 w-full flex justify-start items-stretch divide-x text-center">
                    <span class="w-[10%] flex justify-center items-center">SKU Code</span>
                    <span class="w-[30%] flex justify-center items-center">Item Description</span>
                    <span class="w-[10%] flex justify-center items-center">Unit</span>
                    <span class="w-[15%] flex justify-center items-center">Batch/Lot No.</span>
                    <span class="w-[20%] flex justify-center items-center">Expiration Date</span>
                    <span class="w-[15%] flex justify-center items-center">Quantity Requested</span>
                </div>
                <div class="col-span-2 w-full flex justify-start items-stretch divide-x">
                    <span class="w-[10%] flex justify-center items-center text-center">Yes</span>
                    <span class="w-[10%] flex justify-center items-center text-center">No</span>
                    <span class="w-[20%] flex justify-center items-center text-center">Quantity Issued</span>
                    <span class="w-[20%] flex justify-center items-center text-center">Unit Cost</span>
                    <span class="w-[20%] flex justify-center items-center text-center">Total Amount</span>
                    <span class="w-[20%] flex justify-center items-center text-center">Remarks</span>
                </div>
            </div>
            <div v-for="item in ris.items" class="w-full grid grid-cols-5 divide-x">
                <div class="col-span-3 w-full flex justify-start items-stretch divide-x text-center">
                    <span class="w-[10%] flex justify-center items-center"></span>
                    <span class="w-[30%] flex text-[10px] text-left">{{ item.description }}</span>
                    <span class="w-[10%] flex justify-center items-center">{{item.measurement_unit}}</span>
                    <span class="w-[15%] flex justify-center items-center">{{ item.batch_lot_number }}</span>
                    <span class="w-[20%] flex justify-center items-center">{{ new Date(item.expiry_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
                    <span class="w-[15%] flex justify-center items-center">{{ item.quantity }}</span>
                </div>
                <div class="col-span-2 w-full flex justify-start items-stretch divide-x">
                    <span class="w-[10%] flex justify-center items-center text-center"></span>
                    <span class="w-[10%] flex justify-center items-center text-center"></span>
                    <span class="w-[20%] flex justify-center items-center text-center"></span>
                    <span class="w-[20%] flex justify-center items-center text-center"></span>
                    <span class="w-[20%] flex justify-center items-center text-center"></span>
                    <span class="w-[20%] flex justify-center items-center text-center"></span>
                </div>
            </div>
            <span class="w-full text-left px-1">Purpose:</span>
            <span class="w-full text-left px-1" :class="ris.purpose === '' ? 'py-2' : ''">{{ ris.purpose }}</span>
        </div>

        <div class="w-full flex flex-col justify-start items-start outline-1 text-xs divide-y text-center">
            <div class="w-full flex justify-center items-stretch text-xs divide-x text-center">
                <span class="w-[20%]"></span>
                <span class="w-[20%]">Requested By</span>
                <span class="w-[20%]">Approved By</span>
                <span class="w-[20%]">Issued By</span>
                <span class="w-[20%]">Received By</span>
            </div>
            <div class="w-full flex justify-center items-stretch text-xs divide-x text-center">
                <span class="w-[20%] py-4">Signature</span>
                <span class="w-[20%]"></span>
                <span class="w-[20%]"></span>
                <span class="w-[20%]"></span>
                <span class="w-[20%]"></span>
            </div>
            <div class="w-full flex justify-center items-stretch text-xs divide-x text-center">
                <span class="w-[20%]">Printed Name</span>
                <span class="w-[20%] font-noto font-bold">{{ ris.requested_by.name === '' ? '' : ris.requested_by.name}}</span>
                <span class="w-[20%] font-noto font-bold">{{ ris.approved_by.name === '' ? '' : ris.approved_by.name }}</span>
                <span class="w-[20%] font-noto font-bold">{{ ris.issued_by.name === '' ? '' : ris.issued_by.name }}</span>
                <span class="w-[20%] font-noto font-bold">{{ ris.requested_by.name === '' ? '' : ris.requested_by.name }}</span>
            </div>
            <div class="w-full flex justify-center items-stretch text-xs divide-x text-center">
                <span class="w-[20%]">Office and Designation</span>
                <span class="w-[20%] font-light text-[10px]">{{ ris.requested_by.position === '' ? '' : ris.requested_by.position}}</span>
                <span class="w-[20%] font-light text-[10px]">{{ ris.approved_by.position === '' ? '' : ris.approved_by.position }}</span>
                <span class="w-[20%] font-light text-[10px]">{{ ris.issued_by.position === '' ? '' : ris.issued_by.position }}</span>
                <span class="w-[20%] font-light text-[10px]">{{ ris.requested_by.position === '' ? '' : ris.requested_by.position }}</span>
            </div>
            <div class="w-full flex justify-center items-stretch text-xs divide-x text-center">
                <span class="w-[20%]">Date</span>
                <span class="w-[20%]">{{ ris.date === '' ? '' : new Date(ris.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
                <span class="w-[20%]"></span>
                <span class="w-[20%]"></span>
                <span class="w-[20%]"></span>
            </div>
        </div>

    </div>
 
    <RISItemForm v-model:visible="risItemFormModal" @submit="pushItem"/>

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
    import RISItemForm from '../../RIS/RISItemForm.vue';


     const route = useRoute()
     const router = useRouter()
     const store = useAuthStore()

     var preview = ref(false)

     var selections = ref({
        divisions:[],
        offices:[],
        users:[]
     })

     var ris = ref({
        entity_name:'Department of Health - CHD - CAR',
        office:'',
        division:'',
        fund_cluster:'',
        responsibility_center_code:'',
        date:'',
        items:[],
        purpose:'',
        requested_by:{
            name:'',
            position:'',
        },
        approved_by:{
            name:'',
            position:'',
        },
        issued_by:{
            name:'Felina S. Carlos',
            position:'AO V/SCMU Head',
        },
        received_by:'',
     })

     var risItemFormModal = ref(false)

     onMounted(()=>{
       fetchDivisions()
       fetchOffices()
       fetchFundSources()
       fetchUsers()
     })
 

    function fetchDivisions(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });
        
        axios.get('division/selection',{
            params:{
                ids:route.query.selectedProperties,
            }
        })
        .then((response)=>{
            selections.value.divisions = response.data.divisions
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

    function fetchOffices(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('office/selection',{
            params:{}
        })
        .then((response)=>{
            selections.value.offices = response.data.offices
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
        })
        .finally(()=>{
          
        })
    }

    function fetchFundSources(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });
        
        axios.get('fund_source/list',{
            params:{
              
            }
        })
        .then((response)=>{
            selections.value.fund_cluster = response.data.fund_sources
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function fetchUsers(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('user/selection',{
            params:{
                
            }
        })
        .then((response)=>{
            selections.value.users = response.data.users
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function pushItem(item){
        ris.value.items.push(item)
        console.log(ris.value.items)
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