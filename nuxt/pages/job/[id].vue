<script setup>
import { useRoute, useRouter} from 'vue-router';
import useJobStore from '~/stores/jobs';
import useAuthStore from '~/stores/auth';

const router = useRouter();
const authStore = useAuthStore();
const { getPostJob, updateViews, submitApplication, updateImpressions } = useJobStore();
const { postJob, errors } = storeToRefs(useJobStore());
const id = useRoute().params.id;

onMounted(async()=> {
  await getPostJob(id);
  updateViews(id); // update views when mounted
  errors.value = {}; // reset errors
});

const formData = reactive({
  jobId: id,
  name: authStore.user?.name,
  email: authStore.user?.email,
  contact:'',
  description:'',
});

const form = ref();

const submitForm = async(formData)=>{
  if(await submitApplication(formData)){
      form.value.innerHTML = '<span>You have successfully submitted your application</span>';
  }
}


</script>

<template>
    <Head>
        <Title>{{ postJob?.title  }}</Title>
        <Meta name="description" :content="postJob?.title"/>
    </Head>
  
    <section class="bg-green-50 min-h-[850px]">
      <div class="container m-auto py-10 px-6">

        <div class="grid grid-cols-1 md:grid-cols-[70%_30%] w-full gap-6">
          
          <main>
            <div class="bg-white p-6 rounded-lg shadow-md text-center md:text-left">

              <div class="text-gray-500 mb-4 capitalize flex items-center gap-x-3">
                {{ postJob?.status }} 
              </div>
              
              <h1 class="text-3xl font-bold mb-4">{{ postJob?.title }}</h1>
              <div class="text-gray-500 mb-4 flex align-middle justify-center md:justify-start">
                <i class="pi pi-map-marker text-lg text-orange-700 mr-2">{{  }}</i>
                <p class="text-orange-700">{{ postJob?.company_name  }}</p>
              </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
              <h3 class="text-green-800 text-lg font-bold mb-6">
                Job Description
              </h3>

              <p class="mb-4" v-html="postJob?.description">
                
              </p>

              <h3 class="text-green-800 text-lg font-bold mb-2">Salary</h3>
              <span>to be posted</span>
            </div>
          </main>

          <!-- Sidebar -->
          <aside>
            <!-- Company Info -->
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-bold mb-6">Company Info</h3>

              <h2 class="text-2xl">{{  }}</h2>

              <p class="my-2">
                  {{  }}
              </p>

              <hr class="my-4" />

              <h3 class="text-xl">Contact Email:</h3>

              <p class="my-2 bg-green-100 p-2 font-bold">
                {{ postJob?.email }}
              </p>
            </div>
          </aside>
        </div>
        <!-- application form -->
        <form v-if="authStore.user" @submit.prevent="submitForm(formData)" class="bg-white p-6 rounded-md shadow-xl max-w-md mt-10 space-y-6" ref="form">
            <h3 class="text-green-500">Apply Now</h3>
            <div>
              <input placeholder="Name" name="name" v-model="formData.name" class="custom-input"/>
              <span v-if=" errors.name?.[0]" class="error">{{ errors.name?.[0] }}</span>
            </div>

            <div>
              <input placeholder="Email" name="email" v-model="formData.email" class="custom-input"/>
              <span v-if=" errors.email?.[0]" class="error">{{ errors.email?.[0] }}</span>
            </div>

            <div>         
              <input type="number" placeholder="Contact" name="contact_number" v-model="formData.contact" class="custom-input"/>
              <span v-if=" errors.contact?.[0]" class="error">{{ errors.contact?.[0] }}</span>
            </div>

            <div>   
              <textarea placeholder="Description" name="description" v-model="formData.description" cosl="10" rows="10" class="custom-input"/>
              <span v-if=" errors.description?.[0]" class="error">{{ errors.description?.[0] }}</span>
            </div>
            
            <button class="button-green">Submit application</button>
        </form>
        <div v-else class="bg-white p-6 rounded-lg shadow-xl w-fit mt-5">
            <NuxtLink to="/login" class="text-green-700">Login</NuxtLink> or <NuxtLink to="/login" class="text-green-700">Register</NuxtLink> to Apply
        </div>
      </div>


    </section>

</template>