<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$discodigo = filter_var($_POST['discodigo'], FILTER_SANITIZE_NUMBER_INT);
$disnome = filter_var($_POST['disnome'], FILTER_SANITIZE_STRING);

$sql = "update tbdispositivo set disnome = $2 where discodigo = $1";
$values = [$discodigo, $disnome];

$result = executeDML($db, $sql, $values);

echo $result;