<template>

    <AuthenticatedPage>
         <div class="w-full min-h-[92%] flex flex-col justify-center items-center gap-4 font-lexend overflow-y-scroll p-4">
            <FloatLabel variant="on" class="w-full font-poppins mb-4">
                <InputText v-model="searchKeyword"  class="w-full" @change="fetchProperties"/>
                <label>Search Keyword</label>
            </FloatLabel>
            <FloatLabel variant="on" class="w-full font-poppins mb-4">
                <InputNumber v-model="category"  class="w-full" @input="setDefaultCategories"/>
                <label>Set Default for List</label>
            </FloatLabel>

            <div v-for="property in properties" class="w-full flex justify-center items-center gap-2">
                <FloatLabel variant="on" class="w-full font-poppins">
                    <InputText v-model="property.particulars"  class="w-full" @change="fetchProperties"/>
                    <label>{{ property }}</label>
                </FloatLabel>
                <FloatLabel class="w-[20%] font-poppins" variant="on">
                    <Select v-model="property.main_category_id" :options="categories" optionLabel="name"  optionValue="id" class="w-full" :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                    <label>Category</label>
                </FloatLabel>
                 <!-- <PrimevueButton @click="properties.splice(properties.indexOf(property),1)" label="Remove" severity="warn"/> -->
            </div>

            <PrimevueButton @click="update" label="Update" />
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
    import InputText from 'primevue/inputtext';
    import InputNumber from 'primevue/inputnumber';


    const route = useRoute()
    const router = useRouter()
    const { fetchRequest,postRequest } = useApi()
    const { categorySelection } = useSelection()

    const properties = ref([])
    const categories = ref([])

    var pagination = ref({
        page:1,
        total:0,
        perPage:100
    })

    var searchKeyword = ref('');
    var category = ref(0)

    onMounted(async () => {
        categories.value = await categorySelection()
        fetchProperties()
    })


    async function fetchProperties(){
        var response = await fetchRequest('properties/categorize',{
            page:pagination.value.page,
            keyword:searchKeyword.value,
            per_page:pagination.value.perPage
        })
        response.toast()
        if(response.data.properties){
            properties.value = response.data.properties
            console.log(response.data)
        }
    
    }

    async function update(){
        var response = await postRequest('properties/update/category',properties.value);
        response.toast();
        if(response.apiResponseStatus === 200){
            console.log(response.data)
        }
    }

    function setDefaultCategories(){
        properties.value.forEach(property => {
            property.main_category_id = category
        });
        // console.log('asd')
    }
 

 
 </script>