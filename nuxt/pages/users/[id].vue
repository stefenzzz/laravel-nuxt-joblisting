<script setup>
import { useRoute, useRouter } from 'vue-router';
import useUserStore from '~/stores/users';


const { getUser, updateUser } = useUserStore();
const { user, errors } = storeToRefs(useUserStore());
definePageMeta({
    middleware: ['auth','admin']
});

const router = useRouter();
const id =  useRoute().params.id;
const formData = reactive({});

onMounted(async()=> {
    await getUser(id);
    formData.id = id;
    formData.name = user.value?.name;
    formData.email = user.value?.email;
    formData.status = user.value?.status;
    formData.role = user.value?.role?.code;
});

const submitForm = async(formData)=>{
    if(await updateUser(formData)){
        router.push('/users');
    }
}

</script>
<template>
    <section class="pt-20 ">
        <form @submit.prevent="submitForm(formData)" class=" space-y-6 max-w-96 mx-auto shadow-around p-6" >
            
            <h1 class="text-2xl font-semibold">Profile</h1>    
        
            <Input placeholder="Name" name="name" v-model="formData.name" :message="errors.name?.[0]"/>
            <Input placeholder="Email Address" name="email" v-model="formData.email" :message="errors.email?.[0]"/>
            <select class="custom-input" v-model="formData.status">
                <option value="active">Active</option>
                <option value="pending">Pending</option>
            </select>
            <select class="custom-input" v-model="formData.role">
                <option value="company">Company</option>
                <option value="applicant">Applicant</option>
                <option value="admin">Administrator</option>
            </select>
            <PasswordInputToggle placeholder="New Password" v-model="formData.password" :message="errors.password?.[0]"/>
            <PasswordInputToggle placeholder="Retype New Password" v-model="formData.password_confirmation" :message="errors.password_confirmation?.[0]"/>

            <button class="button-green">Update</button>
        </form>
    </section>
</template>