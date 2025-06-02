<template>

    <AuthenticatedPage>
         <div class="w-full min-h-[92%] flex flex-col justify-start items-center gap-4 font-lexend overflow-y-scroll p-4">
              <FloatLabel class="w-full" variant="on">
                  <Select v-model="selected.user" :options="users" :invalid="errors.user" optionLabel="full_name" optionValue="user_id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                  <label>Select User to Transfer To</label>
              </FloatLabel>

              <FloatLabel variant="on" class="w-full">
                  <AutoComplete v-model="selected.properties" :suggestions="suggestions.properties" :optionLabel="'property_no'" :optionValue="'id'" :invalid="errors.properties" @complete="searchProperty" multiple class="w-full" :overlayStyle="{fontFamily:'Poppins'}"/>
                  <label>Search Property Number</label>
              </FloatLabel>
              <FloatLabel variant="on" class="w-full">
                  <DatePicker v-model="selected.date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}"/>
                  <label>Date</label>
              </FloatLabel>
         </div>
         <div class="w-full flex justify-start items-start p-4">
              <PrimevueButton v-if="selected.properties.length > 0" @click="transfer" label="Transfer" severity="info"/>
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


    const route = useRoute()
    const router = useRouter()
    const { fetchRequest,postRequest } = useApi()
    const { userSelection } = useSelection()
    const users = ref([])

    var selected = ref({
      properties:[],
      user:0,
      date:''
    })

    var suggestions = ref({
        properties: []
    })

    var errors = ref({})

     onMounted( async () => {
       users.value = await userSelection({employee_status_id:1})
     })

    async function searchProperty(event){
        var response = await fetchRequest('properties/find/autocomplete_search',{keyword:event.query},false)
        if(response.apiResponseStatus === 200 && response.data.properties){
            suggestions.value.properties = response.data.properties 
        }
    }

    async function transfer(){
      var response = await postRequest('properties/transfer', {
        transfer_to: selected.value.user,
        transfer_date: selected.value.date,
        properties: selected.value.properties
      }, true)
      
      response.toast()
      
      if(response.apiResponseStatus === 200){
          selected.value = {
              properties:[],
              user:0,
              date:''
          }
          suggestions.value.properties = []
      }
    }
 

 
 </script>