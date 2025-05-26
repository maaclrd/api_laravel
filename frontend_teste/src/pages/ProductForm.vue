<template>
  <div class="container">
    <div class="header">
      <h2>{{ isEdit ? 'Editar Produto' : 'Novo Produto' }}</h2>
      <button @click="router.push('/')" class="back-btn">Voltar</button>
    </div>

    <form @submit.prevent="handleSubmit">
      <div class="form-group">
        <label>Nome:</label>
        <input v-model="form.name" required />
      </div>

      <div class="form-group">
        <label>Descrição:</label>
        <textarea v-model="form.description"></textarea>
      </div>

      <div class="form-group">
        <label>Preço:</label>
        <input v-model.number="form.price" type="number" step="0.01" required min="0.01" />
      </div>

      <div class="form-group">
        <label>Estoque:</label>
        <input v-model.number="form.stock" type="number" required min="0" />
      </div>

      <div v-if="error" class="error">{{ error }}</div>

      <div class="form-actions">
        <button type="submit" class="submit-btn">{{ isEdit ? 'Atualizar' : 'Criar' }}</button>
        <button type="button" @click="router.push('/')" class="cancel-btn">Cancelar</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()
const isEdit = ref(!!route.params.id)
const form = ref({
  name: '',
  description: '',
  price: '',
  stock: ''
})
const error = ref('')

const fetchProduct = async () => {
  try {
    const response = await axios.get(`/products/${route.params.id}`)
    form.value = {
      name: response.data.data.name,
      description: response.data.data.description,
      price: parseFloat(response.data.data.price),
      stock: parseInt(response.data.data.stock)
    }
  } catch (e) {
    error.value = 'Erro ao carregar o produto'
  }
}

const handleSubmit = async () => {
  try {
    if (isEdit.value) {
      await axios.put(`/products/${route.params.id}`, form.value)
    } else {
      await axios.post('/products', form.value)
    }
    router.push('/')
  } catch (e) {
    error.value = 'Erro ao salvar produto. Verifique os dados.'
  }
}

onMounted(() => {
  if (isEdit.value) {
    fetchProduct()
  }
})
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 40px auto;
  padding: 24px;
  background: #222;
  border-radius: 10px;
  box-shadow: 0 2px 16px #0008;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

h2 {
  color: #fff;
  margin: 0;
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

input, textarea {
  width: 100%;
  padding: 10px;
  background: #333;
  color: #fff;
  border: 1px solid #444;
  border-radius: 4px;
  font-size: 14px;
}

input:focus, textarea:focus {
  outline: none;
  border-color: #4f8cff;
}

textarea {
  min-height: 100px;
  resize: vertical;
}

.form-actions {
  display: flex;
  gap: 12px;
  margin-top: 24px;
}

button {
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.2s;
}

.submit-btn {
  background: #4f8cff;
  color: #fff;
}

.submit-btn:hover {
  background: #2563eb;
}

.cancel-btn {
  background: #333;
  color: #fff;
  border: 1px solid #444;
}

.cancel-btn:hover {
  background: #444;
}

.back-btn {
  background: #333;
  color: #fff;
  border: 1px solid #444;
}

.back-btn:hover {
  background: #444;
}

.error {
  color: #ef4444;
  margin-top: 16px;
  padding: 12px;
  background: rgba(239, 68, 68, 0.1);
  border-radius: 4px;
  border: 1px solid rgba(239, 68, 68, 0.2);
}
</style> 