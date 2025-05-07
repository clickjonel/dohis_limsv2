<template>

    <Dialog v-model:visible="visible" modal header="Select Office/s" :style="{ width: '70%', height:'40%',  fontFamily: 'Lexend Deca' }" :closeOnEscape="true"  :showCloseIcon="true">
       <div class="w-full flex flex-col justify-start items-center p-4">
            <FloatLabel class="w-full" variant="on">
                <MultiSelect display="chip" size="small" v-model="selectedOffices" :options="officeSelection" optionLabel="section_name" filter class="w-full" :overlayStyle="{ backgroundColor: 'lightgray',fontFamily:'Lexend Deca', width:'10rem' }"/>
                <label>Select Offices</label>
            </FloatLabel>
       </div>
       <div v-if="selectedOffices.length > 0" class="w-full flex flex-col justify-start items-center gap-1">
            <span class="w-full text-left font-semibold px-2 uppercase">Selected Offices</span>
            <div v-for="office in selectedOffices" :key="office.id" class="w-full flex justify-start items-center gap-2 p-2 font-poppins border-y bg-gray-200 shadow-md shadow-slate-600">
                <span class="text-sm text-gray-600">{{ office.section_name }}</span>
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
    import axios from '../../axios/axios.js';
    import { Block } from 'notiflix/build/notiflix-block-aio';

    var visible = defineModel('visible')
    var selectedOffices = defineModel()

    var officeSelection = ref([])

    onMounted(() => {
        fetchOffices()
    });

    function fetchOffices(){
        axios.get('office/selection',{
            params:{}
        })
        .then((response)=>{
            officeSelection.value = response.data.offices
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Contact System Administrator')
            console.log( error.response )
        })
        .finally(()=>{
          
        })
    }

</script>