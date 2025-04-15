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
            <div class="w-full flex flex-col justify-center items-center font-noto py-2">
                <span class="uppercase font-bold">Allocation List</span>
                <span class="uppercase font-bold w-1/3"><input type="text" v-model="program" placeholder="Enter Program" class="border-b outline-none px-2 w-full text-center font-medium uppercase font-lexend text-sm"></span>
                <span class="uppercase font-bold w-1/3"><input type="text" v-model="period" placeholder="Enter Period" class="border-b outline-none px-2 w-full text-center font-medium uppercase font-lexend text-sm"></span>
                <span class="uppercase font-bold w-1/3"><input type="text" v-model="control_no" placeholder="Enter Control # if applicable" class="border-b outline-none px-2 w-full text-center font-medium uppercase font-lexend text-sm"></span>
            </div>

            <div class="w-full flex justify-start items-stretch font-poppins font-medium text-xs divide-x text-center uppercase border">
                <span class="min-w-[15%] p-2">Recipient</span>
                <span class="min-w-[30%] p-2">Item/s</span>
                <span class="min-w-[10%] p-2">IAR#</span>
                <span class="min-w-[10%] p-2">Quantity</span>
                <span class="min-w-[5%] p-2">Unit</span>
                <span class="min-w-[10%] p-2">Unit Cost</span>
                <span class="min-w-[10%] p-2">Total Cost</span>
                <span class="min-w-[10%] p-2">Schedule</span>
            </div>
            <div v-for="(recipient, index) in recipients" class="w-full flex flex-col justify-start items-start divide-y border-x border-b">
                <div class="w-full flex justify-start items-stretch font-lexend font-light text-[10px] divide-x text-center">
                    <span class="min-w-[15%] p-1">{{ recipient.name }}</span>
                    <span @click="openItemModal" class="min-w-[30%] p-1 cursor-pointer hover:bg-blue-400">{{ itemDescription }}</span>
                    <span class="min-w-[10%] p-1">{{ item.delivery.iar_no }}</span>
                    <span class="min-w-[10%] p-1">{{ recipient.quantity }}</span>
                    <span class="min-w-[5%] p-1">{{ item.measurement_unit.name }}</span>
                    <span class="min-w-[10%] p-1">{{ item.unit_cost }}</span>
                    <span class="min-w-[10%] p-1">{{ item.unit_cost * recipient.quantity }}</span>
                    <span class="min-w-[10%] p-1">{{ recipient.schedule }}</span>
                </div>
            </div>

            <div class="w-full flex justify-start items-stretch text-xs pt-4">
                <Button @click="openRecipientModal" text="Add Recipient" buttonType="create"/>
            </div>

            <div class="w-full flex flex-col justify-center items-center text-xs pt-4 font-lexend gap-4">
                <span class="text-sm">- - - Basis of Allocation - - -</span>
                <input type="text" :value="item.delivery?.purpose" placeholder="Enter Porpuse of allocation" class="border-b outline-none px-2 w-2/4 text-center">
            </div>

            <div class="w-full flex justify-start items-center text-xs pt-6 font-lexend gap-4">
                <div class="w-1/2 flex flex-col justify-center items-center">
                    <span>Prepared By:</span>
                    <span class="text-base uppercase font-noto font-bold border-b px-4 mt-10">{{ item.end_user?.full_name }}</span>
                    <span class="font-light">{{ item.end_user?.position }}</span>
                </div>
                <div class="w-1/2 flex flex-col justify-center items-center">
                    <span>Recommending Approval:</span>
                    <span class="text-base uppercase font-noto font-bold border-b px-4 mt-10">{{ item.recommending_approval?.full_name }}</span>
                    <span class="font-light">Division Chief</span>
                </div>
            </div>
            <div class="w-full flex justify-center items-center text-xs mt-14 font-lexend gap-4">
                <div class="w-3/4 flex flex-col justify-center items-center">
                    <span>Approved By:</span>
                    <span class="text-base uppercase font-noto font-bold border-b px-4 mt-10">Janice Z. Bugtong, MD, MM, PHSAE, CESE</span>
                    <span class="font-light">OIC - Director III</span>
                </div>
            </div>

        </div>
        

    </div>

    <Dialog v-model:visible="recipientModal" modal header="Add Recipient" :style="{ width: '50rem',  fontFamily: 'Lexend Deca' }" @hide="closeRecipientModal">
        <div class="w-full flex justify-start items-center gap-2 border-t">
            <Input type="text" label="Recipient Name" v-model="recipient.name" :errorMessage="''"/>
            <Input type="number" label="Quantity" v-model="recipient.quantity" :errorMessage="''"/>
            <Input type="text" label="Release Schedule" v-model="recipient.schedule" :errorMessage="''"/>
        </div>
        <div class="w-full flex justify-end items-center text-xs py-2">
            <Button @click="submitRecipient" text="Submit" buttonType="create"/>
        </div>
    </Dialog>

    <Dialog v-model:visible="itemModal" modal header="Update Item Description" :style="{ width: '50rem',  fontFamily: 'Lexend Deca' }" @hide="itemModal = false">
        <div class="w-full flex justify-start items-center gap-2 border-t text-xs">
            <TextArea type="text" label="Recipient Name" v-model="itemDescription" :errorMessage="''"/>
        </div>
        <div class="w-full flex justify-end items-center text-xs py-2">
            <Button @click="itemModal = false" text="Update" buttonType="update"/>
        </div>
    </Dialog>

    <!-- <Dialog v-model:visible="itemModal" modal header="Update Item Description" :style="{ width: '50rem',  fontFamily: 'Lexend Deca' }" @hide="itemModal = false">
        <div class="w-full flex justify-start items-center gap-2 border-t text-xs">
            <Input type="text" label="Release Schedule" v-model="recipient.schedule" :errorMessage="''"/>
        </div>
        <div class="w-full flex justify-end items-center text-xs py-2">
            <Button @click="itemModal = false" text="Update" buttonType="update"/>
        </div>
    </Dialog> -->

