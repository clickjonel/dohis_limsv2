<template>

   <AuthenticatedPage pageTitle="Add Delivery Form">
        <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll">

            <div class="w-full flex justify-end items-center p-2">
               <Button @click="handleSaveDelivery" buttonType="create" text="Save Delivery"/>
            </div>

            <!-- selections-fund_source,completion,payment_term,end_user,requisitioning_office -->
            <div class="w-full flex justify-start items-center gap-2 p-2">
                <!-- fund source selection -->
                <Select v-model="delivery.fund_source" :options="selections.fund_sources" :invalid="errors.fund_source ? true : false" filter optionLabel="name" placeholder="Select Fund Source" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

                <!-- requisitioning office selection -->
                <Select v-model="delivery.req_office" :options="selections.offices" :invalid="errors.req_office ? true : false" filter optionLabel="section_name" placeholder="Select Office" class="w-[20%] font-lexend" @change="setPersonnelSelection">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.section_name }}</div>
                        </div>
                    </template>
                </Select>

                 <!-- end user selection -->
                <Select v-model="delivery.end_user" :options="selections.end_users" :invalid="errors.end_user ? true : false" filter optionLabel="full_name" placeholder="Select Personnel" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.full_name }}</div>
                        </div>
                    </template>
                </Select>

                 <!-- payment terms selection -->
                <Select v-model="delivery.payment_term" :options="selections.payment_term" :invalid="errors.payment_term ? true : false" filter optionLabel="name" placeholder="Select Payment Term" class="w-[20%] font-lexend">
                    <template #option="slotProps">
                        <div class="flex items-center font-lexend">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>

                 <!-- completion selection -->
                <Select v-model="delivery.completion" :options="selections.completions" :invalid="errors.completion ? true : false" filter optionLabel="name" placeholder="Select Completion" class="w-[20%] font-lexend">
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
                    <Input v-model="delivery.porpuse" :errorMessage="errors.porpuse ? errors.porpuse[0] : '' " label="Porpuse" type="text"/>
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
                    <Button @click="invoiceFormModal = true"  buttonType="update" :text="`Delivery Invoice/s ( ${delivery.invoices.length} )  Click to Add`" class="sticky top-0 w-full mb-4"/>
                    
                    <div class="w-full flex justify-start items-start gap-2 border-y-2 bg-amber-200 p-1 text-sm">
                        <span class="w-1/2">Invoice Number</span>
                        <span class="w-1/2">Invoice Date</span>
                    </div>

                    <div v-if="delivery.invoices.length > 0" v-for="invoice in delivery.invoices" class="w-full flex flex-col justify-start items-start text-sm">
                        <div class="w-full flex justify-start items-start gap-2 border-b bg-gray-200 p-1 text-sm font-light">
                            <span class="w-1/2">{{ invoice.invoice_no }}</span>
                            <span class="w-1/2">{{ invoice.invoice_date }}</span>
                        </div>
                    </div>
                    <div v-else class="w-full h-full flex justify-center items-center">
                        <span class="animate-bounce">No Invoices</span>
                    </div>
                </div>

                 <!-- delivery receipts -->
                 <div class="w-2/3 h-full flex flex-col justify-start items-start p-2 overflow-auto" :class="errors.delivery_receipts ? 'border-2 border-red-900' : '' ">
                    <Button @click="deliveryReceiptFormModal = true"  buttonType="update" :text="`Delivery Receipt/s ( ${delivery.delivery_receipts.length} )  Click to Add`" class="sticky top-0 w-full mb-4"/>
                        
                        <div class="w-full flex justify-start items-start gap-2 border-y-2 bg-amber-200 p-1 text-sm">
                            <span class="w-[25%]">Delivery Receipt #</span>
                            <span class="w-[25%]">Delivery Receipt Date</span>
                            <span class="w-[25%]">Delivery Date</span>
                            <span class="w-[25%]">Delivery Place</span>
                        </div>

                    <div v-if="delivery.delivery_receipts.length > 0" v-for="receipt in delivery.delivery_receipts" class="w-full flex flex-col justify-start items-start text-sm">
                        
                        <div class="w-full flex justify-start items-start gap-2 border-b bg-gray-200 p-1 text-sm font-light">
                            <span class="w-[25%]">{{ receipt.delivery_receipt_no }}</span>
                            <span class="w-[25%]">{{ receipt.delivery_receipt_date }}</span>
                            <span class="w-[25%]">{{ receipt.delivery_date }}</span>
                            <span class="w-[25%]">{{ receipt.delivery_place }}</span>
                        </div>

                    </div>
                    <div v-else class="w-full h-full flex justify-center items-center">
                        <span class="animate-bounce">No Delivery Receipts</span>
                    </div>
                </div>

            </div>

            <!-- details-delivery_items -->
            <div class="w-full flex flex-col justify-start items-center p-2" :class="errors.items ? 'border-2 border-red-900' : '' ">
                <Button @click="deliveryItemFormModal = true" buttonType="update" :text="`Delivery Item/s ( ${delivery.items.length} )  Click to Add`" class="sticky top-0 w-full mb-4"/>

                <div class="w-full flex justify-start items-start gap-2 border-y-2 bg-amber-200 p-1 text-sm">
                    <span class="w-[40%]">Description</span>
                    <span class="w-[15%]">Quantity</span>
                    <span class="w-[15%]">Unit Cost</span>
                    <span class="w-[15%]">Measurement Unit</span>
                    <span class="w-[15%]">Batch/Lot Number</span>
                </div>

                <div v-if="delivery.items.length > 0" v-for="item in delivery.items" class="w-full flex flex-col justify-start items-start text-sm">
                    <div class="w-full flex justify-start items-start gap-2 border-b bg-gray-200 p-1 text-sm font-light">
                        <span class="w-[40%]" v-html="item.description.replace(/\n/g, '<br>')"></span>
                        <span class="w-[15%]">{{ item.quantity }}</span>
                        <span class="w-[15%]">{{ item.unit_cost }}</span>
                        <span class="w-[15%]">{{ item.measurement_name}}</span>
                        <span class="w-[15%]">{{ item.batch_lot_number }}</span>
                    </div>
                </div>
                <div v-else class="w-full h-full flex justify-center items-center">
                    <span class="animate-bounce">No Items</span>
                </div>
            </div>

        </div>
   </AuthenticatedPage>

   <!-- invoices modal form -->
    <Dialog v-model:visible="invoiceFormModal" modal header="Add Delivery Invoice" :style="{ width: '25rem' }" @hide="clearDeliveryInvoiceForm">
        <hr>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="invoice_no" label="Invoice Number" errorMessage="" type="text"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="invoice_date" label="Invoice Date" errorMessage="" type="date"/>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="invoiceFormModal = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="appendInvoice" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

    <!-- delivery receipts modal form -->
    <Dialog v-model:visible="deliveryReceiptFormModal" modal header="Add Delivery Receipt" :style="{ width: '30rem' }" @hide="clearDeliveryReceiptForm">
        <hr>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="delivery_receipt_no" label="Delivery Receipt Number" errorMessage="" type="text"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="delivery_receipt_date" label="Delivery Receipt Date" errorMessage="" type="date"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="delivery_date" label="Delivery Date" errorMessage="" type="date"/>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <Input v-model="delivery_place" label="Delivery Place" errorMessage="" type="text"/>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="deliveryReceiptFormModal = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="appendDeliveryReceipt" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

    <!-- delivery items modal form -->
    <Dialog v-model:visible="deliveryItemFormModal" modal header="Add Delivery Item" :style="{ width: '80rem' }" @hide="clearDeliveryItemForm">
        <hr>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="manufacturer" label="Manufacturer" :errorMessage="errors.manufacturer ? errors.manufacturer[0] : '' " type="text"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="manufacturing_date" label="Manufacturing Date" :errorMessage="errors.manufacturing_date ? errors.manufacturing_date[0] : '' " type="date"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="expiry_date" label="Expiry Date" :errorMessage="errors.expiry_date ? errors.expiry_date[0] : '' " type="date"/>
            </div>
            <div class="w-1/5 flex items-center gap-4 mb-4">
                <Input v-model="shelf_life" label="Shelf Life" :errorMessage="errors.shelf_life ? errors.shelf_life[0] : '' " type="number"/>
            </div>
            <Select v-model="availability" :options="selections.validities" :invalid="errors.availability ? true : false" filter optionLabel="name" placeholder="Select Item Availability" class="w-[20%] font-lexend">
                <template #option="slotProps">
                    <div class="flex items-center font-lexend">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="batch_lot_number" label="Batch/Lot Number/s" :errorMessage="errors.batch_lot_number ? errors.batch_lot_number[0] : '' " type="text"/>
            </div>
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="quantity" label="Quantity" :errorMessage="errors.quantity ? errors.quantity[0] : '' " type="number"/>
            </div>
            <div class="w-1/4 flex items-center gap-4 mb-4">
                <Input v-model="unit_cost" label="Unit Cost" :errorMessage="errors.unit_cost ? errors.unit_cost[0] : '' " type="number"/>
            </div>
            <Select v-model="measurement_unit" :options="selections.measurements" :invalid="errors.measurement_unit ? true : false" filter optionLabel="name" placeholder="Select Measurement Unit" class="w-1/4 font-lexend">
                <template #option="slotProps">
                    <div class="flex items-center font-lexend">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>
        <div class="flex items-center gap-4 mb-4 py-2">
            <div class="w-full flex items-center gap-4 mb-4">
                <TextArea v-model="description" label="Description" :errorMessage="errors.description ? errors.description[0] : '' "/>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <Button @click="deliveryItemFormModal = false" buttonType="default" text="Cancel" icon="material-symbols:cancel-rounded"></Button>
            <Button @click="appendDeliveryItem" type="info" text="Submit" icon="material-symbols:add-rounded"></Button>
        </div>
    </Dialog>

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
    import { useRouter } from 'vue-router';

    const router = useRouter();

    var selections = ref({
        fund_sources:[],
        offices:[],
        end_users:[],
        payment_term:[
            {
                name:'Charge',
                code:1
            },
            {
                name:'Donation',
                code:2
            }
        ],
        completions:[
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
        ],
        measurements:[],
        validities:[
            {
                name:'Delivered',
                code:1
            },
            {
                name:'Balance',
                code:0
            }
        ]
    })
    

    var delivery = ref({
        fund_source:{},
        req_office:{},
        end_user:{},
        payment_term:{},
        completion:{},
        entity_name:'',
        porpuse:'',
        source_name:'',
        source_address:'',
        iar_no:'',
        iar_date:'',
        po_no:'',
        po_date:'',
        ptr_no:'',
        ptr_date:'',
        dnf_no:'',
        dnf_date:'',
        bl_no:'',
        bl_date:'',
        invoices:[],
        delivery_receipts:[],
        items:[]
    })

    var errors = ref({})

    var invoiceFormModal = ref(false);
    var deliveryReceiptFormModal = ref(false)
    var deliveryItemFormModal = ref(false)

    //delivery invoice fields
    var invoice_no = ref('')
    var invoice_date = ref('')

    // delivery receipt fields
    var delivery_receipt_no = ref('')
    var delivery_receipt_date = ref('')
    var delivery_place = ref('')
    var delivery_date = ref('')

    // delivery item fields
    var availability = ref({})
    var manufacturer = ref('')
    var manufacturing_date = ref('')
    var expiry_date = ref('')
    var unit_cost = ref('')
    var quantity = ref('')
    var batch_lot_number = ref('')
    var shelf_life = ref('')
    var measurement_unit = ref({})
    var description = ref('')

    onMounted(()=>{
        Loading.dots('Loading Data, Please Wait...', {
            clickToClose: false
        });
        getSelectionData()
    })

    // runs when offices selection is changed or a values is selected
    function setPersonnelSelection(office){
        selections.value.end_users = office.value.personnel
    } 

    // push in respective array
    function appendInvoice(){
        if(invoice_no.value === ''){
            Notify.failure('Failed, Please Input Invoice Details Before Submitting')
        }

        else{
            var invoice = {
                invoice_no:invoice_no.value,
                invoice_date:invoice_date.value
            }
            delivery.value.invoices.push(invoice)
            invoiceFormModal.value = false
        }  
    }

    function appendDeliveryReceipt(){
        // if(delivery_receipt_no.value === '' | delivery_place.value === '' | delivery_date.value === ''){
        //     Notify.failure('Failed, Please Input Delivery Receipt Details Before Submitting')
        // }
        // else{
            var deliveryReceipt = {
                delivery_receipt_no : delivery_receipt_no.value,
                delivery_receipt_date : delivery_receipt_date.value,
                delivery_place : delivery_place.value,
                delivery_date : delivery_date.value
            }
            delivery.value.delivery_receipts.push(deliveryReceipt)
            deliveryReceiptFormModal.value = false
        // }
    }

    function appendDeliveryItem(){
        Loading.dots('Validating Item Details, Please Wait...',{
            clickToClose:false
        });
      
        axios.post('delivery/validate/items',{
           availability:availability.value.code,
           manufacturer:manufacturer.value,
           manufacturing_date:manufacturing_date.value,
           expiry_date:expiry_date.value,
           unit_cost:unit_cost.value,
           quantity:quantity.value,
           batch_lot_number:batch_lot_number.value,
           shelf_life:shelf_life.value,
           measurement_unit:measurement_unit.value.id,
           description:description.value
        })
        .then((response)=>{
            var item = {
                availability: availability.value.code,
                manufacturer: manufacturer.value,
                manufacturing_date: manufacturing_date.value,
                expiry_date: expiry_date.value,
                unit_cost: unit_cost.value,
                quantity: quantity.value,
                batch_lot_number: batch_lot_number.value,
                shelf_life: shelf_life.value,
                measurement_unit: measurement_unit.value.id,
                measurement_name: measurement_unit.value.name,
                description: description.value
            }
            delivery.value.items.push(item)
            Notify.success(`Success: ${response.data.message}`)
            Loading.remove()
            deliveryItemFormModal.value = false
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

    // clear functions for form after close
    function clearDeliveryInvoiceForm(){
        invoice_no.value = ''
        invoice_date.value = ''
    }

    function clearDeliveryReceiptForm(){
        delivery_receipt_no.value = ''
        delivery_receipt_date.value = ''
        delivery_place.value = ''
        delivery_date.value = ''
    }

    function clearDeliveryItemForm(){
        availability.value = ''
        manufacturer.value = ''
        manufacturing_date.value = ''
        expiry_date.value = ''
        unit_cost.value = ''
        quantity.value = ''
        batch_lot_number.value = ''
        shelf_life.value = ''
        measurement_unit.value = ''
        description.value = ''
    }

    // saving delivery
    function handleSaveDelivery(){
        Loading.dots('Attempting to Add Delivery Data to Database, Please Wait...',{
            clickToClose:false
        });

        axios.post('delivery/create',{
            fund_source:delivery.value.fund_source.id,
            req_office:delivery.value.req_office.section_id,
            end_user:delivery.value.end_user.user_id,
            payment_term:delivery.value.payment_term.code,
            completion:delivery.value.completion.code,
            entity_name:delivery.value.entity_name,
            purpose:delivery.value.porpuse,
            source_name:delivery.value.source_name,
            source_address:delivery.value.source_address,
            iar_no:delivery.value.iar_no,
            iar_date:delivery.value.iar_date,
            po_no:delivery.value.po_no,
            po_date:delivery.value.po_date,
            ptr_no:delivery.value.ptr_no,
            ptr_date:delivery.value.ptr_date,
            dnf_no:delivery.value.dnf_no,
            dnf_date:delivery.value.dnf_date,
            bl_no:delivery.value.bl_no,
            bl_date:delivery.value.bl_date,
            invoices:delivery.value.invoices,
            delivery_receipts:delivery.value.delivery_receipts,
            items:delivery.value.items
        })
        .then((response)=>{
            Report.success(
                'Success',
                'Delivery Data Has Been Saved',
                'Okay',
                () => {
                    router.push({name:'Delivery'})
                },
                {
                    fontFamily:'Lexend Deca'
                },
            );
        })
        .catch((error)=>{
            errors.value = error.response.data.errors
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

    // selections fetching function
    function getSelectionData(){
        Promise.all([
            fetchFundSources(),
            fetchOffices(),
            fetchMeasurements()
        ])
        .then(() => {
            Notify.success('Data Loaded Successfully')
            Loading.remove();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            Loading.remove();
        });
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
            selections.value.offices = response.data.offices
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
          
        })

    }

    function fetchMeasurements(){
        axios.get('measurement/selection',{
            params:{

            }
        })
        .then((response)=>{
            selections.value.measurements = response.data.measurements
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
            selections.value.fund_sources = response.data.fund_sources
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
        })

    }


</script>