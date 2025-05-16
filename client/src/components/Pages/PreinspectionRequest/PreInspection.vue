<template>
    <AuthenticatedPage pageTitle="Pre Inspection Requests">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

          <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black gap-2">
                   <span class="min-w-[30%]">Equipment</span>
                   <span class="min-w-[10%]">Property #</span>
                   <span class="min-w-[20%]">Requested By</span>
                   <span class="min-w-[10%]">Defects</span>
                   <span class="min-w-[10%]">Date</span>
                   <span class="min-w-[20%]">Actions</span>
               </div>
               <div v-for="request in requests" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400 text-black gap-2">
                    <span class="min-w-[30%] text-left pl-1">{{ request.equipment }}</span>
                    <span class="min-w-[10%]">{{ request.property_no }}</span>
                    <span class="min-w-[20%]">{{ request.requested_by }}</span>
                    <span class="min-w-[10%]"><Tag @click="openDefectsModal(request)" severity="info" value="Defect/s" class="text-xs shadow-sm shadow-slate-600 cursor-pointer"></Tag></span>
                    <span class="min-w-[10%]">{{request.date_requested}}</span>
                    <span class="min-w-[20%] flex flex-col justify-start items-center gap-2">
                        <Tag v-if="request.inspection_result === null" @click="openFindingsModal(request)" severity="secondary" value="Set Findings" class="text-xs shadow-sm shadow-slate-600 cursor-pointer"></Tag>
                        <Tag v-else :severity="request.inspection_result === 'For Waste' ? 'warn' : 'primary'" :value="request.inspection_result"></Tag>
                    </span>
               </div>
               
           </div>

       </div>

       <!-- <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchRequests"/> -->

   </AuthenticatedPage>

   <Dialog v-model:visible="defectsModal" modal header="Create Preinspection Request" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
       <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y" v-html="currentInspectionRequest.defects">

       </div>
   </Dialog>

    <Dialog v-model:visible="findingsModal" modal header="Create Preinspection Request" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
       <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y">
            <Editor v-model="findingsForm.findings" class="w-full" editorStyle="height:220px" placeholder="Enter Findings upon Inspection of the Equipment"/>
            <FloatLabel class="w-full" variant="on">
                <Select v-model="findingsForm.inspection_action" :options="equipment_actions" optionLabel="action"  optionValue="action" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Select Action for Equipment</label>
            </FloatLabel>
             <FloatLabel variant="on" class="w-full">
                <DatePicker v-model="findingsForm.inspection_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Date</label>
            </FloatLabel>
       </div>
       <div class="w-full flex justify-end p-2">
           <PrimevueButton @click="actionPreinspectionRequest" label="Save Inspection"/>
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
    import Tag from 'primevue/tag';
    import Editor from 'primevue/editor';
    import Select from 'primevue/select';
    import FloatLabel from 'primevue/floatlabel';
    import PrimevueButton from 'primevue/button';
    import DatePicker from 'primevue/datepicker';



    const router = useRouter();

    var pagination = ref({
        page:1,
        total:0
    })

    var requests = ref([])

    var equipment_actions = [
        {action:'For Waste'},
        {action:'For Repair'}
    ]

    var searchKeyword = ref('');

    var defectsModal = ref(false)
    var currentInspectionRequest = ref(null)

    var findingsModal = ref(false)

    var findingsForm = ref({
        findings:'',
        inspection_request:0,
        inspection_action:'',
        inspection_date:''
    })

   onMounted(() => {
        fetchRequests()
   });


    function fetchRequests(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('preinspection_request/list',{
            params:{
            
            }
        })
        .then((response)=>{
            requests.value = response.data.requests
            console.log(response.data)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function openDefectsModal(inspection_request){
        currentInspectionRequest.value = inspection_request
        defectsModal.value = true
    }

    function openFindingsModal(inspection_request){
        currentInspectionRequest.value = inspection_request
        findingsForm.value.inspection_request = inspection_request.id
        findingsModal.value = true
    }

    function actionPreinspectionRequest(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

       axios.post('preinspection_request/action',{
            findings:findingsForm.value.findings,
            inspection_result:findingsForm.value.inspection_action,
            id:findingsForm.value.inspection_request,
            inspection_date:findingsForm.value.inspection_date
        })
        .then((response) => {
            Report.success(
                'Success',
                `Message:${response.data.message}`,
                'Okay',
                () => {
                    findingsModal.value = false
                    fetchRequests()
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
            Loading.remove()
        })
    }


</script>