<?php

require_once '../model/model_perguntas.php';

class controllerPerguntas{    
    public function listarTabela(){
        $model = new modelPerguntas();
        $model->getTable();        
    }
    
    public function desativar(){
        $model = new modelPerguntas();
        $model->deactivate();        
    }
    
    public function inserir(){
        $model = new modelPerguntas();
        $model->insert();        
    }
    
    public function remover(){
        $model = new modelPerguntas();
        $model->delete();        
    }

    public function editar(){
        $model = new modelPerguntas();
        $model->update();
    }
}