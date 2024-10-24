<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = "select discodigo,
               setcodigo,
               disnome,
               setdescricao
          from tbdispositivo
          join tbsetor
         using (setcodigo)
         where disstatus = 1 
         order by 1";

$result = execConsulta($db,$sql);

echo $result;