<script setup>
import useAuthStore from '~/stores/auth';
import { useRouter } from "vue-router";

definePageMeta({
    middleware:['guest']
});

const router = useRouter();
const { register } = useAuthStore();
const { errors, isLoading } = storeToRefs(useAuthStore());

definePageMeta({
    middleware:['guest'],
});

const formData = reactive({
    name:'',
    email:'',
    password:'',
    password_confirmation:'',
});

const submitForm = async ()=>{
    if(await register(formData))
    {
        router.push('/');
    }

};
onMounted(()=> errors.value = {});
</script>

<template>
    <section class="pt-20 ">
        <form @submit.prevent="submitForm" class="border rounded-md space-y-6 max-w-96 mx-auto shadow-around p-6" >
            
            <h1 class="text-center text-2xl font-semibold">Register</h1>    
        
            <Input placeholder="Name" name="name" v-model="formData.name" :message="errors.name?.[0]"/>
            <Input placeholder="Email Address" name="email" v-model="formData.email" :message="errors.email?.[0]"/>
            <PasswordInputToggle placeholder="Password" v-model="formData.password" :message="errors.password?.[0]"/>
            <PasswordInputToggle placeholder="Retype Password" v-model="formData.password_confirmation" :message="errors.password_confirmation?.[0]"/>
            <div>
                <p class="text-sm">Already have an account? <NuxtLink to="/login" class="text-blue-500 font-semibold">Login</NuxtLink></p>
            </div>
            <button class="button-gray">Submit</button>
        </form>
    </section>
</template>