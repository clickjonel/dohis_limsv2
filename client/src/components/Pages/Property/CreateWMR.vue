<template>

    
    <div v-if="!preview" class="w-full flex flex-col justify-start items-start p-2 gap-4 font-lexend">
        <div class="w-full flex justify-between items-center">
            <span class="w-full text-2xl font-poppins font-bold uppercase mb-4">Selected Properties</span>
            <PrimevueButton @click="preview = true" label="Preview" class="font-lexend uppercase text-xs"/>
        </div>
        <!-- <PropertySelection @submit="setSelectedProperties"/> -->

       <div class="w-full flex flex-col justify-start items-start gap-4">

            <div class="w-full flex justify-between items-center gap-2">
                <FloatLabel variant="on" class="w-full">
                    <DatePicker v-model="wmr.date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Date</label>
                </FloatLabel>

                <FloatLabel class="w-full" variant="on">
                    <Select v-model="wmr.fund_cluster" :options="fund_sources" optionLabel="name"  optionValue="name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Select Fund Cluster</label>
                </FloatLabel>
           </div>

           <div class="w-full flex justify-between items-center gap-2">
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="wmr.place_of_storage"  class="w-full"/>
                    <label>Place of Storage</label>
                </FloatLabel>
           </div>

           <div class="w-full flex justify-between items-center gap-2">
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="wmr.entity_name"  class="w-full"/>
                    <label>Entity Name</label>
                </FloatLabel>
           </div>

       </div>

    </div>

    <div v-if="preview" class="w-full flex flex-col justify-start items-start gap-4 p-4 font-lexend">
        <div id="header-preview" class="w-full flex justify-between items-center">
            <PrimevueButton @click="preview = false" label="Edit Details" class="font-lexend uppercase text-xs"/>
            <PrimevueButton @click="print" label="Print WMR" class="font-lexend uppercase text-xs"/>
        </div>
        <div class="w-full grid grid-cols-3 gap-2 font-medium font-noto">
            <div></div>
            <div class="w-full flex flex-col justify-center items-center text-sm">
                <span>Republic of the Philippines</span>
                <span>Department of Health</span>
                <span>Center for Health Development</span>
                <span>Cordillera Administrative Regional Office</span>
                <span>Baguio City</span>

                <span class="font-bold text-xl uppercase mt-6">Waste Materials Report</span>
            </div>
            <div class="w-full flex flex-col justify-center items-center gap-2 text-sm">
                <span class="font-light italic">Apendix 65</span>
            </div>
        </div>

        <div class="w-full grid grid-cols-2 gap-2 font-noto text-sm">
            <div class="w-full flex justify-start items-center gap-2">
                <span class="font-bold">Entity Name: </span>
                <span class="underline  px-4">{{ wmr.entity_name }}</span>
            </div>
            <div class="w-full flex justify-start items-center gap-2">
                <span class="font-bold">Fund Cluster: </span>
                <span class="underline px-4">{{ wmr.fund_cluster }}</span>
            </div>
        </div>

        <div class="w-full flex flex-col justify-start items-stretch outline-2 divide-y font-noto">
            <div class="w-full grid grid-cols-2 gap-2 font-noto text-sm divide-x-2">
                <div class="w-full flex justify-start items-center gap-2 p-1">
                    <span class="">Place of Storage: </span>
                    <span class="underline  px-4">{{ wmr.place_of_storage }}</span>
                </div>
                <div class="w-full flex justify-start items-center gap-2 p-1">
                    <span class="">Date: </span>
                    <span class="underline px-4">{{ new Date(wmr.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
                </div>
            </div>
            <div class="w-full flex flex-col justify-start items-stretch outline-2 divide-y-2">
                <div class="w-full grid grid-cols-2 gap-2 font-noto text-sm divide-x-2">
                <span class="font-bold p-1">Items for Disposal</span>
                </div>
                <div class="w-full flex justify-start items-stretch divide-x-2 text-center text-sm font-medium">
                <span class="w-[10%] flex justify-center items-center">Item</span>
                <span class="w-[15%] flex justify-center items-center">Quantity</span>
                <span class="w-[10%] flex justify-center items-center">Unit</span>
                <span class="w-[35%] flex justify-center items-center">Description</span>
                <div class="w-[30%] flex flex-col justify-center items-stretch divide-y-2 text-center">
                        <div class="w-full flex justify-start items-center">
                            <span class="w-full text-center font-medium">Record Sales</span>
                    </div>
                    <div class="w-full flex justify-start items-center">
                            <span class="w-full text-center font-medium">Official Receipt</span>
                    </div>
                    <div class="w-full flex justify-start items-stretch divide-x-2">
                            <span class="w-1/3">No.</span>
                            <span class="w-1/3">Date</span>
                            <span class="w-1/3">Amount</span>
                    </div>
                </div>
                </div>

                <div v-for="(property,index) in properties" class="w-full flex justify-start items-stretch divide-x-2 text-center text-xs font-light font-lexend">
                    <span class="w-[10%] flex justify-center items-center">{{ index+1 }}</span>
                    <span class="w-[15%] flex justify-center items-center">1</span>
                    <span class="w-[10%] flex justify-center items-center">{{property.measurement_unit.name}}</span>
                    <div class="w-[35%] flex flex-col justify-start items-start">
                        <span class="pl-1">{{property.particulars}}</span>
                        <span class="pl-1 mt-2">PN:{{property.property_no}}</span>
                        <span class="pl-1">UC:{{property.unit_cost}}</span>
                        <span class="pl-1">DA:{{property.user.acquisition_date === '0000-00-00' ? '' : property.user.acquisition_date }}</span>
                    </div>
                    <div class="w-[30%] flex justify-center items-stretch divide-y-2 text-center">
                        <div class="w-full flex justify-start items-stretch divide-x-2">
                            <span class="w-1/3"></span>
                            <span class="w-1/3"></span>
                            <span class="w-1/3"></span>
                        </div>
                    </div>
                </div>
                
                <div class="w-full flex justify-start items-stretch divide-x-2 text-center text-xs font-light font-lexend">
                <span class="w-[10%] flex justify-center items-center"></span>
                <span class="w-[15%] flex justify-center items-center"></span>
                <span class="w-[10%] flex justify-center items-center"></span>
                <span class="w-[35%] flex flex-col justify-center items-center font-light italic">
                    <span>Submitted by {{ store.user.full_name }} - {{ store.user.position }}</span>
                </span>
                <div class="w-[30%] flex flex-col justify-center items-stretch divide-y-2 text-center">
                    <div class="w-full flex justify-start items-stretch divide-x-2">
                            <span class="w-1/3"></span>
                            <span class="w-1/3"></span>
                            <span class="w-1/3 font-medium"></span>
                    </div>
                </div>
                </div>
                <div class="w-full grid grid-cols-2 gap-2 font-noto divide-x-2 text-xs">
                    <div class="w-full flex flex-col justify-start items-center p-1">
                        <span class="w-full">Certified Correct:</span>

                        <input type="text" class="w-[70%] border-b py-2 text-center outline-0 text-lf font-semibold uppercase">
                        <span class="w-[70%] text-center">Signature over Printed Name of Supply and/or Property Custodian</span>
                    </div>
                    <div class="w-full flex flex-col justify-start items-center p-1">
                        <span class="w-full">Disposal Approved</span>

                        <input type="text" class="w-[70%] border-b py-2 text-center outline-0 text-lf font-semibold uppercase">
                        <span class="w-[70%] text-center">Signature over Printed Name of Head of Agency/Entity or his/her Authorized Representative</span>
                    </div>
                </div>
                <div class="w-full flex justify-center items-center font-noto text-sm divide-x-2">
                    <span class="font-bold p-1">Certificate of Inspection</span>
                </div>
                <div class="w-full flex flex-col justify-center items-center font-noto text-xs gap-2">
                    <span class="w-[90%] font-light font-lexend p-1 text-left">I hereby certify that the property enumerated above was disposed of as follows:</span>
                    <div class="w-[80%] flex justify-start items-center gap-4 p-1">
                        <span>Item</span>
                        <input type="text" class="w-[70px] border-b">
                        <span>Destroyed</span>
                    </div>
                    <div class="w-[80%] flex justify-start items-center gap-4 p-1">
                        <span>Item</span>
                        <input type="text" class="w-[70px] border-b">
                        <span>Sold at private sale</span>
                    </div>
                    <div class="w-[80%] flex justify-start items-center gap-4 p-1">
                        <span>Item</span>
                        <input type="text" class="w-[70px] border-b">
                        <span>sold at public auction</span>
                    </div>
                    <div class="w-[80%] flex justify-start items-center gap-4 p-1">
                        <span>Item</span>
                        <input type="text" class="w-[70px] border-b">
                        <span>Transfered without cost to </span>
                        <input type="text" class="w-[200px] border-b">
                    </div>
                </div>
                <div class="w-full grid grid-cols-2 gap-2 font-noto divide-x-2 text-xs">
                    <div class="w-full flex flex-col justify-start items-center p-1">
                        <span class="w-full">Certified Correct:</span>

                        <input type="text" class="w-[70%] border-b py-2 text-center outline-0 text-lf font-semibold uppercase">
                        <span class="w-[70%] text-center">Signature over Printed Name of Inspection Officer</span>
                    </div>
                    <div class="w-full flex flex-col justify-start items-center p-1">
                        <span class="w-full">Witness to Disposal</span>

                        <input type="text" class="w-[70%] border-b py-2 text-center outline-0 text-lf font-semibold uppercase">
                        <span class="w-[70%] text-center">Signature over Printed Name of Witnessc</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Pre inspection Requests -->
    <!-- <div v-for="property in properties" :key="property.property_no" class="w-full flex flex-col justify-start items-start outline p-4 break-before-page" >
            <div class="w-full flex justify-center items-center gap-4">
                <div class="w-full flex flex-col justify-center items-center text-sm font-noto">
                    <span>Republic of the Philippines</span>
                    <span>Department of Health</span>
                    <span>Center for Health Development</span>
                    <span>Cordillera Administrative Regional Office</span>
                    <span>Baguio City</span>
                </div>
            </div>

            <span class="w-full text-center mt-4 font-bold font-noto text-xl">Request For Pre-Inspection/Repair</span>

            <div class="w-full grid grid-cols-2 gap-4 py-2 mt-4 font-lexend text-base">
                <div class="w-full flex justify-start items-center gap-2">
                    <span class="font-light uppercase">Equipment:</span>
                    <input type="text" class="w-full border-b outline-none" :value="property.currentPreinspection.equipment" disabled>
                </div>
                 <div class="w-full flex justify-start items-center gap-2">
                    <span class="font-light uppercase">Model:</span>
                    <input type="text" class="w-full border-b outline-none" :value="property.currentPreinspection.model" disabled>
                </div>
            </div>

            <div class="w-full grid grid-cols-2 gap-4 py-2 mt-2 font-lexend text-base">
                <div class="w-full flex justify-start items-center gap-2">
                    <span class="font-light uppercase w-1/3">Serial/Engine No:</span>
                    <input type="text" class="w-full border-b outline-none" disabled>
                </div>
                 <div class="w-full flex justify-start items-center gap-2">
                    <span class="font-light uppercase w-1/5">Property No:</span>
                    <input type="text" class="w-full border-b outline-none" :value="property.currentPreinspection.property_no" disabled>
                </div>
            </div>

            <div class="w-full grid grid-cols-2 gap-4 py-2 mt-2 font-lexend text-base">
                <div class="w-full flex justify-start items-center gap-2">
                    <span class="font-light uppercase w-1/3">Acquisition Date:</span>
                    <input type="text" class="w-full border-b outline-none" :value="property.currentPreinspection.acquisition_date" disabled>
                </div>
                 <div class="w-full flex justify-start items-center gap-2">
                    <span class="font-light uppercase w-1/3">Acquisition Cost:</span>
                    <input type="text" class="w-full border-b outline-none" :value="property.currentPreinspection.acquisition_cost" disabled>
                </div>
            </div>

            <div class="w-full flex gap-4 py-2 mt-2 font-lexend text-base">
                <div class="w-full flex justify-start items-center gap-2">
                    <span class="font-light uppercase w-[14%]">Date of Repair:</span>
                    <input type="text" class="w-full border-b outline-none" disabled>
                </div>
            </div>

            <div class="w-full flex gap-4 py-2 mt-2 font-lexend text-base">
                <div class="w-full flex justify-start items-start gap-2">
                    <span class="font-light uppercase w-[15%]">Nature of Last Repair:</span>
                    <div class="w-full flex flex-col justify-start items-start gap-4">
                        <input type="text" class="w-full border-b outline-none" disabled>
                        <input type="text" class="w-full border-b outline-none" disabled>
                    </div>
                </div>
            </div>

            <span class="w-full text-left mt-4 font-light font-lexend">DEFECTS/COMPLAINTS (Include missing parts/part to be replaced)</span>

            <div class="w-full flex flex-col justify-start items-start gap-4 font-lexend border-b-2 py-2">
                <div class="w-full" v-html="property.currentPreinspection.defects">

                </div>

                <div class="w-full flex justify-end items-center font-noto">
                    <div class="w-1/3 flex flex-col justify-center items-center gap-2">
                        <input type="text" class="w-full border-b text-center outline-0 font-medium" disabled :value="property.currentPreinspection.requested_by">
                        <span class="text-sm font-lexend font-light">Requisition Property Officer</span>
                        <input type="text" class="w-full border-b text-center outline-0 font-medium" disabled :value="property.currentPreinspection.date_requested">
                        <span class="text-sm font-lexend font-light">Date</span>
                    </div>
                </div>
            </div>

             <div class="w-full flex flex-col justify-start items-start gap-4 font-lexend">
                <span class="w-full text-center font-noto text-lg uppercase">Inspection Committee</span>
                <span class="w-full text-left font-noto text-base uppercase font-light">Findings/Recommendation</span>
                <div class="w-full" v-html="property.currentPreinspection.findings">

                </div>
                <div class="w-full flex flex-col justify-start items-center gap-2">
                    <div class="w-full flex justify-start items-center font-lexend font-light uppercase gap-4">
                        <span class="w-1/2">Inspected By:</span>
                        <span class="w-1/2">Date:</span>
                    </div>
                    <div class="w-full flex justify-start items-center font-noto font-semibold uppercase gap-4">
                        <input class="w-1/2 border-b text-center outline-none" :value="property.currentPreinspection.inspector_name"/>
                        <input class="w-1/2  border-b text-center outline-none" :value="property.currentPreinspection.inspection_date"/>
                    </div>
                    <span class="text-left font-light font-noto text-xs italic">Preinspection Request has been processed through LIMS System.</span>
                </div>
            </div>

    </div> -->

 </template>
 
 <script setup> 
    import { ref,onMounted,computed  } from 'vue';
    import { useRouter,useRoute } from 'vue-router';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import InputText from 'primevue/inputtext';
    import Button from '../../Button.vue';
    import axios from '../../../axios/axios';
    import Dialog from 'primevue/dialog';
    import { useAuthStore } from '../../../stores/authStore';
    import PrimevueButton from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import FloatLabel from 'primevue/floatlabel';
    import Select from 'primevue/select';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import DatePicker from 'primevue/datepicker';
    import useApi from '../../../composables/api_calls';
    import PropertySelection from '../../selections/PropertySelection.vue';
    import { showReport } from '../../../composables/notiflix';

     const route = useRoute()
     const router = useRouter()
     const store = useAuthStore()
     const { fetchRequest } = useApi()

     var preview = ref(false)

    var properties = ref([]);
    var fund_sources = ref([]);
    var propertyUrlQuery =  Array.isArray(route.query.ids) ? route.query.ids : [route.query.ids]

     var wmr = ref({
        fund_cluster:'',
        place_of_storage:'',
        date:'',
        entity_name:'Department of Health - CAR'
     })


     onMounted(()=>{
        fetchProperties()
        fetchFundSources() 
        // console.log(propertyUrlQuery)
     })

    async function fetchFundSources(){
        var response = await fetchRequest('fund_source/list',{})
        response.toast()
        if(response.data.fund_sources){
            fund_sources.value = response.data.fund_sources
        }
       
    }

     async function fetchProperties(){
        var response = await fetchRequest('/properties/wmr',{ids:propertyUrlQuery})
        console.log(response)
        response.toast()
        if(response.data.properties){
            properties.value = response.data.properties
        }
       
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