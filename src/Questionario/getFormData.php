<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$setor = filter_var($_POST['setor'], FILTER_SANITIZE_NUMBER_INT);

$sql = "select percodigo,
               perpergunta,
	           -1 as nota,
	           '' as feedback
          from tbpergunta
          join tbperguntasetor 
         using (percodigo)
         where setcodigo = $1 and perativo = 1";

$values = [$setor];

$result = execConsulta($db,$sql,$values); 

echo $result;