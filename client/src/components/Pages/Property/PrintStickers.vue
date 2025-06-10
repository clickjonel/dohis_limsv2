<template>

    <AuthenticatedPage>
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 overflow-y-scroll font-poppins p-4">
           
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
    
    const { fetchRequest } = useApi();
    const router = useRouter();

    // var selections = ref({
    //     measurements: [],
    //     end_users: [],
    //     categories:[]
    // });

    // var property = ref({
    //     status:'Active',
    //     remarks:''
    // })

    onMounted( async ()=>{
        // fetchMeasurements()
        // fetchUsers()
        // selections.value.categories = await categorySelection()
    })

    // async function fetchMeasurements(){
    //     var response = await fetchRequest('measurement/selection');
    //     response.toast();
    //     if(response.data.measurements){
    //         selections.value.measurements = response.data.measurements;
    //     }
    // }


 


 
 </script>