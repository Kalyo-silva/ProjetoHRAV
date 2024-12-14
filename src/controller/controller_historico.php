<?php

class ControllerHistorico{
    public function Listar(){
        require_once '../view/view_historico.php';
        $view = new viewHistorico();
        $view->montaTela();
    }

    
    public function ListarFiltrado(){
        require_once '../view/view_historico.php';
        $view = new viewHistorico();
        $view->filtrar();
    }

    public function listarNotaFiltrado(){
        require_once '../view/view_historico.php';
        $view = new viewHistorico();
        $view->filtrarNota();
    }

    public function grafico(){
        require_once '../model/model_historico.php';
        $model = new ModelHistorico();
        $model->getGrafico();
    }
}