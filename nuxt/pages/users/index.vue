<script setup>
import useUserStore from '~/stores/users';
import { PencilSquareIcon } from '@heroicons/vue/24/solid';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { useRouter } from 'vue-router';

definePageMeta({
    middleware: ['auth','admin']
});

const router = useRouter();
const { getAllUsers, deleteUser } = useUserStore();
const {users} = storeToRefs(useUserStore());

const deletes = async(user)=>{
    const confirm = window.confirm(`Are you sure to delete account ${user.email}`);
    if(!confirm) return;
    if(await deleteUser(user.id)){
        await getAllUsers(); // refresh users after deleting
    }
};

onMounted( async()=> await getAllUsers() );
</script>
<template>
    <section class="pt-20 min-h-[855px]">
        <table class="max-w-4xl w-full mx-auto border bg-white shadow-around" width="100">
            <thead>
                <tr>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Name</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Role</th>
                    <th class="py-2 px-4 text-left"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user of users.data" :key="user.id">
                    <td class="p-4 border capitalize">{{ user.status }}</td>
                    <td class="p-4 border">{{ user.name }}</td>
                    <td class="p-4 border">{{ user.email }}</td>
                    <td class="p-4 border capitalize">{{ user.role.name }}</td>
                    <td class="p-4 border">
                        <div class="flex items-center gap-x-3 w-fit mx-auto">
                            <PencilSquareIcon class="h-5 w-5 text-blue-400 cursor-pointer" @click=" router.push(`/users/${user.id}`);"/>                     
                            <TrashIcon class="h-5 w-5 text-blue-400 cursor-pointer" @click="deletes(user)"/>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- pagination -->
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between mt-5">

            <div class="flex gap-x-1">
                <span>Showing {{ users.from }}</span> 
                <span>to {{ users.to }}</span>
                <span>of {{ users.total }} results</span>
            </div>

            <div>
                <button
                v-for="(link, i) of users.links"
                :key="i"
                v-html="link.label"          
                :class="`cursor-pointer inline-flex items-center px-3 md:px-4 py-2 border text-sm font-medium whitespace-nowrap
                    ${ link.active  ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'}
                    ${ i === 0 && 'rounded-l-md' }
                    ${ i === users.links.length - 1 && 'rounded-r-md' }
                    ${ !link.url ? ' bg-gray-100 text-gray-400': 'text-gray-600' } `" 
                @click="navigatePage(link.url)"
                :disabled="!link.url"
                ></button>
            </div>
        </div>
    </section>

</template>