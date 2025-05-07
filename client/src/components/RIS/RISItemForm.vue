<template>

    <Dialog v-model:visible="visible" modal header="Input Item to Request" :style="{ width: '80%',   fontFamily: 'Lexend Deca' }" :closeOnEscape="true"  :showCloseIcon="true" @hide="item = { description:'', measurement_unit:'', batch_lot_no:'', expiry_date:'', quantity:0 }">
        <div class="w-full flex flex-col justify-start items-start gap-4 p-4 text-black font-lexend">

            <span class="w-full text-2xl uppercase text-center font-noto font-black">Input Item to Request</span>
            <span class="w-full text-sm font-poppins">Please fill in the details of the item you want to request.</span>

        </div>
       <div class="w-full flex flex-col justify-between items-center p-4 gap-4">

            <div class="w-full flex flex-col justify-start items-start gap-2">
                <div class="w-full flex justify-start items-start gap-4">
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="item.description"  class="w-full"/>
                        <label>Item Description</label>
                    </FloatLabel>
                </div>
                <div class="w-full flex justify-start items-start gap-4 mt-2">
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="item.batch_lot_no"  class="w-full"/>
                        <label>Batch/Lot Number</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <DatePicker v-model="item.expiry_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Expiry Date</label>
                    </FloatLabel>
                </div>
                <div class="w-full flex justify-start items-start gap-4 mt-2">
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="item.measurement_unit" :options="measurements" optionLabel="name"  optionValue="name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Measurement Unit</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <InputNumber v-model="item.quantity" class="w-full"/>
                        <label>Quantity to Request</label>
                    </FloatLabel>
                </div>
            </div>

            <div class="w-full flex justify-end items-center">
                <PrimevueButton @click="validateForm" label="Submit" class="shadow-md shadow-slate-600" severity="success"/>
            </div>

       </div>
    </Dialog>

</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import Dialog from 'primevue/dialog';
    import PrimevueButton from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import axios from '../../axios/axios.js';
    import { Notify,Loading } from 'notiflix';
    import Select from 'primevue/select';
    import DatePicker from 'primevue/datepicker';
    import InputNumber from 'primevue/inputnumber';

    var visible = defineModel('visible')

    var measurements = ref([])

    var item = ref({
        description:'',
        measurement_unit:'',
        batch_lot_no:'',
        expiry_date:'',
        quantity:0
    })

    var errors = ref({
        description:'Description Field is required',
        measurement_unit:'Measurement Field is required',
        batch_lot_no:'Batch/Lot Number Field is required',
        expiry_date:'Expiry Date Field is required',
        quantity:'Quantity Field is required and Should be greater than 0'
    })

    const emits = defineEmits(['submit'])

    onMounted(() => {
        fetchMeasurements()
    });

    function fetchMeasurements(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });

        axios.get('measurement/selection',{
            params:{}
        })
        .then((response)=>{
            measurements.value = response.data.measurements
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function validateForm(){
        var isValid = true;
        const errorMessages = [];

        // Validate required fields
        if (item.value.description == null || item.value.description == '') {
            isValid = false;
            errorMessages.push(errors.value.description);
        }

        if (item.value.measurement_unit == null || item.value.measurement_unit == '') {
            isValid = false;
            errorMessages.push(errors.value.measurement_unit);
        }

        if (item.value.quantity == null || item.value.quantity == '' || isNaN(Number(item.value.quantity))) {
            isValid = false;
            errorMessages.push(errors.value.quantity);
        }

        if (isValid) {
            emits('submit', item.value);
            visible.value = false;
            Notify.success('Added to list', () => {}, { fontFamily: 'Lexend Deca' });
        } else {
            errorMessages.forEach(error => {
                Notify.failure(error, () => {}, { fontFamily: 'Lexend Deca' });
            });
        }
    }
  

</script>