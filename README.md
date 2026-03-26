# 🚀 System Login

Sistema completo de autenticação desenvolvido em PHP puro evoluindo até uma API profissional com JWT.
Esse projeto demonstra desde o básico até práticas reais utilizadas no mercado.

---

# 📌 Visão Geral

O **System Login** é um projeto full backend que inclui:

- Cadastro de usuários
- Login seguro
- Sessões e cookies
- Proteção contra ataques
- Controle de acesso
- Recuperação de senha
- API REST
- Autenticação com JWT

👉 Ideal para portfólio de desenvolvedor backend.

---

# 🧱 Tecnologias Utilizadas

- 🐘 PHP (PDO)
- 🗄️ MySQL
- 📦 Composer
- 🔐 JWT (JSON Web Token)
- 🌐 API REST
- 🧠 PSR-4 (autoload)

---

# 📁 Estrutura do Projeto

```
sistema-login/
│
├── public/              # Frontend simples (HTML/PHP)
├── app/                 # Sistema MVC
│   ├── controllers/
│   ├── models/
│   ├── core/
│   ├── middleware/
│
├── api/                 # API REST profissional
│   ├── controllers/
│   ├── models/
│   ├── core/
│   ├── middleware/
│   ├── routes/
│   ├── config/
│
├── config/
├── database/
├── .env
├── composer.json
```

---

# 🔐 Funcionalidades

## 🧾 Cadastro de Usuário

- Validação de dados
- Senha criptografada com `password_hash`
- Proteção contra SQL Injection

---

## 🔑 Login

- Verificação com `password_verify`
- Sessão ativa
- Redirecionamento seguro

---

## 🛡️ Segurança

### 🔒 CSRF Protection

- Token único por formulário
- Validação no backend

### 🧠 Boas práticas

- Prepared Statements
- `hash_equals`
- `random_bytes`

---

## 🍪 Lembrar-me

- Login persistente via cookie
- Token salvo no banco
- Reconexão automática

---

## 👑 Controle de Acesso

- Usuário comum
- Administrador
- Middleware de autorização

---

## 🔁 Recuperação de Senha

- Token único
- Expiração (1 hora)
- Redefinição segura

---

# 🌐 API REST

O sistema evolui para uma API completa:

### 📌 Endpoints

#### 🔹 Registro

```
POST /api/register
```

#### 🔹 Login

```
POST /api/login
```

#### 🔹 Usuário autenticado

```
GET /api/me
```

---

# 🔐 JWT (Autenticação Profissional)

- Token gerado no login
- Sem uso de sessão
- Enviado via header:

```
Authorization: Bearer TOKEN
```

---

# ⚙️ Instalação

## 1️⃣ Clonar o projeto

```
git clone https://github.com/seu-usuario/system-login.git
```

---

## 2️⃣ Instalar dependências

```
composer install
```

---

## 3️⃣ Configurar ambiente

Criar `.env`:

```
DB_HOST=localhost
DB_NAME=system_login
DB_USER=root
DB_PASS=
```

---

## 4️⃣ Criar banco de dados

```
CREATE DATABASE system_login;
```

---

## 5️⃣ Rodar projeto

- Coloque em um servidor local (XAMPP, Laragon)
- Acesse:

```
http://localhost/sistema-login/public
```

---

# 🧪 Testando API

Use ferramentas como:

- Postman
- Insomnia

---

# 📈 Evolução do Projeto

Este projeto foi construído em etapas:

1. Estrutura base
2. Cadastro e login
3. Sessão
4. Segurança (CSRF)
5. Cookies (lembrar-me)
6. Controle de acesso
7. Recuperação de senha
8. API REST
9. JWT

---

# 💡 Diferenciais

✔ Código organizado (MVC)
✔ Segurança aplicada na prática
✔ API pronta para frontend moderno
✔ Uso de padrões profissionais
✔ Projeto escalável

---

# 🚀 Próximos Passos

- 🔄 Refresh Token
- 📧 Envio de email real (PHPMailer)
- ⚡ Integração com React
- ☁️ Deploy (Railway / VPS)

---

# 👨‍💻 Autor

Desenvolvido por Victor Hugo
Projeto focado em evolução real como desenvolvedor backend.

---

# ⭐ Conclusão

Esse projeto não é apenas um login.
É um **mini sistema completo de autenticação profissional**.

---

# 📬 Licença

Uso livre para estudo e portfólio.
