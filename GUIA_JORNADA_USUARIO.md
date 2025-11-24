# 🚀 Guia Completo da Jornada do Usuário - R+Cidades

## 📋 Pré-requisitos

Antes de começar, certifique-se de que:
1. ✅ Backend está rodando: `./vendor/bin/sail up` (API em http://localhost)
2. ✅ Frontend está rodando: `npm run dev` (Web em http://localhost:5174)
3. ✅ Banco de dados foi migrado: `./vendor/bin/sail artisan migrate`

---

## 🎯 Jornada Completa do Usuário

### **ETAPA 1: Cadastro de Usuários**

#### 1.1 Criar Conta de Doador
1. Acesse `http://localhost:5174`
2. Clique em **"Cadastrar"** no menu superior
3. Preencha o formulário:
   - **Nome**: João Silva
   - **Email**: joao@example.com
   - **Senha**: password123
   - **Confirmar Senha**: password123
   - **Tipo**: Doador
4. Clique em **"Registrar"**
5. Você será redirecionado para a tela de login

#### 1.2 Criar Conta de Beneficiário
1. Faça logout (se estiver logado)
2. Clique em **"Cadastrar"**
3. Preencha:
   - **Nome**: Maria Santos
   - **Email**: maria@example.com
   - **Senha**: password123
   - **Confirmar Senha**: password123
   - **Tipo**: Beneficiário
4. Clique em **"Registrar"**

---

### **ETAPA 2: Login e Perfil (Doador)**

#### 2.1 Fazer Login como Doador
1. Acesse `http://localhost:5174/login`
2. Credenciais:
   - **Email**: joao@example.com
   - **Senha**: password123
3. Clique em **"Entrar"**

#### 2.2 Completar Perfil
1. No menu do usuário (canto superior direito), clique em **"Meu Perfil"**
2. Preencha os dados:
   - **Telefone**: (11) 98765-4321
   - **Endereço**: Rua das Flores, 123
   - **Cidade**: São Paulo
   - **Estado**: SP
   - **CEP**: 01234-567
3. Clique em **"Salvar Alterações"**

---

### **ETAPA 3: Criar Anúncio de Material**

#### 3.1 Publicar Anúncio
1. No menu superior, clique em **"+ Anunciar"** (ou vá para `/criar-anuncio`)
2. Preencha o formulário:
   - **Título**: Sobras de Tijolos 8 Furos
   - **Categoria**: Tijolos e Blocos
   - **Condição**: Usado
   - **Quantidade**: 500
   - **Peso Estimado**: 250 (kg)
   - **Descrição**: Sobras de obra, tijolos em bom estado. Retirar no local.
   - **Fotos**: (Opcional) Adicione até 5 fotos
3. Clique em **"Publicar Anúncio"**
4. Você será redirecionado para **"Meus Anúncios"**

---

### **ETAPA 4: Solicitar Material (Beneficiário)**

#### 4.1 Fazer Login como Beneficiário
1. Faça logout do doador
2. Login com:
   - **Email**: maria@example.com
   - **Senha**: password123

#### 4.2 Buscar e Solicitar Material
1. Na **Home** (`/`), você verá o anúncio "Sobras de Tijolos 8 Furos"
2. Clique no card do anúncio para ver os detalhes
3. Clique em **"Solicitar Material"**
4. Escreva uma mensagem:
   - "Preciso desses tijolos para construir uma casa popular. Posso retirar amanhã."
5. Clique em **"Enviar Solicitação"**

#### 4.3 Verificar Solicitação
1. Vá para **"Minhas Solicitações"** (menu do usuário)
2. Você verá a solicitação com status **"Pendente"**

---

### **ETAPA 5: Aprovar Solicitação (Doador)**

#### 5.1 Login como Doador
1. Faça logout
2. Login com **joao@example.com** / **password123**

#### 5.2 Gerenciar Solicitações
1. Vá para **"Meus Anúncios"**
2. No card do anúncio, você verá **"1 interessado(s)"**
3. Clique em **"Gerenciar Solicitações"**
4. Veja a mensagem da Maria
5. Clique em **"Aprovar"**

---

### **ETAPA 6: Agendar Retirada (Beneficiário)**

#### 6.1 Login como Beneficiário
1. Faça logout
2. Login com **maria@example.com** / **password123**

#### 6.2 Agendar Data de Retirada
1. No menu do usuário, clique em **"Logística/Agendamentos"**
2. Na seção **"Pendente de Agendamento"**, você verá o anúncio aprovado
3. Clique em **"Agendar Retirada"**
4. Escolha uma data futura (ex: amanhã às 14:00)
5. Clique em **"Confirmar Agendamento"**

---

### **ETAPA 7: Confirmar Coleta e Entrega**

#### 7.1 Confirmar Coleta (Doador)
1. Login como **joao@example.com**
2. Vá para **"Logística/Agendamentos"**
3. Você verá o agendamento com status **"Agendada"**
4. Após a retirada acontecer, clique em **"Confirmar Coleta"**
5. Status muda para **"Coletada"**

#### 7.2 Confirmar Entrega (Beneficiário)
1. Login como **maria@example.com**
2. Vá para **"Logística/Agendamentos"**
3. Clique em **"Confirmar Entrega"** (ou botão equivalente)
4. Status muda para **"Entregue"**
5. O anúncio agora está com status **"Doado"**

---

### **ETAPA 8: Verificar Pontuação e Ranking**

#### 8.1 Ver Pontos Ganhos (Doador)
1. Login como **joao@example.com**
2. Vá para **"Dashboard"**
3. Você verá:
   - **Ranking de Doadores**: João Silva aparecerá com **260 pontos**
     - 10 pontos base + 250 pontos (peso do material)

---

## 🎁 Funcionalidades Extras

### Criar Banco de Materiais
1. Login como qualquer usuário
2. Vá para **"Bancos de Materiais"**
3. Clique em **"+ Cadastrar Novo Banco"**
4. Preencha:
   - **Nome**: Ponto de Coleta Centro
   - **Endereço**: Av. Paulista, 1000
   - **Telefone**: (11) 3333-4444
5. Salve

### Vincular Anúncio a Banco
1. Ao criar um anúncio, selecione o banco no campo **"Vincular a um Banco de Materiais"**

---

## ❗ Troubleshooting

### "Credenciais inválidas" ao fazer login
- **Causa**: Usuário não existe no banco
- **Solução**: Faça o cadastro primeiro em `/register`

### Backend não responde
- **Verificar**: `./vendor/bin/sail ps` (containers rodando?)
- **Solução**: `./vendor/bin/sail up -d`

### Frontend não carrega
- **Verificar**: Terminal mostra erros?
- **Solução**: `npm install` e depois `npm run dev`

---

## 📊 Resumo da Jornada

```
1. Cadastro → 2. Login → 3. Criar Anúncio (Doador)
                    ↓
4. Buscar → 5. Solicitar (Beneficiário)
                    ↓
6. Aprovar (Doador) → 7. Agendar (Beneficiário)
                    ↓
8. Confirmar Coleta (Doador) → 9. Confirmar Entrega (Beneficiário)
                    ↓
10. Pontos Atribuídos → 11. Ranking Atualizado
```

---

**Pronto!** Agora você tem um guia completo para testar todas as funcionalidades do R+Cidades! 🎉
