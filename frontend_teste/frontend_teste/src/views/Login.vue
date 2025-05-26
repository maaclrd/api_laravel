<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Senha" required />
      <button type="submit">Entrar</button>
      <p v-if="auth.error" style="color:red">{{ auth.error }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const auth = useAuthStore()
const router = useRouter()

const handleLogin = async () => {
  await auth.login(email.value, password.value)
  if (auth.token) {
    router.push('/')
  }
}
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: 100px auto;
  text-align: center;
}
input {
  display: block;
  margin: 10px auto;
  padding: 8px;
  width: 100%;
}
button {
  padding: 8px 16px;
}
</style>