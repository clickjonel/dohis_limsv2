<template>

    <AuthenticatedPage>
        <div class="w-full flex flex-col justify-start items-start gap-4 p-4 font-poppins">
            <span class="w-full text-xl font-semibold uppercase">Transaction Details</span>
            <div class="w-full flex justify-start items-start gap-4">
                <FloatLabel variant="on" class="w-full">
                    <DatePicker v-model="stockObject.transaction_date" class="w-full"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Transaction Date</label>
                </FloatLabel>
                <FloatLabel variant="on"  class="w-full">
                    <InputNumber v-model="stockObject.issued" class="w-full font-light"  :min="0" :max="latest_transaction.balance"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Quantity To Issue (Available: {{ latest_transaction.balance }})</label>
                </FloatLabel>
                <FloatLabel variant="on"  class="w-full">
                    <InputText v-model="stockObject.recepient" class="w-full"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Recipient</label>
                </FloatLabel>
            </div>
            <div class="w-full flex justify-start items-start gap-4">
                <FloatLabel variant="on"  class="w-full">
                    <InputText v-model="stockObject.ptr_no" class="w-full"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">PTR Number</label>
                </FloatLabel>
                <FloatLabel variant="on"  class="w-full">
                    <InputText v-model="stockObject.remarks" class="w-full"/>
                    <label class="font-poppins" style="font-weight: 300; font-size: small;">Remarks</label>
                </FloatLabel>
            </div>
            <PrimevueButton @click="save" label="Create Issue"/>
        </div>
    </AuthenticatedPage>
 
 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import { useRouter,useRoute } from 'vue-router';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import DatePicker from 'primevue/datepicker';
    import PrimevueButton from 'primevue/button';
    import useApi from '../../../composables/api_calls';
    import InputNumber from 'primevue/inputnumber';
    import Textarea from 'primevue/textarea';

 
     const router = useRouter();
     const route = useRoute();
     const { fetchRequest,postRequest } = useApi();

     var stockObject = ref({
        id:route.params.id,
     })
     var stockCard = ref({})
     var latest_transaction = ref({})

     onMounted(()=>{
       fetchStockCard()
     })

    async function fetchStockCard(){
        var response = await fetchRequest('stocks/page/issue',{id:route.params.id})
        response.toast()
        if(response.apiResponseStatus === 200){
            stockCard.value = response.data.stock_card
            latest_transaction.value = response.data.latest_transaction
        }
    
    }

    async function save(){
        var response = await postRequest('stocks/issue',stockObject.value);
        response.toast();
        console.log(response);
        if(response.apiResponseStatus === 200){
            // router.push({path:'/stocks'});
            stockObject.value = {
                id:route.params.id,
                transaction_date: '',
                issued: 0,
                recepient: '',
                ptr_no: '',
                remarks: ''
            };
            fetchStockCard();
        }
    }
 
 </script>
 