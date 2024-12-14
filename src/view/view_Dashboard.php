<?php

header('Content-type: text/html; charset=utf-8');  

class viewDashboard{
    public function getTipoGrafico(){
        require_once '../model/model_dashboard.php';
        $model = new modelDashboard();

        $tipo = $_REQUEST['tipo'];
        

        switch ($tipo) {
            case 1:
                $model->setSqlGraficoSemana($this->getSetCodigo());
                break;
            case 2:
                $model->setSqlGraficoMes($this->getSetCodigo());
                break;
            case 3:
                $model->setSqlGraficoSemestre($this->getSetCodigo());
                break;
            case 4:
                $model->setSqlGraficoAno($this->getSetCodigo());
                break;
        }

        $model->returnSQL();
    }
    
    public function getDadosRespostas(){
        require_once '../model/model_dashboard.php';
        $model = new modelDashboard();

        $tipo = $_REQUEST['tipo'];

        $model->setSqlRespostas($tipo);
        $table = $model->execute();

        $html = "";
        foreach ($table as $row) {
            $html .= "
            <article class = 'window DashContainer'>
                <h2 id = '".$row['id']."' class ='displayValue'>".$row['valor']."</h2>
                <h2>".$row['descricao']."</h2>
            </article>";
        }

        echo $html; 
    }

    public function getNotasSetores(){
        require_once '../model/model_dashboard.php';
        $model = new modelDashboard();

        $tipo = $_REQUEST['tipo'];


        switch ($tipo) {
            case 1:
                $model->getSqlNotaNPS();
                break;
            case 2:
                $model->setSqlNotaSetor();
                break;
        }
        
        $table = $model->execute();

        $html = '';
        foreach ($table as $row) {
            $html .= "<div class='sectorIcon' onclick = 'selectSetor(this, ".$row['setcodigo']."); drawGraph()')'>
                        <h3>".$row['setdescricao']."</h3>";
            
            
            if ($row['nota'] < 6){
                $html .= "<h2 style = 'color:red'>".$row['nota']."</h2>";
            } 
            else if ($row['nota'] < 9){
                $html .= "<h2 style = 'color: #f29b00;'>".$row['nota']."</h2>";
            } 
            else {
                $html .= "<h2 style = 'color:green'>".$row['nota']."</h2>";
            } 

            $html .= "</div>";
        }
        
        echo $html; 
    }

    function getSetCodigo(){
        if (isset($_REQUEST['setcodigo'])){
            return filter_Var($_REQUEST['setcodigo'], FILTER_SANITIZE_NUMBER_INT);
        }
        return null;
    }

    function getFeedbacks(){
        require_once '../model/model_dashboard.php';
        $model = new modelDashboard();

        if ($this->getSetCodigo()){
            $model->setSqlFeedbackSetor($this->getSetCodigo());
        }
        else{
            $model->setSqlUltimoFeedback();
        }
        $table = $model->execute();

        $html = '';
        foreach ($table as $row) {
            $html.="<div class='feedback'>
                        <h2 class='feedbackTitle'>".$row['perpergunta']."</h2>
                        <h3>".$row['avafeedback']."</h3>
                        <h4>".$row['avadatahora']." - ".$row['setdescricao']."</h4>
                    </div>";
        }

        echo $html; 
    }
}