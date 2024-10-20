
const state = ()=>{
    return {
        users: {},
        user:null,
        isLoading:false,
        errors:{}
    }
}

const actions = {
    axios(){
        return useNuxtApp().$axios;
     },
    async getAllUsers(){
        try{
            const response = await this.axios().get('/api/users');
            this.users = response.data;
            
        }catch(e){
            console.log('Error getting authenticated user', e);
        }
    },
    async getUser(id){
        try{
            const response = await this.axios().get(`/api/users/${id}`);
            this.user = response.data;
            
        }catch(e){
            console.log('Error getting authenticated user', e);
        }
    },
    async updateUser(form){
        try{
            const response = await this.axios().put(`/api/users/${form.id}`, form);
            this.user = response.data;
            return true;
            
        }catch(e){
            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;
        }
    },
    async deleteUser(id)
    {
        try{
            const response = await this.axios().delete(`/api/users/${id}`);
            return true;          
        }catch(e){
            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;
        }
    }
    
}


const useUserStore = defineStore('userStore',{state, actions});


export default useUserStore;