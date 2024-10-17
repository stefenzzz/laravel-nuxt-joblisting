

const state = ()=>{
    return {
        postJobs: {},
        postJob:null,
        jobPostLoading: false,
        errors:{}
    }
}

const actions = {
    axios(){
        return useNuxtApp().$axios;
     },
    async getPostJobs(link = null, active = null, search = null, user = null)
    {
        try{
            this.jobPostLoading = true;
            const url = link ?? '/api/jobs'
            const response = await this.axios().get( url, { params: { active: active, search: search, user: user} } );
            this.postJobs = response.data;
            
        }catch(e){
            console.log(e);
        }finally{
            this.jobPostLoading = false;
        }
    },
    async getPostJob(id)
    {
        try{
            
            const response = await this.axios().get( `api/jobs/${id}` );
            this.postJob = response.data;
            
        }catch(e){
            console.log('Error getting authenticated user', e);
        }finally{
            
        }
    },
    async update(formData)
    {
        try{
            this.jobPostLoading = true;
            const response = await this.axios().put(`/api/jobs/${formData.id}`, formData,{
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            });
            console.log(response.data);
            return true;

        }catch(e){

            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;

        }finally{
            this.jobPostLoading = false;
        }
    },
    async storeJobPost(formData){

        try{
            this.jobPostLoading = true;
            const response = await this.axios().post(`/api/jobs/`, formData,{
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            });
            console.log(response.data);
            return true;

        }catch(e){

            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;

        }finally{
            this.jobPostLoading = false;
        }

    },
    async updateViews(id){
        try{
            const response = await this.axios().post(`/api/jobs/views/${id}`);
            return true;

        }catch(e){

            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;

        }
    },
    async updateImpressions(id){
        try{
            const response = await this.axios().post(`/api/jobs/impressions/${id}`);
            return true;

        }catch(e){

            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;

        }
    },

    async deletePost(id){
        try{
            this.jobPostLoading = true;
            const response = await this.axios().delete(`/api/jobs/${id}`);
            return true;

        }catch(e){
            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;
        }finally{
            this.jobPostLoading = false;
        }

    },

    async submitApplication(formData)
    {
        try{
            this.jobPostLoading = true;
            const response = await this.axios().post(`/api/jobs/apply/${formData.jobId}`,formData);
            return true;

        }catch(e){
            if(e.response.status === 422 || e.response.status === 401) this.errors = e.response.data.errors;
        }finally{
            this.jobPostLoading = false;
        }
    }
}


const useJobStore = defineStore('jobStore',{state, actions});

export default useJobStore;