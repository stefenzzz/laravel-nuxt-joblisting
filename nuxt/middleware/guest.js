// middleware/guest.js
import  useAuthStore  from '~/stores/auth'

export default defineNuxtRouteMiddleware(() => {
  const authStore = useAuthStore() // Access your Pinia store
  
  authStore.loadToken(); // get the token

  if (authStore.token) {
    return navigateTo('/') // Redirect to login if not authenticated
  }
  

})