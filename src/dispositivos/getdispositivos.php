<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = "select discodigo,
               disnome as ".'"Dispositivo"'.",
               case when disstatus = 1 then 'Ativo' else 'Desativado' end as ".'"Situacao"'.",
               setdescricao as ".'"Setor"'."
          from tbdispositivo
          join tbsetor
         using (setcodigo)
         order by 1";

$result = execConsulta($db,$sql);

echo $result;