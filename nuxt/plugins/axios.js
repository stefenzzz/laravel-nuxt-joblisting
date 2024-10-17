// plugins/axios.js
import axios from 'axios';

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig(); 

  const axiosInstance = axios.create({
    baseURL: config.public.baseURL,
  });

  axiosInstance.interceptors.request.use(config => {
    config.headers.Accept = 'application/json';
    config.headers.Authorization = `Bearer ${localStorage.getItem('token')}`;
    return config;
  })

  return {
    provide: {
      axios: axiosInstance,
    },
  };
});
