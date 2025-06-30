<template>

    <AuthenticatedPage pageTitle="Update Delivery Form">
         <Tabs value="1" class="w-full font-poppins p-4">
            <TabList>
                <Tab value="1">Delivery Details</Tab>
                <Tab value="2">Delivery Invoice/s</Tab>
                <Tab value="3">Delivery Receipt/s</Tab>
                <Tab value="4">Delivery Item/s</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="1">
                    <div v-if="deliveryObject.delivery" class="w-full flex flex-col justify-start items-start gap-6 p-2 font-poppins">

                        <div class="w-full flex justify-end items-center p-2">
                            <PrimevueButton @click="updateDetails" label="Save Changes to Delivery Details" severity="info" class="shadow-md shadow-slate-600"/>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">Selections</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.fund_source" :options="selections.fund_sources" optionLabel="name" optionValue="id" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Fund Source</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.req_office" :options="selections.offices" optionLabel="section_name" optionValue="section_id" filter class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Requisitioning Office</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.end_user" :options="selections.users" optionLabel="full_name" optionValue="user_id" filter class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>End User</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.payment_term" :options="[{code:1,name:'Charge'},{code:2,name:'Donation'}]" optionLabel="name" optionValue="code" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Acquisition Though</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.completion" :options="[{code:1,name:'Partial'},{code:2,name:'Complete'},{code:3,name:'Completion'}]" optionLabel="name" optionValue="code" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Completion Type</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">Entity</span>
                            <div class="w-full flex justify-start items-start gap-4">
                            <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.entity_name"  class="w-full"/>
                                    <label>Name</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">Porpuse</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.purpose"  class="w-full"/>
                                    <label>Porpuse</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">IAR Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.iar_no"  class="w-full"/>
                                    <label>IAR No</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.iar_date" dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>IAR Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">PO Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.po_no"  class="w-full"/>
                                    <label>Purchase Order No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.po_date" dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>Purchase Order Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">PTR Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.ptr_no"  class="w-full"/>
                                    <label>PTR No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.ptr_date" dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>PTR Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">BL Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.bl_no"  class="w-full"/>
                                    <label>BL No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.bl_date" dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>BL Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">DNF Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.dnf_no"  class="w-full"/>
                                    <label>DNF No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.dnf_date" dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>DNF Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                    </div>
                </TabPanel>
                <TabPanel value="2">
                    <div class="w-full flex flex-col justify-start items-start gap-2 font-poppins">
                         <div class="w-full flex justify-end items-center p-2">
                            <PrimevueButton @click="updateInvoices" label="Save Changes to Invoices" severity="info" class="shadow-md shadow-slate-600"/>
                        </div>
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                             <Panel v-for="(invoice,index) in deliveryObject.invoices" :header="`Invoice ${index+1}`" toggleable class="w-full mt-4">
                                <div class="w-full flex justify-start items-start gap-4">
                                    <FloatLabel variant="on" class="w-full">
                                        <InputText v-model="invoice.invoice_no"  class="w-full"/>
                                        <label>Invoice No.</label>
                                    </FloatLabel>
                                    <FloatLabel variant="on" class="w-full">
                                        <DatePicker v-model="invoice.invoice_date" dateFormat="dd/mm/yy" class="w-full"/>
                                        <label>Invoice Date</label>
                                    </FloatLabel>
                                </div>
                            </Panel>
                        </div>
                    </div>
                </TabPanel>
                <TabPanel value="3">
                    <div class="w-full flex flex-col justify-start items-start gap-2 font-poppins">
                         <div class="w-full flex flex-col justify-start items-start gap-2 font-poppins">
                            <div class="w-full flex justify-end items-center p-2">
                                <PrimevueButton @click="updateReceipts" label="Save Changes to Receipts" severity="info" class="shadow-md shadow-slate-600"/>
                            </div>
                            <div class="w-full flex flex-col justify-start items-start gap-4">
                                <Panel v-for="(receipt,index) in deliveryObject.receipts" :header="`Receipt ${index+1}`" toggleable class="w-full mt-4" >
                                    <div class="w-full flex justify-start items-start gap-4">
                                        <FloatLabel variant="on" class="w-full">
                                            <InputText v-model="receipt.dr_no"  class="w-full"/>
                                            <label>Receipt No.</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <DatePicker v-model="receipt.dr_date" dateFormat="dd/mm/yy" class="w-full"/>
                                            <label>Receipt Date</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <DatePicker v-model="receipt.delivery_date" dateFormat="dd/mm/yy" class="w-full"/>
                                            <label>Delivery Date</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <InputText v-model="receipt.delivery_place"  class="w-full"/>
                                            <label>Delivery Place</label>
                                        </FloatLabel>
                                    </div>
                                </Panel>
                            </div>
                        </div>
                    </div>
                </TabPanel>
                <TabPanel value="4">
                     <div class="w-full flex justify-end items-center p-2">
                        <PrimevueButton @click="updateItems" label="Save Changes to Items" severity="info" class="shadow-md shadow-slate-600"/>
                    </div>

                    <Panel v-for="(item,index) in deliveryObject.items" :header="`Item ${index+1}`" toggleable class="w-full mt-4">
                        <div class="w-full flex justify-start items-start gap-4">
                                <div class="w-full flex flex-col justify-start items-start gap-2">
                                    <div class="w-full flex flex-col justify-start items-start gap-2">
                                        <span class="font-semibold uppercase text-lg">Manufacturing</span>
                                        <div class="w-full flex justify-start items-start gap-4">
                                            <FloatLabel variant="on" class="w-full">
                                                <InputText v-model="item.manufacturer"  class="w-full"/>
                                                <label>Manufacturer</label>
                                            </FloatLabel>
                                            <FloatLabel variant="on" class="w-full">
                                                <DatePicker v-model="item.manufacturing_date" dateFormat="dd/mm/yy" class="w-full"/>
                                                <label>Manufacturing Date</label>
                                            </FloatLabel>
                                            <FloatLabel variant="on" class="w-full">
                                                <DatePicker v-model="item.expiry_date" dateFormat="dd/mm/yy" class="w-full"/>
                                                <label>Expiry Date</label>
                                            </FloatLabel>
                                            <FloatLabel variant="on" class="w-full">
                                                <InputNumber v-model="item.shelf_life"  class="w-full"/>
                                                <label>Shelf Life</label>
                                            </FloatLabel>
                                        </div>
                                    </div>
                                    <div class="w-full flex flex-col justify-start items-start gap-4">
                                        <span class="font-semibold uppercase text-lg">Item</span>
                                        <div class="w-full flex justify-start items-start gap-4">
                                            <FloatLabel variant="on" class="w-full">
                                                <InputText v-model="item.batch_lot_no"  class="w-full"/>
                                                <label>Batch/Lot Number</label>
                                            </FloatLabel>
                                            <FloatLabel variant="on" class="w-full">
                                                <InputNumber v-model="item.quantity"  class="w-full"/>
                                                <label>Quantity</label>
                                            </FloatLabel>
                                            <FloatLabel variant="on" class="w-full">
                                                <InputNumber v-model="item.unit_cost" :minFractionDigits="2" class="w-full"/>
                                                <label>Unit Cost</label>
                                            </FloatLabel>
                                        </div>
                                        <FloatLabel variant="on" class="w-full">
                                            <Textarea v-model="item.description" rows="5" cols="20" class="w-full font-light"/>
                                            <label>Description</label>
                                        </FloatLabel>
                                    </div>
                                    <div class="w-full flex flex-col justify-start items-start gap-2">
                                        <span class="font-semibold uppercase text-lg">Selections</span>
                                        <div class="w-full flex justify-start items-start gap-4">
                                            <FloatLabel class="w-full" variant="on">
                                                <Select v-model="item.measurement_unit" :options="selections.measurements" optionLabel="name" optionValue="id" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                                <label>Measurement Unit</label>
                                            </FloatLabel>
                                            <FloatLabel class="w-full" variant="on">
                                                <Select v-model="item.availability" :options="[{code:1,name:'Delivered'},{code:0,name:'Balance'}]" optionLabel="name" optionValue="code" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                                <label>Item Availability</label>
                                            </FloatLabel>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                    </Panel>

                </TabPanel>
            </TabPanels>
        </Tabs>

         
    </AuthenticatedPage>
 
 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Select from 'primevue/select';
    import { useRouter,useRoute } from 'vue-router';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import DatePicker from 'primevue/datepicker';
    import PrimevueButton from 'primevue/button';
    import Tabs from 'primevue/tabs';
    import TabList from 'primevue/tablist';
    import Tab from 'primevue/tab';
    import TabPanels from 'primevue/tabpanels';
    import TabPanel from 'primevue/tabpanel';
    import useApi from '../../../composables/api_calls';
    import InputNumber from 'primevue/inputnumber';
    import Textarea from 'primevue/textarea';
    import Panel from 'primevue/panel';

 
     const router = useRouter();
     const route = useRoute();
     const { fetchRequest,postRequest } = useApi();

     var deliveryObject = ref({
        id:route.params.id,
     })
     var selections = ref({})

     onMounted(()=>{
        fetchFundSources()
        fetchOffices()
        fetchUsers()
        fetchMeasurements()
        fetchDeliveryObject()
     })

    async function fetchDeliveryObject(){
        var response = await fetchRequest('deliveries/fetch/update',{id:route.params.id})
        response.toast()
        if(response.apiResponseStatus === 200){
            deliveryObject.value = response.data
        }
    
    }

    async function fetchFundSources(){
        var response = await fetchRequest('fund_source/list')
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

    async function fetchUsers(){
        var response = await fetchRequest('user/selection',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            selections.value.users = response.data.users
        }
    
    }

    async function fetchMeasurements(){
        var response = await fetchRequest('measurement/selection',{})
        response.toast()
        if(response.apiResponseStatus === 200){
            selections.value.measurements = response.data.measurements
        }
    
    }

    async function updateDetails(){
        var response = await postRequest('deliveries/update/details',deliveryObject.value.delivery);
        response.toast();
    }

    async function updateInvoices(){
        console.log(deliveryObject.value.invoices)
        var response = await postRequest('deliveries/update/invoices',deliveryObject.value.invoices);
        response.toast();
    }

    async function updateReceipts(){
        var response = await postRequest('deliveries/update/receipts',deliveryObject.value.receipts);
        response.toast();
    }

    async function updateItems(){
        var response = await postRequest('deliveries/update/items',deliveryObject.value.items);
        response.toast();
    }
 
 </script>
 