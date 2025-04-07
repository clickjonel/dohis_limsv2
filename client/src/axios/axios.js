import axios from "axios";
import { useAuthStore } from "../stores/authStore";


const axiosInstance = axios.create({
    baseURL: `http://${import.meta.env.VITE_API_URL}/api/`, // Your Laravel API URL
    timeout: 10000,
    headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: false, // Required for Sanctum CSRF cookie
});

// Add a request interceptor to include the token
axiosInstance.interceptors.request.use((config) => {
    const token = localStorage.getItem('token'); 
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, (error) => {
    return Promise.reject(error);
});

export default axiosInstance;