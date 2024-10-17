// middleware/auth.js
import  useAuthStore  from '~/stores/auth';

export default defineNuxtRouteMiddleware(() => {
  const authStore = useAuthStore() 
  
  
  authStore.loadToken(); // get the token

  if (!authStore.token) {
    return navigateTo('/login') // Redirect to login if not authenticated
  }
  

})