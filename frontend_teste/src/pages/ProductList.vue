<template>
  <div class="container">
    <div class="header">
      <h2>Produtos</h2>
      <button @click="handleLogout" class="logout-btn">Sair</button>
    </div>

    <div class="toolbar">
      <input v-model="search" placeholder="Buscar por nome..." />
      <input v-model="priceMin" type="number" placeholder="Preço Mínimo" />
      <input v-model="priceMax" type="number" placeholder="Preço Máximo" />
      <input v-model="stockMin" type="number" placeholder="Estoque Mínimo" />
      <button @click="fetchProducts">Buscar</button>
      <button @click="goToCreate">Novo Produto</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Descrição</th>
          <th>Preço</th>
          <th>Estoque</th>
          <th>Editar</th>
          <th>Excluir</th>
          <th>Restaurar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.name }}</td>
          <td>{{ product.description }}</td>
          <td>R$ {{ Number(product.price).toFixed(2) }}</td>
          <td>{{ product.stock }}</td>
          <td>
            <button @click="editProduct(product.id)">Editar</button>
          </td>
          <td>
            <button @click="deleteProduct(product.id)">Excluir</button>
          </td>
          <td>
            <button @click="restoreProduct(product.id)" v-if="product.deleted_at">Restaurar</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button :disabled="currentPage === 1" @click="changePage(currentPage - 1)">Anterior</button>
      <span>Página {{ currentPage }} de {{ totalPages }}</span>
      <button :disabled="currentPage === totalPages" @click="changePage(currentPage + 1)">Próxima</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const products = ref([])
const currentPage = ref(1)
const search = ref('')
const priceMin = ref('')
const priceMax = ref('')
const stockMin = ref('')
const totalPages = ref(1)
const router = useRouter()

const fetchProducts = async () => {
  try {
    const response = await axios.get('/products', {
      params: {
        page: currentPage.value,
        'filter[name]': search.value,
        'filter[price_min]': priceMin.value || undefined,
        'filter[price_max]': priceMax.value || undefined,
        'filter[stock_min]': stockMin.value || undefined
      }
    })

    products.value = response.data.data
    totalPages.value = response.data.meta?.last_page || 1
  } catch (e) {
    console.error('Erro ao buscar produtos', e)
  }
}

const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
    fetchProducts()
  }
}

const editProduct = (id) => {
  router.push(`/edit/${id}`)
}

const deleteProduct = async (id) => {
  if (confirm('Deseja excluir este produto?')) {
    await axios.delete(`/products/${id}`)
    fetchProducts()
  }
}

const goToCreate = () => {
  router.push('/create')
}

const handleLogout = async () => {
  try {
    await axios.post('/logout')
    router.push('/login')
  } catch (error) {
    console.error('Erro ao fazer logout:', error)
  }
}

const restoreProduct = async (id) => {
  if (confirm('Deseja restaurar este produto?')) {
    try {
      await axios.patch(`/products/${id}/restore`)
      fetchProducts()
    } catch (error) {
      console.error('Erro ao restaurar produto:', error)
    }
  }
}

// Sempre que algum filtro mudar, volta para página 1 e busca novamente
watch([search, priceMin, priceMax, stockMin], () => {
  currentPage.value = 1
  fetchProducts()
})

onMounted(fetchProducts)
</script>

<style scoped>
.container {
  max-width: 900px;
  margin: 40px auto;
  padding: 24px;
  background: #222;
  border-radius: 10px;
  box-shadow: 0 2px 16px #0008;
}

h2 {
  margin-bottom: 18px;
  color: #fff;
}

.toolbar {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  justify-content: flex-start;
  margin-bottom: 18px;
}

.toolbar input {
  width: 150px;
  background: #333;
  color: #fff;
  border: 1px solid #444;
  border-radius: 4px;
  padding: 6px;
}

.toolbar button {
  background: #4f8cff;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 7px 16px;
  cursor: pointer;
  transition: background 0.2s;
}

.toolbar button:hover {
  background: #2563eb;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  background: #222;
  color: #fff;
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 12px;
}

th, td {
  padding: 12px 10px;
  border-bottom: 1px solid #333;
  text-align: left;
}

th {
  background: #181818;
  position: sticky;
  top: 0;
  z-index: 1;
}

tr:last-child td {
  border-bottom: none;
}

tbody tr:hover {
  background: #2a2a2a;
}

button {
  background: #4f8cff;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 6px 12px;
  margin-right: 4px;
  cursor: pointer;
  transition: background 0.2s;
}

button:hover {
  background: #2563eb;
}

.pagination {
  margin-top: 10px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 10px;
}

.pagination button {
  background: #333;
  color: #fff;
  border: 1px solid #444;
  border-radius: 4px;
  padding: 5px 12px;
  cursor: pointer;
  transition: background 0.2s;
}

.pagination button:disabled {
  background: #222;
  color: #888;
  cursor: not-allowed;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
}

.logout-btn {
  background: #dc2626;
  color: white;
  padding: 8px 16px;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s;
}

.logout-btn:hover {
  background: #b91c1c;
}
</style>