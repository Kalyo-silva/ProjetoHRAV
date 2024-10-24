<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$setcodigo = filter_var($_POST['setcodigo'], FILTER_SANITIZE_NUMBER_INT);
$setdescricao = filter_var($_POST['setdescricao'], FILTER_SANITIZE_STRING);

$sql = "update tbsetor set setdescricao = $2 where setcodigo = $1";
$values = [$setcodigo, $setdescricao];

$result = execUpdate($db, $sql, $values);

echo $result;