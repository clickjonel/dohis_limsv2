<template>
    <AuthenticatedPage pageTitle="Deliveries">
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <Input v-model="searchKeyword" type="text" label="Search Keyword" :errorMessage="''"/>
                    <Button @click="fetchDeliveries" text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
                </div>

                <div class="flex justify-start items-center gap-2 p-2">
                    <Button @click="showNote" text="Note" buttonType="info" class="translate-y-2.5"/>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0">
                    <span class="min-w-[10%]">IAR Number</span>
                    <span class="min-w-[25%]">Requisitioning Office-End User</span>
                    <span class="min-w-[20%]">Source</span>
                    <span class="min-w-[15%]">Delivery</span>
                    <span class="min-w-[10%]">Payment Term</span>
                    <span class="min-w-[20%]">Actions</span>
                </div>
                
                <div v-if="deliveries.length > 0" v-for="delivery in deliveries" v-bind:key="delivery.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
                    <span class="min-w-[10%]">{{ delivery.iar_no }}</span>
                    <span class="min-w-[25%] text-xs">{{ `${delivery.req_office} - ${delivery.end_user}` }}</span>
                    <span class="min-w-[20%] text-xs">{{ delivery.source_name }}</span>
                    <div class="min-w-[15%] flex justify-center items-center gap-2">
                        <span v-if="delivery.invoices.length > 0" @click="showDeliveryInvoices(delivery.invoices)" class="text-xs rounded-full px-1 bg-blue-900 text-white cursor-pointer">Invoices</span>
                        <span v-if="delivery.receipts.length > 0" @click="showDeliveryReceipts(delivery.receipts)" class="text-xs rounded-full px-1 bg-blue-900 text-white cursor-pointer">Receipts</span>
                        <span v-if="delivery.items.length > 0" @click="showDeliveryItems(delivery.items)" class="text-xs rounded-full px-1 bg-blue-900 text-white cursor-pointer">Items</span>
                    </div>
                    <span class="min-w-[10%]">{{ delivery.payment_term }}</span>
                    <div class="min-w-[20%] flex justify-center items-center gap-2">
                       <span title="Update Delivery"><Icon @click="handleNavigation(`/delivery/update/${delivery.id}`)" icon="flowbite:edit-solid" class="text-xl text-blue-800 cursor-pointer hover:scale-125"/></span>
                        <span title="Print IAR"><Icon @click="handleNavigation(`/delivery/iar/${delivery.id}`)" icon="material-symbols:print-rounded" class="text-xl text-emerald-800 cursor-pointer hover:scale-125"/></span>
                        <!-- <span title="Add Item"><Icon icon="mdi:format-list-group-add" class="text-xl text-slate-800 cursor-pointer hover:scale-125"/></span>
                        <span title="Add Invoice"><Icon icon="mdi:invoice-add" class="text-xl text-slate-800 cursor-pointer hover:scale-125"/></span>
                        <span title="Add Receipt"><Icon icon="fluent:receipt-add-20-filled" class="text-xl text-slate-800 cursor-pointer hover:scale-125"/></span> -->
                    </div>
                </div>

                <div v-if="deliveries.length===0" class="w-full h-[600px] flex justify-center items-center">
                    <span class="font-medium font-lexend animate-bounce">No Deliveries Fetched</span>
                </div>
            </div>

        </div>

        <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchDeliveries"/>

    </AuthenticatedPage>

    <Dialog v-model:visible="showInvoiceModal" modal header="Delivery Invoice/s" :style="{ width: '30rem',  fontFamily: 'Lexend Deca' }">
        <hr>
        <div v-for="invoice in currentInvoices" class="w-full flex flex-col justify-start items-center gap-2 p-2">
            <div class="w-full flex justify-between items-center border-y p-2 hover:bg-emerald-500">
                <span>{{ invoice.invoice_no }}</span>
                <span>{{ invoice.invoice_date }}</span>
            </div>
        </div>
    </Dialog>

    <Dialog v-model:visible="showReceiptModal" modal header="Delivery Receipt/s" :style="{ width: '50rem',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex justify-start items-center border-y-2  text-left uppercase py-2">
            <span class="min-w-[20%]">DR#</span>
            <span class="min-w-[20%]">DR Date</span>
            <span class="min-w-[20%]">Date</span>
            <span class="min-w-[40%]">Place</span>
        </div>
        <div v-for="receipt in currentReceipts" class="w-full flex flex-col justify-start items-center gap-2 text-sm">
            <div class="w-full flex justify-between items-center border-b py-2 hover:bg-emerald-500 font-light text-left">
                <span class="min-w-[20%]">{{ receipt.dr_no }}</span>
                <span class="min-w-[20%]">{{ receipt.dr_date }}</span>
                <span class="min-w-[20%]">{{ receipt.delivery_date }}</span>
                <span class="min-w-[40%]">{{ receipt.delivery_place }}</span>
            </div>
        </div>
    </Dialog>

    <Dialog v-model:visible="showItemModal" modal header="Delivery Item/s" :style="{ width: '80rem',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex justify-start items-center border-y-2  text-left uppercase py-2 bg-amber-200">
            <span class="min-w-[50%]">Description</span>
            <span class="min-w-[15%]">Unit Cost</span>
            <span class="min-w-[15%]">Quantity</span>
            <span class="min-w-[20%]">Measurement Unit</span>
        </div>
        <div v-for="item in currentitems" class="w-full flex flex-col justify-start items-center gap-2 text-sm">
            <div class="w-full flex justify-between items-start border-b py-2 hover:bg-emerald-500 font-light text-left">
                <span class="min-w-[50%] px-2" v-html="item.description.replace(/\n/g, '<br>')"></span>
                <span class="min-w-[15%]">{{ item.unit_cost }}</span>
                <span class="min-w-[15%]">{{ item.quantity }}</span>
                <span class="min-w-[20%]">{{ item.measurement_unit.name }}</span>
            </div>
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

    const router = useRouter();
    const deliveries = ref([]);

    var showInvoiceModal = ref(false)
    var showReceiptModal = ref(false)
    var showItemModal = ref(false)

    var currentInvoices = ref([])
    var currentReceipts = ref([])
    var currentitems = ref([])

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

    onMounted(()=>{
        fetchDeliveries()
    })

    function handleNavigation(path){
       router.push({path:path})
    }

    function fetchDeliveries(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('delivery/user',{
            params:{
                page:pagination.value.page,
                keyword:searchKeyword.value
            }
        })
        .then((response)=>{
            Loading.remove()
            deliveries.value = response.data.deliveries
            pagination.value.total = response.data.total
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function showDeliveryInvoices(invoices){
        showInvoiceModal.value = true
        currentInvoices.value = invoices
    }

    function showDeliveryReceipts(receipts){
        showReceiptModal.value = true
        currentReceipts.value = receipts
    }

    function showDeliveryItems(items){
        showItemModal.value = true
        currentitems.value = items
    }

    function showNote(){
        Report.info(
            'Note!',
            'Please Create allocation list as soon as possible if neccessary, click on items of the delivery then click the item you want to make an allocation list and automatically it will redirect you to the allocation page.',
            'Okay',
            () => {
                
            },
            {
                fontFamily:'Lexend Deca'
            },
        );
    }


</script>