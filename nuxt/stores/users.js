import axiosClient from "~/helpers/axiosClient";



const state = ()=>{
    return {
        users: {},
        user:null,
        isLoading:false,
        errors:{}
    }
}

const actions = {

    async getAllUsers(){
        try{
            const response = await axiosClient.get('/api/users',{
                headers:{
                    Authorization: `Bearer ${ localStorage.getItem('token') }`
                }
            });
            this.users = response.data;
            
        }catch(e){
            console.log('Error getting authenticated user', e);
        }
    },
    async getUser(id){
        try{
            const response = await axiosClient.get(`/api/users/${id}`,{
                headers:{
                    Authorization: `Bearer ${ localStorage.getItem('token') }`
                }
            });
            this.user = response.data;
            
        }catch(e){
            console.log('Error getting authenticated user', e);
        }
    },
    async updateUser(form){
        try{
            const response = await axiosClient.put(`/api/users/${form.id}`, form, {
                headers:{
                    Authorization: `Bearer ${ localStorage.getItem('token') }`
                }
            });
            this.user = response.data;
            return true;
            
        }catch(e){
            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;
        }
    },
    async deleteUser(id)
    {
        try{
            const response = await axiosClient.delete(`/api/users/${id}`, {}, {
                headers:{
                    Authorization: `Bearer ${ localStorage.getItem('token') }`
                }
            });
            return true;          
        }catch(e){
            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;
        }
    }
    
}


const useUserStore = defineStore('userStore',{state, actions});


export default useUserStore;