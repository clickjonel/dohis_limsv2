<template>
    <AuthenticatedPage pageTitle="Stock Cards">
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <FloatLabel variant="on" class="w-full font-poppins">
                        <InputText v-model="searchKeyword"  class="w-full" @change="fetchPreinspectionRequests"/>
                        <label>Search Keyword | Stock No.</label>
                    </FloatLabel>
                </div>
                

                <!-- <div class="flex justify-start items-center gap-2 p-2">
                    <PrimevueButton label="Add Stock Card" severity="info" class="shadow-md shadow-slate-600"/>
                </div> -->
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[30%]">Equipment</span>
                    <span class="min-w-[10%]">Property #</span>
                    <span class="min-w-[20%]">Requested By</span>
                    <span class="min-w-[10%]">Defects</span>
                    <span class="min-w-[10%]">Date</span>
                    <span class="min-w-[20%]">Actions</span>
                </div>
                
                <div v-for="request in preinspection_requests" v-bind:key="request.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light bg-white/50 hover:bg-emerald-400 text-sm">
                    <span class="min-w-[30%] text-left pl-1">{{ request.equipment }}</span>
                    <span class="min-w-[10%]">{{ request.property_no }}</span>
                    <span class="min-w-[20%]">{{ request.requestor }}</span>
                    <span class="min-w-[10%]"><Tag @click="openDefectsModal(request)" severity="info" value="Defect/s" class="text-xs shadow-sm shadow-slate-600 cursor-pointer"></Tag></span>
                    <span class="min-w-[10%]">{{request.date}}</span>
                    <span class="min-w-[20%] flex flex-col justify-start items-center gap-2">
                        <Tag v-if="request.inspection_result === null" @click="openFindingsModal(request)" severity="secondary" value="Set Findings" class="text-xs shadow-sm shadow-slate-600 cursor-pointer"></Tag>
                        <Tag v-else :severity="request.inspection_result === 'For Waste' ? 'warn' : 'primary'" :value="request.inspection_result"></Tag>
                    </span>
                </div>
            </div>

        </div>

         <Pagination v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchPreinspectionRequests"/>

    </AuthenticatedPage>

        <Dialog v-model:visible="modals.defects.show" modal header="Create Preinspection Request" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
            <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y" v-html="modals.defects.data.defects">
              
            </div>
        </Dialog>

            <Dialog v-model:visible="modals.findings.show" modal header="Create Preinspection Request" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
                <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y">
                        <Editor v-model="modals.findings.data.findings" class="w-full" editorStyle="height:220px" placeholder="Enter Findings upon Inspection of the Equipment"/>
                        <FloatLabel class="w-full" variant="on">
                            <Select v-model="modals.findings.data.inspection_action" :options="[
                                    {action:'For Waste'},
                                    {action:'For Repair'}
                                ]" 
                                optionLabel="action"  
                                optionValue="action" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                            <label>Select Action for Equipment</label>
                        </FloatLabel>
                        <FloatLabel variant="on" class="w-full">
                            <DatePicker v-model="modals.findings.data.inspection_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
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
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import useApi from '../../../composables/api_calls';
    import PrimevueButton from 'primevue/button';
    import Tag from 'primevue/tag';
    import Dialog from 'primevue/dialog';
    import DatePicker from 'primevue/datepicker';
    import Select from 'primevue/select';
    import Editor from 'primevue/editor';

    const router = useRouter();
    const preinspection_requests = ref([]);
    const { fetchRequest, postRequest } = useApi();

    var pagination = ref({
        page:1,
        total:0,
        perPage:15
    })

    var modals = ref({
        defects:{
            show:false,
            data:''
        },
        findings:{
            show:false,
            data:''
        }
    })

    var searchKeyword = ref('');

    onMounted(()=>{
        fetchPreinspectionRequests()
    })

    function handleNavigation(path){
       router.push({path:path})
    }

    async function fetchPreinspectionRequests(){
        var response = await fetchRequest('preinspection_requests/list',{
            page:pagination.value.page,
            keyword:searchKeyword.value,
            per_page:pagination.value.perPage
        })
        response.toast()
        if(response.data.preinspection_requests){
            preinspection_requests.value = response.data.preinspection_requests
            pagination.value.total = response.data.total
        }
    
    }

    function openDefectsModal(inspection_request){
        modals.value.defects.data = inspection_request
        modals.value.defects.show = true
    }

    function openFindingsModal(inspection_request){
        modals.value.findings.data = inspection_request
        modals.value.findings.show = true
    }

    async function actionPreinspectionRequest(){
        var response = await postRequest('preinspection_request/action',{
            findings:modals.value.findings.data.findings,
            inspection_result:modals.value.findings.data.inspection_action,
            id:modals.value.findings.data.id,
            inspection_date:modals.value.findings.data.inspection_date
        })
        response.toast()
        if(response.data.message){
            modals.value.findings.data = {}
            modals.value.findings.show = false
            fetchPreinspectionRequests()
        }
    }


</script>