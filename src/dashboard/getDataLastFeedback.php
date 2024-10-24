<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = " select avafeedback,
               setdescricao,
               perpergunta,
               to_char(avadatahora, 'dd/mm/yyyy hh24:mi:ss') as avadatahora
         from tbavaliacao a 
         join tbsetor
         using (setcodigo)
         join tbpergunta
         using (percodigo)
         where avafeedback <> ''
            and avadatahora = (select max(avadatahora)
                           from tbavaliacao b
                           where b.setcodigo = a.setcodigo
                           and b.avafeedback <> '')
         order by avadatahora desc";

$result = execConsulta($db,$sql);

echo $result;