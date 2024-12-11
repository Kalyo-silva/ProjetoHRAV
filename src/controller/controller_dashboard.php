<?php

class controllerDashboard {
    public function carregaRespostas(){
        require_once '../view/view_dashboard.php';
        $view = new viewDashboard();
        $view->getDadosRespostas();
    }

    public function carregaNotasSetores(){
        require_once '../view/view_dashboard.php';
        $view = new viewDashboard();
        $view->getNotasSetores();
    }

    public function carregaUltimoFeedback(){
        require_once '../view/view_dashboard.php';
        $view = new viewDashboard();
        $view->getFeedbacks();

    }

    public function carregaDadosGrafico(){
        require_once '../view/view_dashboard.php';
        $view = new viewDashboard();
        $view->getTipoGrafico();
    }
}