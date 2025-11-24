# 📤 Guia: Como Subir o Projeto R+Cidades no GitHub

## 🤔 Opção 1: Repositórios Separados (RECOMENDADO)

Esta é a abordagem mais comum para projetos fullstack. Você terá:
- `r-cidades-api` (Backend)
- `r-cidades-web` (Frontend)

### Vantagens:
- ✅ Deploy independente (API e Frontend podem estar em servidores diferentes)
- ✅ Controle de versão separado
- ✅ Mais fácil para colaboradores focarem em uma parte
- ✅ CI/CD independente

### Como Fazer:

#### 1. Criar Repositório para o Backend

```bash
# Navegar para a pasta da API
cd ~/projetos/r-cidades-api

# Inicializar Git (se ainda não foi)
git init

# Criar .gitignore
cat > .gitignore << EOF
/vendor
/node_modules
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/storage/*.key
/public/storage
/public/hot
EOF

# Adicionar todos os arquivos
git add .

# Fazer primeiro commit
git commit -m "Initial commit - R+Cidades API"

# Criar repositório no GitHub (via navegador ou CLI)
# Depois conectar:
git remote add origin https://github.com/SEU-USUARIO/r-cidades-api.git
git branch -M main
git push -u origin main
```

#### 2. Criar Repositório para o Frontend

```bash
# Navegar para a pasta do Frontend
cd ~/projetos/r-cidades-web

# Inicializar Git
git init

# Criar .gitignore
cat > .gitignore << EOF
# Dependências
/node_modules
/.pnp
.pnp.js

# Produção
/dist
/build

# Diversos
.DS_Store
.env.local
.env.development.local
.env.test.local
.env.production.local

npm-debug.log*
yarn-debug.log*
yarn-error.log*
EOF

# Adicionar arquivos
git add .

# Commit
git commit -m "Initial commit - R+Cidades Web"

# Conectar ao GitHub
git remote add origin https://github.com/SEU-USUARIO/r-cidades-web.git
git branch -M main
git push -u origin main
```

---

## 🤔 Opção 2: Monorepo (Tudo Junto)

Um único repositório contendo API e Web.

### Vantagens:
- ✅ Histórico unificado
- ✅ Mais fácil para sincronizar mudanças entre frontend e backend
- ✅ Um único clone

### Desvantagens:
- ❌ Repositório maior
- ❌ Deploy mais complexo
- ❌ CI/CD precisa detectar mudanças em subpastas

### Como Fazer:

```bash
# Criar pasta pai
cd ~/projetos
mkdir r-cidades-monorepo
cd r-cidades-monorepo

# Mover as pastas para dentro
mv ../r-cidades-api ./api
mv ../r-cidades-web ./web

# Inicializar Git
git init

# Criar .gitignore na raiz
cat > .gitignore << EOF
# API
/api/vendor
/api/.env
/api/storage/*.key

# Web
/web/node_modules
/web/dist
/web/.env.local

# Geral
.DS_Store
EOF

# Criar README.md na raiz
cat > README.md << EOF
# R+Cidades - Plataforma de Economia Circular

## Estrutura do Projeto

- \`/api\` - Backend Laravel
- \`/web\` - Frontend React

## Instalação

Veja os READMEs individuais em cada pasta.
EOF

# Adicionar tudo
git add .

# Commit
git commit -m "Initial commit - R+Cidades Monorepo"

# Conectar ao GitHub
git remote add origin https://github.com/SEU-USUARIO/r-cidades.git
git branch -M main
git push -u origin main
```

---

## 📝 Passo a Passo Visual (GitHub Web)

### 1. Criar Repositório no GitHub

1. Acesse [github.com](https://github.com)
2. Clique em **"New"** (botão verde no canto superior direito)
3. Preencha:
   - **Repository name**: `r-cidades-api` (ou `r-cidades-web`)
   - **Description**: "Backend da plataforma R+Cidades" (ou "Frontend...")
   - **Public** ou **Private** (sua escolha)
   - **NÃO** marque "Add a README" (já temos)
4. Clique em **"Create repository"**

### 2. Conectar Repositório Local ao GitHub

Copie os comandos que o GitHub mostra e cole no terminal:

```bash
git remote add origin https://github.com/SEU-USUARIO/r-cidades-api.git
git branch -M main
git push -u origin main
```

---

## 🔐 Autenticação no GitHub

Se pedir senha ao fazer `git push`, você tem duas opções:

### Opção A: Personal Access Token (Recomendado)

1. GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token
3. Marque: `repo` (full control)
4. Copie o token
5. Use o token como senha quando o Git pedir

### Opção B: SSH (Mais Seguro)

```bash
# Gerar chave SSH
ssh-keygen -t ed25519 -C "seu-email@example.com"

# Copiar chave pública
cat ~/.ssh/id_ed25519.pub

# Adicionar no GitHub: Settings → SSH and GPG keys → New SSH key
# Colar a chave copiada

# Usar URL SSH em vez de HTTPS
git remote set-url origin git@github.com:SEU-USUARIO/r-cidades-api.git
```

---

## ✅ Minha Recomendação

**Use Repositórios Separados (Opção 1)**

Motivos:
1. Padrão da indústria para projetos fullstack
2. Facilita deploy (Vercel para frontend, Railway/Heroku para backend)
3. Mais profissional no portfólio
4. Facilita contribuições futuras

---

## 📦 Estrutura Final no GitHub

```
github.com/SEU-USUARIO/
├── r-cidades-api/          # Backend
│   ├── app/
│   ├── database/
│   ├── routes/
│   └── README.md
│
└── r-cidades-web/          # Frontend
    ├── src/
    ├── public/
    └── README.md
```

---

## 🚀 Próximos Passos Após Subir

1. Adicionar badges no README (build status, license)
2. Configurar GitHub Actions para CI/CD
3. Adicionar CONTRIBUTING.md
4. Criar releases/tags para versões

---

**Dúvidas?** Consulte a [documentação oficial do Git](https://git-scm.com/doc)
