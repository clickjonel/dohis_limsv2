<template>
    <AuthenticatedPage :pageTitle="'System Dashboard'">
        <div class="w-full min-h-[85%] flex justify-start items-start gap-4">

            <!-- <div class="w-full h-full flex flex-col justify-start items-start gap-4 p-2 overflow-y-scroll">
                <div class="w-full h-[400px] flex justify-start items-start">
                    <div class="w-full h-full flex flex-col justify-start items-start gap-4">
                        <div class="w-full h-1/2 flex justify-start items-center rounded-lg shadow-md shadow-slate-600 bg-emerald-900/50 gap-[50px]">
                            <img :src="`http://192.168.224.24/dohis/image_profiles/${store.user.image}`" alt="" class="size-[80px] rounded-full bg-white shadow-md shadow-slate-900 ml-[50px]">
                            <div class="flex flex-col justify-center items-center gap-2 font-lexend">
                                <span class="text-3xl font-bold text-white">Welcome Back</span>
                                <span class="font-bold text-white">{{ store.user.full_name }}</span>
                            </div>
                          </div>
                          <div class="w-full h-1/2 grid grid-cols-4 gap-4 font-lexend text-white">
                              <div class="w-full h-full flex flex-col justify-center items-center rounded-lg shadow-md shadow-slate-600 bg-sky-900/60 gap-2">
                                  <span class="text-4xl font-bold">{{ data?.totals.deliveries }}</span>
                                  <span  class="font-semibold uppercase text-lg">Deliveries</span>
                              </div>
                                <div class="w-full h-full flex flex-col justify-center items-center rounded-lg shadow-md shadow-slate-600 bg-sky-900/60 gap-2">
                                  <span class="text-4xl font-bold">{{ data?.totals.stocks }}</span>
                                  <span  class="font-semibold uppercase text-lg">Stocks</span>
                              </div>
                                <div class="w-full h-full flex flex-col justify-center items-center rounded-lg shadow-md shadow-slate-600 bg-sky-900/60 gap-2">
                                  <span class="text-4xl font-bold">{{ data?.totals.properties }}</span>
                                  <span  class="font-semibold uppercase text-lg">Properties</span>
                              </div>
                                <div class="w-full h-full flex flex-col justify-center items-center rounded-lg shadow-md shadow-slate-600 bg-sky-900/60 gap-2">
                                  <span class="text-4xl font-bold">{{ data?.totals.warehouses }}</span>
                                  <span  class="font-semibold uppercase text-lg">Warehouses</span>
                              </div>
                          </div>
                    </div>
                </div>
                <div class="w-full h-[400px] bg-white rounded-md shadow-slate-600 p-4">
                  <apexchart type="bar" height="380" :options="deliveryColumnChart.chartOptions" :series="deliveryColumnChart.series"></apexchart>
                </div>
            </div>

            <div class="w-1/4 h-full flex flex-col justify-start items-start gap-4 p-2 overflow-scroll">
                <div class="w-full h-[400px] flex flex-col justify-start items-start bg-gray-300 rounded-lg shadow-md shadow-slate-600 font-lexend">
                  <span class="w-full text-center uppercase py-6"></span>
                  <div class="w-full h-full flex justify-center items-center">
                    <apexchart type="donut" :options="deliveryPieChart.chartOptions" :series="deliveryPieChart.series" class="w-full h-full"></apexchart>
                  </div>
                </div>
            </div> -->

            <div class="w-full flex justify-center items-center gap-4">

            </div>

        </div>

    </AuthenticatedPage>

  </template>

<script setup>
    import { ref, onMounted, computed } from 'vue';
    import AuthenticatedPage from '../PageLayouts/AuthenticatedPage.vue';
    import useApi from '../../composables/api_calls.js';
    import { useAuthStore } from '../../stores/authStore.js';

    const store = useAuthStore()
    const { fetchRequest } = useApi()

    var data = ref(null)


    var deliveryPieChart = ref({
        series: [],
        chartOptions: {
          chart: {
            type: 'donut',
            fontFamily:'Lexend Deca, sans-serif',
          },
          legend: {
            position: 'bottom',
          },
          labels: ['Donation', 'Procured'],
          title: {
            text: 'Delivery Distribution',  // Add this
            align: 'center',
            style: {
                fontSize: '16px',
                fontWeight: 'bold',
                fontFamily: 'Lexend Deca, sans-serif'
            }
        },
          plotOptions:{
            pie:{
              donut:{
                labels:{
                  show:true,
                  total:{
                    show:true,
                    label:'Total',
                    fontFamily:'Lexend Deca, sans-serif'
                  },
                },
                size: '50%',
                innerSize: '60%',
              }
            }
          }
        },
    })

    var deliveryColumnChart = ref({
        series: [
          {
            name: 'Count',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
          }, 
        ],
        chartOptions: {
          chart: {
            type: 'bar',
            fontFamily:'Lexend Deca, sans-serif'
          },
          title: {
              text: 'Monthly Deliveries',  // Add this
              align: 'center',
              style: {
                  fontSize: '16px',
                  fontWeight: 'bold',
                  fontFamily: 'Lexend Deca, sans-serif'
              }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '55%',
              borderRadius: 5,
              borderRadiusApplication: 'end'
            },
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            show: true,
            width: 1,
            colors: ['black']
          },
          xaxis: {
            categories: [],
          },
          yaxis: {
            title: {
              text: 'Total'
            }
          },
          fill: {
            opacity: 1
          },
        },
          
          
    })

    onMounted(() => {
       if(store.user.assignment.section_id === 28){
        fetchDashboardData()
       }
       else{
          console.log('redirect')
       }
    });

    async function fetchDashboardData(){
      var response = await fetchRequest('dashboard',{})
      response.toast()
      if(response.data.data){
          data.value = response.data.data
          setDeliveryPieChartDetails()
          setDeliveryColumnChartDetails()
          console.log(data.value)
      }
       
    }

    function setDeliveryPieChartDetails(){
      deliveryPieChart.value.series = data.value.charts.deliveryDonut
    }

    function setDeliveryColumnChartDetails() {
        deliveryColumnChart.value = {
            ...deliveryColumnChart.value,
            series: [{
                name: 'Count',
                data: Object.values(data.value.charts.deliveryColumn)
            }],
            chartOptions: {
                ...deliveryColumnChart.value.chartOptions,
                xaxis: {
                    ...deliveryColumnChart.value.chartOptions.xaxis,
                    categories: Object.keys(data.value.charts.deliveryColumn)
                }
            }
        }
    }


</script>