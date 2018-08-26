# Golden Frota

# Instalação em ambientes Microsoft Windows

## Download Wamp

https://sourceforge.net/projects/wampserver/files/latest/download

### Cuidados durante a instalação
Nas primeiras telas da instalação é apresentado um aviso para verificar
se algumas bibliotecas estão instaladas no sistema.

Na dúvida, antes de prosseguir com a instalação baixar todas as bibliotecas e 
instalá-las.

## Download Composer

https://getcomposer.org/Composer-Setup.exe

IMPORTANTE: Instalar o composer após a instalação do WampServer, e ao ser solicitado selecionar a versão mais atual possível do PHP.


## Download Git

https://git-scm.com/downloads

## Clonando o repositório do projeto

- Navegar pelo windows explorer até o diretório C:\wamp\www (considerando C:\wamp como sendo o local da instalação do WampServer)
- Clicar com o botão direito do mouse e selecionar a opção "Git Bash Here"
- Clonar o repositório da versão 2 (mais atual) com o seguinte comando
    git clone -b v2 https://github.com/marcioelias/goldenfrota.git
- Acessar o diretorio goldenfrota que foi criado 
    cd goldefrota
- Instalar as dependências do sistema usando o composer
    composer install
- Aguardar até que a instalação seja concluida


## Configurando o sistema

- Copiar o arquivo de configuração de exemplo
    cp .env.example .env
- Gerar uma key para o sistema 
    php artisan key:generate
- Criar uma base de dados no MySQL (apenas dar o nome a mesma, não é necessário criar nenhuma tabela).
- Editar o arquivo .env e alterar os seguites dados
    DB_DATABASE=NOME-DA-BASE-CRIADA
    DB_USERNAME=root
    DB_PASSWORD=
- Salvar as aterações e fechar o arquivo
- Rodar os scripts de migração das tabelas
    php artisan migrate
- Popular a base de dados com dados padrões
    php artisan db:seed

## Configuração do webserver (Apache)
- Criar um virtualhost pelo menu do Wamp 
    Endereço do VirtualHost: goldenfrota
    Local dos arquivos: c:/wamp/www/goldenfrota
- Com o botão direito do mouse no icone do tray do WampServer, selecionar tools, restart DNS

## Acessando o sistema
- Abrir o navegador e informar a url:
    http://goldenfrota
- Usuário: super
- Senha: super

# Para atualizar o sistema 
    Sempre que são feitas alterações, implementaçãos e/ou correções no sistema o projeto é atualizado no Git, facilitando muito o processo de atualização do mesmo nos servidores onde se encontrar instalado.

    Para atualizar o sistema instalado seguindo os passos acima, basta executar poucos comandos.

- Navegar até o diretório onde os se encontram os arquivos do sistema
    C:\wamp\www\goldenfrota
- Com o botão direito do mouse no menu suspenso selecionar a opção 
    Git Bash Here
- Baixar as atualizações com o comando
    git pull origin v2
- Rodar as atualizações da base de dados
    php artisan db:migrate -seed

Pronto, sistema atualizado para a última versão do fonte disponível.