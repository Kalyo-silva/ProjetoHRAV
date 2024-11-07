<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$query = pg_query($db, 'select max(percodigo)+1 from tbpergunta');

$percodigo = -1;

while($row = pg_fetch_row($query)){
    $percodigo = $row[0];
};

$perdescricao = filter_var($_POST['perdescricao'], FILTER_SANITIZE_STRING);
$setcodigo = $_POST['setcodigo'];

$setcodigo = explode(',', $setcodigo);

$sql = "insert into tbpergunta values($1, $2, 1)";
$values = [$percodigo ,$perdescricao];

$result = executeDML($db, $sql, $values);

foreach ($setcodigo as $setor) {
    $sql = "insert into tbperguntasetor values($1, $2, 1)";
    $setor = filter_var($setor, FILTER_SANITIZE_NUMBER_INT);
    $values = [$percodigo, $setor];

    $result = executeDML($db, $sql, $values);
}

echo $result;