# 📦 Teste Técnico - Gerenciamento de Produtos

Aplicativo web desenvolvido em **Laravel 11 + Vue 3 + Docker** para o gerenciamento de produtos, com foco em arquitetura limpa, boas práticas, testes automatizados e autenticação via token.

---

## 🚀 Tecnologias Utilizadas

### Backend:

* **Laravel 11** - Framework principal
* **Docker** - Ambiente isolado de desenvolvimento
* **MySQL** - Banco de dados
* **Laravel Sanctum** - Autenticação com token
* **PHPUnit** - Testes unitários e de feature

### Frontend:

* **Vue.js 3** - Framework JavaScript
* **Pinia** - Gerenciamento de estado
* **Axios** - Requisições HTTP
* **Vite** - Build tool

---

## 📂 Estrutura do Projeto

```
laravel_docker/
├── app/
│   ├── Http/Controllers/Api/   # Controllers da API
│   ├── Services/               # Regras de negócio
│   ├── Repositories/Contracts/ # Interfaces
│   ├── Repositories/Eloquent/  # Implementações dos repositórios
│   ├── Models/                 # Models Eloquent
│
├── database/
│   ├── factories/              # Factory de Product
│   ├── migrations/             # Estrutura da tabela products
│   ├── seeders/                # Dados de exemplo (opcional)
│
├── routes/
│   └── api.php                 # Rotas protegidas da API
│
├── tests/
│   ├── Feature/                # Testes de integração do ProductController
│   └── Unit/Services/          # Testes unitários do ProductService

frontend_teste/
├── src/
│   ├── views/                  # Login e CRUD de produtos
│   ├── components/             # Tabela, filtros, formulários
│   ├── stores/                 # AuthStore e ProductStore
│   └── router/                # Rotas protegidas
```

---

## 🛠️ Instalação e Execução

### Requisitos:

* Docker + Docker Compose

### Passos:

```bash
git clone https://github.com/seu-usuario/laravel_docker.git
cd laravel_docker
```

#### Backend:

```bash
docker-compose up -d

# Acesse o container PHP
docker-compose exec app bash

# Instale as dependências do Laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

#### Frontend:

```bash
cd frontend_teste
npm install
npm run dev
```

Acesse:

* Frontend: [http://localhost:5173](http://localhost:5173)
* API: [http://localhost:8000/api](http://localhost:8000/api)

---

## 🔐 Autenticação

* Login via email e senha retorna um token Bearer.
* Todas as rotas da API estão protegidas via `auth:sanctum`.

Usuário padrão (se criado via seeder):

```json
{
  "email": "admin@example.com",
  "password": "senha123"
}
```

---

## ✅ Testes Automatizados

Para rodar os testes:

```bash
docker-compose exec app bash
php artisan migrate:fresh --env=testing
php artisan test
```

Ou para testar apenas um grupo:

```bash
php artisan test --filter=ProductServiceTest
php artisan test --filter=ProductFeatureTest
```

Testes implementados:

* **Unitários**: `ProductServiceTest`
* **Feature**: `ProductFeatureTest`

---

## 🧪 Funcionalidades Implementadas

* Autenticação via token
* CRUD de produtos (com soft delete)
* Filtros por nome, preço mínimo/máximo e estoque
* Paginação e ordenação
* Validações frontend/backend
* Testes automatizados unitários e de feature

---

## 📌 Extras

* Segue padrões SOLID e Clean Code
* Estrutura desacoplada com Repositórios e Services
* Convenção de commits semânticos (ex: `feat:`, `fix:`, `test:`, `chore:`)

---

> Desenvolvido para fins de avaliação técnica. Qualquer dúvida, estou à disposição!

---

Se quiser, posso gerar esse README.md com emojis e estrutura ajustada no repositório GitHub direto ou como Markdown prrio GitHub direto ou como Markdown pr\u00onto para colar.
