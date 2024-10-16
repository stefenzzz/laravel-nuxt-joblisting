<script setup>
import useJobStore from '~/stores/jobs';
import { useRouter } from 'vue-router';


definePageMeta({
    middleware:['auth','company-or-admin']
});


const router = useRouter();
const { storeJobPost } = useJobStore();
const { errors } = storeToRefs(useJobStore());


const formData = reactive({
    title:'',
    company_name:'',
    description:'',
    email:'',
    status:'active',
});

const addPost = async(formData)=>{
    if( await storeJobPost(formData)){
        router.push('/');
    }
};

onMounted(()=> errors.value = {});

</script>

<template>
    <section class="max-w-7xl mt-20 mx-auto">
        <form @submit.prevent="addPost(formData)" class="max-w-xl mx-auto space-y-6">
            <div>
                <label for="title">Title</label>
                <input type="text" v-model="formData.title" class="custom-input" id="title">
                <span v-if=" errors.title?.[0]" class="text-red-500">{{ errors.title?.[0] }}</span>
            </div>

            <div>
                <label for="company_name">Company Name</label>
                <input type="text" v-model="formData.company_name" class="custom-input" id="company_name">
                <span v-if=" errors.company_name?.[0]" class="text-red-500">{{ errors.company_name?.[0] }}</span>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea v-model="formData.description" class="custom-input leading-6" rows="10" id="description" />
                <span v-if=" errors.description?.[0]" class="text-red-500">{{ errors.description?.[0] }}</span>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" v-model="formData.email" class="custom-input" id="email">
                <span v-if=" errors.email?.[0]" class="text-red-500">{{ errors.email?.[0] }}</span>
            </div>

            <div>
                <label for="email">Status</label>
                <select v-model="formData.status" class="custom-input" id="email">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button class="button-green">Submit</button>
        </form>
    </section>
</template>