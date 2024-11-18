<?php
class modelQuestionario{
    private function getNextAvaCodigo(){
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select max(avacodigo)+1 as cod from tbavaliacao");
        $query->open();

        return $query->Next();
    }
    
    public function insert(){    
        $avacodigo = $this->getNextAvaCodigo()['cod'];
        $data = json_decode($_REQUEST['data']);

        $query = Application::getInstance()->getDbConn()->newQuery();
        foreach ($data as $registro) {
            $percodigo = filter_var($registro->percodigo,FILTER_SANITIZE_NUMBER_INT);
            $setcodigo = filter_var($_REQUEST['setcodigo'],FILTER_SANITIZE_NUMBER_INT);
            $discodigo = filter_var($_REQUEST['discodigo'],FILTER_SANITIZE_NUMBER_INT);
            $avaresposta = filter_var($registro->nota,FILTER_SANITIZE_NUMBER_INT);
            $avafeedback = filter_var($registro->feedback,FILTER_SANITIZE_SPECIAL_CHARS);

            $query->setSQL('insert into tbavaliacao values ($1, $2, $3, $4, $5, $6, now())');
            $query->setValues([$avacodigo, $percodigo, $setcodigo, $discodigo, $avaresposta, $avafeedback]);

            if(!$query->DML()){
                return false;
            }
        }
        return true;        
    }

    private function getSetor(){
        if (isset($_REQUEST['setor'])){
            return filter_var($_REQUEST['setor'], FILTER_SANITIZE_NUMBER_INT);
        }
        return null;
    }

    public function getAll() {
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select percodigo,
                               perpergunta,
	                           -1 as nota,
                 	           '' as feedback
                          from tbpergunta
                          join tbperguntasetor 
                         using (percodigo)
                         where setcodigo = $1 and perativo = 1");
        $query->setValues([$this->getSetor()]);
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }
    
}