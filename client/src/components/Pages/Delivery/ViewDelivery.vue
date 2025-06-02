<template>

    <AuthenticatedPage>
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 overflow-y-scroll font-poppins p-4">
            <div class="w-full flex flex-col justify-start items-start gap-2">

                <Panel header="Details" toggleable class="w-full mt-4 shadow-md shadow-slate-600" >
                   <div v-if="deliveryObject.delivery" class="w-full flex flex-col justify-start items-start gap-6 p-2 font-poppins">
                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">Selections</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.fund_source" :options="selections.fund_sources" optionLabel="name" optionValue="id" class="w-full" disabled :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Fund Source</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.req_office" :options="selections.offices" optionLabel="section_name" optionValue="section_id" filter class="w-full" disabled :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Requisitioning Office</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.end_user" :options="selections.users" optionLabel="full_name" optionValue="user_id" filter class="w-full" disabled :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>End User</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.payment_term" :options="[{code:1,name:'Charge'},{code:2,name:'Donation'}]" optionLabel="name" optionValue="code" class="w-full" disabled :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Acquisition Though</label>
                                </FloatLabel>
                                <FloatLabel class="w-full" variant="on">
                                    <Select v-model="deliveryObject.delivery.completion" :options="[{code:1,name:'Partial'},{code:2,name:'Complete'},{code:3,name:'Completion'}]" optionLabel="name" optionValue="code" class="w-full" disabled :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                    <label>Completion Type</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">Entity</span>
                            <div class="w-full flex justify-start items-start gap-4">
                            <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.entity_name" disabled class="w-full"/>
                                    <label>Name</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">Porpuse</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.purpose" disabled class="w-full"/>
                                    <label>Porpuse</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">IAR Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.iar_no" disabled class="w-full"/>
                                    <label>IAR No</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.iar_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>IAR Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">PO Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.po_no" disabled class="w-full"/>
                                    <label>Purchase Order No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.po_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>Purchase Order Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">PTR Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.ptr_no" disabled class="w-full"/>
                                    <label>PTR No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.ptr_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>PTR Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">BL Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.bl_no" disabled class="w-full"/>
                                    <label>BL No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.bl_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>BL Date</label>
                                </FloatLabel>
                            </div>
                        </div>

                        <div class="w-full flex flex-col justify-start items-start gap-2">
                            <span class="text-xl font-semibold uppercase">DNF Details</span>
                            <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="deliveryObject.delivery.dnf_no" disabled class="w-full"/>
                                    <label>DNF No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="deliveryObject.delivery.dnf_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>DNF Date</label>
                                </FloatLabel>
                            </div>
                        </div>
                    </div>
                </Panel>

                <Panel v-if="deliveryObject.invoices?.length > 0" header="Invoices" toggleable collapsed class="w-full mt-4 shadow-md shadow-slate-600" >
                   <div class="w-full flex flex-col justify-start items-start gap-4 font-poppins">
                        <div v-for="(invoice,index) in deliveryObject.invoices" class="w-full justify-start items-start gap-4">
                             <div class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="invoice.invoice_no" disabled class="w-full"/>
                                    <label>Invoice No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="invoice.invoice_date" dateFormat="dd/mm/yy" disabled class="w-full"/>
                                    <label>Invoice Date</label>
                                </FloatLabel>
                            </div>
                        </div>
                    </div>
                </Panel>

                 <Panel v-if="deliveryObject.receipts?.length > 0" header="Receipts" toggleable collapsed class="w-full mt-4 shadow-md shadow-slate-600" >
                   <div class="w-full flex flex-col justify-start items-start gap-2 font-poppins">
                         <div class="w-full flex flex-col justify-start items-start gap-4 font-poppins">
                            <div v-for="(receipt,index) in deliveryObject.receipts" class="w-full flex justify-start items-start gap-4">
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="receipt.dr_no" disabled class="w-full"/>
                                    <label>Receipt No.</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="receipt.dr_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>Receipt Date</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <DatePicker v-model="receipt.delivery_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                    <label>Delivery Date</label>
                                </FloatLabel>
                                <FloatLabel variant="on" class="w-full">
                                    <InputText v-model="receipt.delivery_place" disabled  class="w-full"/>
                                    <label>Delivery Place</label>
                                </FloatLabel>
                            </div>
                        </div>
                    </div>
                </Panel>

                <Panel header="Items" toggleable collapsed class="w-full mt-4 shadow-md shadow-slate-600" >
                    <Panel v-for="(item,index) in deliveryObject.items" :header="`Item ${index+1}`" toggleable collapsed class="w-full mt-4 ">
                        <div class="w-full flex justify-start items-start gap-4">
                            <div class="w-full flex flex-col justify-start items-start gap-2">
                                <div class="w-full flex flex-col justify-start items-start gap-2">
                                    <span class="font-semibold uppercase text-lg">Manufacturing</span>
                                    <div class="w-full flex justify-start items-start gap-4">
                                        <FloatLabel variant="on" class="w-full">
                                            <InputText v-model="item.manufacturer" disabled class="w-full"/>
                                            <label>Manufacturer</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <DatePicker v-model="item.manufacturing_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                            <label>Manufacturing Date</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <DatePicker v-model="item.expiry_date" disabled dateFormat="dd/mm/yy" class="w-full"/>
                                            <label>Expiry Date</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <InputNumber v-model="item.shelf_life" disabled  class="w-full"/>
                                            <label>Shelf Life</label>
                                        </FloatLabel>
                                    </div>
                                </div>
                                <div class="w-full flex flex-col justify-start items-start gap-4">
                                    <span class="font-semibold uppercase text-lg">Item</span>
                                    <div class="w-full flex justify-start items-start gap-4">
                                        <FloatLabel variant="on" class="w-full">
                                            <InputText v-model="item.batch_lot_no" disabled class="w-full"/>
                                            <label>Batch/Lot Number</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <InputNumber v-model="item.quantity" disabled  class="w-full"/>
                                            <label>Quantity</label>
                                        </FloatLabel>
                                        <FloatLabel variant="on" class="w-full">
                                            <InputNumber v-model="item.unit_cost" disabled :minFractionDigits="2" class="w-full"/>
                                            <label>Unit Cost</label>
                                        </FloatLabel>
                                    </div>
                                    <FloatLabel variant="on" class="w-full">
                                        <Textarea v-model="item.description" disabled rows="5" cols="20" class="w-full font-light"/>
                                        <label>Description</label>
                                    </FloatLabel>
                                </div>
                                <div class="w-full flex flex-col justify-start items-start gap-2">
                                    <span class="font-semibold uppercase text-lg">Selections</span>
                                    <div class="w-full flex justify-start items-start gap-4">
                                        <FloatLabel class="w-full" variant="on">
                                            <Select v-model="item.measurement_unit" :options="selections.measurements" optionLabel="name" optionValue="id" disabled class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                            <label>Measurement Unit</label>
                                        </FloatLabel>
                                        <FloatLabel class="w-full" variant="on">
                                            <Select v-model="item.availability" :options="[{code:1,name:'Delivered'},{code:0,name:'Balance'}]" disabled optionLabel="name" optionValue="code" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                                            <label>Item Availability</label>
                                        </FloatLabel>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <FloatLabel variant="on" class="w-full mt-4">
                            <InputText v-model="item.total" disabled  class="w-full"/>
                            <label>Total Cost</label>
                        </FloatLabel>
                    </Panel>
                    <FloatLabel variant="on" class="w-full mt-4">
                        <InputText v-model="deliveryObject.total_cost" disabled  class="w-full"/>
                        <label>Total Cost</label>
                    </FloatLabel>
                </Panel>
                
            </div>
         </div>
    </AuthenticatedPage>

 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import { useRouter,useRoute } from 'vue-router';
    import Select from 'primevue/select';
    import Input from '../../Form/Input.vue';
    import Button from '../../Button.vue';
    import Dialog from 'primevue/dialog';
    import TextArea from '../../TextArea.vue';
    import useApi from '../../../composables/api_calls';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import DatePicker from 'primevue/datepicker';
    import PrimevueButton from 'primevue/button';
    import Tabs from 'primevue/tabs';
    import TabList from 'primevue/tablist';
    import Tab from 'primevue/tab';
    import TabPanels from 'primevue/tabpanels';
    import TabPanel from 'primevue/tabpanel';
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
        var response = await fetchRequest('deliveries/fetch/view',{id:route.params.id})
        response.toast()
        if(response.apiResponseStatus === 200){
            deliveryObject.value = response.data
            console.log(response.data)
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


 
 </script>