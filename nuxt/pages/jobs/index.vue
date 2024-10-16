<script setup>
import useAuthStore from '~/stores/auth';

const authUser = useAuthStore();
definePageMeta({
    middleware:['auth','company-or-admin'],
});

</script>

<template>
<section class="max-w-[1366px] mx-auto mt-20">
    <JobsTable v-if="authUser.user.role.code === 'admin' " />
    <JobsTable v-if="authUser.user.role.code === 'company'" :user="authUser.user.id" />
</section>
</template>