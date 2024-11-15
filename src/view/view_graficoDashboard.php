<?php

class viewGraficoDashboard{
    public function execute(){
        require_once '../model/model_dashboard.php';
        $model = new modelDashboard();

        $tipo = $_REQUEST['tipo'];

        switch ($tipo) {
            case 1:
                $model->setSqlGraficoSemana();
                break;
            case 2:
                $model->setSqlGraficoMes();
                break;
            case 3:
                $model->setSqlGraficoSemestre();
                break;
            case 4:
                $model->setSqlGraficoAno();
                break;
        }

        $model->execute();
    } 
}