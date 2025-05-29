# 📦 Teste Técnico - Gerenciamento de Produtos

Aplicativo web desenvolvido em **Laravel 11 + Vue 3 + Docker** para o gerenciamento de produtos, com foco em arquitetura limpa, boas práticas, testes automatizados e autenticação via token.

---

## 🚀 Tecnologias Utilizadas

### Backend:
- **Laravel 11** – Framework principal
- **Docker** – Ambiente isolado de desenvolvimento
- **MySQL** – Banco de dados relacional
- **Laravel Sanctum** – Autenticação com token
- **PHPUnit** – Testes unitários e de feature

### Frontend:
- **Vue.js 3** – Framework JavaScript
- **Pinia** – Gerenciamento de estado
- **Axios** – Requisições HTTP
- **Vite** – Ferramenta de build moderna

---

## 📂 Estrutura do Projeto

```
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
- Docker + Docker Compose

### Clonagem:

```bash
git clone https://github.com/maaclrd/api_laravel.git
cd laravel_docker
```

### Backend (Laravel):

```bash
docker-compose up -d

# Acesse o container
docker-compose exec app bash

# Instale dependências
composer install

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Execute as migrations e seeds
php artisan migrate --seed
```

### Frontend (Vue 3):

```bash
cd frontend_teste
npm install
npm run dev
```

Acesse:

- Frontend: [http://localhost:5173](http://localhost:5173)
- API: [http://localhost:8000/api](http://localhost:8000/api)

---

## 🔐 Autenticação

Login retorna um token JWT via Sanctum.

Usuário padrão criado via seeder:

```json
{
  "email": "admin@example.com",
  "password": "senha123"
}
```

As rotas protegidas exigem o header:

```
Authorization: Bearer {token}
```

---

## ✅ Testes Automatizados

### Para rodar todos os testes:

```bash
docker-compose exec app bash
php artisan migrate:fresh --env=testing
php artisan test
```

### Para testes específicos:

```bash
php artisan test --filter=ProductServiceTest
php artisan test --filter=ProductFeatureTest
```

**Cobertura:**

- Unitários: `ProductServiceTest`
- Feature: `ProductFeatureTest`

---

## 🧪 Funcionalidades Implementadas

- Login com token (Sanctum)
- CRUD de produtos com Soft Delete
- Filtros por nome, preço mínimo/máximo e estoque
- Paginação e ordenação
- Validações no frontend e backend
- Testes unitários e de integração

---

## 📌 Extras

- Estrutura baseada em Service/Repository
- Aplicação dos princípios **SOLID** e **Clean Code**
- Commits semânticos (`feat:`, `fix:`, `test:` etc.)

---

> Desenvolvido para fins de avaliação técnica. Em caso de dúvidas, fico à disposição.
