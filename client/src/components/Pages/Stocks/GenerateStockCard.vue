<template>

    <div class="w-full flex flex-col justify-start items-start p-2">

        <!-- <div class="w-full flex justify-end items-center">
            <span class="px-2 py-1 text-xs font-lexend border">Annex 5</span>
        </div> -->

        <div id="header" class="w-full flex justify-between items-center py-2">
            <Button @click="goBack" text="Back to Stocks" buttonType="update" icon="pajamas:go-back" class="header-button"/>
            <div class="flex justify-center items-center gap-2">
                <div class="flex w-20 h-20">
                    <img src="../../../assets/doh_logo.png" class="size-full" alt="">
                </div>
                <div class="flex flex-col justify-start items-start font-noto gap-0 text-xs uppercase">
                    <span class="font-bold">Republic of the Philippines</span>
                    <span class="font-bold">Department of Health</span>
                    <span class="font-bold">Center for Health Development</span>
                    <span>Cordillera Administrative Region</span>
                    <span>Baguio City</span>
                </div>
            </div>
            <Button @click="printIAR" text="Print Stock Card" buttonType="update" icon="material-symbols:print-rounded" class="header-button"/>
        </div>

        <div class="w-full flex flex-col justify-start items-stretch divide-y font-lexend text-[10px] outline">
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[60%] pl-1">Stock Card</span>
                <span class="min-w-[20%] pl-1">Stock Keeping Unit(SKU Code)</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.stock_no }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[20%] pl-1">PO/PTR/Contract Number</span>
                <span class="min-w-[40%] pl-1">{{ stock_card.contract_no }}</span>
                <span class="min-w-[20%] pl-1">Entity Name</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.entity_name }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[20%] pl-1">Supplier</span>
                <span class="min-w-[40%] pl-1">{{ stock_card.supplier_name }}</span>
                <span class="min-w-[20%] pl-1">Fund Source</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.fund_cluster }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[20%] pl-1">Item Description</span>
                <span class="min-w-[40%] pl-1">{{ stock_card.item_description }}</span>
                <span class="min-w-[20%] pl-1">Unit Cost</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.unit_cost }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[20%] pl-1">Dosage Form</span>
                <span class="min-w-[40%] pl-1">{{ stock_card.dosage_form }}</span>
                <span class="min-w-[20%] pl-1">IAR Number</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.iar_no }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[20%] pl-1">Dosage Strength</span>
                <span class="min-w-[40%] pl-1">{{ stock_card.dosage_strength }}</span>
                <span class="min-w-[20%] pl-1">Mode of Procurement</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.procurement_mode }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[20%] pl-1">Unit of</span>
                <span class="min-w-[40%] pl-1">{{ stock_card.measurement_unit }}</span>
                <span class="min-w-[20%] pl-1">End User</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.req_office }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[20%] pl-1">Batch Number</span>
                <span class="min-w-[40%] pl-1">{{ stock_card.batch_no }}</span>
                <span class="min-w-[20%] pl-1">Expiry Date</span>
                <span class="min-w-[20%] pl-1">{{ stock_card.expiry_date }}</span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x bg-gray-400">
                <span class="min-w-[20%] py-2"></span>
            </div>
            <div class="min-w-full flex justify-start items-stretch divide-x">
                <span class="min-w-[10%] pl-1">Date</span>
                <div class="min-w-[60%] flex flex-col justify-start items-stretch divide-y">
                    <div class="w-full flex justify-start items-stretch">
                        <span class="w-full text-center font-medium uppercase">Quantity</span>
                    </div>
                    <div class="w-full flex justify-start items-stretch divide-x text-center">
                        <span class="min-w-[25%]">Received</span>
                        <span class="min-w-[25%]">Issued</span>
                        <span class="min-w-[25%]">Balance</span>
                        <span class="min-w-[25%]">Total Cost</span>
                    </div>
                </div>
                <span class="min-w-[15%] pl-1">DR/SI/RIS/PTR/BL No.</span>
                <span class="min-w-[15%] pl-1">Remarks</span>
            </div>
            <div class="w-full flex flex-col justify-start items-start divide-y">
                <div v-for="transaction in stock_card.transactions" class="min-w-full flex justify-start items-stretch divide-x text-center font-light">
                    <span class="min-w-[10%]">{{ transaction.transaction_date }}</span>
                    <span class="min-w-[15%]">{{ transaction.received }}</span>
                    <span class="min-w-[15%]">{{ transaction.issued }}</span>
                    <span class="min-w-[15%]">{{ transaction.balance }}</span>
                    <span class="min-w-[15%]">{{ transaction.total_cost }}</span>
                    <span class="min-w-[15%]">{{ transaction.iar_no ?? transaction.ptr_no }}</span>
                    <span class="min-w-[15%]">{{ transaction.remarks }}</span>
                </div>
            </div>

        </div>

    </div>

</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import Button from '../../Button.vue';
    import { Notify,Loading, Report } from 'notiflix';
    import axios from '../../../axios/axios';
    import { useRoute,useRouter } from 'vue-router';

    const delivery = ref([]);
    const route = useRoute()
    const router = useRouter()
    const stock_card = ref({})

    var showHeader = ref(true)

    onMounted(()=>{
        getStockCardDetails()
    })

    function getStockCardDetails(){
        Loading.dots('Generating Printable PDF...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('/stock_card/generate/stock_card',{
            params:{
                stock_card_id:route.params.id,
            }
        })
        .then((response)=>{
            stock_card.value = response.data.stock_card
            console.log(response.data)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
            console.log(error)
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function goBack(){
        router.push({path:'/stocks'})
    }

    function printIAR(){
        window.print()
    }

</script>


<style scoped>
    @media print{
        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .header-button {
            display: none;
        }
        #header {
            justify-content: center;
        }
    }
</style>