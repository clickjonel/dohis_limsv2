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
                    <PrimevueButton v-if="selected.length > 0" @click="goToWMRPage" label="Create WMR" severity="info" class="shadow-md shadow-slate-600"/>
                    <!-- <PrimevueButton label="Create WMR" severity="info" class="shadow-md shadow-slate-600"/> -->
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[30%] max-w-[30%] text-left px-2">Equipment</span>
                    <span class="min-w-[10%] max-w-[10%]">Property #</span>
                    <span class="min-w-[20%] max-w-[20%]">Date Requested</span>
                    <span class="min-w-[20%] max-w-[20%]">Defects</span>
                    <span class="min-w-[10%] max-w-[10%]">Status</span>
                    <span class="min-w-[10%] max-w-[10%]">Action</span>
                </div>
                
                <div v-for="request in requests" v-bind:key="request.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light bg-white/50 hover:bg-emerald-400 text-sm">
                    <span class="min-w-[30%] max-w-[30%] text-left pl-1">{{ request.property.particulars }}</span>
                    <span class="min-w-[10%] max-w-[10%]">{{ request.property.property_no }}</span>
                    <span class="min-w-[20%] max-w-[20%]">{{ request.request_date }}</span>
                    <span class="min-w-[20%] max-w-[20%]">{{ request.defects }}</span>
                    <span class="min-w-[10%] max-w-[10%] flex flex-col justify-start items-center gap-2">{{ request.status }}</span>
                    <span class="min-w-[10%] max-w-[10%] flex flex-col justify-start items-center gap-2">
                         <Badge v-if="request.status === 'WMR' && !selected.includes(request.id)" @click="addToSelected(request.id)" value="Select" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge>
                         <Badge v-if="request.status === 'WMR' && selected.includes(request.id)" @click="removeToSelected(request.id)" value="Remove" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge>
                    </span>
                </div>
            </div>

        </div>

         <Pagination v-if="pagination.total > pagination.perPage" v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchPreinspectionRequests"/>

    </AuthenticatedPage>

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
        create:{
            show:false,
            data:{}
        },
    })

    // var searchKeyword = ref('');

    var requests = ref([])
    var selected = ref([])

   onMounted(() => {
      fetchPreinspectionRequests()
   });

    async function fetchPreinspectionRequests(){
        var response = await fetchRequest('property_inspection_requests/list',{
            page:pagination.value.page,
            per_page:pagination.value.perPage,
            user_id:store.user.user_id
        })
        response.toast()
        if(response.apiResponseStatus === 200){
          requests.value = response.data.requests
          pagination.value.total = response.data.total
        }
    
    }

    function addToSelected(property_id){
        selected.value.push(property_id)
    }

    function removeToSelected(property_id){
        selected.value.splice(selected.value.indexOf(property_id), 1)
    }

    function goToWMRPage(){
        router.push({path:'/property/wmr/create',query:{ids:selected.value}})
    }
  

</script>