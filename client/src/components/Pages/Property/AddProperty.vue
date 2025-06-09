<template>

    <AuthenticatedPage>
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 overflow-y-scroll font-poppins p-4">
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="w-full text-left font-semibold text-3xl">Add a New Property</span>
                <div class="w-full flex justify-end items-center">
                    <PrimevueButton @click="createProperty" label="Create" severity="info"/>
                </div>
                <div class="w-full grid grid-cols-4 mt-4 gap-4">
                     <FloatLabel variant="on" class="w-full">
                        <InputText v-model="property.property_no" class="w-full"/>
                        <label>Property No.</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="property.particulars" class="w-full"/>
                        <label>Particulars</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <InputNumber v-model="property.unit_cost" :maxFractionDigits="5" class="w-full"/>
                        <label>Unit Cost</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <DatePicker v-model="property.acquisition_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Acquisition Date</label>
                    </FloatLabel>
                </div>
                <div class="w-full grid grid-cols-3 mt-4 gap-4">
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="property.measurement_unit" :options="selections.measurements" optionLabel="name"  optionValue="id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Measurement Unit</label>
                    </FloatLabel>
                     <FloatLabel class="w-full" variant="on">
                        <Select v-model="property.end_user" :options="selections.users" optionLabel="full_name"  optionValue="user_id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>End User</label>
                    </FloatLabel>
                    <FloatLabel variant="on" class="w-full">
                        <InputText v-model="property.status" disabled class="w-full"/>
                        <label>Status</label>
                    </FloatLabel>
                    <FloatLabel class="w-full" variant="on">
                        <Select v-model="property.main_category_id" :options="selections.categories" optionLabel="name"  optionValue="id" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                        <label>Category</label>
                    </FloatLabel>
                </div>
                
            </div>
         </div>
    </AuthenticatedPage>

 </template>
 
 <script setup> 
    import { ref,onMounted } from 'vue';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import InputNumber from 'primevue/inputnumber';
    import Select from 'primevue/select';
    import { useRouter } from 'vue-router';
    import useApi from '../../../composables/api_calls';
    import DatePicker from 'primevue/datepicker';
    import PrimevueButton from 'primevue/button';
    import useSelection from '../../../composables/selections';
    
    const { fetchRequest,postRequest } = useApi();
    const { categorySelection } = useSelection()
    const router = useRouter();

    var selections = ref({
        measurements: [],
        end_users: [],
        categories:[]
    });

    var property = ref({
        status:'Active',
        remarks:''
    })

    onMounted( async ()=>{
        fetchMeasurements()
        fetchUsers()
        selections.value.categories = await categorySelection()
    })

    async function fetchMeasurements(){
        var response = await fetchRequest('measurement/selection');
        response.toast();
        if(response.data.measurements){
            selections.value.measurements = response.data.measurements;
        }
    }

    async function fetchUsers(){
        var response = await fetchRequest('user/selection');
        response.toast();
        if(response.data.users){
            selections.value.users = response.data.users;
        }
    }

    async function createProperty(){
        var response = await postRequest('properties/create',property.value);
        response.toast();
        console.log(response);
        if(response.apiResponseStatus === 201){
            router.push({path:'/properties'});
        }
    }

 


 
 </script>