<script setup>
import { useRoute, useRouter} from 'vue-router';
import useJobStore from '~/stores/jobs';

definePageMeta({
    middleware:['auth', 'post-auth']
});

const router = useRouter();
const { getPostJob, update } = useJobStore();
const { postJob } = storeToRefs(useJobStore());


const id = useRoute().params.id;

const formData = reactive({});
onMounted(async()=> {

    await getPostJob(id);
    formData.id = id;
    formData.title = postJob.value?.title;
    formData.company_name = postJob.value?.company_name;
    formData.description = postJob.value?.description;
    formData.email = postJob.value?.email;
    formData.status = postJob.value?.status;

});

const updatePost = async(formData)=>{
    if( await update(formData)){
        router.push('/jobs');
    }
}

</script>

<template>
    <section class="max-w-7xl mt-20 mx-auto">
        <form @submit.prevent="updatePost(formData)" class="max-w-xl mx-auto space-y-6">
            <div>
                <label for="title">Title</label>
                <input type="text" v-model="formData.title" class="custom-input" id="title">
            </div>

            <div>
                <label for="company_name">Company Name</label>
                <input type="text" v-model="formData.company_name" class="custom-input" id="company_name">
            </div>

            <div>
                <label for="description">Description</label>
                <textarea v-model="formData.description" class="custom-input leading-6" rows="10" id="description" />
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" v-model="formData.email" class="custom-input" id="email">
            </div>

            <div>
                <label for="email">Status</label>
                <select v-model="formData.status" class="custom-input" id="email">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button class="button-green">Update</button>
        </form>
    </section>
    
</template>