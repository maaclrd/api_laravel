<template>
  <div class="container">
    <h2>{{ isEdit ? 'Editar Produto' : 'Novo Produto' }}</h2>

    <form @submit.prevent="handleSubmit">
      <div>
        <label>Nome:</label>
        <input v-model="form.name" required />
      </div>

      <div>
        <label>Descrição:</label>
        <textarea v-model="form.description"></textarea>
      </div>

      <div>
        <label>Preço:</label>
        <input v-model.number="form.price" type="number" step="0.01" required min="0.01" />
      </div>

      <div>
        <label>Estoque:</label>
        <input v-model.number="form.stock" type="number" required min="0" />
      </div>

      <div v-if="error" class="error">{{ error }}</div>

      <button type="submit">{{ isEdit ? 'Atualizar' : 'Criar' }}</button>
      <button type="button" @click="router.push('/')">Cancelar</button>
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
  margin: auto;
  padding: 20px;
}
form div {
  margin-bottom: 10px;
}
label {
  display: block;
  font-weight: bold;
}
input, textarea {
  width: 100%;
  padding: 6px;
}
button {
  margin-right: 10px;
}
.error {
  color: red;
}
</style> 