# 🎞️ Teste Técnico - Gerenciamento de Produtos

Aplicativo web desenvolvido em **Laravel 11 + Vue 3 + Docker** para o gerenciamento de produtos, com foco em arquitetura limpa, boas práticas, testes automatizados e autenticação via token.

---

## 🚀 Tecnologias Utilizadas

### Backend:

* **Laravel 11** – Framework principal
* **Docker + Docker Compose** – Ambiente isolado de desenvolvimento
* **MySQL 8** – Banco de dados
* **Laravel Sanctum** – Autenticação via token
* **PHPUnit** – Testes unitários e de feature

### Frontend:

* **Vue.js 3** – Framework JavaScript moderno
* **Pinia** – Gerenciamento de estado
* **Axios** – Requisições HTTP
* **Vuetify** – Componentes UI
* **Vite** – Bundler rápido e moderno

---

## 📂 Estrutura do Projeto

```bash
laravel_docker/
├── app/
│   ├── Http/Controllers/Api/
│   ├── Services/
│   ├── Repositories/Contracts/
│   ├── Repositories/Eloquent/
│   ├── Models/
│   └── Exceptions/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── tests/
│   ├── Feature/
│   └── Unit/Services/

frontend_teste/
├── src/
│   ├── pages/
│   ├── views/
│   ├── components/
│   ├── stores/
│   └── router/
```

---

## 🛠️ Instalação e Execução

### Pré-requisitos:

* Docker instalado
* Node.js instalado (para o frontend)

### 1️⃣ Clonagem:

```bash
git clone https://github.com/maaclrd/api_laravel.git
cd laravel_docker
```

### 2️⃣ Backend (Laravel via Docker):

```bash
# Copia o arquivo de variáveis de ambiente
cp .env.example .env

# Sobe os containers com build
docker-compose up -d --build

# Instala as dependências
docker exec -it laravel_app composer install

# Gera a chave da aplicação
docker exec -it laravel_app php artisan key:generate

# Executa as migrations e seeders
docker exec -it laravel_app php artisan migrate --seed

# Inicia o servidor Laravel (se necessário)
docker exec -it laravel_app php artisan serve --host=0.0.0.0 --port=8000
```

### 3️⃣ Frontend (Vue 3):

```bash
cd frontend_teste
npm install
npm run dev
```

---

## 🌐 Acesso

* Frontend: [http://localhost:5173](http://localhost:5173)
* API Backend: [http://localhost:8000/api](http://localhost:8000/api)

---

## 🔐 Autenticação

Login via Laravel Sanctum. Após autenticação, é retornado um token Bearer.

Usuário padrão criado pelo seeder:

```json
{
  "email": "admin@example.com",
  "password": "senha123"
}
```

Use este token no cabeçalho para rotas protegidas:

```
Authorization: Bearer {token}
```

---

## ✅ Testes Automatizados

### Executar todos os testes:

```bash
docker exec -it laravel_app php artisan test
```

### Executar testes específicos:

```bash
php artisan test --filter=ProductServiceTest
php artisan test --filter=ProductFeatureTest
```

---

## 🧪 Funcionalidades Implementadas

* Login com token via Sanctum
* CRUD completo de produtos com Soft Delete
* Paginação, ordenação e filtros (nome, preço, estoque)
* Validações no frontend e backend
* Testes automatizados (unitários e de feature)

---

## 📌 Extras

* Estrutura desacoplada por camadas: Controllers, Services, Repositories
* Aplicação de boas práticas com **SOLID** e **Clean Code**
* Commits com convenção semântica (`feat:`, `fix:`, `test:` etc.)

---

> Projeto desenvolvido para fins de avaliação técnica.
> Em caso de dúvidas, entre em contato. Estou à disposição.
