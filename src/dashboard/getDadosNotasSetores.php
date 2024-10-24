<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = " select setdescricao,
	            coalesce((select cast(sum(avaresposta::numeric) / count(1)::numeric as numeric(10,2))
                            from tbavaliacao 
		                   where setcodigo = tbsetor.setcodigo),0) as nota
           from tbsetor
          where setativo = 1";

$result = execConsulta($db,$sql);

echo $result;