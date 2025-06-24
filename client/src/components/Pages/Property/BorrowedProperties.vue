<template>
    <AuthenticatedPage pageTitle="Properties">
        <div class="w-full min-h-[85%] flex flex-col justify-start items-center gap-4">

            <div class="w-full min-h-[10%] flex justify-between items-center border-b">
                <div class="w-1/3 flex justify-start items-center gap-2 p-2">
                    <FloatLabel variant="on" class="w-full font-poppins">
                        <InputText v-model="searchKeyword"  class="w-full"/>
                        <label>Search Keyword.</label>
                    </FloatLabel>
                </div>
                

                <div class="flex justify-start items-center gap-2 p-2">
                    <PrimevueButton @click="modals.borrow.show = true" label="Add Borrower" severity="info" :style="{fontFamily:'Poppins'}"/>
                </div>
            </div>

            <div class="w-full flex flex-col justify-start items-center overflow-auto px-2">
                <div class="w-full flex justify-start items-center border-y-2 font-lexend uppercase bg-emerald-600 text-center pb-2 sticky top-0 font-medium">
                    <span class="min-w-[10%]">Property #</span>
                    <span class="min-w-[50%]">Article</span>
                    <span class="min-w-[10%]">Date Borrowed</span>
                    <span class="min-w-[20%]">Borrower</span>
                    <span class="min-w-[10%]">Actions</span>
                </div>
                
                <div v-for="borrower in borrowers" class="w-full flex justify-start items-center border-b font-poppins text-center py-2 font-light text-sm bg-white/50 hover:bg-emerald-400">
                    <span class="min-w-[10%]">{{ borrower.property_no }}</span>
                    <span class="min-w-[50%]">{{ borrower.item }}</span>
                    <span class="min-w-[10%]">{{ borrower.borrow_date }}</span>
                    <span class="min-w-[20%]">{{ borrower.borrower.full_name }}</span>
                    <span class="min-w-[10%]">
                        <Badge @click="(modals.return.fields.id = borrower.id,modals.return.show = true)" value="Returned" severity="info" class="text-xs shadow-md shadow-slate-600 cursor-pointer"/>
                    </span>
                </div>

                <div v-if="borrowers.length===0" class="w-full h-[600px] flex justify-center items-center">
                    <span class="font-medium font-lexend animate-bounce">No Borrowed Properties</span>
                </div>
            </div>

        </div>

    </AuthenticatedPage>

        <Dialog v-model:visible="modals.borrow.show" modal header="Add Borrowed Property" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
            <div class="w-full flex flex-col justify-between items-start gap-4 p-4 text-black border-y">
                <div class="w-full flex flex-col justify-start items-start gap-4">
                    <div class="w-full flex justify-start items-start gap-2 mt-4">
                        <FloatLabel variant="on" class="w-1/3">
                           <InputText v-model="modals.borrow.fields.property_no" class="w-full"/>
                            <label>Property Number</label>
                        </FloatLabel>
                        <FloatLabel variant="on" class="w-full">
                           <InputText v-model="modals.borrow.fields.item" class="w-full"/>
                            <label>Item</label>
                        </FloatLabel>
                    </div>
                    <div class="w-full flex justify-start items-start gap-2">
                        <FloatLabel class="w-full" variant="on">
                            <Select v-model="modals.borrow.fields.borrower_id" :options="users" optionLabel="full_name" optionValue="user_id" class="w-full" filter :overlayStyle="{fontFamily:'Lexend Deca'}"/>
                            <label>Select Borrower</label>
                        </FloatLabel>
                        <FloatLabel variant="on" class="w-full">
                            <DatePicker v-model="modals.borrow.fields.borrow_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}" dateFormat="dd/mm/yy"/>
                            <label>Borrow Date</label>
                        </FloatLabel>
                    </div>
                    <PrimevueButton @click="saveBorrower" label="Save Borrower" severity="info" class="w-full mt-4 shadow-md shadow-slate-600"/>
                </div>
            </div>
        </Dialog>

        <Dialog v-model:visible="modals.return.show" modal header="Add Borrowed Property" :style="{ width: '90%',  fontFamily: 'Lexend Deca' }">
            <div class="w-full flex flex-col justify-between items-start gap-4 p-4 text-black border-y">
                <div class="w-full flex flex-col justify-start items-start gap-4">
                     <FloatLabel variant="on" class="w-full">
                        <DatePicker v-model="modals.return.fields.return_date" showIcon class="w-full" :panelStyle="{fontFamily:'Lexend Deca'}" dateFormat="dd/mm/yy"/>
                        <label>Return Date</label>
                    </FloatLabel>
                    <PrimevueButton @click="returnBorrowed" label="Returned" severity="info" class="w-full mt-4 shadow-md shadow-slate-600"/>
                </div>
            </div>
        </Dialog>



</template>

<script setup>
    import { ref,onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import AuthenticatedPage from '../../PageLayouts/AuthenticatedPage.vue';
    import Pagination from '../../Pagination.vue';
    import FloatLabel from 'primevue/floatlabel';
    import InputText from 'primevue/inputtext';
    import useApi from '../../../composables/api_calls';
    import PrimevueButton from 'primevue/button';
    import { useAuthStore } from '../../../stores/authStore';
    import Badge from 'primevue/badge';
    import { Icon } from '@iconify/vue/dist/iconify.js';
    import Dialog from 'primevue/dialog';
    import DatePicker from 'primevue/datepicker';
    import Select from 'primevue/select';
    import Textarea from 'primevue/textarea';
    import { showToast } from '../../../composables/notiflix';
    import AutoComplete from 'primevue/autocomplete';
    import useSelection from '../../../composables/selections';

    const router = useRouter();
    const borrowers = ref([]);
    const { fetchRequest,postRequest } = useApi();
    const { userSelection } = useSelection();
    const store = useAuthStore();
    const users = ref([]);

    var pagination = ref({
        page:1,
        total:0,
        perPage:15
    })

    var searchKeyword = ref('');
    
    var modals = ref({
        borrow:{
            show:false,
            fields:{},
            suggestions:[],
            property_no:''
        },
        return:{
            show:false,
            fields:{}
        }
    })

    onMounted( async () => {
        users.value = await userSelection()
        fetchBorrowers()
    })

    async function fetchBorrowers(){
        var response = await fetchRequest('borrowers/list',{})
        response.toast()
        if(response.data.borrowers){
            borrowers.value = response.data.borrowers
            console.log(borrowers.value)
        }
    
    }

    async function saveBorrower(){
        var response = await postRequest('borrowers/create',modals.value.borrow.fields)
        response.toast()
        if(response.apiResponseStatus === 200){
            modals.value.borrow.fields = {}
            modals.value.borrow.show = false
            fetchBorrowers()
        }
    }

    async function returnBorrowed(){
        var response = await postRequest('borrowers/return',modals.value.return.fields)
        response.toast()
        if(response.apiResponseStatus === 200){
            modals.value.return.show = false
            fetchBorrowers()
        }
    }

    async function searchProperty(event){
        var response = await fetchRequest('properties/find/autocomplete_search',{keyword:event.query},false)
        if(response.apiResponseStatus === 200 && response.data.properties){
            modals.value.borrow.suggestions = response.data.properties 
        }
    }

</script>