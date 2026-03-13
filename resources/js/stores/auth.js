import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../api'

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null)
    const token = ref(localStorage.getItem('token') || null)

    const isAuth = computed(() => !!token.value)

    async function login(credentials) {
        const { data } = await api.post('/login', credentials)
        token.value = data.token
        user.value = data.user
        localStorage.setItem('token', data.token)
    }

    async function register(credentials) {
        const { data } = await api.post('/register', credentials)
        token.value = data.token
        user.value = data.user
        localStorage.setItem('token', data.token)
    }

    async function fetchUser() {
        try {
            const { data } = await api.get('/user')
            user.value = data
        } catch {
            logout()
        }
    }

    function logout() {
        user.value = null
        token.value = null
        localStorage.removeItem('token')
    }

    return { user, token, isAuth, login, register, fetchUser, logout };
})
