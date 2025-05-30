

---

# Checklist de Testes para Usuário — My\_Bookshelf\_2025

### 1. **Visualização/Listagem de livros**

* [X] Acessar a página de listagem de livros (`GET /livros` ou equivalente)
* [X] Verificar se todos os livros são listados corretamente com dados básicos (título, autor, capa, etc)
* [X] Testar paginação:

  * [X] Acessar diferentes páginas (`?page=1`, `?page=2` etc)
  * [x] Verificar se a paginação respeita o limite definido (ex: 4 livros por página)
  * [X] Verificar comportamento ao acessar página inválida (ex: `?page=9999`)
* [X] Verificar ordenação dos livros (ex: ordenados por id DESC)

---

### 2. **Cadastro de um novo livro**

* [X] Acessar a página/formulário de cadastro de livro
* [X] Preencher todos os campos obrigatórios e enviar
* [x] Confirmar que o livro foi salvo corretamente no banco
* [x] Confirmar que o livro aparece na listagem após cadastro
* [x] Testar envio de dados inválidos ou incompletos (ex: campos em branco)
* [x] Testar upload de capa (se aplicável) e confirmar o arquivo foi salvo

---

### 3. **Visualização dos detalhes de um livro**

* [X] Clicar para visualizar detalhes de um livro específico
* [X] Confirmar que os dados exibidos estão corretos e completos
* [X] Testar acesso com um ID inexistente (ex: `/livros/9999`)
* [X] Confirmar redirecionamento ou mensagem de erro apropriada para livro não encontrado

---

### 4. **Edição de um livro existente**

* [X] Acessar o formulário de edição para um livro existente
* [X] Alterar um ou mais campos e enviar o formulário
* [X] Confirmar que as alterações foram atualizadas corretamente no banco
* [X] Confirmar que os dados atualizados aparecem corretamente na visualização e listagem
* [X] Testar edição com dados inválidos (ex: campos obrigatórios em branco)
* [X] Testar edição de um livro inexistente (ex: tentar editar livro que não existe)

---

### 5. **Exclusão de um livro**

* [X] Excluir um livro existente via ação específica (ex: botão "Excluir")
* [X] Confirmar que o livro foi removido do banco
* [X] Confirmar que a imagem da capa foi excluída do servidor (se não for a placeholder)
* [X] Testar exclusão de livro inexistente ou com ID inválido
* [X] Confirmar mensagens e redirecionamentos após exclusão (sucesso e erro)

---

### 6. **Fluxos de erro e exceção**

* [X] Simular falha na conexão com o banco de dados e confirmar tratamento de erro
* [X] Simular falha ao executar queries (ex: inserção duplicada) e verificar mensagens de erro
* [X] Confirmar que erros não expõem dados sensíveis ao usuário
* [X] Verificar logs gerados para erros (ex: LoggerTXT)

---

### 7. **Validação de acesso e segurança**

* [X] Testar restrição de acesso se a aplicação tiver controle de usuários/autenticação
* [X] Testar envio de dados maliciosos (ex: SQL Injection) e confirmar que prepared statements previnem ataques
* [X] Verificar permissões para upload e exclusão de arquivos (capas)

---

### 8. **Usabilidade geral**

* [X] Confirmar que mensagens de feedback são claras (sucesso, erro, warning)
* [X] Confirmar que redirecionamentos ocorrem corretamente após ações
* [X] Testar comportamento em diferentes navegadores e dispositivos (responsividade)
* [X] Confirmar que campos de formulários possuem validação adequada (HTML5 + backend)

---

### Extras (se aplicável)

* [X] Testar upload e substituição da capa do livro no momento da edição

---

