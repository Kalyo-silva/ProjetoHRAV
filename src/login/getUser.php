<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$usucodigo = filter_var($_POST['usucodigo'],FILTER_SANITIZE_NUMBER_INT);

$sql = "select usucodigo, usunome 
          from tbusuario
         where usucodigo = $1
           and usuativo = 1";

$values = [$usucodigo];

$result = execConsulta($db,$sql, $values);

echo $result;