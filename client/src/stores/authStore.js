// stores/counter.js
import { defineStore } from 'pinia'
import axios from '../axios/axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        permissions: [],
        isAuthenticated: false,
        token: '',
    }),
    actions: {
        setUser(user,status) {
            this.user = user;
            this.isAuthenticated = status;
        },
        setUserAssignment(assignment) {
            this.user = user;
            this.isAuthenticated = status;
        },
        setToken(token){
            this.token = token;
            localStorage.setItem('token', token);
        },
        setPermissions(permissions) {
            this.permissions = permissions;
        },
        clearUser() {
            this.user = null;
            this.permissions = [];
            this.isAuthenticated = false;
        },
        hasPermission(permission) {
            return this.permissions.includes(permission);
        },
        async fetchUser(){
            try {
                const response = await axios.get('user/data');
                this.setUser(response.data.user, true);
                this.setPermissions(response.data.permissions);
              } catch (error) {
                console.error('Fetch user failed:', error.response);
                this.clearUser(); // Clear user data on error
              }
        }
    },
    getters:{
        getUser(){
            return this.user;
        },
        getToken(){
            return this.token;
        },
        // isAuthenticated(){
        //     return this.isAuthenticated;
        // },
        getPermissions(){
            return this.permissions;
        },
    }
})