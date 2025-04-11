<template>

    <div class="w-full flex flex-col justify-start items-start p-2 gap-4">

        <!-- <div class="w-full flex justify-end items-center">
            <span class="px-2 py-1 text-xs font-lexend border">Annex 5</span>
        </div> -->

        <div id="header" class="w-full flex justify-between items-center py-2">
            <Button @click="goBack" text="Back to Deliveries" buttonType="update" icon="pajamas:go-back" class="header-button"/>
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
            <Button @click="printIAR" text="Print Allocation List" buttonType="info" icon="material-symbols:print-rounded" class="header-button"/>
        </div>

        <div class="w-full flex flex-col justify-start items-center">
            <div class="flex flex-col justify-center items-center font-noto">
                <span class="uppercase font-bold">Allocation List</span>
                <span class="uppercase font-bold">{{ allocation_list.program }}</span>
                <span class="uppercase font-bold">Period: {{ allocation_list.period }}</span>
                <span class="uppercase font-bold">{{ allocation_list.control_no }}</span>
            </div>

            <div class="w-full flex justify-start items-stretch font-poppins font-medium text-xs divide-x text-center uppercase border">
                <span class="min-w-[20%] p-2">Recipient</span>
                <span class="min-w-[20%] p-2">Item/s</span>
                <span class="min-w-[10%] p-2">IAR#</span>
                <span class="min-w-[10%] p-2">Quantity</span>
                <span class="min-w-[10%] p-2">Unit</span>
                <span class="min-w-[10%] p-2">Unit Cost</span>
                <span class="min-w-[10%] p-2">Total Cost</span>
                <span class="min-w-[10%] p-2">Schedule</span>
            </div>
            <div v-for="(recipient, index) in allocation_list.recipients" class="w-full flex flex-col justify-start items-start divide-y border-x border-b">
                <div class="w-full flex justify-start items-stretch font-lexend font-light text-xs divide-x text-center">
                    <span class="min-w-[20%] p-1">{{ recipient.name }}</span>
                    <span @click="showRecipientItemsModal(index)" class="min-w-[20%] p-1 cursor-pointer hover:bg-blue-400" title="Click to add item"></span>
                    <span class="min-w-[10%] p-1"></span>
                    <span class="min-w-[10%] p-1"></span>
                    <span class="min-w-[10%] p-1"></span>
                    <span class="min-w-[10%] p-1"></span>
                    <span class="min-w-[10%] p-1"></span>
                    <span class="min-w-[10%] p-1"></span>
                </div>
            </div>
        </div>
        

    </div>

    <Dialog v-model:visible="showDetailsCollectionModal" modal header="Input Allocation Details" :style="{ width: '80rem',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex justify-start items-center text-left uppercase p-2 bg-gray-300">
            <Input v-model="allocation_list_modal_details.program" type="text" label="Program" :errorMessage="''"/>
            <Input v-model="allocation_list_modal_details.period" type="text" label="Period" :errorMessage="''"/>
            <Input v-model="allocation_list_modal_details.control_no" type="text" label="Control Number" :errorMessage="''"/>
        </div>
        <div class="w-full flex justify-start items-center text-left uppercase p-2 bg-gray-300">
            <Input v-model="allocation_list_modal_details.recipients" type="text" label="Recipients ( Separated by Comma )" :errorMessage="''"/>
        </div>
        <div class="w-full flex justify-start items-center text-left uppercase py-6 px-2 bg-gray-300">
            <Button @click="submitAllocationDetails" text="Submit" buttonType="create" icon="material-symbols:search" class="translate-y-2.5"/>
        </div>
    </Dialog>

    <Dialog v-model:visible="recipientItemsModal" modal header="Recipient Items" :style="{ width: '80rem',  fontFamily: 'Lexend Deca' }">
        <!-- <div class="w-full flex justify-start items-center text-left uppercase p-2 bg-gray-300">
            <Input v-model="allocation_list_modal_details.program" type="text" label="Program" :errorMessage="''"/>
            <Input v-model="allocation_list_modal_details.period" type="text" label="Period" :errorMessage="''"/>
            <Input v-model="allocation_list_modal_details.control_no" type="text" label="Control Number" :errorMessage="''"/>
        </div>
        <div class="w-full flex justify-start items-center text-left uppercase p-2 bg-gray-300">
            <Input v-model="allocation_list_modal_details.recipients" type="text" label="Recipients ( Separated by Comma )" :errorMessage="''"/>
        </div>
        <div class="w-full flex justify-start items-center text-left uppercase py-6 px-2 bg-gray-300">
            <Button @click="submitAllocationDetails" text="Submit" buttonType="create" icon="material-symbols:search" class="translate-y-2.5"/>
        </div> -->
    </Dialog>

</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import Button from '../../Button.vue';
    import { Notify,Loading, Report } from 'notiflix';
    import axios from '../../../axios/axios';
    import { useRoute,useRouter } from 'vue-router';
    import Dialog from 'primevue/dialog';
    import Input from '../../Form/Input.vue';

   const router = useRouter();

    var showDetailsCollectionModal = ref(true)
    var recipientItemsModal = ref(false)

    var allocation_list = ref({
        program: '',
        period: '',
        control_no: '',
        recipients: []
    })

    var allocation_list_modal_details = ref({
        program: '',
        period: '',
        control_no: '',
        recipients: ''
    })

    onMounted(()=>{
        //getStockCardDetails()
    })

    // function getStockCardDetails(){
    //     Loading.dots('Generating Printable PDF...',{
    //         clickToClose:false,
    //         fontFamily:'Lexend Deca'
    //     });

    //     axios.get('/stock_card/generate/stock_card',{
    //         params:{
    //             stock_card_id:route.params.id,
    //         }
    //     })
    //     .then((response)=>{
    //         stock_card.value = response.data.stock_card
    //         console.log(response.data)
    //     })
    //     .catch((error)=>{
    //         Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
    //         console.log(error)
    //     })
    //     .finally(()=>{
    //         Loading.remove()
    //     })
    // }

    function goBack(){
        router.push({path:'/deliveries/user'})
    }

    function printIAR(){
        window.print()
    }

    function submitAllocationDetails(){
        if(allocation_list_modal_details.value.program == '' || allocation_list_modal_details.value.period == '' || allocation_list_modal_details.value.recipients == ''){
            Notify.failure('Please fill up Neccessary fields.',() => {},{fontFamily:'Lexend Deca'})
        }
        else{
            allocation_list.value.program = allocation_list_modal_details.value.program
            allocation_list.value.period = allocation_list_modal_details.value.period
            allocation_list.value.control_no = allocation_list_modal_details.value.control_no
            allocation_list.value.recipients = allocation_list_modal_details.value.recipients.split(',').map(item => ({ name: item.trim() }))

            showDetailsCollectionModal.value = false

            Notify.success('Recipients have been set. Click to close',() => {},{fontFamily:'Lexend Deca'})
        }
    }

    function showRecipientItemsModal(index){
        recipientItemsModal.value = true
        console.log(allocation_list.value.recipients[index])
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