# Projeto de sistema de avaliações do Hospital Regional do Alto Vale do Itajaí.

Para instalar o projeto, basta:

- realizar o download dos arquivos;
- criar um banco de dados conforme a estrutura passada no setup.sql;
- configurar a conexão do banco de dados no arquivo config.php;
- cadastrar um usuário administrador para a retaguarda (lembrando de utilizar md5 na senha de usuário);
- logar na retaguarda como adminstrador acessando o arquivo login.html;
- realizar os cadastro dos dispositivos, setores e perguntas conforme necessário;

Para utilizar o sistema de avaliação:

- acesse o arquivo index.html;
- Selecione o dispositívo desejado;
- inicie a sessão de avaliação;

O dispositívo selecionado estará vinculado ao setor de onde as perguntas serão buscadas. Após o fim do formulário, as repostas serão armazenadas e será disponibilizado informações sobre os dados coletados na seção de Dashboard da retaguarda.
