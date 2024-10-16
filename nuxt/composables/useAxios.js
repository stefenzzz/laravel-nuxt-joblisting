// composables/useAxios.js
import axios from "axios";

export const useAxios = () => {
  const config = useRuntimeConfig();

  // Create an axios instance
  const axiosClient = axios.create({
    baseURL: config.public.baseURL
  });

  // Add interceptors
  axiosClient.interceptors.request.use(config => {
    config.headers.Accept = 'application/json';
    config.headers.Authorization = `Bearer ${localStorage.getItem('token') || ''}`;
    return config;
  });

  return { axiosClient };
};
