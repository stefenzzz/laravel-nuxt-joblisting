import axiosClient from "~/helpers/axiosClient";


const state = ()=>{
    return {
        user:null,
        isLoading: false,
        token: null,
        errors: {}
    }
}


const actions = {
    loadToken(){
        if (process.client) {
            this.token = localStorage.getItem('token');
          }
    },
    async getUser(){    
        if(!localStorage.getItem('token')) return;    
        try{
            const response = await axiosClient.get('/api/user',{
                headers:{
                    Authorization: `Bearer ${ localStorage.getItem('token') }`
                }
            });
            
            this.user = response.data;
            
        }catch(e){
            // console.log('Error getting authenticated user', e);
        }
    },
    async register(formData){
        try{
            this.isLoading = true;
            const response = await axiosClient.post('/api/register', formData);
            
            localStorage.setItem('token', response.data.token);
            this.user = response.data.user;
            return true;
        }catch(e){
            if(e.response){
             if(e.response.status === 422 || e.response.status === 403) this.errors = e.response.data.errors ;

            }else{
                console.log(e);
            }
        }finally{
            this.isLoading = false;
        }
    },
    async login(formData){

        try{
            this.isLoading = true;
            const response = await axiosClient.post(`/api/login`,formData);
            this.user = response.data.user;
            localStorage.setItem('token', response.data.token);
            return true;
        }catch(e){
            if(e.response){
                console.log(e.response);
                if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;

            }else{
                console.log(e);
            }
        }finally{
            this.isLoading = false;
        }  
    },
    async logout(){
        try{
            this.isLoading = true;
            const response = await axiosClient.post('/api/logout',{},{
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            });
            
            this.user = null;
            this.token = null;
            localStorage.removeItem('token');
            return true;
        }catch(e){
            console.log(e);
        }finally{
            this.isLoading = false;
        }
    },


}

const useAuthStore = defineStore('authStore',{state, actions});

export default useAuthStore;