<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$setDescricao = filter_var($_POST['setdescricao'], FILTER_SANITIZE_STRING);

$sql = "insert into tbsetor values((select max(setcodigo)+1 from tbsetor), $1, 1)";
$values = [$setDescricao];

$result = executeDML($db, $sql, $values);

echo $result;