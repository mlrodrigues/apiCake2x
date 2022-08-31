<p align="center">
  <a href="https://cakephp.org/" target="_blank" >
    <img alt="CakePHP" src="https://cakephp.org/v2/img/logos/CakePHP_Logo.svg" width="400" />
  </a>
</p>

## Rodando o projeto

Faça o clone do projeto ou baixe o zip, detro da pasta do servidor local, www no caso de wamp server, após isso é necessario algumas configuraçãoes: 
1 - Crie uma copia do arquivo database.php.default e salve sem o .default
2 - Coloque as informações do banco de dados.
3 - Crie uma banco de dados chamado `api`.
3 - Rode o script de banco de dados no gerencidor de BD, o arquivo chama `noticiasBD`.

Após esses passos, basta rodar a [Url](http://localhost/apiCake2x/noticias). A pagina irá trazer todas as noticias do banco de dados. 
Para uma melhor visualização recomendo rodar a url no aplicativo Postman ou Insomnia
Um arquivo json com as requisões está presente no projeto, com ela é possivel fazer todas as chamadas
  - Listar todas as noticias
  - Visualizar uma noticias especifica
  - Criar uma nova noticia
  - Editar uma noticias
  - Excluir uma noticias 