</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import Button from '../../Button.vue';
    import { Notify,Loading, Report } from 'notiflix';
    import axios from '../../../axios/axios';
    import { useRoute,useRouter } from 'vue-router';
    import Dialog from 'primevue/dialog';
    import Input from '../../Form/Input.vue';
    import TextArea from '../../TextArea.vue';

    const router = useRouter();
    const route = useRoute();

    var recipientModal = ref(false)
    var itemModal = ref(false)

    var item = ref({})
    var recipients = ref([])

    var recipient = ref({
        name:'',
        schedule:'',
        quantity:0
    })
    var itemDescription = ref('')
    var period = ref('')
    var program = ref('')
    var control_no = ref('')


    onMounted(()=>{
        getStockCardDetails()
    })

    function getStockCardDetails(){
        Loading.dots('Generating Printable PDF...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('/delivery/item/find',{
            params:{
                id:route.params.id,
            }
        })
        .then((response)=>{
           item.value = response.data.item
           itemDescription.value = item.value.description
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
        router.push({path:'/deliveries/user'})
    }

    function printIAR(){
        window.print()
    }

    function openRecipientModal(){
        recipientModal.value = true
    }

    function closeRecipientModal(){
        recipientModal.value = false
        recipient.value.name = ''
        recipient.value.schedule = ''
        recipient.value.quantity = 0
    }

    function submitRecipient(){
        if(recipient.value.name === '' | recipient.value.quantity === '' | recipient.value.quantity === 0 | recipient.value.schedule === ''){
            Notify.failure('Please fill out all fields. Click to Close',() => {},{fontFamily:'Lexend Deca'})
        }
        else{
            var recipientObject = {
                name:recipient.value.name,
                schedule:recipient.value.schedule,
                quantity:recipient.value.quantity
            }
            recipients.value.push(recipientObject)
            closeRecipientModal()
        }
    }

    function openItemModal(){
        itemModal.value = true
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