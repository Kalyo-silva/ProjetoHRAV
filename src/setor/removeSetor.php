<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$setcodigo = filter_var($_POST['setcodigo'], FILTER_SANITIZE_NUMBER_INT);

$sql = "delete from tbsetor where setcodigo = $1";
$values = [$setcodigo];

$result = executeDML($db, $sql,$values);

echo $result;