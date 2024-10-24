<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$setcodigo = filter_var($_POST['setcodigo'], FILTER_SANITIZE_NUMBER_INT);

$sql = "update tbsetor set setativo = case when setativo = 1 then 0 else 1 end where setcodigo = $1";
$values = [$setcodigo];

$result = execUpdate($db, $sql, $values);

echo $result;