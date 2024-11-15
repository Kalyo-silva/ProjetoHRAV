<?php

require_once '../model/model_dispositivos.php';

class ControllerDispositivos {
    public function listar(){
        $model = new modelDispositivos();
        $model->getAll();
    }
    
    public function listarTabela(){
        $model = new modelDispositivos();
        $model->getTable();        
    }
    
    public function desativar(){
        $model = new modelDispositivos();
        $model->deactivate();        
    }
    
    public function inserir(){
        $model = new modelDispositivos();
        $model->insert();        
    }
    
    public function remover(){
        $model = new modelDispositivos();
        $model->delete();        
    }

    public function editar(){
        $model = new modelDispositivos();
        $model->update();
    }
}