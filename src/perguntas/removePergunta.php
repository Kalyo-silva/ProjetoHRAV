<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$percodigo = filter_var($_POST['percodigo'], FILTER_SANITIZE_NUMBER_INT);

$sql = "delete from tbpergunta where percodigo = $1";
$values = [$percodigo];

$result = executeDML($db, $sql, $values);

echo $result;