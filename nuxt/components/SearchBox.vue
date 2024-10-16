<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import useJobStore from '~/stores/jobs';

defineProps({
    active:{
        type:[Boolean, null],
        default: null
    },
    user:{
        type:[String, Number],
        default: null
    },
    css:String
});
// Uses
const { getPostJobs } = useJobStore();

// Refs
const search = ref(null);

</script>

<template>
    <section class="max-w-[1280px] flex justify-center mx-auto px-4">
        <div class="bg-white flex gap-x-2 max-w-xl w-full rounded-md px-2 py-[5px] shadow-md mb-10" :class="css">
            <MagnifyingGlassIcon class="w-6 h-6 text-gray-500"/>
            <input type="search" class="w-full text-black placeholder:text-gray-500
            text-sm md:text-[14px] font-poppins font-light tracking-wide outline-none"
            v-model="search"
            autocomplete
            @keyup.enter.prevent="getPostJobs(null, active, search, user);"
            placeholder="Search Product"
            />
        </div>   
    </section> 
</template>