<?php
header('Access-Control-Allow-Origin: admin.html'); 

session_start();

if (!isset($_SESSION['usucodigo'])){
  echo false;
}
else{
  if (time() - $_SESSION['last_request'] > (10*60)){ //10 min de inatividade 
    echo false;
  }
  else{
    $_SESSION['last_request'] = time();
    echo true;
  }
}

