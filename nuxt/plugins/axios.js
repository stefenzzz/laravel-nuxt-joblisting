// plugins/axios.js
import axios from 'axios';

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig(); 

  // check if on client side
  const token = import.meta.client ? localStorage.getItem('token'): ''; 

  const axiosInstance = axios.create({
    baseURL: config.public.baseURL,
  });

  axiosInstance.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${token}`;
    config.headers.Accept = 'application/json';
    return config;
  })

  return {
    provide: {
      axios: axiosInstance,
    },
  };
});
