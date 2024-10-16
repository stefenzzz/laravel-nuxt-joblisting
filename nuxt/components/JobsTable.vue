<script setup>
import useJobStore from '~/stores/jobs'
import { PencilSquareIcon } from '@heroicons/vue/24/solid';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { useRouter } from 'vue-router';

const props = defineProps({
    user:{
        type:[String, Number],
        default:null
    }
});

const router = useRouter();
const { getPostJobs, deletePost } = useJobStore();
const { postJobs } = storeToRefs(useJobStore());

onMounted(async ()=>{
    await getPostJobs(null,null,null,props.user);
});

const currentPage = ref(null);
const navigatePage = async (link)=>{
   currentPage.value = link;
   await getPostJobs(link,null,null,props.user);
}

const deleteJobPost = async(id)=>{
    const confirm = window.confirm(`Are you sure to delete post ${id}`);
    if(!confirm) return;
    if(await deletePost(id)){
        await getPostJobs(currentPage.value,null,null,props.user);
    }
}

</script>

<template>
<section class="max-w-[1366px] mx-auto mt-20">
    <SearchBox css="shadow-none border" :user="user"/>
    <table class="w-full border p-2">
        <thead>
            <tr>
                <th class="text-left p-4">Status</th>
                <th class="text-left p-4">Title</th>
                <th class="text-left p-4">Company Name</th>
                <th class="text-left p-4">Description</th>
                <th class="text-left p-4">Created by</th>
                <th class="text-left p-4">Impressions</th>
                <th class="text-left p-4">Applied</th>
                <th class="text-left p-4">Views</th>
                <th class="text-left p-4"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="job of postJobs.data" :key="job.id">
                <td class="p-4 border">{{ job.status  }}</td>
                <td class="p-4 border">{{ job.title  }}</td>
                <td class="p-4 border">{{ job.company_name  }}</td>
                <td class="max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis border px-3">
                    {{ job.description  }}
                </td>
                <td class="p-4 border">{{ job.created_by  }}</td>
                <td class="p-4 border text-center">{{ job.number_impression  }}</td>
                <td class="p-4 border text-center">{{ job.number_applies }}</td>
                <td class="p-4 border text-center">{{ job.number_views  }}</td>
                <td class="p-4 border">
                    <div class="flex items-center gap-x-6">
                        <PencilSquareIcon class="h-6 w-6 text-blue-400 cursor-pointer" @click=" router.push({ path: `/jobs/${job.id}`, query: { user_id: job.user_id } });"/>                     
                        <TrashIcon class="h-6 w-6 text-blue-400 cursor-pointer" @click="deleteJobPost(job.id)"/>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- pagination -->
    <div class="flex flex-col md:flex-row items-center justify-between mt-5">

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
</section>
</template>