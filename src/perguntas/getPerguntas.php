<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = "select percodigo,
               perpergunta as ".'"Pergunta"'.",
               case when perativo = 1 then 'Ativo' else 'Desativado' end as ".'"Situação"'.",
               array_to_string((select array_agg(setdescricao)
                                  from tbperguntasetor
                                  join tbsetor 
                                 using (setcodigo)  
                                 where percodigo = tbpergunta.percodigo), ', ') as ".'"Setores Cadastrados"'."
          from tbpergunta
         order by 1";

$result = execConsulta($db,$sql);

echo $result;