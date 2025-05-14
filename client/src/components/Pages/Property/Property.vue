<template>
    <AuthenticatedPage pageTitle="Properties (as of January 2025)">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full min-h-[10%] flex justify-between items-center border-b">
               <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                   <Input v-model="searchKeyword" type="text" label="Search Keyword" :errorMessage="''"/>
                   <Button @click="fetchProperties" text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
               </div>

               <div class="flex justify-start items-center gap-2 p-2 font-lexend">
                    <PrimevueButton @click="addPropertyModal = true" label="Add Property" severity="primary"/>
                    <PrimevueButton @click="selectPropertiesModal = true" label="Transfer Property/ies" severity="info"/>
               </div>
           </div>

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black">
                   <span class="min-w-[10%]">Property #</span>
                   <span class="min-w-[25%]">Article</span>
                   <span class="min-w-[20%]">End User/s</span>
                   <span class="min-w-[15%]">Cost</span>
                   <span class="min-w-[10%]">Acquisition Date</span>
                   <span class="min-w-[20%]">Actions</span>
               </div>
               
               <div v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400 text-black">
                   <span class="min-w-[10%]">{{ property.property_no }}</span>
                   <span class="min-w-[25%] text-xs">{{ property.particulars }}</span>
                   <span class="min-w-[20%] text-xs">{{ property.user_name }}</span>
                   <span class="min-w-[15%] text-xs">{{ property.unit_cost }}</span>
                   <span class="min-w-[10%]">{{ property.user.issuance_date }}</span>
                   <div class="min-w-[20%] flex justify-center items-center gap-2">
                        <span @click="handleNavigation(`/property/update/${property.id}`)" title="Update Property"><Icon icon="flowbite:edit-solid" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
                        <span title="Print Sticker"><Icon icon="material-symbols:print-rounded" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/></span>
                   </div>
               </div>
           </div>

       </div>

       <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchProperties"/>

   </AuthenticatedPage>

   <Dialog v-model:visible="addPropertyModal" modal header="Add Property" :style="{ width: '100rem',  fontFamily: 'Lexend Deca' }" @hide="clearAddPropertyForm">
       <div class="w-full flex flex-col justify-start items-start gap-4 bg-gray-200 p-4 text-black">
            <div class="w-full flex justify-start items-start gap-4">
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="text" label="Property Number" :errorMessage="errors.property_no ? errors.property_no[0] : ''" v-model="property.property_no"/>
                </div>
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="number" label="Unit Cost" :errorMessage="errors.unit_cost ? errors.unit_cost[0] : ''" v-model="property.unit_cost"/>
                </div>
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="text" label="Remarks" :errorMessage="errors.remarks ? errors.remarks[0] : ''" v-model="property.remarks"/>
                </div>
                <div class="w-1/4 flex justify-start items-start gap-2">
                    <Input type="date" label="Acquisition Date" :errorMessage="errors.acquisition_date ? errors.acquisition_date[0] : ''" v-model="property.acquisition_date"/>
                </div>
            </div>
            <div class="w-full flex justify-start items-start gap-4">
                <Select v-model="property.measurement_unit" :options="measurements" :invalid="errors.measurement_unit ? true : false" filter optionLabel="name" placeholder="Select Measurement" class="w-1/3 font-lexend translate-y-1/2">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>
                <Select v-model="property.status" :options="statuses" :invalid="errors.status ? true : false" filter optionLabel="name" placeholder="Select Status" class="w-1/3 font-lexend translate-y-1/2">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>
                <Select v-model="property.end_user" :options="end_users" :invalid="errors.end_user ? true : false" filter optionLabel="full_name" placeholder="Select End User" class="w-1/3 font-lexend translate-y-1/2">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.full_name }}</div>
                        </div>
                    </template>
                </Select>
            </div>
            <div class="w-full flex justify-start items-start pt-4">
                <TextArea v-model="property.particulars" label="Description/Particulars" :errorMessage="errors.particulars ? errors.particulars[0] : '' "/>
            </div>
            <div class="w-full flex justify-end items-start p-4">
                <Button @click="save" text="Submit" buttonType="create" class="translate-y-2.5"/>
            </div>
       </div>
   </Dialog>

    <Dialog v-model:visible="selectPropertiesModal" modal header="Select Properties to Transfer" :style="{ width: '100rem', height:'100%',  fontFamily: 'Lexend Deca' }">

        <div class="w-full flex justify-start items-start gap-4 p-4 text-black">
            <PropertySelection @submit="setSelectedPropertiesFromSelection"/>
        </div>
        
        <div v-if="transfer.selectedProperties.length > 0" class="w-full flex justify-end px-4  mt-4 gap-4">
             <FloatLabel variant="on" class="w-full">
                <DatePicker v-model="transfer.transfer_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Date of Transfer</label>
            </FloatLabel>
            <Select v-model="transfer.transfer_to" :options="end_users" filter optionLabel="full_name" optionValue="user_id" placeholder="Select End User" class="w-full font-lexend">
                <template #option="slotProps">
                    <div class="flex items-center font-lexend">
                        <div>{{ slotProps.option.full_name }}</div>
                    </div>
                </template>
            </Select>
        </div>

        <div v-if="transfer.selectedProperties.length > 0" class="w-full flex justify-end px-4 mt-4">
            <PrimevueButton @click="transferSelectedProperties" label="Transfer Selected Properties" severity="info"/>
        </div>

    </Dialog>

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
    import PrimevueButton from 'primevue/button';
    import PropertySelection from '../../selections/PropertySelection.vue';
    import DatePicker from 'primevue/datepicker';
    import FloatLabel from 'primevue/floatlabel';


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

    var property = ref({
        property_no:'',
        measurement_unit:null,
        particulars:'',
        unit_cost:null,
        status:'',
        remarks:'',
        end_user:null ,
        acquisition_date:'' 
    })

    var errors = ref({})

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

    var addPropertyModal = ref(false)

    var selectPropertiesModal = ref(false)
    var selectedProperties = ref([])

    var property_no = ref('')

    var transfer = ref({
        selectedProperties:[],
        transfer_date:'',
        transfer_to:0,
        remarks:''
    })

   onMounted(() => {
       fetchProperties();
       fetchUserSelection();
       fetchMeasurements();
   });


    function fetchProperties(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });
        
        axios.get('property/list',{
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

    function fetchMeasurements(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('measurement/selection',{
            params:{
                page:pagination.value.page,
            }
        })
        .then((response)=>{
            measurements.value = response.data.measurements
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
            end_users.value = response.data.users
            //    pagination.value.total = response.data.total
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

    function save(){
        axios.post('property/create',{
            property_no:property.value.property_no,
            measurement_unit:property.value.measurement_unit?.id,
            particulars:property.value.particulars,
            unit_cost:property.value.unit_cost,
            status:property.value.status.name,
            remarks:property.value.remarks,
            end_user:property.value.end_user?.user_id,
            acquisition_date:property.value.acquisition_date ?? null
        })
        .then((response) => {
            Report.success(
                'Success',
                `Message:${response.data.message}`,
                'Okay',
                () => {
                    addPropertyModal.value = false
                    fetchProperties()
                },
                {
                    fontFamily:'Lexend Deca'
                },
            );
        })
        .catch((error) => {
            errors.value = error.response.data.errors
            Report.failure(
                'Error',
                `Errors:${error.response.data.errors}`,
                'Okay',
                () => {

                },
                {
                    fontFamily:'Lexend Deca'
                },
            );
        })
        .finally(()=>{

        })
    }

    function setSelectedPropertiesFromSelection(selected_properties){
        transfer.value.selectedProperties = selected_properties
    }

    function transferSelectedProperties(){
        axios.post('property/transfer',{
            transfer_to: transfer.value.transfer_to,
            properties: transfer.value.selectedProperties,
            transfer_date: transfer.value.transfer_date,
            remarks: transfer.value.remarks
        })
        .then((response) => {
            Report.success(
                'Success',
                `Message:${response.data.message}`,
                'Okay',
                () => {
                    selectPropertiesModal.value = false
                    fetchProperties()
                },
                {
                    fontFamily:'Lexend Deca'
                },
            );
        })
        .catch((error) => {
            errors.value = error.response.data.errors
            Report.failure(
                'Error',
                `Errors:${error.response.data.errors}`,
                'Okay',
                () => {

                },
                {
                    fontFamily:'Lexend Deca'
                },
            );
        })
        .finally(()=>{

        })

    }

</script>