<?php

class controllerDashboard {
    public function carregaRespostas(){
        require_once '../model/model_dashboard.php';
        $model = new ModelDashboard();
        $model->setSqlRespostas();
        $model->execute();
    }

    public function carregaNotasSetores(){
        require_once '../model/model_dashboard.php';
        $model = new ModelDashboard();
        $model->setSqlNotaSetor();
        $model->execute();

    }

    public function carregaUltimoFeedback(){
        require_once '../model/model_dashboard.php';
        $model = new ModelDashboard();
        $model->setSqlUltimoFeedback();
        $model->execute();

    }

    public function carregaDadosGrafico(){
        require_once '../view/view_graficoDashboard.php';
        $view = new viewGraficoDashboard();
        $view->execute();
    }
}