<template>
    <AuthenticatedPage pageTitle="Properties">
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <FloatLabel variant="on" class="w-full font-poppins">
                        <InputText v-model="searchKeyword"  class="w-full" @change="fetchProperties"/>
                        <label>Search Keyword | Property No.</label>
                    </FloatLabel>
                </div>
                

                <div class="flex justify-start items-center gap-2 p-2">
                    <!-- <PrimevueButton label="Create PTR" severity="info"/> -->
                    <!-- <PrimevueButton label="Create Inventory Report" severity="info"/> -->
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[10%]">Property #</span>
                    <span class="min-w-[45%]">Article</span>
                    <span class="min-w-[15%]">Cost</span>
                    <span class="min-w-[10%]">Acquisition Date</span>
                    <span class="min-w-[20%]">Actions</span>
                </div>
                
                <div v-if="properties.length > 0" v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
                    <span class="min-w-[10%]">{{ property.property_no }}</span>
                    <span class="min-w-[45%] text-xs">{{ property.particulars }}</span>
                    <span class="min-w-[15%] text-xs">{{ property.unit_cost }}</span>
                    <span class="min-w-[10%]">{{ property.user.issuance_date }}</span>
                    <div class="min-w-[20%] flex justify-center items-center gap-2">
                        <Badge @click="router.push({path:`/property/view/${property.id}`})" value="View" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge>
                        <Badge v-if="property.status === 'Active'" @click="{modals.preinspection.show = true; modals.preinspection.data.property_id = property.id}" value="Preinspection" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge>
                        <!-- <Badge value="QR Code" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge> -->
                    </div>
                </div>

                <div v-if="properties.length===0" class="w-full h-[600px] flex justify-center items-center">
                    <span class="font-medium font-lexend animate-bounce">No Properties Fetched</span>
                </div>
            </div>

        </div>

        <Pagination v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchProperties"/>

    </AuthenticatedPage>

        <Dialog v-model:visible="modals.preinspection.show" modal header="Create Property Inspection Request" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
            <div class="w-full flex flex-col justify-between items-start gap-4 p-4 text-black border-y">
                <div class="w-full flex flex-col justify-start items-start gap-2">
                    <div class="w-full flex justify-start items-start gap-2 mt-4">
                        <FloatLabel variant="on" class="w-full">
                            <DatePicker v-model="modals.preinspection.data.request_date" class="w-full"/>
                            <label class="font-poppins">Date of Request</label>
                        </FloatLabel>
                        <FloatLabel class="w-full" variant="on">
                            <Select v-model="modals.preinspection.data.inspection_section" :options="[{id:22,label:'Other Equipment'},{id:25,label:'ICT Equipment'}]" optionLabel="label" optionValue="id" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                            <label>Equipment Type</label>
                        </FloatLabel>
                        <FloatLabel class="w-full" variant="on">
                            <InputText v-model="modals.preinspection.data.status" class="w-full" />
                            <label>Status</label>
                        </FloatLabel>
                    </div>
                    <FloatLabel class="w-full mt-4" variant="on">
                        <Textarea v-model="modals.preinspection.data.defects" class="w-full" />
                        <label>Defects</label>
                    </FloatLabel>
                    <PrimevueButton @click="savePreinspection" label="Submit Request" severity="info" class="w-full mt-4 shadow-md shadow-slate-600"/>
                </div>
            </div>
        </Dialog>

</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import useApi from '../../../composables/api_calls';
    import PrimevueButton from 'primevue/button';
    import { useAuthStore } from '../../../stores/authStore';
    import Badge from 'primevue/badge';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import Dialog from 'primevue/dialog';
    import DatePicker from 'primevue/datepicker';
    import Select from 'primevue/select';
    import Textarea from 'primevue/textarea';
    import { showToast } from '../../../composables/notiflix';

    const router = useRouter();
    const properties = ref([]);
    const { fetchRequest,postRequest } = useApi();
    const store = useAuthStore();

    var pagination = ref({
        page:1,
        total:0,
        perPage:15
    })

    var searchKeyword = ref('');
    
    var modals = ref({
        preinspection:{
            show:false,
            data:{
                status:'For Inspection',
                requested_by:store.user.user_id,
            }
        }
    })

    onMounted(()=>{
        fetchProperties()
    })

    async function fetchProperties(){
        var response = await fetchRequest('properties/list/user',{
            page:pagination.value.page,
            keyword:searchKeyword.value,
            per_page:pagination.value.perPage,
            user_id:store.user.user_id
        })
        response.toast()
        if(response.data.properties){
            properties.value = response.data.properties
            pagination.value.total = response.data.total
        }
    
    }

async function savePreinspection(){
    console.log(modals.value.preinspection.data)
    const response = await postRequest('property_inspection_requests/create', modals.value.preinspection.data);
    response.toast();

    if(response.apiResponseStatus === 200){
        showToast('success',response.data.message)
        modals.value.preinspection.show = false;
        modals.value.preinspection.data = {
            status:'For Inspection',
            requested_by:store.user.user_id,
        };
    }
}

</script>