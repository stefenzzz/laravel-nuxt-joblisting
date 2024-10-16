<script setup>
import useAuthStore from '~/stores/auth';
import useJobStore from '~/stores/jobs';
import { useRouter } from "vue-router";

const router = useRouter();
const authStore = useAuthStore();
const { logout, getUser } = useAuthStore();
const { errors, isLoading,  } = storeToRefs(useAuthStore());
const { jobPostLoading } = storeToRefs(useJobStore());

const logoutUser = async()=>{
    const confirm = window.confirm('Are you sure to logout');
    if(!confirm) return ;
    if(await logout()){
        router.push('/login');
    }
}

onMounted( async()=> await getUser());
</script>

<template>
    <header class="border-b">
        <nav class="flex justify-between items-center py-2 max-w-7xl mx-auto">
            <NuxtLink to="/">Jobs</NuxtLink>
            <div class="flex gap-x-8">
    
                <div v-if="authStore.user" class="flex items-center gap-x-2">
                    <p class="capitalize">{{ authStore.user.name }}</p>
                    <NuxtLink v-if="authStore.user.role?.code == 'admin' || authStore.user.role?.code == 'company'" to="/jobs" class="navlink">Jobs</NuxtLink>
                    <NuxtLink v-if="authStore.user.role?.code == 'admin' || authStore.user.role?.code == 'company'" to="/jobs/add" class="navlink">Post a job</NuxtLink>
                    <NuxtLink v-if="authStore.user.role?.code == 'admin'" to="/users" class="navlink">Users</NuxtLink>
                    <button @click="logoutUser" class="navlink">Logout</button>
                </div>
                <div v-else class="flex items-center gap-x-8">
                    <NuxtLink to="/login" class="navlink">Login</NuxtLink>
                    <NuxtLink to="/register" class="navlink">Register</NuxtLink>
                </div>
            </div>
        </nav>
    </header>


    <main>
        <slot />
    </main>
    <PulseLoader v-model="isLoading"/>
    <PulseLoader v-model="jobPostLoading"/>
</template>

<style scoped>
    .router-link-exact-active.navlink{
        @apply bg-gray-100 rounded-md;
    }

</style>