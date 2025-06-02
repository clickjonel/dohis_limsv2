<template>

    <AuthenticatedPage>
         <div class="w-full flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll">
 
            <div class="w-full flex justify-end items-center p-2">
                <PrimevueButton label="Create Request" severity="info"/>
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-4 p-2">
                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="requestObject.property_no"  class="w-full" @change="fetchProperty"/>
                    <label>Property No</label>
                </FloatLabel>

                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="requestObject.equipment"  class="w-full" disabled/>
                    <label>Equipment</label>
                </FloatLabel>

                <FloatLabel variant="on" class="w-full">
                    <InputText v-model="requestObject.model"  class="w-full"/>
                    <label>Model</label>
                </FloatLabel>

                <FloatLabel variant="on" class="w-full">
                    <InputNumber v-model="requestObject.unit_cost"  :minFractionDigits="2" class="w-full" disabled/>
                    <label>Acquisition Cost</label>
                </FloatLabel>

                <FloatLabel class="w-full" variant="on">
                    <Select v-model="requestObject.equipment_type" :options="
                        [
                            {
                                name:'ICT Equipments',
                                code:'ICT'
                            },
                            {
                                name:'Other Equipments',
                                code:'OTHER'
                            }
                        ]" 
                    optionLabel="name"  optionValue="name" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Equipment Type</label>
                </FloatLabel>

                <FloatLabel variant="on" class="w-full">
                    <DatePicker v-model="requestObject.date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Date Prepared</label>
                </FloatLabel>
                <FloatLabel variant="on" class="w-full">
                    <DatePicker v-model="requestObject.acquisition_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}" disabled/>
                    <label>Date of Acquisition</label>
                </FloatLabel>
                
                <Editor v-model="requestObject.defects" class="w-full" editorStyle="height:220px" placeholder="Enter Defects"/>

            </div>
         </div>
    </AuthenticatedPage>
 
 
 
 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Select from 'primevue/select';
    import axios from '../../../axios/axios';
    import { useRouter,useRoute } from 'vue-router';
    import PrimevueButton from 'primevue/button';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import Textarea from 'primevue/textarea';
    import InputNumber from 'primevue/inputnumber';
    import DatePicker from 'primevue/datepicker';
    import useApi from '../../../composables/api_calls';
    import Editor from 'primevue/editor';
    import { showToast } from '../../../composables/notiflix';

 
    const router = useRouter();
    const route = useRoute();
    const { fetchRequest, postRequest } = useApi();
     
    const selections = ref({})

    var requestObject = ref({
        transaction:{}
    })

 
     onMounted(()=>{
        // fetchFundSources()
        // fetchOffices()
        // fetchMeasurements()
        // fetchWarehouses()
        // fetchCategories()
     })

    async function fetchProperty(){
       if(requestObject.value.property_no !== ''){
            var response = await fetchRequest('properties/find/pn',{property_no:requestObject.value.property_no})
            if(response.apiResponseStatus === 200 && response.data.property){
                requestObject.value.equipment = response.data.property.equipment;
                requestObject.value.acquisition_date = response.data.property.user.issuance_date;
                requestObject.value.unit_cost = response.data.property.unit_cost;
                console.log(response.data.property)
            }
            else{
                showToast('failure','The property number you entered does not exist.');
            }
       }
    
    }

    // async function save(){
    //     var response = await postRequest('stocks/create',stockObject.value);
    //     response.toast();
    //     if(response.apiResponseStatus === 200){
    //         router.push({path:'/stocks'});
    //     }
    // }

 </script>