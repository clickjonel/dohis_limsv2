<template>

    <AuthenticatedPage>
        <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll p-4 print:hidden">
            <FloatLabel variant="on" class="w-full">
                <AutoComplete v-model="selectedProperties" :suggestions="propertySuggestions" :optionLabel="'property_no'" :optionValue="'id'" @complete="searchProperty" multiple class="w-full" :overlayStyle="{fontFamily:'Poppins'}"/>
                <label>Search Property Number</label>
            </FloatLabel>

            <FloatLabel class="w-full" variant="on">
                <Select v-model="options.sticker_type" :options="[{name:'Small Sticker'},{name:'Large Sticker'}]" optionLabel="name" optionValue="name" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                <label>Select Sticker Type</label>
            </FloatLabel>
<!-- 
            <FloatLabel class="w-full" variant="on">
                <InputText v-model="options.coa_representative" class="w-full"/>
                <label>COA Representative</label>
            </FloatLabel> -->

            <FloatLabel class="w-full" variant="on">
                <DatePicker v-model="options.date_counted" class="w-full" dateFormat="dd/mm/yy"/>
                <label>Date Counted</label>
            </FloatLabel>
        </div>

        <div class="w-full flex justify-start items-start p-4 print:hidden">
            <PrimevueButton v-if="selectedProperties.length > 0" label="Print" severity="info" @click="print"/>
        </div>

        <div v-if="options.sticker_type === 'Large Sticker'" class="w-full grid grid-cols-2 gap-6 p-4 font-poppins">
            <div v-for="property in selectedProperties" class="w-full flex flex-col justify-start items-start gap-2 p-2 text-xs border">
                <div class="w-full flex justify-center items-center gap-2 border-b pb-1">
                    <div class="w-full flex flex-col justify-start items-start text-base font-bold">
                        <span>Government Property</span>
                        <span>CHD-CAR, Baguio City</span>
                    </div>
                    <div class="w-full flex justify-end items-center">
                        <QrcodeVue :value="'asdasd'" :size="50" class=""/>
                    </div>
                </div>
                <span>Article: {{ property.particulars }}</span>
                <span>Serial Number: {{ property.serial_number }}</span>
                <span>Date Acquired: {{ property.user.issuance_date }}</span>
                <span>Acquisition Cost: {{ property.unit_cost }}</span>
                <span>End User/MR to: {{ property.user.full_name }}</span>
                <span>Date Counted: {{ options.date_counted ?  new Date(options.date_counted).toLocaleDateString() : ''}}</span>
                <span>Inventory Conducted By: Shayne</span>
                
                <div class="w-full flex justify-center items-center">
                    <span class="w-[90%] text-center mt-2 px-4 py-2 font-bold border rounded-lg uppercase">Tampering this sticker is punishable by law</span>
                </div>
            </div>
        </div>

        <div v-if="options.sticker_type === 'Small Sticker'" class="w-full grid grid-cols-4 gap-4 p-4">
            <div v-for="property in selectedProperties" class="w-full flex flex-col justify-start items-start gap-2 border p-2 font-poppins text-xs">
                <div class="w-full flex justify-between items-center">
                    <img src="../../../assets/doh_logo.png" alt="asd" class="size-[50px]">
                    <QrcodeVue :value="'asdasd'" :size="50" class=""/>
                </div>
                <span class="w-full border-b"></span>
                <span>PN: {{ property.property_no }}</span>
                <span>EU: {{ property.user.full_name }}</span>
                <span>DA: {{ property.user.issuance_date }}</span>
                <span>UC: Shayne</span>
            </div>
        </div>

    </AuthenticatedPage>

 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Select from 'primevue/select';
    import { useRouter,useRoute } from 'vue-router';
    import FloatLabel from 'primevue/floatlabel';
    import useSelection from '../../../composables/selections';
    import AutoComplete from 'primevue/autocomplete';
    import useApi from '../../../composables/api_calls';
    import PrimevueButton from 'primevue/button';
    import DatePicker from 'primevue/datepicker';
    import QrcodeVue from 'qrcode.vue'
    import InputText from 'primevue/inputtext';

    const route = useRoute()
    const router = useRouter()
    const { fetchRequest,postRequest } = useApi()
    const { userSelection } = useSelection()
    
    var selectedProperties = ref([])
    var propertySuggestions = ref([])

    var options = ref({})

    onMounted( async ()=>{

    })

    async function searchProperty(event){
        var response = await fetchRequest('properties/find/autocomplete_search',{keyword:event.query},false)
        if(response.apiResponseStatus === 200 && response.data.properties){
            propertySuggestions.value = response.data.properties 
            console.log(propertySuggestions.value)
        }
    }

    function print(){
        window.print()
    }


 


 
 </script>