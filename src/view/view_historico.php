<?php

header('Content-type: text/html; charset=utf-8');  

class viewHistorico{
    public function montaTela(){
        $html = "<div id = 'HistTable'>
                    <table>
                        <thead>
                            <tr>
                                <th>Feedback</th>
                                <th>Setor</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        
                        <tbody>";

        include '../model/model_historico.php';
        $model = new ModelHistorico();
        $model->getFeedback();
        foreach ($model->execute() as $row) {
            $html .= "<tr>
                        <td>".$row['avafeedback']."</td>
                        <td>".$row['setdescricao']."</td>
                        <td>".$row['avadatahora']."</td>
                      </tr>";
        }
                        
        $html .="   </tbody>
                    </table>
                </div>

                <footer>
                    <div class = 'searchbox'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 -960 960 960'><path d='M420-280h120v-100h100v-120H540v-100H420v100H320v120h100v100ZM160-120v-480l320-240 320 240v480H160Zm80-80h480v-360L480-740 240-560v360Zm240-270Z'/></svg>
                        <select name='setorselect' id='SetorSelect' onchange='showHistFeedbackFiltrado(this)'>
                            <option value='0'>Todos os Setores</option>";

        foreach($model->getSetores() as $row){
            $html .= "<option value='".$row['setcodigo']."'>".$row['setdescricao']."</option>";
        }
                    
        $html .=        "</select>
                    </div>
                </footer>";

        echo $html;
    }

    public function filtrar(){
        $html ="<table>
                    <thead>
                        <tr>
                            <th>Feedback</th>
                            <th>Setor</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    
                    <tbody>";

        include '../model/model_historico.php';
        $model = new ModelHistorico();
        $model->getFeedback();
        foreach ($model->execute() as $row) {
        $html .= "<tr>
                <td>".$row['avafeedback']."</td>
                <td>".$row['setdescricao']."</td>
                <td>".$row['avadatahora']."</td>
            </tr>";
        }
        
        $html .="</tbody>
            </table>";
            
        echo $html;
    }
}