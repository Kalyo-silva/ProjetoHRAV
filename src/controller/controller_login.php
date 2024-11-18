<?php

require_once '../model/model_login.php';

class controllerLogin{
    function statusSessao(){
        $model = new modelLogin();
        $model->getSessionStatus();
    }

    function iniciaSessao(){
        $model = new modelLogin();
        $model->startSession();
    }

    function validaLogin(){
        $model = new modelLogin(); 
        $model->validateLogin();
    }

    function getUser(){
        $model = new modelLogin();
        $model->getUser();
    }
}