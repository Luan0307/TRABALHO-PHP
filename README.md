# EcoArte Tech Store — Sistema PHP com SQLite

Bem-vindo(a) ao projeto de sistema de cadastro, autenticação e mini e-commerce em PHP com banco de dados SQLite.

Este repositório é ideal para quem quer estudar:
- cadastro de usuários
- login com segurança
- proteção de páginas restritas
- manipulação de carrinho e pedidos
- persistência de dados com SQLite e PDO

---

## Recursos implementados

- Cadastro de usuários com validação e e-mail único
- Login seguro com `password_hash()` e `password_verify()`
- Controle de sessão e redirecionamento inteligente
- Mini loja pública com catálogo de produtos
- Carrinho de compras em sessão
- Finalização de pedidos com controle de estoque
- Área de usuário com painel, perfil e histórico de pedidos
- Página administrativa para cadastrar produtos com upload de imagem
- Proteção CSRF em formulários principais

---

## Arquivos principais

- `index.php` — ponto de entrada e redirecionamento
- `cadastro.php` — formulário e lógica de cadastro
- `login.php` — autenticação de usuário
- `dashboard.php` — área restrita do usuário
- `logout.php` — encerra sessão com limpeza segura
- `loja.php` — catálogo público de produtos
- `carrinho.php` — visualização e finalização de compras
- `meus_pedidos.php` — histórico de pedidos do usuário
- `perfil.php` — dados de entrega e faturamento
- `admin_produtos.php` — cadastro de produtos para administradores
- `db.php` — conexão PDO e criação automática de tabelas
- `helpers.php` — funções de sessão, redirecionamento e CSRF

---

## Como começar

### Pré-requisitos

- PHP 7.4 ou superior
- Extensão `pdo_sqlite` ativada

### Executando localmente

1. Abra o terminal na pasta do projeto
2. Execute:

```bash
php -S localhost:8000
```

3. Acesse no navegador:

```text
http://localhost:8000
```

O arquivo `database.db` será criado automaticamente na primeira requisição.

---

## Estrutura do banco de dados

O sistema cria automaticamente as tabelas: `usuarios`, `produtos`, `pedidos` e `pedido_itens`.

A tabela `usuarios` inclui campos de cadastro básicos e informações de entrega:
- nome
- email
- senha (hash)
- is_admin
- cpf
- endereco
- numero
- bairro
- cidade
- estado
- cep
- telefone

---

## Boas práticas aplicadas

- Uso de `PDO` com prepared statements
- Sanitização de saída com `htmlspecialchars()` para evitar XSS
- Regeneração do ID de sessão após login
- Validação de formulários no servidor
- Proteção CSRF em formulários sensíveis

---

## Observações

- O arquivo `database.db` é ignorado pelo `.gitignore`
- A pasta `uploads/produtos/` também está preservada para evitar subir imagens geradas localmente

---

## Próximas melhorias

- Recuperação de senha por e-mail
- Edição de perfil com troca de senha
- Listagem e edição de produtos em painel administrativo
- Pesquisa e filtro de produtos na loja
- Integração com sistema de pagamento simulado

---


# TRABALHO-PHP
