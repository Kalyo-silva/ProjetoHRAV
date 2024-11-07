<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$avacodigo = filter_var($_POST['avacodigo'], FILTER_SANITIZE_NUMBER_INT);
$percodigo = filter_var($_POST['percodigo'], FILTER_SANITIZE_NUMBER_INT);
$setcodigo = filter_var($_POST['setcodigo'], FILTER_SANITIZE_NUMBER_INT);
$discodigo = filter_var($_POST['discodigo'], FILTER_SANITIZE_NUMBER_INT);
$avaresposta = filter_var($_POST['avaresposta'], FILTER_SANITIZE_NUMBER_INT);
$avafeedback = filter_var($_POST['avafeedback'], FILTER_SANITIZE_STRING);

$values = [$avacodigo, $percodigo, $setcodigo, $discodigo, $avaresposta, $avafeedback];

$sql = "insert into tbavaliacao values ($1, $2, $3, $4, $5, $6, now());";

$result = executeDML($db,$sql,$values);

echo $result;