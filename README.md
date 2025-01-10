# 📝 Teste VOZ - Desenvolvedor Back-End

## 📄 Descrição

Este projeto é uma aplicação backend desenvolvida em **PHP** utilizando o framework **Laravel** e **PostgreSQL** como banco de dados. A aplicação implementa uma API CRUD para gerenciar as entidades "Produtos" e "Categorias".

## 📋 Instruções de Instalação

1. **Clone** este repositório para o seu ambiente local:
    ```bash
    git clone https://github.com/Alan01777/teste-voz-backEnd.git
    ```

2. **Instale** as dependências do PHP utilizando o Composer:
    ```bash
    composer install
    ```

3. **Instale** as dependências do JavaScript utilizando o npm:
    ```bash
    npm install
    ```

4. **Copie** o arquivo `.env.example` para `.env` e configure as variáveis de ambiente:
    ```bash
    cp .env.example .env
    ```

5. **Gere** a chave da aplicação Laravel:
    ```bash
    php artisan key:generate
    ```

6. **Configure** o banco de dados no arquivo `.env`:
    ```dotenv
    DB_CONNECTION=pgsql
    DB_HOST=postgres
    DB_PORT=5432
    DB_DATABASE=voz
    DB_USERNAME=user_voz
    DB_PASSWORD=password_voz
    SSL_MODE=prefer
    ```

7. **Execute** as migrações para criar as tabelas no banco de dados:
    ```bash
    php artisan migrate
    ```

8. **Inicie** o servidor de desenvolvimento:
    ```bash
    php artisan serve
    ```

## 🐳 Inicialização com Docker

Se preferir, você pode utilizar o Docker para inicializar a aplicação. Siga os passos abaixo:

1. **Copie** o arquivo `.env.example` para `.env` e configure as variáveis de ambiente:
    ```bash
    cp .env.example .env
    ```

2. **Configure** o banco de dados no arquivo `.env`:
    ```dotenv
    DB_CONNECTION=pgsql
    DB_HOST=postgres
    DB_PORT=5432
    DB_DATABASE=voz
    DB_USERNAME=user_voz
    DB_PASSWORD=password_voz
    SSL_MODE=prefer
    ```

3. **Construa** e **inicie** os containers Docker:
    ```bash
    docker-compose up --build
    ```

4. **Acesse** a aplicação no navegador:
    ```bash
    http://localhost:8080
    ```

5. **Execute** as migrações para criar as tabelas no banco de dados:
    ```bash
    docker-compose exec app php artisan migrate
    ```

Agora você pode utilizar a aplicação normalmente através do Docker.

## 🛠️ Funcionalidades

A aplicação inclui as seguintes operações CRUD para as entidades "Produtos" e "Categorias":

### Produtos

1. **Criar Produto:**
    - Rota: `POST /api/produtos`
    - Payload: `{ "nome": "Nome do Produto", "descricao": "Descrição do Produto", "preco": 100.00, "categoria_id": 1 }`

2. **Ler Produtos:**
    - Rota: `GET /api/produtos`
    - Retorna uma lista de todos os produtos.

3. **Ler Produto por ID:**
    - Rota: `GET /api/produtos/{id}`
    - Retorna os detalhes de um produto específico.

4. **Atualizar Produto:**
    - Rota: `PUT /api/produtos/{id}`
    - Payload: `{ "nome": "Nome do Produto", "descricao": "Descrição do Produto", "preco": 150.00, "categoria_id": 2 }`

5. **Deletar Produto:**
    - Rota: `DELETE /api/produtos/{id}`
    - Deleta um produto específico.

### Categorias

1. **Criar Categoria:**
    - Rota: `POST /api/categorias`
    - Payload: `{ "nome": "Nome da Categoria" }`

2. **Ler Categorias:**
    - Rota: `GET /api/categorias`
    - Retorna uma lista de todas as categorias.

3. **Ler Categoria por ID:**
    - Rota: `GET /api/categorias/{id}`
    - Retorna os detalhes de uma categoria específica.

4. **Atualizar Categoria:**
    - Rota: `PUT /api/categorias/{id}`
    - Payload: `{ "nome": "Nome da Categoria Atualizada" }`

5. **Deletar Categoria:**
    - Rota: `DELETE /api/categorias/{id}`
    - Deleta uma categoria específica.

### Relacionamento Produto-Categoria

- Cada produto pertence a uma categoria (`categoria_id` como chave estrangeira na tabela `produtos`).
- Cada categoria pode ter vários produtos.

## 📚 Documentação da API

A documentação da API foi feita utilizando o **Postman**. Você pode importar a coleção de requests do Postman para testar as APIs.
