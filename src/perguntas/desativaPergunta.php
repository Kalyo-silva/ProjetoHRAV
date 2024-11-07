<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$percodigo = filter_var($_POST['percodigo'], FILTER_SANITIZE_NUMBER_INT);

$sql = "update tbpergunta set perativo = case when perativo = 1 then 0 else 1 end where percodigo = $1";
$values = [$percodigo];

$result = executeDML($db, $sql, $values);

echo $result;