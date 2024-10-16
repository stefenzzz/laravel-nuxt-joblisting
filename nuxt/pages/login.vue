<script setup>
import authStore from '~/stores/auth';
import { useRouter } from 'vue-router';


definePageMeta({
    middleware:['guest'],
});

const router = useRouter();
const { login } = authStore();
const { errors , isLoading } = storeToRefs(authStore());

const formData = reactive({
    email:'',
    password:'',
});

const submitForm = async()=>{
    if(await login(formData)){
        router.push('/');
    }
}
onMounted(()=> errors.value = {});

</script>

<template>
    
    <form @submit.prevent="submitForm" class="max-w-sm mx-auto mt-20 p-6 bg-white space-y-6 rounded-lg relative border">
        <h1 class="text-xl font-semibold">Sign In</h1>
        <Input placeholder="Email" name="email" v-model="formData.email" :message="errors.email?.[0]"/>
        <PasswordInputToggle placeholder="Password" v-model="formData.password" :message="errors.password?.[0]"/>
        <button class="button-gray">Login</button>
    </form>

</template>