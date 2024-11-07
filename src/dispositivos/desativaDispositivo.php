<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$discodigo = filter_var($_POST['discodigo'], FILTER_SANITIZE_NUMBER_INT);

$sql = "update tbdispositivo set disstatus = case when disstatus = 1 then 0 else 1 end where discodigo = $1";
$values = [$discodigo];

$result = executeDML($db, $sql, $values);

echo $result;