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
}