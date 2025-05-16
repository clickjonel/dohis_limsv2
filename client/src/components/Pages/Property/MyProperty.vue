<template>
    <AuthenticatedPage pageTitle="Properties (as of January 2025)">
       <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

           <div class="w-full min-h-[10%] flex justify-between items-center border-b">
               <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                   <Input v-model="searchKeyword" type="text" label="Search Keyword" :errorMessage="''"/>
                   <Button @click="fetchProperties" text="Search" buttonType="default" icon="material-symbols:search" class="translate-y-2.5"/>
               </div>
               <div class="w-1/3 flex justify-center items-center gap-2 p-2 font-poppins">
                    <PrimevueButton @click="navigateToCreateRISPage" label="Create RIS" class="shadow-md shadow-slate-600" severity="primary"/>
                    <PrimevueButton @click="propertySelectionModal = true" label="Create ITR" class="shadow-md shadow-slate-600" severity="info"/>
                    <!-- <PrimevueButton  @click="propertySelectionModal = true" label="Create WMR" class="shadow-md shadow-slate-600" severity="warn"/> -->
               </div>

           </div>

           <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
               <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-amber-200 text-center pb-2 sticky top-0 text-black">
                   <span class="min-w-[10%]">Property #</span>
                   <span class="min-w-[30%] max-w-[30%]">Article</span>
                   <span class="min-w-[20%]">Cost</span>
                   <span class="min-w-[15%]">Acquisition Date</span>
                   <span class="min-w-[10%]">Status</span>
                   <span class="min-w-[15%]">Actions</span>
               </div>
               
               <div v-for="property in properties" v-bind:key="property.id" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400 text-black">
                   <span class="min-w-[10%]">{{ property.property_no }}</span>
                   <span class="min-w-[30%] max-w-[30%] text-xs">{{ property.particulars }}</span>
                   <span class="min-w-[20%] text-xs">{{ property.unit_cost }}</span>
                   <span class="min-w-[15%]">{{ property.user.issuance_date }}</span>
                   <span class="min-w-[10%]">{{ property.status }}</span>
                   <div class="min-w-[15%] flex flex-col justify-center items-start gap-1 text-xs">
                        <!-- <Tag severity="info" class="cursor-pointer">Transfer Property</Tag>
                        <Tag severity="info">Waste Property</Tag> -->
                   </div>
               </div>
           </div>

       </div>

       <Pagination v-model="pagination.page" :total="pagination.total" @fetchPage="fetchProperties"/>

   </AuthenticatedPage>

   <Dialog v-model:visible="propertySelectionModal" modal header="Select Property/ies" :style="{ width: '50%', height:'40%',  fontFamily: 'Lexend Deca' }" @hide="selectedProperties = []" :closeOnEscape="true" :dismissableMask="true" :showCloseIcon="true" :baseZIndex="10000" :appendTo="'self'">
       <div class="w-full flex flex-col justify-between items-start gap-4  p-4 text-black">
            <FloatLabel class="w-full" variant="on">
                <MultiSelect display="chip" size="small" v-model="selectedProperties" :options="propertySelection" optionLabel="particulars" optionValue="id" filter class="w-full" :overlayStyle="{ backgroundColor: 'lightgray',fontFamily:'Lexend Deca', width:'10rem' }"/>
                <label>Select Properties to include in ITR/WMR</label>
            </FloatLabel>
            <div class="w-full flex justify-end items-center gap-2 p-2 font-poppins">
                <PrimevueButton @click="navigateToCreateITRPage" label="Create ITR" class="shadow-md shadow-slate-600" severity="info"/>
                <!-- <PrimevueButton @click="navigateToCreateWMRPage" label="Create WMR" class="shadow-md shadow-slate-600" severity="warn"/> -->
            </div>
       </div>

       
   </Dialog>

</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import Input from '../../Form/Input.vue';
    import Button from '../../Button.vue';
    import axios from '../../../axios/axios';
    import Dialog from 'primevue/dialog';
    import { Notify,Loading, Report } from 'notiflix';
    import { useAuthStore } from '../../../stores/authStore';
    import PrimevueButton from 'primevue/button';
    import MultiSelect from 'primevue/multiselect';
    import FloatLabel from 'primevue/floatlabel';
    import useLoader from '../../../composables/notiflix_loading';
    import { showToast } from '../../../composables/notiflix';

    const router = useRouter();
    const properties = ref([]);
    const users = ref([]);
    const authStore = useAuthStore();

    const { showLoader,hideLoader } = useLoader()
    
    var propertySelectionModal = ref(false);
    var propertySelection = ref([]);

    var selectedProperties = ref([]);

    var pagination = ref({
        page:1,
        total:0
    })

    var searchKeyword = ref('');

    var errors = ref({})

   onMounted(() => {
        loadPageData()
   });

    async function loadPageData(){
        showLoader();

        await Promise.allSettled([
            fetchProperties(),
            fetchUserSelection(),
            fetchUserPropertySelection(),
        ]);
        hideLoader()
        showToast('success','Data fetched Successfully')
    }


    function fetchProperties(){
        axios.get('property/user',{
            params:{
                    page:pagination.value.page,
                    keyword:searchKeyword.value
            }
        })
        .then((response)=>{
            properties.value = response.data.properties
            pagination.value.total = response.data.total
            console.log(response.data)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
            console.log(error.response.data)
        })
        .finally(()=>{

        })
    }

    function fetchUserSelection(){
        axios.get('user/selection',{
            params:{
                
            }
        })
        .then((response)=>{
            users.value = response.data.users
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
        })
        .finally(()=>{
        
        })
    }
    
    function fetchUserPropertySelection(){
        axios.get('property/user/selection',{
            params:{
                   
            }
        })
        .then((response)=>{
            propertySelection.value = response.data.properties
            console.log(response.data)
        })
        .catch((error)=>{
            Notify.failure('Something Went Wrong, Try again or Contact System Admin.',() => {},{fontFamily:'Lexend Deca'})
            console.log(error.response.data)
        })
        .finally(()=>{
        
        })
    }

    function navigateToCreateITRPage(){
        if(selectedProperties.value.length > 0){
            router.push({
                name: 'Create ITR',
                query: {
                    selectedProperties: selectedProperties.value
                }
            });
        }
        else{
            Notify.failure('Please select at least one property.',() => {},{fontFamily:'Lexend Deca'})
        }
    }

    function navigateToCreateRISPage(){
        router.push({
                name: 'Create RIS',
            });
    }


</script>
