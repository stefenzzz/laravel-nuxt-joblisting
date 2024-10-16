// middleware/post-auth.js
import  useAuthStore  from '~/stores/auth';

export default defineNuxtRouteMiddleware((to, from) => {
  const authStore = useAuthStore() 

  if (authStore.user?.role.code != 'company' && authStore.user?.role.code != 'admin' ) {
      return navigateTo('/') // Redirect home if user didnt own the post
  }
  

})