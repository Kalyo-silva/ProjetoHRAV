<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$disnome = filter_var($_POST['disnome'], FILTER_SANITIZE_STRING);
$setcodigo = filter_var($_POST['setcodigo'], FILTER_SANITIZE_NUMBER_INT);

$sql = "insert into tbdispositivo values((select max(discodigo)+1 from tbdispositivo), 1, $1, $2)";
$values = [$disnome, $setcodigo];

$result = executeDML($db, $sql, $values);

echo $result;