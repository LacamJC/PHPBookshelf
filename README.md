# 📖 My Bookshelf PHP  
*PHP, MySQL, Docker, Nginx, CI/CD, Pest*


Um sistema de compartilhamento de livros cadastrados pelos usuários, desenvolvido **100% em PHP puro**, sem o uso de frameworks ou bibliotecas externas. Toda a estrutura foi pensada do zero, com foco em boas práticas de organização, testes e controle de versão.

O projeto conta com um *frontcontroller personalizado*, implementação completa das operações **CRUD** para as entidades principais, e arquitetura pronta para escalar novas funcionalidades.

---

## 💻 Tecnologias Utilizadas

- PHP 8.3  
- MySQL (produção)  
- SQLite (ambiente de desenvolvimento)  
- Bootstrap 5  
- Pest (testes unitários)  

---

## ✨ Funcionalidades

- Cadastro e autenticação de usuários  
- Cadastro, edição e exclusão de livros  
- Listagem de livros com paginação  
- Validação de entrada de dados  
- Separação clara entre camadas de aplicação (entidades, gateway, controller, view)

---

## Integrações e Processos

- **Banco de dados dual**: uso de MySQL em produção e SQLite em desenvolvimento, otimizando o ambiente de trabalho sem depender de servidores externos.
- **Testes automatizados com Pest**: cobertura dos principais fluxos da aplicação para garantir estabilidade contínua.
- **Deploy contínuo com GitHub Actions**: automatização total do fluxo de publicação para uma **VPS com Nginx** configurada manualmente.
  
---

>Projeto no ar:  [https://lacambookshelf.ddns.net](https://lacambookshelf.ddns.net/) 
><br>Documentação sobre o processo de deploy: [documentação deploy](./doc-deploy.md)


