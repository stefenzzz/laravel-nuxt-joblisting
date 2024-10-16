<script setup>
import useJobStore from '~/stores/jobs';
import { formatLongDate } from '~/helpers/formats';
// props
const props = defineProps({
    job:Object
  });

// use
const { updateImpressions } = useJobStore();
const initalLength = 90;
const showFullDescription = ref(false);
const toggleFullDescription = ()=>{
  showFullDescription.value = !showFullDescription.value;
}

// show less description
const truncatedDescription = computed(()=>{
  let description = props.job.description
  if(!showFullDescription.value){
     description = description.substring(0, initalLength);
  }
  return description;
});

// update impression when mounted
onMounted(()=> updateImpressions(props.job.id));

</script>
<template>
        <div class="bg-white rounded-xl shadow-md relative">
            <div class="p-4">
              <div class="mb-6">
                <div class="text-gray-600 mt-2 text-sm text-right">{{ formatLongDate(job.posted) }}</div>
                <h3 class="text-xl font-bold">{{ job.title }}</h3>
              </div>

              <div>
                {{ truncatedDescription }}
                <ToggleDescription 
                :length="truncatedDescription.length"
                :limit="initalLength"
                @onToggle="toggleFullDescription"
                />
              </div>
              <h3 class="text-green-500 my-2 capitalize">{{ job.status }}</h3>

              <div class="border border-gray-100 mb-5"></div>

              <div class="flex flex-col lg:flex-row justify-between mb-4">
                <div class="text-orange-700 mb-3">
                  <i class="pi pi-map-marker text-orange-700"></i>
                  {{ job.company_name }}
                </div>
                <NuxtLink
                  :to="`/job/${job.id}`"
                  class="h-[36px] bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-center text-sm"
                >
                  Read More
                </NuxtLink>
              </div>
            </div>
        </div>
</template>