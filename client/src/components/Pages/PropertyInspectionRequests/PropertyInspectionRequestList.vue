<template>
 <AuthenticatedPage>
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <!-- <FloatLabel variant="on" class="w-full font-poppins">
                        <InputText v-model="searchKeyword"  class="w-full"/>
                        <label>Search Keyword | Property #</label>
                    </FloatLabel> -->
                </div>
                

                <div class="flex justify-start items-center gap-2 p-2">
                    <!-- <PrimevueButton @click="modals.create.show = true" label="Create" severity="info" class="shadow-md shadow-slate-600"/> -->
                    <!-- <PrimevueButton label="Create WMR" severity="info" class="shadow-md shadow-slate-600"/> -->
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[10%] max-w-[10%]">Property #</span>
                    <span class="min-w-[20%] max-w-[20%]">Date Requested</span>
                    <span class="min-w-[20%] max-w-[20%]">Defects</span>
                    <span class="min-w-[20%] max-w-[20%]">Status</span>
                    <span class="min-w-[20%] max-w-[20%]">Requested By</span>
                    <span class="min-w-[10%] max-w-[10%]">Action</span>
                </div>
                
                <div v-for="request in requests" v-bind:key="request.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light bg-white/50 hover:bg-emerald-400 text-sm">
                    <span class="min-w-[10%] max-w-[10%]">{{ request.property.property_no }}</span>
                    <span class="min-w-[20%] max-w-[20%]">{{ request.request_date }}</span>
                    <span class="min-w-[20%] max-w-[20%]">{{ request.defects }}</span>
                    <span class="min-w-[20%] max-w-[20%] flex flex-col justify-start items-center gap-2">{{ request.status }}</span>
                    <span class="min-w-[20%] max-w-[20%]">{{ request.requested_by }}</span>
                    <span class="min-w-[10%] max-w-[10%] flex justify-center items-center gap-2">
                        <Badge v-if="request.status === 'For Inspection'" @click="(modals.inspection.show = true, modals.inspection.data.request_id = request.id)" value="Inspect" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge>
                        <Badge v-if="request.status === 'Inspection Done' && request.inspection_result === 'For Waste'" @click="confirmWasteStatus(request.id)" value="Set as for WMR" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge>
                        <!-- <Badge v-if="request.status === 'Inspection Done' && request.inspection_result === 'For Repair'" value="Set as Repaired" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge> -->
                    </span>
                </div>
            </div>

        </div>

         <Pagination v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchPreinspectionRequests"/>

    </AuthenticatedPage>

    <Dialog v-model:visible="modals.inspection.show" modal header="Set Property Inspection Findings" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex flex-col justify-between items-start gap-4 p-4 text-black border-y">
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <div class="w-full flex justify-start items-start gap-2 mt-4">
                    <FloatLabel variant="on" class="w-full">
                        <DatePicker v-model="modals.inspection.data.inspection_date" class="w-full"/>
                        <label class="font-poppins">Date of Inspection</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="modals.inspection.data.inspection_result" :options="[{id:1,label:'For Waste'},{id:2,label:'For Repair'}]" optionLabel="label" optionValue="label" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Inspection Result</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <InputText v-model="modals.inspection.data.status" class="w-full" disabled/>
                        <label>Status</label>
                    </FloatLabel>
                </div>
                <FloatLabel class="w-full mt-4" variant="on">
                    <Textarea v-model="modals.inspection.data.inspection_findings" class="w-full" />
                    <label>Inspection Findings</label>
                </FloatLabel>
                <PrimevueButton @click="setFindings" label="Submit Inspection Findings" severity="info" class="w-full mt-4 shadow-md shadow-slate-600"/>
            </div>
        </div>
    </Dialog>


</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import { useAuthStore } from '../../../stores/authStore';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import Dialog from 'primevue/dialog';
    import TextArea from '../../TextArea.vue';
    import PrimevueButton from 'primevue/button';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import Tag from 'primevue/tag';
    import useApi from '../../../composables/api_calls';
    import AutoComplete from 'primevue/autocomplete';
    import Badge from 'primevue/badge';
    import DatePicker from 'primevue/datepicker';
    import Select from 'primevue/select';
    import Textarea from 'primevue/textarea';
    import { showConfirm } from '../../../composables/notiflix';
     

    const router = useRouter();
    const store = useAuthStore();   
    const { fetchRequest,postRequest } = useApi();

    var pagination = ref({
        page:1,
        total:0,
        perPage:15
    })


    var modals = ref({
        inspection:{
            show:false,
            data:{
                status:'Inspection Done'
            }
        },
        qr:{
            show:false,
            text:''
        }
    })

    // var searchKeyword = ref('');

    var requests = ref([])


   onMounted(() => {
      fetchPreinspectionRequests()
   });

    async function fetchPreinspectionRequests(){
        var response = await fetchRequest('property_inspection_requests/list',{
            page:pagination.value.page,
            //keyword:searchKeyword.value,
            per_page:pagination.value.perPage,
            section_id:store.user.assignment.section_id
        })
        response.toast()
        if(response.apiResponseStatus === 200){
          requests.value = response.data.requests
          pagination.value.total = response.data.total
        }
    
    }

    async function setFindings(){
        const response = await postRequest('property_inspection_requests/inspect', modals.value.inspection.data);
        response.toast();
        if(response.apiResponseStatus === 200){
            modals.value.inspection.show = false;
            modals.value.inspection.data = {
                status:'Inspection Done',

            }

            fetchPreinspectionRequests();

        }
    }

    function confirmWasteStatus(request_id){
        showConfirm(
            'Set Property For WMR',
            'Are you sure you want to set the property for WMR?',
            'Yes, waste it',
            'No, cancel',
            () => setWMRStatus(request_id),
            () => {}
            
        )
    }

    async function setWMRStatus(request_id){
        const response = await postRequest('property_inspection_requests/wmr', {request_id:request_id});
        response.toast();
        if(response.apiResponseStatus === 200){
            fetchPreinspectionRequests();
        }
    }


</script>