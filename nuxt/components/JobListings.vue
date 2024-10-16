<script setup>
import useJobStore from '~/stores/jobs'
import { PencilSquareIcon } from '@heroicons/vue/24/solid';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { useRouter } from 'vue-router';

const { getPostJobs } = useJobStore();
const { postJobs } = storeToRefs(useJobStore());

onMounted(async ()=>{
    await getPostJobs(null, true); 
});

const navigatePage = async (link)=>{
   await getPostJobs(link, true);
}


</script>

<template>
    <section class="bg-blue-50 min-h-[820px] px-4 pt-10 pb-20">

        <div class="container-xl lg:container m-auto">

            <h2 class="text-3xl font-bold text-green-500 mb-6 text-center">
            Browse Jobs
            </h2>
            <SearchBox :active="true"/>
            <!-- Show job listing when done loading -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <JobListing v-for="job of postJobs.data" :key="job.index" :job="job"/>
            </div>
        </div>

        <!-- pagination -->
        <div v-if="postJobs.total > 0" class="max-w-[1540px] mx-auto flex flex-col md:flex-row items-center justify-between mt-5">
            <div class="flex gap-x-1">
                <span>Showing {{ postJobs.from }}</span> 
                <span>to {{ postJobs.to }}</span>
                <span>of {{ postJobs.total }} results</span>
            </div>

            <div>
            <button
                v-for="(link, i) of postJobs.links"
                :key="i"
                v-html="link.label"          
                :class="`cursor-pointer inline-flex items-center px-3 md:px-4 py-2 border text-sm font-medium whitespace-nowrap
                    ${ link.active  ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'}
                    ${ i === 0 && 'rounded-l-md' }
                    ${ i === postJobs.links.length - 1 && 'rounded-r-md' }
                    ${ !link.url ? ' bg-gray-100 text-gray-400': 'text-gray-600' } `" 
                @click="navigatePage(link.url)"
                :disabled="!link.url"
            ></button>
            </div>
        </div>
        
        <p v-if="!postJobs.data?.length" class="text-center">No job post found.</p>
    </section>
</template>