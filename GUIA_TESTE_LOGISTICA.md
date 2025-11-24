# 🚚 Guia de Teste: Fluxo de Logística e Agendamento

Este guia descreve passo a passo como testar o ciclo completo de doação, desde a criação do anúncio até a confirmação de entrega.

## 📋 Pré-requisitos

1.  **Dois Usuários Cadastrados**:
    *   **Usuário A (Doador)**: Quem cria o anúncio.
    *   **Usuário B (Beneficiário)**: Quem solicita o material.
2.  **Servidores Rodando**:
    *   Backend: `php artisan serve` (ou `./vendor/bin/sail up`)
    *   Frontend: `npm run dev`

---

## 🔄 Passo a Passo do Teste

### Passo 1: Criar Anúncio (Usuário A - Doador)

1.  Faça login como **Usuário A**.
2.  Vá para **Criar Anúncio**.
3.  Preencha os dados (Título, Categoria, etc.).
    *   *Opcional*: Vincule a um Banco de Materiais se desejar testar essa funcionalidade.
4.  Clique em **Publicar Anúncio**.
5.  Verifique se o anúncio aparece em **Meus Anúncios** com status `Disponível`.
6.  Faça **Logout**.

### Passo 2: Solicitar Material (Usuário B - Beneficiário)

1.  Faça login como **Usuário B**.
2.  Na **Home**, localize o anúncio criado pelo Usuário A.
3.  Clique em **Ver Detalhes**.
4.  Clique em **Solicitar Material**.
5.  Escreva uma mensagem de justificativa e confirme.
6.  Vá para **Minhas Solicitações** e verifique se o status está `Pendente`.
7.  Faça **Logout**.

### Passo 3: Aprovar Solicitação (Usuário A - Doador)

1.  Faça login como **Usuário A**.
2.  Vá para **Meus Anúncios**.
3.  No card do anúncio, você verá um aviso de "1 interessado(s)".
4.  Clique em **Gerenciar Solicitações**.
5.  No modal, clique em **Aprovar** na solicitação do Usuário B.
6.  O status do anúncio mudará para `Reservado`.
7.  Faça **Logout**.

### Passo 4: Agendar Retirada (Usuário B - Beneficiário)

1.  Faça login como **Usuário B**.
2.  Vá para o menu do usuário e clique em **Logística/Agendamentos**.
3.  Na seção "Pendente de Agendamento", você verá o anúncio aprovado.
4.  Clique em **Agendar Retirada**.
5.  Escolha uma data e hora futura e confirme.
6.  A solicitação moverá para a seção "Agendamentos Confirmados" com status `Agendada`.

### Passo 5: Confirmar Coleta (Usuário A ou B)

*Neste fluxo simplificado, tanto o doador quanto o beneficiário podem confirmar que a coleta ocorreu.*

1.  Ainda como **Usuário B** (ou faça login como A).
2.  Na página **Logística/Agendamentos**, localize o agendamento.
3.  Clique em **Confirmar Coleta**.
4.  O status mudará para `Coletada`.

### Passo 6: Confirmar Entrega/Recebimento (Usuário B - Beneficiário)

1.  Como **Usuário B** (Beneficiário).
2.  Na página **Logística/Agendamentos**, o botão mudará (se a lógica de frontend permitir, ou aguarde atualização futura para confirmação final de entrega).
    *   *Nota: Atualmente o botão de confirmação de entrega pode estar desabilitado ou automático dependendo da regra de negócio. Se estiver desabilitado ("Aguardando Entrega"), o fluxo termina na Coleta para este MVP, ou requer que o Doador confirme a entrega final.*

---

## ✅ Resultados Esperados

- O anúncio deve terminar com status `Doado`.
- O agendamento deve terminar com status `Entregue` (se o fluxo for completo).
- O material não deve mais aparecer na busca da Home (pois foi doado).
