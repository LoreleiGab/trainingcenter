# trainingcenter
Sistema de Gestão de Treino

#Requisitos necessários
- Servidor apache e MySql instalados e configurados
- NodeJs instalado


# Instruções para instalação
- Executar o arquivo do banco de dados `database/sportsdb.sql` 
- No arquivo `config/configApp.php`, deve-se configurar os dados de acesso ao banco de dados, atribuindo valores as constante, onde:
    - **SERVER**: Endereço do servidor MySql
    - **USER**: Usuário do banco de dados
    - **PASS**: Senha de acesso
- Na raiz do sistema executar o comando `npm install` para efetuar o download das dependências.

## Tecnologias e Metodologias
- PHP 7.4
- MariaDB 10.4.22
- Node v16.13.1
- Estrutura MVC
