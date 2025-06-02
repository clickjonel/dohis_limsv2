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
                    <PrimevueButton label="Create Preinspection Request" severity="info"/>
                    <PrimevueButton label="Create PTR" severity="info"/>
                    <PrimevueButton label="Create Inventory Report" severity="info"/>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                     <span class="min-w-[5%]"></span>
                    <span class="min-w-[10%]">Property #</span>
                    <span class="min-w-[45%]">Article</span>
                    <span class="min-w-[15%]">Cost</span>
                    <span class="min-w-[10%]">Acquisition Date</span>
                    <span class="min-w-[15%]">Actions</span>
                </div>
                
                <div v-if="properties.length > 0" v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
                    <span class="min-w-[5%] flex justify-center items-center text-xl">
                        <Icon v-if="!selected.includes(property.id)" icon="zondicons:add-solid" @click="pushToSelected(property.id)" class="text-blue-900 cursor-pointer"/>
                        <Icon v-if="selected.includes(property.id)" icon="ep:remove-filled" class="text-red-900 cursor-pointer" @click="removeToSelected(property.id)"/>
                    </span>
                    <span class="min-w-[10%]">{{ property.property_no }}</span>
                    <span class="min-w-[45%] text-xs">{{ property.particulars }}</span>
                    <span class="min-w-[15%] text-xs">{{ property.unit_cost }}</span>
                    <span class="min-w-[10%]">{{ property.user.issuance_date }}</span>
                    <div class="min-w-[15%] flex justify-center items-center gap-2">
                            <!-- <span @click="handleNavigation(`/property/update/${property.id}`)" title="Update Property"><Icon icon="flowbite:edit-solid" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
                            <span title="Print Sticker"><Icon icon="material-symbols:print-rounded" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/></span> -->
                            <Badge value="View" class="text-xs shadow-slate-600 shadow-md cursor-pointer hover:scale-110" severity="info"></Badge>
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
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import useApi from '../../../composables/api_calls';
    import PrimevueButton from 'primevue/button';
    import { useAuthStore } from '../../../stores/authStore';
    import Badge from 'primevue/badge';
    import { Icon } from '@iconify/vue/dist/iconify.js';

    const router = useRouter();
    const properties = ref([]);
    const { fetchRequest } = useApi();
    const store = useAuthStore();

    var pagination = ref({
        page:1,
        total:0,
        perPage:15
    })

    var searchKeyword = ref('');
    var selected = ref([]);

    onMounted(()=>{
        fetchProperties()
    })

    function handleNavigation(path){
       router.push({path:path})
    }

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
            console.log(response.data)
        }
    
    }

    function pushToSelected(id){
       selected.value.push(id)
    }

    function removeToSelected(id){
        selected.value.splice(selected.value.indexOf(id), 1);
    }

</script>