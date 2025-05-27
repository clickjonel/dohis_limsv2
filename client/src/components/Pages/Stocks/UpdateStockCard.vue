<template>

    <AuthenticatedPage pageTitle="Update Stock Card Form">
         <div class="w-full flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll">
 
             <div class="w-full flex justify-end items-center p-2">
                <PrimevueButton @click="save" label="Save Changes"/>
             </div>

            <div class="w-full flex flex-col justify-start items-start gap-2 p-2">
                <span class="w-full text-xl uppercase font-semibold">Selections</span>
                 <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="stockObject.fund_cluster" :options="selections.fund_sources" optionLabel="name" optionValue="id" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Fund Cluster</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="stockObject.req_office" :options="selections.offices" optionLabel="section_name" optionValue="section_id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Section</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="stockObject.measurement_unit" :options="selections.measurements" optionLabel="name" optionValue="id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Measurement Unit</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="stockObject.warehouse" :options="selections.warehouses" optionLabel="name" optionValue="id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Warehouse</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="stockObject.category" :options="selections.categories" optionLabel="name" optionValue="id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Category</label>
                    </FloatLabel>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-start gap-2 p-2">
                <span class="w-full text-xl uppercase font-semibold">Supplier Details</span>
                <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.supplier_name"  class="w-full"/>
                        <label>Name</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.supplier_address"  class="w-full"/>
                        <label>Address</label>
                    </FloatLabel>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-start gap-2 p-2">
                <span class="w-full text-xl uppercase font-semibold">Entity</span>
                <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.entity_name"  class="w-full"/>
                        <label>Name</label>
                    </FloatLabel>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-start gap-2 p-2">
                <span class="w-full text-xl uppercase font-semibold">Delivery</span>
                <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.iar_no"  class="w-full"/>
                        <label>IAR No</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="stockObject.procurement_mode" :options="[{code:1,name:'Charge'},{code:2,name:'Donation'}]" optionLabel="name" optionValue="code" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Acquire Mode</label>
                    </FloatLabel>
                     <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.contract_no"  class="w-full"/>
                        <label>PO/PTR No</label>
                    </FloatLabel>
                     <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.batch_no"  class="w-full"/>
                        <label>Batch/Lot No</label>
                    </FloatLabel>
                </div>
            </div>

             <div class="w-full flex flex-col justify-start items-start gap-2 p-2">
                <span class="w-full text-xl uppercase font-semibold">Stock</span>
                <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.stock_name"  class="w-full"/>
                        <label>Name</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.stock_no"  class="w-full"/>
                        <label>Number</label>
                    </FloatLabel>
                </div>
                <FloatLabel variant="on" class="w-full">
                   <Textarea v-model="stockObject.item_description" rows="5" cols="20" class="w-full font-light"/>
                    <label>Description</label>
                </FloatLabel>
            </div>

            <div class="w-full flex flex-col justify-start items-start gap-2 p-2">
                <span class="w-full text-xl uppercase font-semibold">Dosage</span>
                <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.dosage_form"  class="w-full"/>
                        <label>Form</label>
                    </FloatLabel>
                     <FloatLabel variant="on" class="w-full">
                        <InputText v-model="stockObject.dosage_strength"  class="w-full"/>
                        <label>Strength</label>
                    </FloatLabel>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-start gap-2 p-2">
                <span class="w-full text-xl uppercase font-semibold">Other</span>
                <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel variant="on" class="w-full">
                        <InputNumber v-model="stockObject.unit_cost"  class="w-full"/>
                        <label>Unit Cost</label>
                    </FloatLabel>
                   <FloatLabel variant="on" class="w-full">
                        <InputNumber v-model="stockObject.quantity"  class="w-full"/>
                        <label>Quantity</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <DatePicker v-model="stockObject.expiry_date" dateFormat="dd/mm/yy" class="w-full"/>
                        <label>Expiry Date</label>
                    </FloatLabel>
                </div>
            </div>
            
         </div>
    </AuthenticatedPage>
 
 
 
 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Select from 'primevue/select';
    import axios from '../../../axios/axios';
    import { useRouter,useRoute } from 'vue-router';
    import PrimevueButton from 'primevue/button';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import Textarea from 'primevue/textarea';
    import InputNumber from 'primevue/inputnumber';
    import DatePicker from 'primevue/datepicker';
    import useApi from '../../../composables/api_calls';

 
    const router = useRouter();
    const route = useRoute();
    const { fetchRequest, postRequest } = useApi();
     
    const selections = ref({
        fund_sources:[],
        offices:[],
        measurements:[],
        warehouses:[],
        categories:[]
    })

    var errors = ref({})

    var stockObject = ref({})

 
     onMounted(()=>{
        fetchFundSources()
        fetchOffices()
        fetchMeasurements()
        fetchWarehouses()
        fetchCategories()
        fetchStockCard()
     })

    async function fetchFundSources(){
        var response = await fetchRequest('fund_source/list',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            selections.value.fund_sources = response.data.fund_sources
        }
    
    }

    async function fetchOffices(){
        var response = await fetchRequest('office/list',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            selections.value.offices = response.data.offices
        }
    
    }

    async function fetchMeasurements(){
        var response = await fetchRequest('measurement/selection',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            selections.value.measurements = response.data.measurements
        }
    
    }

    async function fetchWarehouses(){
        var response = await fetchRequest('warehouse/list',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            selections.value.warehouses = response.data.warehouses
        }
    
    }

    async function fetchCategories(){
        var response = await fetchRequest('stock_card_category/list',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            selections.value.categories = response.data.categories
        }
    
    }

    async function fetchStockCard(){
        var response = await fetchRequest('stocks/fetch/update',{id:route.params.id})
        response.toast()
        if(response.apiResponseStatus === 200){
            stockObject.value = response.data.stock_card
            console.log(response.data.stock_card)
        }
    
    }

    async function save(){
        var response = await postRequest('stocks/update',stockObject.value);
        response.toast();
        console.log(response);
        // if(response.apiResponseStatus === 201){
        //     router.push({path:'/properties'});
        // }
        //console.log(stockObject.value);
    }
 
 </script>