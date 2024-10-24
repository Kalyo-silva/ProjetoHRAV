<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$discodigo = filter_var($_POST['discodigo'], FILTER_SANITIZE_NUMBER_INT);

$sql = "delete from tbdispositivo where discodigo = $1";
$values = [$discodigo];

$result = execDelete($db, $sql, $values);

echo $result;