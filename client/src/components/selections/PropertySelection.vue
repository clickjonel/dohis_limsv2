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
    import PrimevueButton from 'primevue/button';
    import useApi from '../../composables/api_calls';
    import { showToast } from '../../composables/notiflix';


    const emit = defineEmits(['submit'])
    const { fetchRequest } = useApi()

    var selectedProperties = ref([])
    var property_no = ref('');

    onMounted(() => {
        
    })

    async function fetchProperty(){
        if(property_no.value !== ''){
            var response = await fetchRequest('property/find/property_number',{property_no:property_no.value})
            if(response.data.data !== null){
                pushProperty(response.data.property)
                
            }
        }
        else{
            showToast('failure','Property Number Required')
        }
    }

    function emitSubmit(){
        if(selectedProperties.value.length > 0){
            emit('submit',selectedProperties.value)
        }
        else{
            showToast('failure','No properties selected')
        }

    }

    function pushProperty(property){
        var duplicate = selectedProperties.value.some(selectedProperty => selectedProperty.property_no === property.property_no)
        if(property === null){
            showToast('failure','Property number not found, try again')
        }
        else{
            if(duplicate){
                showToast('failure','Property Already added to list, No duplicates allowed')
            }
            else{
                selectedProperties.value.push(property)
                showToast('success','Added to Selected Properties')
                property_no.value = ''
            }
        }
    }

</script>