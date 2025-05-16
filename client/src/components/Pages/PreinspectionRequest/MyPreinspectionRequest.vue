<template>
    <AuthenticatedPage pageTitle="Pre Inspection Requests">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full min-h-[10%] flex justify-between items-center border-b">
               <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                   <Input v-model="searchKeyword" type="text" label="Search Keyword" :errorMessage="''"/>
                   <Button text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
               </div>

               <div class="flex justify-start items-center gap-2 p-2">
                    <PrimevueButton v-if="wmr.selectedRequests.length > 0" @click="goToWMRPage" label="Create WMR" class="shadow-md shadow-slate-600" severity="warn"/>
                    <PrimevueButton @click="preInspectionModal = true" label="Create Pre Inspection Request" />
               </div>
           </div>

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black gap-2">
                   <span class="min-w-[30%]">Equipment</span>
                   <span class="min-w-[10%]">Property #</span>
                   <span class="min-w-[20%]">Section to Inspect</span>
                   <span class="min-w-[10%]">Defects</span>
                   <span class="min-w-[10%]">Date</span>
                   <span class="min-w-[20%]">Status</span>
               </div>
               <div v-for="request in requests" @click="pushToWMR(request)" class="w-full flex justify-start items-center border-b font-poppins text-center cursor-pointer py-2 font-light text-sm hover:bg-emerald-400 text-black gap-2" :class="wmr.selectedRequests.includes(request.property) ? 'bg-blue-500 text-white' : 'bg-white/50'">
                    <span class="min-w-[30%] text-left pl-1">{{ request.equipment }}</span>
                    <span class="min-w-[10%]">{{ request.property_no }}</span>
                    <span class="min-w-[20%]">{{ request.inspection_section }}</span>
                    <span class="min-w-[10%] flex flex-col gap-2">
                        <Tag @click="openDefectsModal(request.defects)" severity="info" value="Defect/s" class="text-xs shadow-sm shadow-slate-600 cursor-pointer"></Tag>
                        <Tag v-if="request.findings === ''" @click="openDefectsModal(request.findings)" severity="warn" value="Findings" class="text-xs shadow-sm shadow-slate-600 cursor-pointer"></Tag>
                    </span>
                    <span class="min-w-[10%]">{{request.date_requested}}</span>
                    <span class="min-w-[20%]">{{ request.inspection_result }}</span>
               </div>
               
           </div>

       </div>

       <!-- <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchRequests"/> -->

   </AuthenticatedPage>

   <Dialog v-model:visible="preInspectionModal" modal header="Create Preinspection Request" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }" @hide="clearPreinspectionForm">
       <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y">
            <div class="w-full flex justify-start items-start gap-4 p-2">
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="preInspectionRequest.property_no"  class="w-full" @change="onChangePropertyNumber"/>
                    <label>Property #</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="preInspectionRequest.model"  class="w-full"/>
                    <label>Equipment Model</label>
                </FloatLabel>
                <FloatLabel class="w-full" variant="on">
                    <Select v-model="preInspectionRequest.equipment_type" :options="equipmentTypes" optionLabel="name"  optionValue="name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Equipment Type</label>
                </FloatLabel>
            </div>

            <div class="w-full flex justify-start items-start gap-4 p-2">
                <FloatLabel variant="on" class="w-full">
                    <DatePicker v-model="preInspectionRequest.date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Date Prepared</label>
                </FloatLabel>
                <FloatLabel variant="on"  class="max-w-1/3 w-1/3">
                    <InputNumber v-model="preInspectionRequest.acquisition_cost" mode="decimal" class="w-full"/>
                    <label>Acquisiton Cost</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full">
                    <DatePicker v-model="preInspectionRequest.acquisition_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Date of Acquisition</label>
                </FloatLabel>
                <FloatLabel class="w-full" variant="on">
                    <Select v-model="preInspectionRequest.requested_by" :options="userSelection" optionLabel="full_name"  optionValue="full_name" disabled class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Requested By</label>
                </FloatLabel>
            </div>

            <FloatLabel variant="on" class="w-full">
                <InputText v-model="preInspectionRequest.equipment"  class="w-full"/>
                <label>Equipment</label>
            </FloatLabel>

            <div class="w-full flex flex-col justify-start items-start">
                <Editor v-model="preInspectionRequest.defects" class="w-full" editorStyle="height:220px" placeholder="Enter Defects"/>
            </div>

            <div class="w-full flex justify-end items-center gap-2 p-2 font-poppins">
                <PrimevueButton @click="saveRequest" label="Create Request" class="shadow-md shadow-slate-600" severity="info"/>
            </div>
       </div>
   </Dialog>

   <Dialog v-model:visible="defectsModal" modal header="Equipment Defects" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
       <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y" v-html="currentDefects">

       </div>
   </Dialog>

   <Dialog v-model:visible="findingsModal" modal header="Equipment Inspection Findings" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
       <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y" v-html="currentFindings">

       </div>
   </Dialog>


</template>

