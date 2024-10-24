<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$sql = "select coalesce(max(avacodigo),0)+1 from tbavaliacao";

$result = execConsulta($db,$sql);

echo $result;