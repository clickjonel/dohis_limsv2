<template>
    <div class="w-full flex flex-col justify-start items-start">
        <div class="w-full flex justify-between items-start gap-4 my-2 px-2">
            <div class="flex justify-start items-start gap-2">
                <FloatLabel variant="on">
                    <InputText v-model="property_no" />
                    <label>Property No.</label>
                </FloatLabel>
                <PrimevueButton @click="fetchProperty" label="Add Property"/>
            </div>
             <PrimevueButton @click="emitSubmit" severity="info" label="Submit Selected"/>
        </div>
       <div class="w-full flex flex-col justify-start items-start divide-y border-y">
            <div v-for="property in selectedProperties" class="w-full flex flex-col justify-start items-center bg-gray-200 p-2 font-light text-sm font-lexend">
                <span class="w-full font-bold uppercase">{{ property.property_no }}</span>
                <span class="w-full font-lexend text-sm">{{ property.particulars }}</span>
            </div>
       </div>
       
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import InputText from 'primevue/inputtext';
    import FloatLabel from 'primevue/floatlabel';
    import { Notify,Loading, Report } from 'notiflix';
    import axios from '../../axios/axios';
    import PrimevueButton from 'primevue/button';

    const emit = defineEmits(['submit'])

    // var properties = ref([])
    var selectedProperties = ref([])

    var pagination = ref({
        page:1,
        total:0
    })
    var property_no = ref('');

    onMounted(() => {
        
    });

    function fetchProperty(){
        Loading.dots('Loading Data, Please Wait...',{
            clickToClose:false,
            fontFamily:'Lexend Deca'
        });
        
        axios.get('/property/find/property_number',{
            params:{
                property_no:property_no.value
            }
        })
        .then((response)=>{
           pushProperty(response.data.property)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',{fontFamily:'Lexend Deca',timeout:1000})
            console.log(error)
        })
        .finally(()=>{
            Loading.remove()
        })
    }

    function emitSubmit(){
        if(selectedProperties.value.length > 0){
            emit('submit',selectedProperties.value)
        }
        else{
            Notify.failure('No properties selected',{fontFamily:'Lexend Deca',timeout:2000})
        }

    }

    function pushProperty(property){
        var duplicate = selectedProperties.value.some(selectedProperty => selectedProperty.property_no === property.property_no)
        if(property === null){
            Notify.failure('Property number not found, try again',{fontFamily:'Lexend Deca',timeout:2000})
        }
        else{
            if(duplicate){
                Notify.failure('Property Already added to list, No duplicates allowed',{fontFamily:'Lexend Deca',timeout:2000})
            }
            else{
                selectedProperties.value.push(property)
                Notify.success('Added to Selected Properties',{fontFamily:'Lexend Deca',timeout:2000})
                property_no.value = ''
            }
        }
    }

</script>