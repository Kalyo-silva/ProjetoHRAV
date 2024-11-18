<?php

require_once '../model/model_setor.php';

class controllerSetor{    
    public function listarTabela(){
        $model = new modelSetor();
        $model->getTable();        
    }
    
    public function desativar(){
        $model = new modelSetor();
        $model->deactivate();        
    }
    
    public function inserir(){
        $model = new modelSetor();
        $model->insert();        
    }
    
    public function remover(){
        $model = new modelSetor();
        $model->delete();        
    }

    public function editar(){
        $model = new modelSetor();
        $model->update();
    }
}