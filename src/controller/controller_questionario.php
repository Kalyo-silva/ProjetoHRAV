<?php

require_once '../model/model_questionario.php';

class ControllerQuestionario {
    public function listar(){
        $model = new modelQuestionario();
        $model->getAll();
    }

    public function inserir(){
        $model = new modelQuestionario();
        $model->insert();
    }
}