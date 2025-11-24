# 🏗️ R+Cidades - Plataforma de Economia Circular para Construção Civil

![Status](https://img.shields.io/badge/status-MVP-success)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![React](https://img.shields.io/badge/React-18.x-blue)
![License](https://img.shields.io/badge/license-MIT-green)

## 📋 Sobre o Projeto

**R+Cidades** é uma plataforma web que conecta doadores e beneficiários de materiais de construção civil, promovendo a economia circular e reduzindo o desperdício. O projeto facilita a doação de sobras de obras, materiais usados e excedentes, contribuindo para a sustentabilidade urbana e inclusão social.

### 🎯 Principais Funcionalidades

- 🔐 **Autenticação Segura** - Sistema de login e registro com JWT
- 📢 **Gestão de Anúncios** - Criar, editar e excluir anúncios de materiais
- 🤝 **Sistema de Solicitações** - Beneficiários podem solicitar materiais
- 📅 **Logística e Agendamentos** - Agendar retirada e confirmar entregas
- 🏆 **Gamificação** - Sistema de pontos e ranking de doadores
- 📊 **Dashboard de Impacto** - Visualize o impacto ambiental (kg desviados de aterros)
- 🗺️ **Bancos de Materiais** - Cadastro de pontos de coleta
- 🔍 **Busca e Filtros** - Encontre materiais por categoria, condição e localização

---

## 🛠️ Tecnologias Utilizadas

### Backend
- **Laravel 11.x** - Framework PHP
- **MySQL** - Banco de dados
- **Laravel Sanctum** - Autenticação API
- **PHPUnit** - Testes automatizados
- **Docker (Laravel Sail)** - Ambiente de desenvolvimento

### Frontend
- **React 18.x** - Biblioteca JavaScript
- **Vite** - Build tool
- **React Router** - Roteamento
- **Context API** - Gerenciamento de estado
- **CSS Modules** - Estilização

---

## 📦 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **Docker Desktop** (Windows/Mac) ou **Docker Engine** (Linux)
- **Node.js** 18+ e **npm**
- **Git**

---

## 🚀 Instalação e Configuração

### 1. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/r-cidades.git
cd r-cidades
```

### 2. Configurar Backend (API)

```bash
cd r-cidades-api

# Copiar arquivo de ambiente
cp .env.example .env

# Subir containers Docker
./vendor/bin/sail up -d

# Instalar dependências
./vendor/bin/sail composer install

# Gerar chave da aplicação
./vendor/bin/sail artisan key:generate

# Rodar migrations
./vendor/bin/sail artisan migrate

# (Opcional) Popular banco com dados de exemplo
./vendor/bin/sail artisan db:seed --class=DemoDataSeeder
```

**A API estará rodando em**: `http://localhost`

### 3. Configurar Frontend (Web)

```bash
cd ../r-cidades-web

# Instalar dependências
npm install

# Criar arquivo .env
echo "VITE_API_URL=http://localhost/api" > .env

# Iniciar servidor de desenvolvimento
npm run dev
```

**O frontend estará rodando em**: `http://localhost:5173` (ou 5174)

---

## 👥 Usuários de Demonstração

Se você rodou o seeder, pode fazer login com:

| Email | Senha | Tipo | Pontos |
|-------|-------|------|--------|
| joao@example.com | password123 | Doador | 150 |
| carlos@example.com | password123 | Doador | 200 |
| ana@example.com | password123 | Doador | 80 |
| maria@example.com | password123 | Beneficiário | - |
| pedro@example.com | password123 | Beneficiário | - |

---

## 📖 Guias de Uso

### Jornada Completa do Usuário

Consulte o arquivo `GUIA_JORNADA_USUARIO.md` para um passo a passo detalhado de como:
1. Criar uma conta
2. Publicar um anúncio (Doador)
3. Solicitar material (Beneficiário)
4. Aprovar solicitação (Doador)
5. Agendar retirada
6. Confirmar coleta e entrega
7. Ganhar pontos e aparecer no ranking

### Testar Logística

Consulte `GUIA_TESTE_LOGISTICA.md` para testar o fluxo de agendamento e confirmação de entregas.

---

## 🧪 Testes

### Rodar Testes do Backend

```bash
cd r-cidades-api

# Rodar todos os testes
./vendor/bin/sail test

# Rodar teste específico
./vendor/bin/sail test --filter=AuthTest

# Rodar com cobertura
./vendor/bin/sail test --coverage
```

### Testes Disponíveis
- **AuthTest** - Registro e login
- **AnuncioTest** - CRUD de anúncios e permissões
- **LogisticaTest** - Fluxo completo de doação (E2E)

---

## 📁 Estrutura do Projeto

```
r-cidades/
├── r-cidades-api/          # Backend Laravel
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   └── Http/Requests/
│   ├── database/
│   │   ├── migrations/
│   │   ├── seeders/
│   │   └── factories/
│   ├── routes/
│   │   └── api.php
│   └── tests/
│       └── Feature/
│
└── r-cidades-web/          # Frontend React
    ├── src/
    │   ├── components/     # Componentes reutilizáveis
    │   ├── pages/          # Páginas da aplicação
    │   ├── context/        # Context API (Auth)
    │   ├── config/         # Configurações (API)
    │   └── index.css       # Design system global
    └── public/
```

---

## 🎨 Design System

O projeto utiliza um design system baseado em variáveis CSS definidas em `src/index.css`:

- **Cores Principais**: Azul (#3b82f6), Verde (#10b981), Vermelho (#ef4444)
- **Tipografia**: Inter (Google Fonts)
- **Espaçamento**: Sistema de 8px
- **Componentes**: Button, Input, Card, Loading, Toast, Modal, Navbar, Footer

---

## 🔐 Autenticação

A autenticação é feita via **Laravel Sanctum** com tokens Bearer:

```javascript
// Exemplo de requisição autenticada
const response = await fetch('http://localhost/api/anuncios', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  }
});
```

---

## 📊 Endpoints da API

### Autenticação
- `POST /api/register` - Registrar usuário
- `POST /api/login` - Fazer login
- `POST /api/logout` - Fazer logout

### Anúncios
- `GET /api/anuncios` - Listar anúncios (público)
- `POST /api/anuncios` - Criar anúncio (autenticado)
- `GET /api/anuncios/{id}` - Ver detalhes
- `PUT /api/anuncios/{id}` - Editar (dono)
- `DELETE /api/anuncios/{id}` - Excluir (dono)

### Solicitações
- `GET /api/minhas-solicitacoes` - Listar minhas solicitações
- `POST /api/solicitacoes` - Criar solicitação
- `POST /api/solicitacoes/{id}/aprovar` - Aprovar (doador)
- `POST /api/solicitacoes/{id}/rejeitar` - Rejeitar (doador)

### Agendamentos
- `GET /api/agendamentos` - Listar agendamentos
- `POST /api/agendamentos` - Criar agendamento
- `PUT /api/agendamentos/{id}` - Atualizar status

### Dashboard
- `GET /api/dashboard` - KPIs e ranking

**Documentação completa**: Consulte `DOCUMENTACAO_API.md` (em breve)

---

## 🤝 Contribuindo

Contribuições são bem-vindas! Para contribuir:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

---

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

---

## 👨‍💻 Autores

- **Equipe R+Cidades** - Desenvolvimento inicial

---

## 🙏 Agradecimentos

- Comunidade Laravel
- Comunidade React
- Todos os contribuidores do projeto

---

## 📞 Contato

Para dúvidas ou sugestões:
- **Email**: contato@rcidades.com.br
- **GitHub Issues**: [Abrir issue](https://github.com/seu-usuario/r-cidades/issues)

---

**Feito com ❤️ para um futuro mais sustentável**
