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
                    <PrimevueButton @click="addPropertyModal = true" label="Add Property" severity="primary"/>
                    <PrimevueButton @click="selectPropertiesModal = true" label="Transfer Property/ies" severity="info"/>
                    <PrimevueButton @click="handleNavigation('property/user')" label="Create Inventory Report" severity="info"/>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[10%]">Property #</span>
                    <span class="min-w-[25%]">Article</span>
                    <span class="min-w-[20%]">End User/s</span>
                    <span class="min-w-[15%]">Cost</span>
                    <span class="min-w-[10%]">Acquisition Date</span>
                    <span class="min-w-[20%]">Actions</span>
                </div>
                
                <div v-if="properties.length > 0" v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
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

                <div v-if="properties.length===0" class="w-full h-[600px] flex justify-center items-center">
                    <span class="font-medium font-lexend animate-bounce">No Properties Fetched</span>
                </div>
            </div>

        </div>

        <Pagination v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchProperties"/>

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
    const properties = ref([]);
    const { fetchRequest } = useApi();

    var pagination = ref({
        page:1,
        total:0,
        perPage:15
    })

    var searchKeyword = ref('');

    onMounted(()=>{
        fetchProperties()
    })

    function handleNavigation(path){
       router.push({path:path})
    }

    async function fetchProperties(){
        var response = await fetchRequest('properties/list',{
            page:pagination.value.page,
            keyword:searchKeyword.value
        })
        response.toast()
        if(response.data.properties){
            properties.value = response.data.properties
            pagination.value.total = response.data.total
            console.log(response.data)
        }
    
    }



</script>