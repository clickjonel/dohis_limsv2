<template>
    <AuthenticatedPage pageTitle="Stock Cards">
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <FloatLabel variant="on" class="w-full font-poppins">
                        <InputText v-model="searchKeyword"  class="w-full" @change="fetchStocks"/>
                        <label>Search Keyword | Stock No.</label>
                    </FloatLabel>
                </div>
                

                <div class="flex justify-start items-center gap-2 p-2">
                    <PrimevueButton label="Add Stock Card" severity="info" class="shadow-md shadow-slate-600"/>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[10%]">Stock #</span>
                    <span class="min-w-[30%]">Stock Name</span>
                    <span class="min-w-[25%]">Office</span>
                    <span class="min-w-[15%]">Quantity</span>
                    <span class="min-w-[10%]">Remaining</span>
                    <span class="min-w-[10%]"></span>
                </div>
                
                <div v-for="stock_card in stocks" v-bind:key="stock_card.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light bg-white/50 hover:bg-emerald-400 text-sm">
                    <span class="min-w-[10%]">{{ stock_card.stock_no }}</span>
                    <span class="min-w-[30%]">{{ stock_card.stock_name }}</span>
                    <span class="min-w-[25%]">{{ stock_card.req_office }}</span>
                    <span class="min-w-[15%]">{{ stock_card.quantity }}</span>
                    <span class="min-w-[10%]">{{ stock_card.balance }}</span>
                    <div class="min-w-[10%] flex justify-start items-center gap-2">
                        <span @click="handleNavigation(`/stock_card/update/${stock_card.id}`)" title="Update Delivery">
                            <Icon icon="material-symbols:edit-square-outline" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/>
                        </span>
                        <span @click="handleNavigation(`/stock_card/generate/${stock_card.id}`)" title="Print IAR">
                            <Icon icon="material-symbols:print-outline" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/>
                        </span>
                        <span v-if="stock_card.balance > 0" @click="openIssueStockModal(stock_card)" title="Issue Stock">
                            <Icon icon="hugeicons:give-pill" class="text-xl text-purple-800 cursor-pointer hover:scale-125"/>
                        </span>
                    </div>
                </div>
            </div>

        </div>

         <Pagination v-model="pagination.page" :total="pagination.total" :perPage="pagination.perPage" @fetchPage="fetchStocks"/>

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
    const stocks = ref([]);
    const { fetchRequest } = useApi();

    var pagination = ref({
        page:1,
        total:0,
        perPage:15
    })

    var searchKeyword = ref('');

    onMounted(()=>{
        fetchStocks()
    })

    function handleNavigation(path){
       router.push({path:path})
    }

    async function fetchStocks(){
        var response = await fetchRequest('stocks/list',{
            page:pagination.value.page,
            keyword:searchKeyword.value,
            per_page:pagination.value.perPage
        })
        response.toast()
        if(response.data.stocks){
            stocks.value = response.data.stocks
            pagination.value.total = response.data.total
        }
    
    }



</script>