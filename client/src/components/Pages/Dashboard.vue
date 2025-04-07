<template>
    <AuthenticatedPage :pageTitle="`${store.user.nickname}'s Dashboard`">
      <div class="w-full flex flex-col min-h-[94%] h-[94%] justify-start items-start font-lexend gap-4 text-black">
        <div class="w-full min-h-[95%] flex justify-start items-start gap-4 text-black">
          <div class="w-1/3 h-full flex flex-col justify-start items-start gap-4 p-2 overflow-scroll">
            <div @click="switchTabs('items')" class="w-full min-h-[250px] max-h-[250px] flex flex-col justify-between items-center p-2 bg-white shadow-xl cursor-pointer">
              <span class="py-1 px-2 bg-gray-300 rounded-full text-base uppercase font-black font-lexend text-emerald-900">Deliveries</span>
              <span class="text-[100px] font-bold animate-bounce">{{ deliveryData.total }}</span>
              <div class="w-full flex justify-between items-center gap-2 divide-x font-lexend text-base uppercase">
                <div class="w-1/2 flex flex-col justify-center items-center">
                  <span class="font-semibold uppercase">Charged</span>
                  <span>{{ deliveryData.charge }}</span>
                </div>
                <div class="w-1/2 flex flex-col justify-center items-center">
                  <span class="font-semibold uppercase">Donation</span>
                  <span>{{ deliveryData.donation }}</span>
                </div>
              </div>
            </div>
  
            <div @click="switchTabs('stockCards')" class="w-full min-h-[250px] max-h-[250px] flex flex-col justify-between items-center p-2 bg-white shadow-xl cursor-pointer">
              <span class="py-1 px-2 bg-gray-300 rounded-full text-base uppercase font-black font-lexend text-emerald-900">Stock Cards</span>
              <span class="text-[100px] font-bold animate-bounce">{{ stockCardData.total }}</span>
            </div>
  
            <div @click="switchTabs('properties')" class="w-full min-h-[250px] max-h-[250px] flex flex-col justify-between items-center p-2 bg-white shadow-xl cursor-pointer">
              <span class="py-1 px-2 bg-gray-300 rounded-full text-base uppercase font-black font-lexend text-emerald-900">Properties(MR)</span>
              <span class="text-[100px] font-bold animate-bounce">{{ propertyData.total }}</span>
            </div>
          </div>
  
          <div v-if="tabs.charts" class="w-2/3 h-[100%] flex flex-col justify-start items-start gap-4 bg-white shadow-xl overflow-y-scroll px-2 pb-2 divide-y">
            <VueApexCharts
              width="1000"
              height="400"
              type="bar"
              :options="barDeliveryOptions"
              :series="barDeliverySeries"
              class="pt-4 flex justify-center items-center pr-4"
            ></VueApexCharts>
  
            <div class="w-full flex h-full justify-between items-center gap-2">
              <div class="w-1/2 h-full flex justify-center items-center border-r">
                <apexchart
                  type="pie"
                  width="400"
                  :options="pieStockCardOptions"
                  :series="pieStockCardSeries"
                ></apexchart>
              </div>
              <div class="w-1/2 h-full flex justify-center items-center border-l">
                <apexchart
                  type="pie"
                  width="400"
                  :options="piePropertyOptions"
                  :series="piePropertySeries"
                ></apexchart>
              </div>
            </div>
          </div>

          <div v-if="tabs.items" class="w-2/3 h-[100%] flex flex-col justify-start items-start gap-4 bg-white shadow-xl overflow-y-scroll px-2 pb-2 divide-y p-2">
                <div class="w-full flex justify-between items-center border-b p-2">
                    <span class="font-semibold font-noto uppercase">Your Delivered items</span>
                    <span @click="switchTabs('charts')" class="font-lexend bg-blue-900 px-2 rounded-full text-white cursor-pointer">View Chart</span>
                </div>
                <div class="w-full flex justify-start items-center gap-2 uppercase font-noto bg-amber-300 border-y">
                    <span class="w-1/4 px-1">Supplier</span>
                    <span class="w-1/4 px-1">Delivery Date/s</span>
                    <span class="w-1/4 px-1">Delivery Place/s</span>
                    <span class="w-1/4 px-1">Items</span>
                </div>
                <div class="w-full flex flex-col justify-start items-start">
                    <div v-for="delivery in deliveryList" class="w-full flex justify-start items-start gap-2 uppercase font-lexend text-xs font-light hover:bg-emerald-900 hover:text-white p-2 border-b">
                        <span class="w-1/4 p-1">{{ delivery.source }}</span>
                        <span class="w-1/4 p-1 flex flex-col justify-start items-start">
                            <span v-for="receipt in delivery.receipts">{{ receipt.delivery_date }}</span>
                        </span>
                        <span class="w-1/4 p-1 flex flex-col justify-start items-start">
                            <span v-for="receipt in delivery.receipts">{{ receipt.delivery_place }}</span>
                        </span>
                        <span class="w-1/4 flex justify-start items-center p-1">
                            <span @click="showDeliveryItemsModal(delivery.items)" class="bg-blue-900 text-white cursor-pointer px-2 rounded-full" title="Show Items for this Delivery">Items</span>
                        </span>
                    </div>
                </div>
          </div>

            <div v-if="tabs.stockCards" class="w-2/3 h-[100%] flex flex-col justify-start items-start gap-4 bg-white shadow-xl overflow-y-scroll px-2 pb-2 divide-y p-2">
                <div class="w-full flex justify-between items-center border-b p-2">
                    <span class="font-semibold font-noto uppercase">Your Section's Allocations</span>
                    <span @click="switchTabs('charts')" class="font-lexend bg-blue-900 px-2 rounded-full text-white cursor-pointer">View Chart</span>
                </div>
                <div class="w-full flex justify-start items-center gap-2 uppercase font-noto bg-amber-300 border-y">
                    <span class="w-1/4 px-1">Stock Number</span>
                    <span class="w-1/4 px-1">Stock Name</span>
                    <span class="w-1/4 px-1">Status</span>
                    <span class="w-1/4 px-1">Transaction/s</span>
                </div>
                <div class="w-full flex flex-col justify-start items-start">
                    <div v-for="stockCard in stockCardList" class="w-full flex justify-start items-start gap-2 uppercase font-lexend text-xs font-light hover:bg-emerald-900 hover:text-white p-2 border-b">
                        <span class="w-1/4 p-1">{{ stockCard.stock_no }}</span>
                        <span class="w-1/4 p-1">{{ stockCard.stock_name }}</span>
                        <span class="w-1/4 p-1">{{ stockCard.status }}</span>
                        <span class="w-1/4 flex justify-start items-center p-1">
                            <span @click="showStockCardTransactionsModal(stockCard.transactions)" class="bg-blue-900 text-white cursor-pointer px-2 rounded-full" title="Show Items for this Delivery">Transactions</span>
                        </span>
                    </div>
                </div>
            </div>

            <div v-if="tabs.properties" class="w-2/3 h-[100%] flex flex-col justify-start items-start gap-4 bg-white shadow-xl overflow-y-scroll px-2 pb-2 divide-y p-2">
                <div class="w-full flex justify-between items-center border-b p-2">
                    <span class="font-semibold font-noto uppercase">Your Delivered items</span>
                    <span @click="switchTabs('charts')" class="font-lexend bg-blue-900 px-2 rounded-full text-white cursor-pointer">View Chart</span>
                </div>
                <div class="w-full flex justify-start items-center gap-2 uppercase font-noto bg-amber-300 border-y">
                    <span class="min-w-[20%] max-w-[20%] px-1">Property Number</span>
                    <span class="min-w-[30%] max-w-[30%] px-1">Particular</span>
                    <span class="min-w-[20%] max-w-[20%] px-1">Acquired Date</span>
                    <span class="min-w-[10%] max-w-[10%] px-1">Status</span>
                </div>
                <div class="w-full flex flex-col justify-start items-start">
                    <div v-for="property in propertyList" class="w-full flex justify-start items-start gap-2 uppercase font-lexend text-xs font-light hover:bg-emerald-900 hover:text-white p-2 border-b">
                        <span class="min-w-[20%] max-w-[20%] p-1">{{ property.property.property_no }}</span>
                        <span class="min-w-[30%] max-w-[30%] p-1">{{ property.property.particulars }}</span>
                        <span class="min-w-[20%] max-w-[20%] p-1">{{ property.acquisition_date }}</span>
                        <span class="min-w-[10%] max-w-[10%] p-1">{{ property.property.status }}</span>
                    </div>
                </div>
            </div>

        </div>
      </div>
    </AuthenticatedPage>

    <Dialog v-model:visible="showDeliveryItems" modal header="Delivery Item/s" :style="{ width: '80rem',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex justify-start items-center border-y-2  text-left uppercase py-2 bg-amber-200">
            <span class="min-w-[50%]">Description</span>
            <span class="min-w-[15%]">Unit Cost</span>
            <span class="min-w-[15%]">Quantity</span>
            <span class="min-w-[20%]">Measurement Unit</span>
        </div>
        <div v-for="item in currentDeliveryItems" class="w-full flex flex-col justify-start items-center gap-2 text-sm">
            <div class="w-full flex justify-between items-start border-b py-2 hover:bg-emerald-500 font-light text-left">
                <span class="min-w-[50%] px-2" v-html="item.description.replace(/\n/g, '<br>')"></span>
                <span class="min-w-[15%]">{{ item.unit_cost }}</span>
                <span class="min-w-[15%]">{{ item.quantity }}</span>
                <span class="min-w-[20%]">{{ item.measurement_unit.name }}</span>
            </div>
        </div>
    </Dialog>

    <Dialog v-model:visible="showStockCardTransactions" modal header="Delivery Item/s" :style="{ width: '80rem',  fontFamily: 'Lexend Deca' }">
        <div class="w-full flex justify-start items-center border-y-2  text-left uppercase py-2 bg-amber-200 px-1">
            <span class="min-w-[20%]">Date</span>
            <span class="min-w-[20%]">Received</span>
            <span class="min-w-[20%]">Issued</span>
            <span class="min-w-[20%]">Balance</span>
            <span class="min-w-[20%]">Recipient</span>
        </div>
        <div v-for="transaction in currentStockCardTransactions" class="w-full flex flex-col justify-start items-center gap-2 text-sm">
            <div class="w-full flex justify-between items-start border-b py-2 hover:bg-emerald-500 font-light text-left px-1">
                <span class="min-w-[20%]">{{ transaction.transaction_date }}</span>
                <span class="min-w-[20%]">{{ transaction.received }}</span>
                <span class="min-w-[20%]">{{transaction.issued}}</span>
                <span class="min-w-[20%]">{{transaction.balance}}</span>
                <span class="min-w-[20%]">{{transaction.recepient}}</span>
            </div>
        </div>
    </Dialog>

  </template>

