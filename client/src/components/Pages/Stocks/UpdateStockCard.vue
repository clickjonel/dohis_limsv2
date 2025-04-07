<template>

    <AuthenticatedPage pageTitle="Update Stock Card Form">
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll">
 
             <div class="w-full flex justify-end items-center p-2">
                <Button @click="saveStockCard" buttonType="create" text="Save Stock Card"/>
             </div>

             <div class="w-full flex justify-start items-start gap-4 p-2">

                <Select v-model="stock_card.fund_source" :options="fund_sources" :invalid="errors.fund_source ? true : false" filter optionLabel="name" placeholder="Select Fund Source" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

                <Select v-model="stock_card.req_office" :options="offices" :invalid="errors.req_office ? true : false" filter optionLabel="section_name" placeholder="Select Office" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.section_name }}</div>
                        </div>
                    </template>
                </Select>

                <Select v-model="stock_card.measurement_unit" :options="measurement_units" :invalid="errors.measurement_unit ? true : false" filter optionLabel="name" placeholder="Select Measurement Unit" class="w-1/4 font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

                <Select v-model="stock_card.warehouse" :options="warehouses" :invalid="errors.warehouse ? true : false" filter optionLabel="name" placeholder="Select Warehouse" class="w-1/4 font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

                <Select v-model="stock_card.category" :options="categories" :invalid="errors.category ? true : false" filter optionLabel="name" placeholder="Select Category" class="w-1/4 font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

             </div>

            <div class="w-full flex justify-start items-start gap-4 p-2">
                <Input v-model="stock_card.supplier_name" label="Supplier Name" :errorMessage="errors.supplier_name ? errors.supplier_name[0] : '' " type="text"/>
                <Input v-model="stock_card.supplier_address" label="Supplier Address" :errorMessage="errors.supplier_address ? errors.supplier_address[0] : '' " type="text"/>
                <Input v-model="stock_card.entity_name" label="Entity Name" :errorMessage="errors.entity_name ? errors.entity_name[0] : '' " type="text"/>
                <Input v-model="stock_card.iar_no" label="IAR Number" :errorMessage="errors.iar_no ? errors.iar_no[0] : '' " type="text"/>
                <Input v-model="stock_card.procurement_mode" label="Procurement Mode(1,2)" :errorMessage="errors.procurement_mode ? errors.procurement_mode[0] : '' " type="number"/>
            </div>

            <div class="w-full flex justify-start items-start gap-4 p-2">
                <Input v-model="stock_card.contract_no" label="PO/PTR Number" :errorMessage="errors.contract_no ? errors.contract_no[0] : '' " type="text"/>
                <Input v-model="stock_card.stock_name" label="Stock Name" :errorMessage="errors.stock_name ? errors.stock_name[0] : '' " type="text"/>
                <Input v-model="stock_card.stock_no" label="Stock Number" :errorMessage="errors.stock_no ? errors.stock_no[0] : '' " type="text"/>
                <Input v-model="stock_card.batch_no" label="Batch/Lot Number" :errorMessage="errors.batch_no ? errors.batch_no[0] : '' " type="text"/>
            </div>

            <div class="w-full flex justify-start items-start gap-4 p-2">
                <TextArea v-model="stock_card.item_description" label="Description" :errorMessage="errors.item_description ? errors.item_description[0] : '' " type="text"/>
            </div>

            <div class="w-full flex justify-start items-start gap-4 p-2">
                <Input v-model="stock_card.dosage_form" label="Dosage Form" :errorMessage="errors.dosage_form ? errors.dosage_form[0] : '' " type="text"/>
                <Input v-model="stock_card.dosage_strength" label="Dosage Strength" :errorMessage="errors.dosage_strength ? errors.dosage_strength[0] : '' " type="text"/>
                <Input v-model="stock_card.unit_cost" label="Unit Cost" :errorMessage="errors.unit_cost ? errors.unit_cost[0] : '' " type="number"/>
                <Input v-model="stock_card.exp_date" label="Expiry Date" :errorMessage="errors.exp_date ? errors.exp_date[0] : '' " type="date"/>
                <Input v-model="stock_card.quantity" label="Quantity" :errorMessage="errors.quantity ? errors.quantity[0] : '' " type="number"/>
            </div>
 
         </div>
    </AuthenticatedPage>
 
 
 
 </template>
 
 <script setup> 
     import { ref,onMounted } from 'vue';
     import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
     import Select from 'primevue/select';
     import axios from '../../../axios/axios';
     import { Notify,Loading, Report } from 'notiflix';
     import Input from '../../Form/Input.vue';
     import Button from '../../Button.vue';
     import Dialog from 'primevue/dialog';
     import TextArea from '../../TextArea.vue';
     import { useRouter,useRoute } from 'vue-router';
     import { Icon } from '@iconify/vue/dist/iconify.js';
 
    const router = useRouter();
    const route = useRoute();
     
    const fund_sources = ref([])
    const offices = ref([])
    const measurement_units = ref([])
    const warehouses = ref([])
    const categories = ref([])

    var errors = ref({})

    var stock_card = ref({
        contract_no:'',
        iar_no:'',
        entity_name:'',
        supplier_name:'',
        supplier_address:'',
        procurement_mode:0,
        req_office:0,
        fund_source:0,

        stock_no:'',
        stock_name:'',
        item_description:'',
        dosage_form:'',
        dosage_strength:'',
        batch_no:'',
        measurement_unit:'',
        unit_cost:0,
        warehouse:0,
        exp_date:'',
        category:0,
        quantity:0
    })

 
     onMounted(()=>{
        fetchFundSources()
        fetchOffices()
        fetchMeasurements()
        fetchWarehouses()
        fetchCategories()
        fetchStockCard()
     })
 
    function fetchFundSources(){
        Loading.dots('Loading Data, Please Wait...', {
            clickToClose: false
        });

        axios.get('fund_source/list',{
            params:{

            }
        })
        .then((response)=>{
            fund_sources.value = response.data.fund_sources
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
        })
        .finally(()=>{
            Loading.remove()
        })
    }
    
    function fetchOffices(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false
        });

        axios.get('office/list',{
            params:{

            }
        })
        .then((response)=>{
            offices.value = response.data.offices
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
            Loading.remove()
        })

    }

    function fetchMeasurements(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false
        });
        axios.get('measurement/list',{
            params:{

            }
        })
        .then((response)=>{
            measurement_units.value = response.data.measurements
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
          Loading.remove()
        })

    }

    function fetchWarehouses(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false
        });
        axios.get('warehouse/list',{
            params:{

            }
        })
        .then((response)=>{
            warehouses.value = response.data.warehouses
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
          Loading.remove()
        })

    }

    function fetchCategories(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false
        });
        axios.get('stock_card_category/list',{
            params:{

            }
        })
        .then((response)=>{
            categories.value = response.data.categories
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
          Loading.remove()
        })

    }

    function fetchStockCard(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false
        });
        axios.get('stock_card/find',{
            params:{
                id:route.params.id
            }
        })
        .then((response)=>{
            stock_card.value = response.data.stock_card
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
          Loading.remove()
        })
    }

    function saveStockCard(){
        axios.post('stock_card/update',{
            stock_card_id:route.params.id,
            contract_no:stock_card.value.contract_no,
            iar_no:stock_card.value.iar_no,
            entity_name:stock_card.value.entity_name,
            supplier_name:stock_card.value.supplier_name,
            supplier_address:stock_card.value.supplier_address,
            procurement_mode:stock_card.value.procurement_mode,
            req_office:stock_card.value.req_office?.section_id,
            fund_source:stock_card.value.fund_source?.id,

            stock_no:stock_card.value.stock_no,
            stock_name:stock_card.value.stock_name,
            item_description:stock_card.value.item_description,
            dosage_form:stock_card.value.dosage_form,
            dosage_strength:stock_card.value.dosage_strength,
            batch_no:stock_card.value.batch_no,
            measurement_unit:stock_card.value.measurement_unit?.id,
            unit_cost:stock_card.value.unit_cost,
            warehouse:stock_card.value.warehouse?.id,
            exp_date:stock_card.value.exp_date,
            category:stock_card.value.category?.id,
            quantity:stock_card.value.quantity
        })
        .then((response)=>{
            if(response.data.status){
                Report.success(
                    'Success',
                    'Stock Card has been updated',
                    'Okay',
                    () => {
                        router.push({path:'/stocks'})
                    },
                    {
                        fontFamily:'Lexend Deca'
                    }
                );
            } 
        })
        .catch((error)=>{
            console.log(error.response)
            errors.value = error.response.data.errors ?? null
            Report.failure(
                'Validation Error',
                `Please Fill Up Correct Details and Try Again. Errors:${error.response.data.errors}`,
                'Okay',
                () => {

                },
                {
                    fontFamily:'Lexend Deca'
                },
            );
        })
        .finally(()=>{
            Loading.remove()
        })
    }
 
 </script>