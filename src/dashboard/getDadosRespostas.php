<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = 'select count(distinct avacodigo) resphoje,
               (select count(distinct avacodigo)
	              from tbavaliacao) as resptodos,
	           cast((select sum(avaresposta)::numeric / count(avacodigo)::numeric 
                       from tbavaliacao) as numeric(10,2)) as mediageral
          from tbavaliacao
         where avadatahora::date = now()::date';

$result = execConsulta($db,$sql);

echo $result;