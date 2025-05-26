<template>
  <div class="container">
    <div class="login-box">
      <h2>Login</h2>
      
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label>Email:</label>
          <input 
            type="email" 
            v-model="email" 
            required 
            placeholder="Seu email"
          />
        </div>

        <div class="form-group">
          <label>Senha:</label>
          <input 
            type="password" 
            v-model="password" 
            required 
            placeholder="Sua senha"
          />
        </div>

        <div v-if="auth.error" class="error">{{ auth.error }}</div>

        <button type="submit" class="submit-btn">Entrar</button>
      </form>
    </div>
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
.container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #111;
  padding: 20px;
}

.login-box {
  width: 100%;
  max-width: 400px;
  padding: 32px;
  background: #222;
  border-radius: 10px;
  box-shadow: 0 2px 16px #0008;
}

h2 {
  color: #fff;
  text-align: center;
  margin-bottom: 24px;
  font-size: 24px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  color: #fff;
  margin-bottom: 8px;
  font-weight: 500;
}

input {
  width: 100%;
  padding: 12px;
  background: #333;
  color: #fff;
  border: 1px solid #444;
  border-radius: 4px;
  font-size: 14px;
}

input:focus {
  outline: none;
  border-color: #4f8cff;
}

input::placeholder {
  color: #666;
}

.submit-btn {
  width: 100%;
  padding: 12px;
  background: #4f8cff;
  color: #fff;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
  margin-top: 8px;
}

.submit-btn:hover {
  background: #2563eb;
}

.error {
  color: #ef4444;
  margin: 16px 0;
  padding: 12px;
  background: rgba(239, 68, 68, 0.1);
  border-radius: 4px;
  border: 1px solid rgba(239, 68, 68, 0.2);
  text-align: center;
}
</style>