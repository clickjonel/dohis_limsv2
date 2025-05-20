<template>
    <main class="w-full min-h-screen h-screen flex justify-center items-center bg-[url('./assets/bg-image-honeycomb.png')] bg-cover bg-center bg-no-repeat">
      <div class="w-2/3 h-3/4 flex justify-start items-center bg-[#3f4e4f]/40 backdrop-blur-md shadow-sm shadow-slate-900 rounded-sm">
        <div class="w-full h-full flex justify-start items-center">
  
          <!-- Side Image -->
          <img src="../assets/login-side-image.webp" class="w-2/3 h-full shadow-md shadow-slate-600 opacity-80">
  
          <!-- Login Form -->
          <div class="w-full h-full flex flex-col justify-between items-center gap-4 font-poppins border">
            <div class="w-full h-full flex flex-col justify-start items-center p-4 gap-4">
  
              <!-- Header -->
              <div class="w-full min-h-[25%] flex flex-col justify-start items-center gap-4 font-lexend border-b">
                <span class="w-full text-sm text-center font-light">Welcome to <strong class="uppercase font-bold">Logistics Information Management System (LIMS)</strong> <br/> Please Enter DOHIS Credentials to Enter</span>
                <span class="w-full text-2xl uppercase text-center font-medium">Sign In</span>
              </div>
  
              <!-- Fields -->
              <div class="w-full h-[50%] flex flex-col justify-evenly py-2 items-start gap-4 border-y">
                <Input type="text" label="Username" :errorMessage="errors.username" v-model="credentail_inputs.username"/>
                <Input type="password" label="Password" :errorMessage="errors.password" v-model="credentail_inputs.password"/>
  
                <div class="w-full grid place-content-start">
                  <Button @click="handleLogin" text="Login To LIMS" buttonType="update" icon="material-symbols:login"/>
                </div>
              </div>
  
              <!-- Other Systems -->
              <div class="w-full max-h-[25%] grid grid-cols-2 gap-2 overflow-y-scroll p-2 border-t">
                <Button @click="handleRedirect('http://192.168.224.24/dohis/dashboard.php')" text="DOHIS" buttonType="default" icon="mdi:google-chrome"/>
                <Button text="eDtr" buttonType="default" icon="mdi:google-chrome"/>
                <Button text="ePayroll" buttonType="default" icon="mdi:google-chrome"/>
              </div>
  
            </div>
  
            <span class="text-xs w-full text-center p-2"><strong>Important Reminder:</strong> Make sure you are registered on DOHIS System to have access to this system.</span>
  
          </div>
        </div>
      </div>
    </main>
  
    <!-- <Loader v-if="loader.show" :text="loader.text" /> -->
  </template>
  
  <script setup>
  import { ref,onMounted } from 'vue';
  import Input from './Form/Input.vue';
  import Button from './Button.vue';
  import axios from '../axios/axios';
  // import Loader from './Loader.vue';
  import { Loading } from 'notiflix/build/notiflix-loading-aio';
  import { Notify } from 'notiflix/build/notiflix-notify-aio';
  import { useRouter } from 'vue-router';
  import { useAuthStore } from '../stores/authStore';
  import { showToast } from '../composables/notiflix';
  
  const router = useRouter();
  const store = useAuthStore();
  
  const credentail_inputs = ref({
    username: '',
    password: ''
  });
  
  const errors = ref({
    username: '',
    password: ''
  });

  
  function handleRedirect(path) {
    window.location.replace(path);
  }
  
  async function handleLogin() {
    Loading.dots('Attempting Login, Please Wait...',{
        clickToClose:false
    });
  
    try {
      const response = await axios.post('login', {
        username: credentail_inputs.value.username,
        password: credentail_inputs.value.password
      });
  
      if (response.data.status) {
       showToast('success','Login Successfull, Welcome to Dashboard')
        // localStorage.setItem('token', response.data.token);
  
        store.setToken(response.data.token);
        store.setUser(response.data.user,response.data.status)
        store.setRoles(response.data.roles);

        router.push({ path: '/dashboard/user' }); 
        // if(store.hasRole('supply_officer')){
        //   router.push({ path: '/deliveries' });
        // }
        // else if(store.hasRole('permanent')){
        //   router.push({ path: '/deliveries/user' });
        // }
      } 
      else {
        showToast('failure','Login Failed, Try Again With Correct DOHIS Credentials')
      }
    } catch (error) {
      if (error.response) {
        errors.value.username = error.response.data.errors.username?.[0] ?? '';
        errors.value.password = error.response.data.errors.password?.[0] ?? '';
        console.log(error)
      } 
      else {
        showToast('failure','Login Failed, Try Again With Correct DOHIS Credentials')
      }
      console.log(error)
    } finally {
      Loading.remove();
    }
  }
  </script>
  
  <style scoped>
  /* Add any scoped styles here */
  </style>