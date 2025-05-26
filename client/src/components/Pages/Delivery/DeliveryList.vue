<template>
    <AuthenticatedPage pageTitle="Deliveries">
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <FloatLabel variant="on" class="w-full font-poppins">
                        <InputText v-model="searchKeyword"  class="w-full" @change="fetchDeliveries"/>
                        <label>Search Keyword | IAR No.</label>
                    </FloatLabel>
                </div>
                

                <div class="flex justify-start items-center gap-2 p-2">
                    <PrimevueButton @click="handleNavigation('/delivery/notice')" label="Notice of Delivery" severity="info" class="shadow-md shadow-slate-600"/>
                    <PrimevueButton @click="handleNavigation('/delivery/add')" label="Create Delivery" severity="info" class="shadow-md shadow-slate-600"/>
                    
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[10%]">IAR Details</span>
                    <span class="min-w-[15%]">PTR Details</span>
                    <span class="min-w-[25%]">Requisitioning <br> Office-End User</span>
                    <span class="min-w-[25%]">Source Details</span>
                    <span class="min-w-[10%]">Delivery Date/s</span>
                    <span class="min-w-[20%]">Actions</span>
                </div>
                
                <div v-if="deliveries.length > 0" v-for="delivery in deliveries" v-bind:key="delivery.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
                    <span class="min-w-[10%]">{{ delivery.iar_no }} <br> <span class="text-xs">{{ delivery.iar_date }}</span></span>
                    <span class="min-w-[15%]">{{ delivery.ptr_no ?? delivery.po_no }} <br> <span class="text-xs">{{ delivery.ptr_date ?? delivery.po_date }}</span></span>
                    <span class="min-w-[25%]">{{ delivery.end_user }} <br> <span class="text-xs">{{ delivery.req_office }}</span></span>
                    <span class="min-w-[25%]">{{ delivery.source_name }} <br> <span class="text-xs">{{ delivery.source_address }}</span></span>
                    <div class="min-w-[10%] flex flex-col justify-start items-center">
                        <span v-for="date in delivery.delivery_dates" :key="date"><span class="text-xs">{{ date }}</span></span>
                    </div>
                    <div class="min-w-[20%] flex justify-center items-center gap-2">
                         <span title="Update Delivery">
                            <Icon @click="handleNavigation(`/delivery/update/${delivery.id}`)" icon="material-symbols:edit-square-outline" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/>
                        </span>
                        <span title="Print IAR">
                            <Icon @click="handleNavigation(`/delivery/iar/${delivery.id}`)" icon="material-symbols:print-outline" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/>
                        </span>
                    </div>
                </div>

                <div v-if="deliveries.length===0" class="w-full h-[600px] flex justify-center items-center">
                    <span class="font-medium font-lexend animate-bounce">No Deliveries Fetched</span>
                </div>
            </div>

        </div>

         <Pagination v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchDeliveries"/>

    </AuthenticatedPage>
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

    const router = useRouter();
    const deliveries = ref([]);
    const { fetchRequest } = useApi();

    var pagination = ref({
        page:1,
        total:0,
        perPage:10
    })

    var searchKeyword = ref('');

    onMounted(()=>{
        fetchDeliveries()
    })

    function handleNavigation(path){
       router.push({path:path})
    }

    async function fetchDeliveries(){
        var response = await fetchRequest('deliveries/list',{
            page:pagination.value.page,
            keyword:searchKeyword.value,
            per_page:pagination.value.perPage
        })
        response.toast()
        if(response.data.deliveries){
            deliveries.value = response.data.deliveries
            pagination.value.total = response.data.total
        }
    
    }



</script>