<script setup>
    import { ref, onMounted, computed } from 'vue';
    import AuthenticatedPage from '../PageLayouts/AuthenticatedPage.vue';
    import axios from '../../axios/axios.js';
    import { useAuthStore } from '../../stores/authStore.js';
    import VueApexCharts from 'vue3-apexcharts';
    import Dialog from 'primevue/dialog';

    const store = useAuthStore();

    //lists
    const deliveryList = ref([])
    const stockCardList = ref([])
    const propertyList = ref([])

    // modal statuses
    var showDeliveryItems = ref(false)
    var showStockCardTransactions = ref(false)

    //tempopary variables
    var currentDeliveryItems = ref([])
    var currentStockCardTransactions = ref([])

    // Reactive data for widgets
    const deliveryData = ref({ total: 0, charge: 0, donation: 0 });
    const stockCardData = ref({ total: 0 });
    const propertyData = ref({ total: 0 });

    // Reactive data for bar chart
    const barDeliverySeries = ref([{ name: 'Total', data: [] }]);
    const barDeliveryCategories = ref([]);
    const barDeliveryOptions = computed(() => ({
        chart: {
        type: 'bar',
        fontFamily: 'Lexend Deca, sans-serif',
        },
        xaxis: {
        categories: barDeliveryCategories.value,
        },
        title: {
        text: 'Monthly User Delivery Distribution',
        align: 'center',
        floating: true,
        style: {
            fontSize: '10px',
            fontWeight: 'bold',
        },
        },
    }));

    // Reactive data for Stock Card pie chart
    const pieStockCardSeries = ref([]);
    const pieStockCardLabels = ref(['Allocating', 'Allocated', 'For Allocation']);
    const pieStockCardOptions = computed(() => ({
        series: pieStockCardSeries.value,
        chart: {
        type: 'pie',
        fontFamily: 'Lexend Deca, sans-serif',
        },
        labels: pieStockCardLabels.value,
        responsive: [
        {
            breakpoint: 480,
            options: {
            chart: {
                width: 200,
            },
            legend: {
                position: 'bottom',
            },
            },
        },
        ],
        title: {
        text: 'Stock Cards Statuses',
        align: 'center',
        floating: false,
        style: {
            fontSize: '12px',
            fontWeight: 'bold',
        },
        },
    }));

    // Reactive data for Property pie chart
    const piePropertySeries = ref([44, 55, 10]); // Initial data, will be updated
    const piePropertyLabels = ref(['Stock', 'Active', 'Waste']);
    const piePropertyOptions = computed(() => ({
        series: piePropertySeries.value,
        chart: {
        type: 'pie',
        fontFamily: 'Lexend Deca, sans-serif',
        },
        labels: piePropertyLabels.value,
        responsive: [
        {
            breakpoint: 480,
            options: {
            chart: {
                width: 200,
            },
            legend: {
                position: 'bottom',
            },
            },
        },
        ],
        title: {
        text: 'Property Statuses',
        align: 'center',
        floating: false,
        style: {
            fontSize: '12px',
            fontWeight: 'bold',
        },
        },
    }));

    var tabs = ref({
        charts:false,
        items:false,
        stockCards:false,
        properties:false
    })

    onMounted(() => {
        fetchDashboardData();
        switchTabs('charts')
    });

    const fetchDashboardData = async () => {
        try {
            const response = await axios.get('dashboard/user');
            const data = response.data.data;
            console.log(data);

            // Update widget data
            deliveryData.value.charge = data.deliveries.charge;
            deliveryData.value.donation = data.deliveries.donation;
            deliveryData.value.total = data.deliveries.total;

            stockCardData.value.total = data.stocks.total;
            propertyData.value.total = data.properties.total;

            // Update bar chart data
            barDeliverySeries.value = [{ name: 'Total', data: Object.values(data.deliveries.chart) }];
            barDeliveryCategories.value = Object.keys(data.deliveries.chart);

            // Update pie chart data
            pieStockCardSeries.value = Object.values(data.stocks.series);
            pieStockCardLabels.value = Object.keys(data.stocks.series);
            piePropertySeries.value = data.properties.series;

            //set lists
            deliveryList.value = data.deliveries.list
            stockCardList.value = data.stocks.list
            propertyList.value = data.properties.list
            console.log(stockCardList.value)
        } 
        catch (error) {
        console.error('Error fetching dashboard data:', error);
        // Optionally display an error message to the user
        }
    };

    function switchTabs(tab){
        Object.keys(tabs.value).forEach(key => {
            tabs.value[key] = key === tab;
        });
        console.log(tabs.value)
    }

    function showDeliveryItemsModal(items){
        currentDeliveryItems.value = items
        showDeliveryItems.value = true
    }

    function showStockCardTransactionsModal(transactions){
        currentStockCardTransactions.value = transactions
        showStockCardTransactions.value = true
    }

</script>