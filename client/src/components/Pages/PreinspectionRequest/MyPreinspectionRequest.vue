<template>
 <AuthenticatedPage>
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <FloatLabel variant="on" class="w-full font-poppins">
                        <InputText v-model="searchKeyword"  class="w-full" @change="fetchPreinspectionRequests"/>
                        <label>Search Keyword | Stock No.</label>
                    </FloatLabel>
                </div>
                

                <div class="flex justify-start items-center gap-2 p-2">
                    <PrimevueButton @click="router.push({path:'/preinspection_request/create'})" label="Create Request" severity="info" class="shadow-md shadow-slate-600"/>
                    <PrimevueButton label="Create WMR" severity="info" class="shadow-md shadow-slate-600"/>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[30%]">Equipment</span>
                    <span class="min-w-[10%]">Property #</span>
                    <span class="min-w-[20%]">Date Requested</span>
                    <span class="min-w-[10%]">Defects</span>
                    <span class="min-w-[10%]">Inspection</span>
                    <span class="min-w-[20%]">Status</span>
                </div>
                
                <div v-for="request in requests" v-bind:key="request.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light bg-white/50 hover:bg-emerald-400 text-sm">
                    <span class="min-w-[30%] text-left pl-1">{{ request.equipment }}</span>
                    <span class="min-w-[10%]">{{ request.property_no }}</span>
                    <span class="min-w-[20%]">{{ request.date }}</span>
                    <span class="min-w-[10%]"><Tag @click="openDefectsModal(request)" severity="info" value="Defect/s" class="text-xs shadow-sm shadow-slate-600 cursor-pointer"></Tag></span>
                    <span class="min-w-[10%]">{{request.inspection_date ?? 'Pending'}}</span>
                    <span class="min-w-[20%] flex flex-col justify-start items-center gap-2">{{ request.inspection_result ?? 'For Inspection' }}</span>
                </div>
            </div>

        </div>

         <Pagination v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchPreinspectionRequests"/>

    </AuthenticatedPage>

   <!-- <Dialog v-model:visible="preInspectionModal" modal header="Create Preinspection Request" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }" @hide="clearPreinspectionForm">
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
                    <Select v-model="preInspectionRequest.equipment_type" :options="
                        [
                            {
                                name:'ICT Equipments',
                                code:'ICT'
                            },
                            {
                                name:'Other Equipments',
                                code:'OTHER'
                            }
                        ]" 
                    optionLabel="name"  optionValue="name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
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
   </Dialog> -->

   <Dialog v-model:visible="modals.defects.show" modal header="Equipment Defects" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
       <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black border-y" v-html="modals.defects.data.defects">

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

    const router = useRouter();
    const store = useAuthStore();   
    const { fetchRequest } = useApi();

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
    })

    var searchKeyword = ref('');

    var requests = ref([])


   onMounted(() => {
      fetchPreinspectionRequests()
   });

    async function fetchPreinspectionRequests(){
        var response = await fetchRequest('preinspection_requests/list/user',{
            page:pagination.value.page,
            keyword:searchKeyword.value,
            per_page:pagination.value.perPage,
            user_id:store.user.user_id
        })
        response.toast()
        if(response.data.preinspection_requests){
          requests.value = response.data.preinspection_requests
          pagination.value.total = response.data.total
          console.log(response.data)
        }
    
    }
  
    function openDefectsModal(defects){
        modals.value.defects.data = defects
        modals.value.defects.show = true
    }

</script>