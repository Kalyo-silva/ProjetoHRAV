<?php
header('Content-Type: application/json; charset=utf-8');

require_once('../../config.php');

$db = pg_connect("host=$host dbname=$dbname user=$user password=$password"); 

function execConsulta($con, $sql, $values = []){
    $query = pg_prepare($con, "", $sql);
    $query = pg_execute($con, "", $values);

    $results = [];

    while($row = pg_fetch_assoc($query)){
        $results[] = $row;
    };

    echo json_encode($results);
};

function executeDML($con, $sql, $values = []){
    $query = pg_prepare($con, "", $sql);
    $query = @pg_execute($con, "", $values);

    if (!$query){
        echo false;
    }
    else{
        echo true;
    }
};