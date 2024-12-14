<?php

header('Content-type: text/html; charset=utf-8');  

class viewHistorico{
    public function montaTela(){
        require_once '../model/model_historico.php';
        $model = new ModelHistorico();
            
        $html = "<div id = 'HistContainer'>
                    <div id = 'HistNotaContainer'>".$this->montaTabelaNotas($model)."</div>
                    <div id = 'NotaPeriodo'>
                        <canvas id = 'grafNotaPeriodo'></canvas>
                    </div>
                </div>";

         $html .= "<div id = 'HistTable'>".$this->montarTabela($model)."</div>
                   <footer id = 'histFooter'>".$this->montarFiltros($model)."</footer>";

        echo $html;
    }
    
    private function montaTabelaNotas($model){
        $html = "<table>
                    <thead>
                        <tr>
                            <th>Nota</th>
                            <th>Setor</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>";
        $model->getNotasPeriodo();
        foreach ($model->execute() as $row) {
            $html .= "<tr> ";

            if ($row['avaresposta'] < 6){
                $html .= "<td style = 'font-weight : bolder; color:red'>".$row['avaresposta']."</td>";
            } 
            else if ($row['avaresposta'] < 9){
                $html .= "<td style = 'font-weight : bolder; color: #f29b00;'>".$row['avaresposta']."</td>";
            } 
            else {
                $html .= "<td style = 'font-weight : bolder; color:green'>".$row['avaresposta']."</td>";
            } 

            $html .="   <td>".$row['setdescricao']."</td>
                        <td>".$row['avadatahora']."</td>
                    </tr>";
        }

        $html.= "   </tbody> 
                 </table>";   

        return $html;
    }

    private function montarFiltros($model){
        $html = "<div class = 'searchbox'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 -960 960 960'><path d='M420-280h120v-100h100v-120H540v-100H420v100H320v120h100v100ZM160-120v-480l320-240 320 240v480H160Zm80-80h480v-360L480-740 240-560v360Zm240-270Z'/></svg>
                    <select name='HistSetorSelect' id='HistSetorSelect'>
                        <option value='0'>Todos os Setores</option>";

        foreach($model->getSetores() as $row){
            $html .= "<option value='".$row['setcodigo']."'>".$row['setdescricao']."</option>";
        }
            
        $html .= "</select>
                  </div>";  
        
        $html .= "<label for='dataini'>Início</label> <input type='date' id='dataini'>";

        $html .= "<label for='datafim'>Fim</label> <input type='date' id='datafim'>";

        $html .= "<button onclick='showHistFiltrado()'>Filtrar</button>";

        return $html;
    }

    private function montarTabela($model){
        $html = "<table>
                    <thead>
                        <tr>
                            <th>Feedback</th>
                            <th>Setor</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    
                    <tbody>";

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
            
        return $html;
    } 

    public function filtrar(){
        require_once '../model/model_historico.php';
        $model = new ModelHistorico();
        
        echo $this->montarTabela($model);
    }
    

    public function filtrarNota(){
        require_once '../model/model_historico.php';
        $model = new ModelHistorico();
        
        echo $this->montaTabelaNotas($model);
    }
}