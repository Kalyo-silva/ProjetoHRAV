<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$usucodigo = filter_var($_POST['usucodigo'],FILTER_SANITIZE_NUMBER_INT);
$ususenha = filter_var($_POST['ususenha'],FILTER_SANITIZE_STRING);

$sql = "select 1 
          from tbusuario
         where usucodigo = $1
           and ususenha = md5($2)
           and usuativo = 1";

$values = [$usucodigo, $ususenha];

$result = execConsulta($db,$sql, $values);

echo $result;