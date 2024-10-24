<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = "select setcodigo,
               setdescricao as ".'"Descrição do Setor"'.",
               case when setativo = 1 then 'Ativo' else 'Desativado' end as ".'"Situação"'."
          from tbsetor 
         order by setativo desc, setcodigo";

$result = execConsulta($db,$sql);

echo $result;