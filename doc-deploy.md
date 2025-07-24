# My Bookshelf PHP | Doc Deploy

> Aplicação CRUD em PHP puro com deploy em VPS (Nginx + PHP-FPM) e CI/CD via GitHub Actions


Este projeto tem como o objetivo o desenvolvimento de uma aplicação CRUD completa feita a partir do core do PHP puro sem o uso de frameworks. Após isso, utilizei como objeto de estudos para aprender sobre configuração de VPS para a hospedagem de projetos em ambientes de produção.

Atualmente *16/07/2025* tenho uma VPS na Hostinger que está hospedando este projeto em um servidor nginx para web e integrado com um deploy continuo com Workflow do GitHub. 

#### SUMÁRIO

- [Virtual Private Server - VPS](#virtual-private-server---vps)
  - [O que é](#o-que-é)
- [Servidor Web - Nginx](#servidor-web---nginx)
  - [Configuração do Nginx com PHP-FPM](#configuração-do-nginx-com-php-fpm)
    - [1 - Instalação](#1--instalação)
    - [2 - Estrutura de Diretórios](#2---estrutura-de-diretórios)
    - [3 - Configuração do Arquivo Nginx](#3---configuração-do-arquivo-nginx)
    - [6 - Ativação](#6---ativação)
    - [7 - Iniciar Nginx](#7---iniciar-nginx)
- [Automação e CI/CD](#automação-e-cicd)
  - [Integração e Deploy Contínuos](#integração-e-deploy-contínuos)
  - [Criando Workflow](#criando-workflow)

### VIRTUAL PRIVATE SERVER - VPS

Ao longo de todos os meus estudos e projetos, todos os deploys que fiz foram em plataformas que automatizam o processo como a *Vercel* ou a *Railway*, apesar de úteis elas facilitam tanto esta ação que todo o conhecimento necessário e essencial acaba nunca sendo necessário para quem não conhece, causando assim um grave deficit de conhecimento para alguêm que quer lidar com Desenvolvimento.

Com isso em mente, peguei uma *VPS* para aprender mais sobre como um sistema precisa ser configurado para que uma aplicação fique no ar, de maneira a ser acessivel para outros usuários.

###### O QUE É 

Uma *VPS* é uma máquina virtual que roda em um servidor físico externo, geralmente ao usar uma você geralmente você assinaria um serviço de alguma plataforma como a *Hostinger* que possuem diversos servidores espalhados na qual dividem eles entre várias máquinas virtuais personalizadas oferecendo acesso via *SSH* para acesso remoto.

Com isso você tem acesso a recursos de uma máquina completa sem a necessidade e possuir um servidor em casa, podendo também aumentar os recursos que precisa ou até mesmo limitar eles.

Diferente de **hospedagens compartilhadas** que você não possui acesso total ao sistema, uma *VPS* te dá uma liberdade maior em questão de controle, você decide quais serviços vão estar rodando e quais programas serão instalados.

Porém isso significa que você tem que entender o básico de sistemas *Unix* para poder realizar praticamente qualquer operação, entender como um sistema de pacotes funciona para instalar softwares externos.

Configuração de firewall com **UFW**, gerenciamento de permissões e usuários em sistemas *Linux* entre outras tarefas essenciais.

Com tudo isso você pode facilmente estar preparado para lidar com um ambiente remoto de uma máquina virtual.

Apesar disso, muitos serviços também oferecem interfaces gráficas para o gerenciamento de uma *VPS* o que facilita o usuário mais leigo nestas questões a administrar um ambiente virtual.


### SERVIDOR WEB - NGINX

Uma aplicação em *PHP* roda em servidores web, que inicialmente não possuem um interpretador para *PHP* fazendo com que eles não consigam executar o código. Por isso muitos servidores usam interpretadores a parte como o *php-fpm* para gerenciar esta parte da aplicação. 

Enquanto o servidor web disponibiliza os serviços, o interpretador do *php-fpm* cuida da execução dos scripts em *PHP*.

Antigamente a maioria dos projetos em *PHP* rodavam sobre um servidor *Apache* que apesar de possuir qualidades ótimas para isso, existiam algumas limitações que prejudicavam projetos em larga escala. 

Com isso veio a popularização de outro servidor web, sendo ele o  *Nginx* que se destacava por sua eficiência em lidar com múltiplas conexões no servidor onde se saia melhor onde o *Apache* falhava.

#### CONFIGURAÇÃO DO NGINX COM PHP-FPM

A união do *Nginx* e o *php-fpm* torna um projeto extremamente eficiente, onde o servidor fica responsável pela entrega de arquivos e o interpretador pela execução dos serviços solicitados nas requisições.

Para instalar e configurar o *Nginx* é necessário seguir os seguintes passos:


###### 1- INSTALAÇÃO

Instale o *Nginx* e os pacotes necessários para o *PHP* no ambiente 
````bash
    sudo apt install nginx php php-fpm php-mysql
````

Após isso será instalado o servidor web, o interpretador, o *PHP* e o módulo responsável pela comunicação entre um banco de dados e o *PHP*

###### 2 - ESTRUTURA DE DIRETÓRIOS

O servidor disponibiliza os arquivos de um site na pasta `/var/www/`, ou seja se você tem um projeto chamado `bookshelf` ele estará em `/var/www/bookshelf/` podendo assim permitir o acesso aos arquivos do projeto.

###### 3 - CONFIGURAÇÃO DO ARQUIVO NGINX

Após isso será necessário criar um arquivo de configuração para o *Nginx* conseguir interpretar como seu projeto funciona, a base do arquivo deve ser a seguinte.

Primeiro crie e abra o arquivo em um editor de texto.

````bash 
    sudo vim /etc/nginx/sites-available/bookshelf
````

Após isso essa será a estrutura necessária

````nginx 
server {
    listen 80;
    server_name SEU_DOMINIO.com.br; # ou use o IP da VPS

    root /var/www/bookshelf/public;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;# configurada para um frontcontroller
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock; # verifique se a versão é essa!
    }

    location ~ /\.ht {
        deny all;
    }
}

````

###### 6 - ATIVAÇÃO 

Para que seu projeto fique realmente disponivel, é necessário adicionar um link simbolico entre o arquivo de configuração e a pasta onde o *Nginx* disponibiliza os projetos realmente.

Para isso. 

````bash 
    ln -s /etc/nginx/sites-available/bookshelf /etc/nginx/sites-enabled/ # ln - cria um link simbólico entre duas pastas
````

###### 7 - INICIAR NGINX

Após estas etapas serem finalizadas, teste se está tudo ok com o servidor, com o comando.
````bash 
    sudo nginx -t
````

Após isso, será mostrado um retorno indicando se está tudo ok com o servidor.

Após realizar a criação do arquivo de configuração, sempre será necessário reiniciar o *Nginx* para ele pegar as novas configurações

````bash 
    sudo systemctl restart nginx
    # systemctl restart - reinicia alguma serviço ou processo 
````

Após isso, você terá disponível um projeto rodando em php na sua VPS


### AUTOMAÇÃO E CI/CD
Após ter configurado tudo corretamente, já ter meu projeto hospedado e rodando na minha *VPS*, surgiu um problema. 

Alterações pequenas em um terminal podem ser feitas de maneira eficiente, o problema acontece quando você tem que realizar muitas alterações em diversos arquivos de um projeto.

Isso acaba se tornando insustentável para um terminal simples como de uma *VPS*. 

Mas você realizar todas as alterações localmente, subir para o repositório remoto, após isso ter que acessar a *VPS* e realizar o *pull* desta alterações também acaba se tornando insustentável ao longo do tempo, o mesmo trabalho repetido manualmente diversas vezes possibilitando que pequenos erros causem problemas inimaginaveis.

###### INTEGRAÇÃO E DEPLOY CONTINUOS CI/CD

Para resolver está situação, podemos utilizar ferramentas para realizar a automação desta tarefa, podendo realizar diversas tarefas como a execução de testes, atualização de dependências e o deploy de maneira automatica. 

Utiliando *GitHub Actions* podemos configurar arquivos de `Workflow` para iniciar um processo de ações sempre que realizarmos um push para uma branch.

###### CRIANDO WORKFLOW

Para isso, será necessário criar no seu projeto o arquivo `.github/workflows/deploy.yml`. 

Com este arquivo podemos definir uma serie de tarefas que serão realizadas ao realizar uma ação especificada.

A estrutura segue este fluxo: 

````yaml
name: Deploy Automático # Nome que íra aparecer no GitHub actions

on: # Define em que momento ira ocorrer
  push: 
    branches:
      - main
    # acima define que quando ocorrer um push para a branch main ira ser executado

jobs: # Define os jobs que serão executados
  deploy:
    runs-on: ubuntu-latest # máquina virtual que ira rodar os scripts

    steps: # lista de tarefas que serão executadas
      - name: Clonando repositório # nome da tarefa
        uses: actions/checkout@v3 # clona o repositorio na máquina virtual

      - name: Enviando arquivos via SSH 
        uses: appleboy/scp-action@v0.1.7 # realiza o upload dos arquivos de forma segura com uma função nativa do GitHub actions
        with:
          host: ${{ secrets.VPS_HOST }}
          username: ${{ secrets.VPS_USER }}
          key: ${{ secrets.VPS_SSH_KEY }}
          source: "."
          target: "/var/www/bookshelf" # define qual pasta sera selecionada
````

Com este arquivo no seu projeto, e os segredos configurados no GitHub, este script de deploy está pronto e será executado sempre que ocorrer um `push` na branch `main`.


>Aviso: este readme foi modificado para informações relacionadas a configuração e deploy em uma VPS com esquemas de deploy continuo com o GitHub, para entender melhor o objetivo do projeto em si recomendo ver a documentação [Deste Projeto em Laravel](https://github.com/LacamJC/Laravel_Bookshelf/tree/main)



