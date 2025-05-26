import { defineStore } from 'pinia'
import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || '',
    error: null
  }),
  actions: {
    async login(email, password) {
      try {
        const response = await axios.post(`${API_URL}/login`, {
          email,
          password
        })

        this.token = response.data.access_token
        localStorage.setItem('token', this.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`
        this.error = null
      } catch (error) {
        this.error = 'Email ou senha inválidos'
        this.token = ''
        localStorage.removeItem('token')
      }
    },
    logout() {
      this.token = ''
      localStorage.removeItem('token')
      delete axios.defaults.headers.common['Authorization']
    }
  }
})