<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$percodigo = filter_var($_POST['percodigo'], FILTER_SANITIZE_NUMBER_INT);
$perpergunta = filter_var($_POST['perpergunta'], FILTER_SANITIZE_STRING);

$sql = "update tbpergunta set perpergunta = $2 where percodigo = $1";
$values = [$percodigo, $perpergunta];

$result = executeDML($db, $sql, $values);

echo $result;