<script setup>
   import { ref,onMounted } from 'vue';
   import { useRouter } from 'vue-router';
   import { useAuthStore } from '../../../stores/authStore';
   import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
   import Pagination from '../../Pagination.vue';
   import Input from '../../Form/Input.vue';
   import Button from '../../Button.vue';
   import axios from '../../../axios/axios';
   import { Icon } from '@iconify/vue/dist/iconify.js';
   import Dialog from 'primevue/dialog';
   import { Notify,Loading, Report } from 'notiflix';
   import TextArea from '../../TextArea.vue';
   import PrimevueButton from 'primevue/button';
   import FloatLabel from 'primevue/floatlabel';
   import InputText from 'primevue/inputtext';
   import DatePicker from 'primevue/datepicker';
   import Select from 'primevue/select';
   import Editor from 'primevue/editor';
   import InputNumber from 'primevue/inputnumber';
   import Tag from 'primevue/tag';

    const router = useRouter();
    const store = useAuthStore();   

    var pagination = ref({
        page:1,
        total:0
    })

    var preInspectionRequest = ref({
        equipment:'',
        property_no:'',
        requested_by:store.user.full_name,
        defects:'',
        date:'',
        model:'',
        equipment_type:'',
        acquisition_date:'',
        acquisition_cost:''
    })

    var equipmentTypes = ref([
        {
            name:'ICT Equipments',
            code:'ICT'
        },
        {
            name:'Other Equipments',
            code:'OTHER'
        }
    ])

    var preInspectionModal = ref(false);
    var defectsModal = ref(false)
    var findingsModal = ref(false)

    var searchKeyword = ref('');

    var userSelection = ref([])
    var requests = ref([])

    var currentDefects = ref('')
    var currentFindings = ref('')


    var wmr = ref({
        selectedRequests:[]
    })


   onMounted(() => {
      fetchUserSelection();
      fetchRequests()
   });


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

    function fetchRequests(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('preinspection_request/list/user',{
            params:{
               
            }
        })
        .then((response)=>{
           requests.value = response.data.requests
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function onChangePropertyNumber(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('property/find/property_number',{
            params:{
                property_no:preInspectionRequest.value.property_no
            }
        })
        .then((response)=>{
            if(response.data.property){
                preInspectionRequest.value.equipment = response.data.property.particulars
                preInspectionRequest.value.acquisition_date = response.data.property.user.issuance_date
                preInspectionRequest.value.acquisition_cost = response.data.property.unit_cost
            }
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function saveRequest(){
        console.log(preInspectionRequest.value)
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.post('preinspection_request/create',{
            equipment:preInspectionRequest.value.equipment,
            model:preInspectionRequest.value.model,
            property_no:preInspectionRequest.value.property_no,
            date:preInspectionRequest.value.date,
            acquisition_cost:preInspectionRequest.value.acquisition_cost,
            acquisition_date:new Date(preInspectionRequest.value.acquisition_date).toLocaleDateString('en-US', { year: 'numeric', month: 'numeric', day: 'numeric' }),
            defects:preInspectionRequest.value.defects,
            requestor:store.user.user_id,
            equipment_type:preInspectionRequest.value.equipment_type
        })
        .then((response)=>{
            Notify.success('Pre Inspection Request has been created and routed to designated inspector/s.',() => {},{fontFamily:'Lexend Deca'}) 
            preInspectionModal.value = false
            fetchRequests()
        })
        .catch((error)=>{
            if(error.response.data.message){
                Notify.failure(error.response.data.message,() => {},{fontFamily:'Lexend Deca'}) 
            }
            else{
                Notify.failure('Something Went Wrong, Please Try Again',() => {},{fontFamily:'Lexend Deca'}) 
            }
            console.log(error.response)
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function  clearPreinspectionForm(){
        preInspectionRequest.value.equipment = '',
        preInspectionRequest.value.property_no = '',
        preInspectionRequest.value.requested_by = store.user.full_name,
        preInspectionRequest.value.defects = '',
        preInspectionRequest.value.date = '',
        preInspectionRequest.value.model = '',
        preInspectionRequest.value.equipment_type = '',
        preInspectionRequest.value.acquisition_date = '',
        preInspectionRequest.value.acquisition_cost = ''
    }

    function openDefectsModal(defects){
        currentDefects.value = defects
        defectsModal.value = true
    }

    
    function openFindingsModal(findings){
        currentFindings.value = defects
        findingsModal.value = true
    }

    function pushToWMR(request){
       if(request.inspection_result === 'For Waste'){
            var duplicate = wmr.value.selectedRequests.some(selectedProperty => selectedProperty.property_no === request.property.property_no)
            if(duplicate){
                wmr.value.selectedRequests.splice(wmr.value.selectedRequests.indexOf(request.property),1)
            }
            else{
                wmr.value.selectedRequests.push(request.property)
                Notify.success('Added to Selected Properties',{fontFamily:'Lexend Deca',timeout:2000})
            }
       }
       else{
            Notify.failure('Cannot add to WMR list for it is either for repair or still under inspection',{fontFamily:'Lexend Deca',timeout:2000})
       }
    }

    function goToWMRPage(){
        var ids = []

        wmr.value.selectedRequests.forEach(property => {
            ids.push(property.id)
        });

        router.push({
            name: 'Create WMR',
            query: {
                selectedProperties: ids
            }
        });
    }


</script>