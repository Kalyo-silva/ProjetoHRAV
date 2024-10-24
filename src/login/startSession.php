<?php
header('Access-Control-Allow-Origin: admin.html'); 

session_start();
session_destroy();
session_start();

$usucodigo = filter_var($_POST['usucodigo'],FILTER_SANITIZE_NUMBER_INT);

$_SESSION['usucodigo'] = $usucodigo;
$_SESSION['last_request'] = time();
