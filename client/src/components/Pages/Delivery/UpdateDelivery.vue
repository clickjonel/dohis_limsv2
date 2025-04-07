<template>

    <AuthenticatedPage pageTitle="Update Delivery Form">
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll">

             <div class="w-full flex justify-end items-center p-2">
                <Button @click="saveDelivery" buttonType="update" text="Save Delivery"/>
             </div>
 
            <!-- selections-fund_source,completion,payment_term,end_user,requisitioning_office -->
            <div class="w-full flex justify-start items-center gap-2 p-2">
                <!-- fund source selection -->
                <Select v-model="delivery.fund_source" :options="fund_sources" :invalid="errors.fund_source ? true : false" filter optionLabel="name" placeholder="Select Fund Source" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

                <!-- requisitioning office selection -->
                <Select v-model="delivery.req_office" :options="offices" :invalid="errors.req_office ? true : false" filter optionLabel="section_name" placeholder="Select Office" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.section_name }}</div>
                        </div>
                    </template>
                </Select>

                 <!-- end user selection -->
                <Select v-model="delivery.end_user" :options="end_users" :invalid="errors.end_user ? true : false" filter optionLabel="full_name" placeholder="Select Personnel" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.full_name }}</div>
                        </div>
                    </template>
                </Select>

                 <!-- payment terms selection -->
                <Select v-model="delivery.payment_term" :options="payment_terms" :invalid="errors.payment_term ? true : false" filter optionLabel="name" placeholder="Select Payment Term" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

                 <!-- completion selection -->
                <Select v-model="delivery.completion" :options="completions" :invalid="errors.completion ? true : false" filter optionLabel="name" placeholder="Select Completion" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>
            </div>

            <!-- details-entity_name,porpuse,source_name,source_address -->
            <div class="w-full flex justify-start items-center gap-2 p-2">
                <div class="w-[20%]">
                    <Input v-model="delivery.entity_name" :errorMessage="errors.entity_name ? errors.entity_name[0] : '' " label="Entity Name" type="text"/>
                </div>
                <div class="w-[40%]">
                    <Input v-model="delivery.purpose" :errorMessage="errors.purpose ? errors.purpose[0] : '' " label="Porpuse" type="text"/>
                </div>
                <div class="w-[20%]">
                    <Input v-model="delivery.source_name" :errorMessage="errors.source_name ? errors.source_name[0] : '' " label="Source Name" type="text"/>
                </div>
                <div class="w-[20%]">
                    <Input v-model="delivery.source_address" :errorMessage="errors.source_address ? errors.source_address[0] : '' " label="Source Address" type="text"/>
                </div>
            </div>

             <!-- details-iar_no,iar_date,po_no,po_date,ptr_no,ptr_date -->
             <div class="w-full flex justify-start items-center gap-2 p-2">
                <div class="w-1/6">
                    <Input v-model="delivery.iar_no" :errorMessage="errors.iar_no ? errors.iar_no[0] : '' " label="IAR Number" type="text"/>
                </div>
                <div class="w-1/6">
                    <Input v-model="delivery.iar_date" :errorMessage="errors.iar_date ? errors.iar_date[0] : '' " label="IAR Date" type="date"/>
                </div>
                <div class="w-1/6">
                    <Input v-model="delivery.po_no" :errorMessage="errors.po_no ? errors.po_no[0] : '' " label="PO Number" type="text"/>
                </div>
                <div class="w-1/6">
                    <Input v-model="delivery.po_date" :errorMessage="errors.po_date ? errors.po_date[0] : '' " label="PO Date" type="date"/>
                </div>
                <div class="w-1/6">
                    <Input v-model="delivery.ptr_no" :errorMessage="errors.ptr_no ? errors.ptr_no[0] : '' " label="PTR Number" type="text"/>
                </div>
                <div class="w-1/6">
                    <Input v-model="delivery.ptr_date" :errorMessage="errors.ptr_date ? errors.ptr_date[0] : '' "  label="PTR Date" type="date"/>
                </div>
            </div>

            <!-- details-bl_no,bl_date,dnf_no,dnf_date -->
            <div class="w-full flex justify-start items-center gap-2 p-2">
                <div class="w-[25%]">
                    <Input v-model="delivery.bl_no" :errorMessage="errors.bl_no ? errors.bl_no[0] : '' " label="Bill of Laiding Number" type="text"/>
                </div>
                <div class="w-[25%]">
                    <Input v-model="delivery.bl_date" :errorMessage="errors.bl_date ? errors.bl_date[0] : '' " label="Bill of Laiding Date" type="date"/>
                </div>
                <div class="w-[25%]">
                    <Input v-model="delivery.dnf_no" :errorMessage="errors.dnf_no ? errors.dnf_no[0] : '' " label="Delivery Notification Form Number" type="text"/>
                </div>
                <div class="w-[25%]">
                    <Input v-model="delivery.dnf_date" :errorMessage="errors.dnf_date ? errors.dnf_date[0] : '' " label="Delivery Notification Form Date" type="date"/>
                </div>
            </div>


            <!-- details-delivery_receipts,delivery_invoices -->
            <div class="w-full h-full flex justify-start items-start gap-4">

                <!-- delivery invoices -->
                <div class="w-1/3 h-full flex flex-col justify-start items-start p-2 overflow-auto" :class="errors.invoices ? 'border-2 border-red-900' : '' ">
                    <Button @click="modals.invoice_add = true" buttonType="update" :text="`Delivery Invoice/s  =>  Click to Add`" class="sticky top-0 w-full mb-4"/>
                    
                    <div class="w-full flex justify-start items-start gap-2 border-y-2 bg-amber-200 p-1 text-sm">
                        <span class="w-[40%]">Invoice Number</span>
                        <span class="w-[40%]">Invoice Date</span>
                        <span class="w-[20%]">Action</span>
                    </div>

                    <div v-if="delivery?.invoices?.length > 0" v-for="invoice in delivery.invoices" class="w-full flex flex-col justify-start items-start text-sm">
                        <div class="w-full flex justify-start items-start gap-2 border-b bg-gray-200 p-1 text-sm font-light">
                            <span class="w-[40%]">{{ invoice.invoice_no }}</span>
                            <span class="w-[40%]">{{ invoice.invoice_date }}</span>
                            <div class="w-[20%] flex justify-start items-center gap-1">
                                <span title="Edit Invoice"><Icon @click="() => { modals.invoice_update = true; invoiceUpdateFields = invoice }" icon="material-symbols:edit-square-rounded" class="text-2xl text-blue-900 hover:scale-125 cursor-pointer"/></span>
                                <span title="Delete Invoice"><Icon @click="confirmDeleteInvoice(invoice.id)" icon="typcn:delete" class="text-3xl text-red-900 hover:scale-125 cursor-pointer"/></span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="w-full h-full flex justify-center items-center">
                        <span class="animate-bounce">No Invoices</span>
                    </div>
                </div>

                <!-- delivery receipts -->
                <div class="w-2/3 h-full flex flex-col justify-start items-start p-2 overflow-auto" :class="errors.receipts ? 'border-2 border-red-900' : '' ">
                    <Button @click="modals.receipt_add = true" buttonType="update" :text="`Delivery Receipt/s  =>  Click to Add`" class="sticky top-0 w-full mb-4"/>
                        
                    <div class="w-full flex justify-start items-start gap-2 border-y-2 bg-amber-200 p-1 text-sm">
                        <span class="min-w-[15%]">Delivery Receipt #</span>
                        <span class="min-w-[20%]">Delivery Receipt Date</span>
                        <span class="min-w-[20%]">Delivery Date</span>
                        <span class="min-w-[30%]">Delivery Place</span>
                        <span class="min-w-[15%]">Action</span>
                    </div>

                    <div v-if="delivery?.receipts?.length > 0" v-for="receipt in delivery.receipts" class="w-full flex flex-col justify-start items-start text-sm">
                        
                        <div class="w-full flex justify-start items-start gap-2 border-b bg-gray-200 p-1 text-sm font-light">
                            <span class="min-w-[15%]">{{ receipt.dr_no }}</span>
                            <span class="min-w-[20%]">{{ receipt.dr_date }}</span>
                            <span class="min-w-[20%]">{{ receipt.delivery_date }}</span>
                            <span class="min-w-[30%] text-xs">{{ receipt.delivery_place }}</span>
                            <div class="min-w-[15%] flex justify-start items-center gap-1">
                                <span title="Edit Invoice"><Icon @click="() => { modals.receipt_update = true; receiptUpdateFields = receipt }" icon="material-symbols:edit-square-rounded" class="text-2xl text-blue-900 hover:scale-125 cursor-pointer"/></span>
                                <span title="Delete Invoice"><Icon @click="confirmDeleteReceipt(receipt.id)" icon="typcn:delete" class="text-3xl text-red-900 hover:scale-125 cursor-pointer"/></span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="w-full h-full flex justify-center items-center">
                        <span class="animate-bounce">No Delivery Receipts</span>
                    </div>
                </div>

            </div>


             <!-- details-delivery_items -->
             <div class="w-full flex flex-col justify-start items-center p-2" :class="errors.items ? 'border-2 border-red-900' : '' ">
                <Button @click="modals.item_add = true" buttonType="update" :text="`Delivery Item/s  =>  Click to Add`" class="sticky top-0 w-full mb-4"/>

                <div class="w-full flex justify-start items-start gap-2 border-y-2 bg-amber-200 p-1 text-sm">
                    <span class="w-[40%]">Description</span>
                    <span class="w-[15%]">Quantity</span>
                    <span class="w-[15%]">Unit Cost</span>
                    <span class="w-[15%]">Measurement Unit</span>
                    <span class="w-[15%]">Action</span>
                </div>

                <div v-if="delivery?.items?.length > 0" v-for="item in delivery.items" class="w-full flex flex-col justify-start items-start text-sm">
                    <div class="w-full flex justify-start items-start gap-2 border-b bg-gray-200 p-1 text-sm font-light">
                        <span class="w-[40%]" v-html="item.description.replace(/\n/g, '<br>')"></span>
                        <span class="w-[15%]">{{ item.quantity }}</span>
                        <span class="w-[15%]">{{ item.unit_cost }}</span>
                        <span class="w-[15%]">{{ item.measurement_unit.name}}</span>
                        <div class="w-[15%] flex justify-start items-center gap-1">
                            <span title="Edit Invoice"><Icon @click="setItemUpdateFields(item)" icon="material-symbols:edit-square-rounded" class="text-2xl text-blue-900 hover:scale-125 cursor-pointer"/></span>
                            <span title="Delete Invoice"><Icon @click="confirmDeleteItem(item.id)" icon="typcn:delete" class="text-3xl text-red-900 hover:scale-125 cursor-pointer"/></span>
                        </div>
                    </div>
                </div>
                <div v-else class="w-full h-full flex justify-center items-center">
                    <span class="animate-bounce">No Items</span>
                </div>
            </div>
             
 
         </div>
    </AuthenticatedPage>
 
    <!-- invoice add modal form -->
    <Dialog v-model:visible="modals.invoice_add" modal header="Add Delivery Invoice" :style="{ width: '25rem' }">
        <hr>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="invoiceAddFields.invoice_no" label="Invoice Number" :errorMessage="errors.invoice_no ? errors.invoice_no[0] : '' " type="text"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="invoiceAddFields.invoice_date" label="Invoice Date" :errorMessage="errors.invoice_date ? errors.invoice_date[0] : '' " type="date"/>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="modals.invoice_add = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="saveInvoice" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

    <!-- invoice update modal form -->
    <Dialog v-model:visible="modals.invoice_update" modal header="Update Delivery Invoice" :style="{ width: '25rem' }">
        <hr>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="invoiceUpdateFields.invoice_no" label="Invoice Number" :errorMessage="errors.invoice_no ? errors.invoice_no[0] : '' " type="text"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="invoiceUpdateFields.invoice_date" label="Invoice Date" :errorMessage="errors.invoice_date ? errors.invoice_date[0] : '' " type="date"/>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="modals.invoice_update = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="updateInvoice" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

    <!-- receipt add modal form -->
    <Dialog v-model:visible="modals.receipt_add" modal header="Add Delivery Receipt" :style="{ width: '30rem' }">
        <hr>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptAddFields.dr_no" label="Delivery Receipt Number" :errorMessage="errors.dr_no ? errors.dr_no[0] : '' " type="text"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptAddFields.dr_date" label="Delivery Receipt Date" :errorMessage="errors.dr_date ? errors.dr_date[0] : '' " type="date"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptAddFields.delivery_date" label="Delivery Date" :errorMessage="errors.delivery_date ? errors.delivery_date[0] : '' " type="date"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptAddFields.delivery_place" label="Delivery Place" :errorMessage="errors.delivery_place ? errors.delivery_place[0] : '' " type="text"/>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="modals.receipt_add = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="saveReceipt" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

    <!-- receipt update modal form -->
    <Dialog v-model:visible="modals.receipt_update" modal header="Update Delivery Receipt" :style="{ width: '30rem' }">
        <hr>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptUpdateFields.dr_no" label="Delivery Receipt Number" errorMessage="" type="text"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptUpdateFields.dr_date" label="Delivery Receipt Date" errorMessage="" type="date"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptUpdateFields.delivery_date" label="Delivery Date" errorMessage="" type="date"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="receiptUpdateFields.delivery_place" label="Delivery Place" errorMessage="" type="text"/>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="modals.receipt_update = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="updateReceipt" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

    <!-- delivery items add modal form -->
    <Dialog v-model:visible="modals.item_add" modal header="Add Delivery Item" :style="{ width: '80rem' }" @hide="clearAddItemForm">
        <hr>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemAddFields.manufacturer" label="Manufacturer" :errorMessage="errors.manufacturer ? errors.manufacturer[0] : '' " type="text"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemAddFields.manufacturing_date" label="Manufacturing Date" :errorMessage="errors.manufacturing_date ? errors.manufacturing_date[0] : '' " type="date"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemAddFields.expiry_date" label="Expiry Date" :errorMessage="errors.expiry_date ? errors.expiry_date[0] : '' " type="date"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemAddFields.shelf_life" label="Shelf Life" :errorMessage="errors.shelf_life ? errors.shelf_life[0] : '' " type="number"/>
            </div>
            <Select v-model="itemAddFields.availability" :options="availabilities" :invalid="errors.availability ? true : false" filter optionLabel="name" placeholder="Select Item Availability" class="w-[20%] font-lexend">
                <template #option="slotProps">
                    <div class="flex items-center font-lexend">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="itemAddFields.batch_lot_number" label="Batch/Lot Number/s" :errorMessage="errors.batch_lot_number ? errors.batch_lot_number[0] : '' " type="text"/>
            </div>
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="itemAddFields.quantity" label="Quantity" :errorMessage="errors.quantity ? errors.quantity[0] : '' " type="number"/>
            </div>
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="itemAddFields.unit_cost" label="Unit Cost" :errorMessage="errors.unit_cost ? errors.unit_cost[0] : '' " type="number"/>
            </div>
            <Select v-model="itemAddFields.measurement_unit" :options="measurements" :invalid="errors.measurement_unit ? true : false" filter optionLabel="name" placeholder="Select Measurement Unit" class="w-1/4 font-lexend">
                <template #option="slotProps">
                    <div class="flex items-center font-lexend">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-full flex items-center gap-4 mb-4">
                <TextArea v-model="itemAddFields.description" label="Description" :errorMessage="errors.description ? errors.description[0] : '' "/>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="modals.item_add = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="saveItem" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

    <!-- delivery items update modal form -->
    <Dialog v-model:visible="modals.item_update" modal header="Update Delivery Item" :style="{ width: '80rem' }" @hide="clearAddItemForm">
        <hr>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemUpdateFields.manufacturer" label="Manufacturer" :errorMessage="errors.manufacturer ? errors.manufacturer[0] : '' " type="text"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemUpdateFields.manufacturing_date" label="Manufacturing Date" :errorMessage="errors.manufacturing_date ? errors.manufacturing_date[0] : '' " type="date"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemUpdateFields.expiry_date" label="Expiry Date" :errorMessage="errors.expiry_date ? errors.expiry_date[0] : '' " type="date"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="itemUpdateFields.shelf_life" label="Shelf Life" :errorMessage="errors.shelf_life ? errors.shelf_life[0] : '' " type="number"/>
            </div>
            <Select v-model="itemUpdateFields.availability" :options="availabilities" :invalid="errors.availability ? true : false" filter optionLabel="name" placeholder="Select Item Availability" class="w-[20%] font-lexend">
                <template #option="slotProps">
                    <div class="flex items-center font-lexend">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="itemUpdateFields.batch_lot_number" label="Batch/Lot Number/s" :errorMessage="errors.batch_lot_number ? errors.batch_lot_number[0] : '' " type="text"/>
            </div>
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="itemUpdateFields.quantity" label="Quantity" :errorMessage="errors.quantity ? errors.quantity[0] : '' " type="number"/>
            </div>
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="itemUpdateFields.unit_cost" label="Unit Cost" :errorMessage="errors.unit_cost ? errors.unit_cost[0] : '' " type="number"/>
            </div>
            <Select v-model="itemUpdateFields.measurement_unit" :options="measurements" :invalid="errors.measurement_unit ? true : false" filter optionLabel="name" placeholder="Select Measurement Unit" class="w-1/4 font-lexend">
                <template #option="slotProps">
                    <div class="flex items-center font-lexend">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-full flex items-center gap-4 mb-4">
                <TextArea v-model="itemUpdateFields.description" label="Description" :errorMessage="errors.description ? errors.description[0] : '' "/>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="modals.item_update = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="updateItem" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>
  
 </template>
 
 <script setup> 
     import { ref,onMounted } from 'vue';
     import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
     import Select from 'primevue/select';
     import axios from '../../../axios/axios';
     import { Notify,Loading, Report,Confirm } from 'notiflix';
     import Input from '../../Form/Input.vue';
     import Button from '../../Button.vue';
     import Dialog from 'primevue/dialog';
     import TextArea from '../../TextArea.vue';
     import { useRouter,useRoute } from 'vue-router';
     import { Icon } from '@iconify/vue/dist/iconify.js';
 
     const router = useRouter();
     const route = useRoute();

     const delivery = ref({})

     const fund_sources = ref([])
     const offices = ref([])
     const end_users = ref([])
     const measurements = ref([])
     const payment_terms = ref([
        {
            name:'Charge',
            code:1
        },
        {
            name:'Donation',
            code:2
        }
     ])
     const availabilities = ref([
        {
            name:'Delivered',
            code:1
        },
        {
            name:'Balance',
            code:0
        }
     ])

    const completions = ref([
        {
            name:'Partial',
            code:1
        },
        {
            name:'Complete',
            code:2
        },
        {
            name:'Completion',
            code:2
        }
    ])

     var errors = ref({})

     var modals = ref({
        invoice_add:false,
        receipt_add:false,
        item_add:false,

        invoice_update:false,
        receipt_update:false,
        item_update:false,
     })

     var invoiceAddFields = ref({
        invoice_no:'',
        invoice_date:''
     })
     var invoiceUpdateFields = ref({})

     var receiptAddFields = ref({
        dr_no:'',
        dr_date:'',
        delivery_place:'',
        delivery_date:''
     })
     var receiptUpdateFields = ref({})

     var itemAddFields = ref({
        availability : {},
        manufacturer : '',
        manufacturing_date : '',
        expiry_date : '',
        unit_cost : '',
        quantity : '',
        batch_lot_number : '',
        shelf_life : '',
        measurement_unit : {},
        description : '',
     })
     var itemUpdateFields = ref({})

     onMounted(()=>{
        fetchDelivery()
        fetchFundSources()
        fetchMeasurements()
        fetchOffices()
     })

    function fetchDelivery(){
        Loading.dots('Loading Data, Please Wait...', {
            clickToClose: false,
            fontFamily:'Lexend Deca'
        });

        axios.get('delivery/find',{
            params:{
                id:route.params.id
            }
        })
        .then((response)=>{
            delivery.value = response.data.delivery
            delivery.value.payment_term = payment_terms.value.find(payment_term => payment_term.code ===response.data.delivery.payment_term)
            delivery.value.completion = completions.value.find(completion => completion.code === response.data.delivery.completion)
            // console.log(delivery.value.invoices)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
        })
    }

    function fetchFundSources(){
    axios.get('fund_source/list',{
        params:{
            
        }
    })
    .then((response)=>{
        fund_sources.value = response.data.fund_sources
        // console.log(fund_sources.value)
    })
    .catch((error)=>{
        Notify.failure('Something Went Wrong, Contact System Administrator')
        console.log( error.response )
    })
    .finally(()=>{
    })
    }
 
    function fetchOffices(){
    axios.get('office/list',{
        params:{
        
        }
    })
    .then((response)=>{
        offices.value = response.data.offices
        delivery.value.req_office = offices.value.find(office => office.section_id === delivery.value.req_office)
        end_users.value = delivery.value.req_office.personnel
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
    axios.get('measurement/selection',{
        params:{
        
        }
    })
    .then((response)=>{
        measurements.value = response.data.measurements
    })
    .catch((error)=>{
        Notify.failure('Something Went Wrong, Contact System Administrator')
        console.log( error.response )
    })
    .finally(()=>{
        Loading.remove()
    })
    }

    function saveInvoice(){
    Loading.dots('Saving Data, Please Wait...', {
        clickToClose: false,
        fontFamily:'Lexend Deca'
    });

    axios.post('delivery/create/invoice',{
        delivery_id:route.params.id,
        invoice_no:invoiceAddFields.value.invoice_no,
        invoice_date:invoiceAddFields.value.invoice_date
    })
    .then((response)=>{
        delivery.value.invoices.push(response.data.invoice)
        Report.success(
            'Success',
            'Invoice has been added to Delivery',
            'Okay',
        );
        modals.value.invoice_add = false
        invoiceAddFields.value.invoice_no = ''
        invoiceAddFields.value.invoice_date = ''
    })
    .catch((error)=>{
        errors.value.invoice_no = error.response.data.errors
        Report.failure(
            'Validation Error',
            'Please Fill Up Correct Details and Try Again',
            'Okay',
        );
    })
    .finally(()=>{
        Loading.remove()
    })
    }

    function updateInvoice(){
    
    Loading.dots('Updating Invoice, Please Wait...', {
        clickToClose: false,
        fontFamily:'Lexend Deca'
    });

    var invoiceIndex = delivery.value.invoices.indexOf(invoiceUpdateFields.value)

    axios.post('delivery/update/invoice',{
        id:invoiceUpdateFields.value.id,
        delivery_id:invoiceUpdateFields.value.delivery_id,
        invoice_no:invoiceUpdateFields.value.invoice_no,
        invoice_date:invoiceUpdateFields.value.invoice_date,
    })
    .then((response)=>{
        delivery.value.invoices[invoiceIndex] = response.data.invoice
        Report.success(
            'Success',
            'Invoice has been updated',
            'Okay',
        );
        modals.value.invoice_update= false      
    })
    .catch((error)=>{
        errors.value.invoice_no = error.response.data.errors
        Report.failure(
            'Validation Error',
            'Please Fill Up Correct Details and Try Again',
            'Okay',
        );
        console.log(error)
    })
    .finally(()=>{
        Loading.remove()
    })

    }

    function confirmDeleteInvoice(invoice_id){
        Confirm.show(
            'Confirm to Delete Invoice',
            'Do you want to delete this invoice?',
            'Delete',
            'Cancel',

        () => {
            deleteInvoice(invoice_id)
        },
        () => {
            
        },

        {
            fontFamily:'Lexend Deca'
        },

        );
    }

    function deleteInvoice(invoice_id){
    Loading.dots('Deleting Invoice, Please Wait...', {
        clickToClose: false,
        fontFamily:'Lexend Deca'
    });

    axios.delete('delivery/delete/invoice',{
        data:{
            id:invoice_id
        }
    })
    .then((response)=>{
        Report.success(
            'Success',
            'Invoice has been deleted',
            'Okay',
        ); 
        var index = delivery.value.invoices.findIndex(invoice => invoice.id === invoice_id);
        delivery.value.invoices.splice(index,1)
    })
    .catch((error)=>{
        Report.failure(
            'Validation Error',
            `${error.response.data}`,
            'Okay',
        );
        console.log(error)
    })
    .finally(()=>{
        Loading.remove()
    })
    }
   
    function saveReceipt(){
    Loading.dots('Saving Data, Please Wait...', {
        clickToClose: false,
        fontFamily:'Lexend Deca'
    });

    axios.post('delivery/create/receipt',{
        delivery_id:route.params.id,
        dr_no:receiptAddFields.value.dr_no,
        dr_date:receiptAddFields.value.dr_date,
        delivery_date:receiptAddFields.value.delivery_date,
        delivery_place:receiptAddFields.value.delivery_place
    })
    .then((response)=>{
        delivery.value.receipts.push(response.data.receipt)
        Report.success(
            'Success',
            'Receipt has been added to Delivery',
            'Okay',
        );
        modals.value.receipt_add = false
        receiptAddFields.value.dr_no = ''
        receiptAddFields.value.dr_date = ''
        receiptAddFields.value.delivery_place = ''
        receiptAddFields.value.delivery_date = ''
    })
    .catch((error)=>{
        errors.value = error.response.data.errors
        Report.failure(
            'Validation Error',
            'Please Fill Up Correct Details and Try Again',
            'Okay',
        );
    })
    .finally(()=>{
        Loading.remove()
    })
    }

    function updateReceipt(){
       
       Loading.dots('Updating Invoice, Please Wait...', {
           clickToClose: false,
           fontFamily:'Lexend Deca'
       });

       var receiptIndex = delivery.value.receipts.indexOf(receiptUpdateFields.value)

       axios.post('delivery/update/receipt',{
           id:receiptUpdateFields.value.id,
           dr_no:receiptUpdateFields.value.dr_no,
           dr_date:receiptUpdateFields.value.dr_date,
           delivery_date:receiptUpdateFields.value.delivery_date,
           delivery_place:receiptUpdateFields.value.delivery_place,
       })
       .then((response)=>{
           delivery.value.receipts[receiptIndex] = response.data.receipt
           Report.success(
               'Success',
               'Receipt has been updated',
               'Okay',
           );
           modals.value.receipt_update= false      
       })
       .catch((error)=>{
           errors.value = error.response.data.errors
           Report.failure(
               'Validation Error',
               'Please Fill Up Correct Details and Try Again',
               'Okay',
           );
           console.log(error)
       })
       .finally(()=>{
           Loading.remove()
       })

    }

    function confirmDeleteReceipt(receipt_id){
        Confirm.show(
        'Confirm to Delete Receipt',
        'Do you want to delete this receipt?',
        'Delete',
        'Cancel',

        () => {
            deleteReceipt(receipt_id)
        },
        () => {
           
        },

        {
            fontFamily:'Lexend Deca'
        },

        );
    }

    function deleteReceipt(receipt_id){
        Loading.dots('Deleting Invoice, Please Wait...', {
            clickToClose: false,
            fontFamily:'Lexend Deca'
        });

        axios.delete('delivery/delete/receipt',{
            data:{
                id:receipt_id
            }
        })
        .then((response)=>{
            Report.success(
                'Success',
                'Receipt has been deleted',
                'Okay',
            ); 
            var index = delivery.value.receipts.findIndex(receipt => receipt.id === receipt_id);
            delivery.value.receipts.splice(index,1)
        })
        .catch((error)=>{
            Report.failure(
                'Validation Error',
                `${error.response.data}`,
                'Okay',
            );
            console.log(error)
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function saveItem(){
    Loading.dots('Saving Data, Please Wait...', {
        clickToClose: false,
        fontFamily:'Lexend Deca'
    });
    
    axios.post('delivery/create/item',{
        delivery_id:route.params.id,
        availability : itemAddFields.value.availability?.code,
        manufacturer : itemAddFields.value.manufacturer,
        manufacturing_date : itemAddFields.value.manufacturing_date,
        expiry_date : itemAddFields.value.expiry_date,
        unit_cost : itemAddFields.value.unit_cost,
        quantity : itemAddFields.value.quantity,
        batch_lot_number : itemAddFields.value.batch_lot_number,
        shelf_life : itemAddFields.value.shelf_life,
        measurement_unit : itemAddFields.value.measurement_unit?.id,
        description : itemAddFields.value.description,
    })
    .then((response)=>{
        Report.success(
            'Success',
            'Item has been added',
            'Okay',
        ); 
        modals.value.item_add = false
        fetchDelivery()
    })
    .catch((error)=>{
        errors.value = error.response.data.errors
        Report.failure(
            'Validation Error',
            'Please Fill Up Correct Details and Try Again',
            'Okay',
        );
    })
    .finally(()=>{
        Loading.remove()
    })
    }

    function updateItem(){
       Loading.dots('Updating Item, Please Wait...', {
           clickToClose: false,
           fontFamily:'Lexend Deca'
       });

       axios.post('delivery/update/item',{
            id:itemUpdateFields.value.id,
            delivery_id:route.params.id,
            availability : itemUpdateFields.value.availability?.code,
            manufacturer : itemUpdateFields.value.manufacturer,
            manufacturing_date : itemUpdateFields.value.manufacturing_date,
            expiry_date : itemUpdateFields.value.expiry_date,
            unit_cost : itemUpdateFields.value.unit_cost,
            quantity : itemUpdateFields.value.quantity,
            batch_lot_number : itemUpdateFields.value.batch_lot_number,
            shelf_life : itemUpdateFields.value.shelf_life,
            measurement_unit : itemUpdateFields.value.measurement_unit?.id,
            description : itemUpdateFields.value.description,
       })
       .then((response)=>{
        console.log(response.data)
        Report.success(
                'Success',
                'Item has been updated',
                'Okay',
            ); 
            modals.value.item_update = false
            fetchDelivery()   
       })
       .catch((error)=>{
           errors.value = error.response.data.errors
           Report.failure(
               'Validation Error',
               'Please Fill Up Correct Details and Try Again',
               'Okay',
           );
           console.log(error)
       })
       .finally(()=>{
           Loading.remove()
       })

    }

    function clearAddItemForm(){
    itemAddFields.value.availability = {}
    itemAddFields.value.manufacturer = ''
    itemAddFields.value.manufacturing_date = ''
    itemAddFields.value.expiry_date = ''
    itemAddFields.value.unit_cost = ''
    itemAddFields.value.quantity = ''
    itemAddFields.value.batch_lot_number = ''
    itemAddFields.value.shelf_life = ''
    itemAddFields.value.measurement_unit = {}
    itemAddFields.value.description = ''
    }

    function setItemUpdateFields(item){
    itemUpdateFields.value = item;
    itemUpdateFields.value.availability = availabilities.value.find(a => a.code === item.availability)
    modals.value.item_update = true
    }

    function confirmDeleteItem(item_id){
        Confirm.show(
            'Confirm to Delete Item',
            'Do you want to delete this item?',
            'Delete',
            'Cancel',

        () => {
            deleteItem(item_id)
        },
        () => {
            
        },

        {
            fontFamily:'Lexend Deca'
        },

        );
    }

    function deleteItem(item_id){
        Loading.dots('Deleting Item, Please Wait...', {
            clickToClose: false,
            fontFamily:'Lexend Deca'
        });

        axios.delete('delivery/delete/item',{
            data:{
                id:item_id
            }
        })
        .then((response)=>{
            Report.success(
                'Success',
                'Item has been deleted',
                'Okay',
            ); 
           fetchDelivery()
        })
        .catch((error)=>{
            Report.failure(
                'Validation Error',
                `${error.response.data}`,
                'Okay',
            );
            console.log(error)
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function saveDelivery(){
        axios.post('delivery/update',{
            id : route.params.id,
            entity_name : delivery.value.entity_name,
            fund_source : delivery.value.fund_source?.id,
            source_name : delivery.value.source_name,
            source_address : delivery.value.source_address,
            iar_no : delivery.value.iar_no,
            iar_date : delivery.value.iar_date,
            po_no : delivery.value.po_no ?? null,
            po_date : delivery.value.po_date ?? null,
            ptr_no : delivery.value.ptr_no ?? null,
            ptr_date : delivery.value.ptr_date ?? null,
            bl_no : delivery.value.bl_no ?? null,
            bl_date : delivery.value.bl_date ?? null,
            dnf_no : delivery.value.dnf_no ?? null,
            dnf_date : delivery.value.dnf_date ?? null,
            req_office : delivery.value.req_office?.section_id,
            end_user : delivery.value.end_user?.user_id,
            payment_term : delivery.value.payment_term?.code,
            completion : delivery.value.completion?.code,
            purpose : delivery.value.purpose,
        })
        .then((response)=>{
            if(response.data.status){
                Report.success(
                    'Success',
                    'Delivery has been updated',
                    'Okay',
                    () => {
                        router.push({path:'/deliveries'})
                    },
                    {
                        fontFamily:'Lexend Deca'
                    }
                );
            }
        })
        .catch((error)=>{
            Report.failure(
                'Validation Error',
                `${error.response.data}`,
                'Okay',
            );
            console.log(error)
        })
        .finally(()=>{
            Loading.remove()
        })
    }
 
 </script>