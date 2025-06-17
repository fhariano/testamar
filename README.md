# TestAmar

Sistema de gestão de produtos com usuários `admin` e `user` desenvolvido em **Laravel 9 + VueJS (Inertia + Breeze)**.

## 🚀 Funcionalidades

- ✅ CRUD de Produtos (nome, descrição com tags HTML controladas, imagens, preço de venda, custo).
- ✅ Upload de múltiplas imagens com redimensionamento automático.
- ✅ Validação de preços (preço de venda ≥ custo + 10%).
- ✅ Permissões: 
  - Admin: Acesso total (adicionar novos usuários e gerenciar produtos).
  - User: Acesso somente ao gerenciamento de produtos.
- ✅ Interface SPA com Inertia + Vue.

## 🐳 Deploy Local com Docker

### 1️⃣ Requisitos

- Docker
- Docker Compose

### 2️⃣ Clone o projeto

```
git clone https://github.com/fhariano/testamar.git
cd testamar
```

### 3️⃣ Suba os containers

```
docker-compose up --build -d
```

### 4️⃣ Configure o ambiente

```
cp .env.example .env
```

Atualize no .env:

```
DB_HOST=127.0.0.1
DB_DATABASE=testamar
DB_USERNAME=root
DB_PASSWORD=root
```

### 5️⃣ Execute as migrations e seeders

```
docker exec -it testamar-app bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

### 🎨 Build Frontend

```
docker exec -it testamar-app bash
npm run build
exit
```

### Acesse
App: http://localhost:8000
PhpMyAdmin: http://localhost:8080

### Login para usuários de testes
user: admin@example.com
pwd: password

user: user@example.com
pwd: password

### Observação:
Novos usuários faz-se necessário uma conta de email real para ativação da conta e acesso!
