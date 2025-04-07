<template>
     <AuthenticatedPage pageTitle="Stock Cards">
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <Input type="text" label="Search Keyword" :errorMessage="''" v-model="searchKeyword"/>
                    <Button @click="fetchStocks" text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
                </div>

                <div class="flex justify-start items-center gap-2 p-2">
                    <Button @click="handleNavigation('/stock_card/add')" text="Add Stock Card" buttonType="info" icon="material-symbols:add-rounded" class="translate-y-2.5"/>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0">
                    <span class="min-w-[10%]">Stock #</span>
                    <span class="min-w-[25%]">Stock Name</span>
                    <span class="min-w-[20%]">End User</span>
                    <span class="min-w-[15%]">Transactions</span>
                    <span class="min-w-[10%]">Warehouse</span>
                    <span class="min-w-[20%]">Actions</span>
                </div>
                
                <div v-for="stock_card in stockCards" v-bind:key="stock_card.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
                    <span class="min-w-[10%]">{{ stock_card.stock_no }}</span>
                    <span class="min-w-[25%] text-xs">{{ stock_card.stock_name }}</span>
                    <span class="min-w-[20%] text-xs">{{ stock_card.req_office }}</span>
                    <div class="min-w-[15%] flex flex-col justify-center items-center gap-2">
                        <span @click="showStockStransactions(stock_card)" class="text-xs rounded-full px-1 bg-blue-900 text-white cursor-pointer">Transactions</span>
                    </div>
                    <span class="min-w-[10%]">{{ stock_card.warehouse }}</span>
                    <div class="min-w-[20%] flex justify-center items-center gap-2">
                       <span @click="handleNavigation(`/stock_card/update/${stock_card.id}`)" title="Update Delivery"><Icon icon="flowbite:edit-solid" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
                        <span @click="handleNavigation(`/stock_card/generate/${stock_card.id}`)" title="Print IAR"><Icon icon="material-symbols:print-rounded" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/></span>
                        <span v-if="stock_card.transactions.length > 0 && stock_card.remaining > 0" @click="openIssueStockModal(stock_card)" title="Issue Stock"><Icon icon="hugeicons:give-pill" class="text-xl text-purple-800 cursor-pointer hover:scale-125"/></span>
                    </div>
                </div>
            </div>

        </div>

        <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchStocks"/>

    </AuthenticatedPage>

    <Dialog v-model:visible="showTransactionsModal" modal header="Stock Card Transaction/s" :style="{ width: '80rem',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex justify-start items-center border-y-2  text-left uppercase p-2 bg-amber-200 sticky top-0">
            <span class="min-w-[10%]">Date</span>
            <span class="min-w-[10%]">Received</span>
            <span class="min-w-[10%]">Issued</span>
            <span class="min-w-[10%]">Balance</span>
            <span class="min-w-[10%]">Cost</span>
            <span class="min-w-[25%]">Recipient</span>
            <span class="min-w-[25%]">Remarks</span>
        </div>
        <div v-for="transaction in currentTransaction.transactions" class="w-full flex flex-col justify-start items-center gap-2 text-sm">
            <div class="w-full flex justify-between items-start border-b p-2 hover:bg-emerald-500 font-light text-left">
                <span class="min-w-[10%]">{{transaction.transaction_date}}</span>
                <span class="min-w-[10%]">{{transaction.received}}</span>
                <span class="min-w-[10%]">{{transaction.issued}}</span>
                <span class="min-w-[10%]">{{transaction.balance}}</span>
                <span class="min-w-[10%]">{{ transaction.total_cost }}</span>
                <span class="min-w-[25%]">{{transaction.recepient}}</span>
                <span class="min-w-[25%]">{{transaction.remarks}}</span>
            </div>
        </div>
    </Dialog>

    <Dialog v-model:visible="issueStockModal" modal header="Issue Stocks" :style="{ width: '80rem',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex justify-start items-center border-y-2  text-left uppercase p-2">
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="issueTransaction.transaction_date" label="Date" :errorMessage="errors.transaction_date ? errors.transaction_date[0] : '' " type="date"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="issueTransaction.issued" label="Issued Quantity" :errorMessage="errors.issued ? errors.issued[0] : '' " type="number"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="issueTransaction.ptr_no" label="PTR Number" :errorMessage="errors.ptr_no ? errors.ptr_no[0] : '' " type="text"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="issueTransaction.recepient" label="Recepient" :errorMessage="errors.recepient ? errors.recepient[0] : '' " type="text"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="issueTransaction.remarks" label="Remarks" :errorMessage="errors.remarks ? errors.remarks[0] : '' " type="text"/>
            </div>
        </div>
        <div class="w-full flex justify-start items-center  text-left uppercase p-2">
            <Button @click="saveIssueTransaction" buttonType="create" text="Save Transaction"/>
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
    import ProgressBar from 'primevue/progressbar';

    const router = useRouter();
    const stockCards = ref([]);

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('')

    var showTransactionsModal = ref(false)
    var currentTransaction = ref({})

    var selectedStock = ref({})

    var issueTransaction = ref({
        stock_card_id:0,
        transaction_date:'',
        issued:0,
        balance:0,
        total:0,
        ptr_no:'',
        remarks:''
    })

    var issueStockModal = ref(false)

    var errors = ref({})

    onMounted(() => {
        fetchStocks();
    });


    function fetchStocks(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('stock_card/list',{
            params:{
                page:pagination.value.page,
                keyword:searchKeyword.value
            }
        })
        .then((response)=>{
            stockCards.value = response.data.stock_cards
            pagination.value.total = response.data.total
            console.log(response.data)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function showStockStransactions(stock_card){
        currentTransaction.value = stock_card
        showTransactionsModal.value = true
    }

    function handleNavigation(path){
       router.push({path:path})
    }

    function openIssueStockModal(stock){
        issueStockModal.value = true
        issueTransaction.value.stock_card_id = stock.id
        console.log(stock.id)
    }

    function saveIssueTransaction(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.post('stock_card/transaction/issue',{
            stock_card_id:issueTransaction.value.stock_card_id,
            transaction_date:issueTransaction.value.transaction_date,
            issued:issueTransaction.value.issued,
            ptr_no:issueTransaction.value.ptr_no,
            remarks:issueTransaction.value.remarks,
            recepient:issueTransaction.value.recepient         
        })
        .then((response)=>{
            Notify.success('Transaction Created Successfuly')
        })
        .catch((error)=>{
            errors.value = error.response.data.errors
        })
        .finally(()=>{
            Loading.remove()
        })
    }


</script>