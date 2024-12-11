<?php

class ModelDashboard{
    public $sql;
    public $values = [];

    public function setSQL($sql){
        $this->sql = $sql;
    }

    public function setValues($values){
        $this->values = $values;
    }

    public function returnSQL(){
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql($this->sql);
        $query->setValues($this->values);
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }

    public function execute(){

        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql($this->sql);
        $query->setValues($this->values);
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        return $result;
    }

    public function setSqlNotaSetor() {
        $this->setSQL("SELECT SETCODIGO,
                              SETDESCRICAO,
                              (SUM(AVARESPOSTA::NUMERIC) / COUNT(1)::NUMERIC)::NUMERIC(10,2) AS NOTA
                         FROM TBAVALIACAO
                         JOIN TBSETOR
                        USING (SETCODIGO)
                        WHERE SETATIVO = 1
                        GROUP BY SETCODIGO, SETDESCRICAO
                        ORDER BY SETDESCRICAO");
    }
    
    public function getSqlNotaNPS(){
        $this->setSQL(" SELECT SETCODIGO,
                               SETDESCRICAO,
                               ((PERCPROMOTORES - PERCDETRATORES)/10)::NUMERIC(10,2) AS NOTA
                          FROM (
                        SELECT ((PROMOTORES*100)::NUMERIC / TOTAL::NUMERIC)::NUMERIC(10,2) AS PERCPROMOTORES,
                               ((DETRATORES*100)::NUMERIC / TOTAL::NUMERIC)::NUMERIC(10,2) AS PERCDETRATORES,
                               SETDESCRICAO,
                               SETCODIGO
                          FROM (
                        SELECT SUM(PROMOTORES) AS PROMOTORES,
                               SUM(DETRATORES) AS DETRATORES,
                               COUNT(1) AS TOTAL,
                               SETDESCRICAO,
                               SETCODIGO
                          FROM ( 
                        SELECT CASE WHEN AVARESPOSTA > 8 THEN 1 ELSE 0 END AS PROMOTORES,
                               CASE WHEN AVARESPOSTA < 7 THEN 1 ELSE 0 END AS DETRATORES,
                               SETDESCRICAO,
                               SETCODIGO
                          FROM TBAVALIACAO
                          JOIN TBSETOR 
                         USING (SETCODIGO)
                         WHERE AVARESPOSTA NOT IN (7,8)
                           AND SETATIVO = 1 
                        ) O
                        GROUP BY SETCODIGO, SETDESCRICAO
                        ) O2 
                        )O3 ORDER BY SETDESCRICAO");    
    }

    public function setSqlRespostas($tipo) {
        $sql = "SELECT 1 AS ORDEM,
                       'avNum' AS ID,
                       COUNT(1) AS VALOR,
                       'Avaliações Respondidas' AS DESCRICAO
                  FROM TBAVALIACAO
                 UNION
                SELECT 2 AS ORDEM,
                       'avHj' AS ID,
                       COUNT(DISTINCT AVACODIGO) VALOR,
                       'Respondidas Hoje' AS DESCRICAO
                  FROM TBAVALIACAO
                 WHERE AVADATAHORA::DATE = NOW()::DATE
                 UNION ";
        
        if ($tipo == 1){
            $sql .= $this->setSQLNotaGeralNPS();
        } else{
            $sql .= $this->setSQLNotaGeralART();
        }
        
        $this->setSQL($sql);
    }
    
    public function setSQLNotaGeralNPS(){
        return "SELECT 3 AS ORDEM,
                       'mdGeral' AS ID,
                       ((PERCPROMOTORES - PERCDETRATORES)/10)::NUMERIC(10,2) AS VALOR,
                       'Média Geral' AS DESCRICAO
                  FROM (
                SELECT ((PROMOTORES*100)::NUMERIC / TOTAL::NUMERIC)::NUMERIC(10,2) AS PERCPROMOTORES,
                       ((DETRATORES*100)::NUMERIC / TOTAL::NUMERIC)::NUMERIC(10,2) AS PERCDETRATORES
                  FROM (
                SELECT SUM(PROMOTORES) AS PROMOTORES,
                       SUM(DETRATORES) AS DETRATORES,
                       COUNT(1) AS TOTAL
                  FROM ( 
                SELECT CASE WHEN AVARESPOSTA > 8 THEN 1 ELSE 0 END AS PROMOTORES,
                       CASE WHEN AVARESPOSTA < 7 THEN 1 ELSE 0 END AS DETRATORES
                  FROM TBAVALIACAO
                 WHERE AVARESPOSTA NOT IN (7,8)
                ) O
                ) O2 
                ) O3 ORDER BY 1";
    }

    public function setSQLNotaGeralART(){
        return "SELECT 3 AS ORDEM,
                       'mdGeral' AS ID,
                       CAST((SUM(AVARESPOSTA)::NUMERIC / COUNT(AVACODIGO)::NUMERIC) AS NUMERIC(10,2)) AS VALOR,
                       'Média Geral' AS DESCRICAO
                  FROM TBAVALIACAO
                 ORDER BY 1";   
    }

    public function setSqlFeedbackSetor($setcodigo){
        $this->setSQL("SELECT AVAFEEDBACK,
                              SETDESCRICAO,
                              PERPERGUNTA,
                              TO_CHAR(AVADATAHORA, 'DD/MM/YYYY HH24:MI:SS') AS AVADATAHORA
                         FROM TBAVALIACAO A 
                         JOIN TBSETOR
                        USING (SETCODIGO)
                         JOIN TBPERGUNTA
                        USING (PERCODIGO)
                        WHERE AVAFEEDBACK <> ''
						  AND SETCODIGO = $1
                        ORDER BY AVADATAHORA DESC
						LIMIT 10");

        $this->setValues([$setcodigo]);
    }

    public function setSqlUltimoFeedback() {
        $this->setSQL("SELECT AVAFEEDBACK,
                              SETDESCRICAO,
                              PERPERGUNTA,
                              TO_CHAR(AVADATAHORA, 'DD/MM/YYYY HH24:MI:SS') AS AVADATAHORA
                         FROM TBAVALIACAO A 
                         JOIN TBSETOR
                        USING (SETCODIGO)
                         JOIN TBPERGUNTA
                        USING (PERCODIGO)
                        WHERE AVAFEEDBACK <> ''
                          AND AVADATAHORA = (SELECT MAX(AVADATAHORA)
                                               FROM TBAVALIACAO B
                                              WHERE B.SETCODIGO = A.SETCODIGO
                                                AND B.AVAFEEDBACK <> '')
                        ORDER BY AVADATAHORA DESC");
    }
    
    public function setSqlGraficoSemana($setcodigo) {
        $sql = "SELECT COUNT(1) AS AVALIACOES,
                       TO_CHAR(AVADATAHORA, 'DD/MM/YYYY') AS DATA 
                  FROM (SELECT DISTINCT AVACODIGO, 
                               AVADATAHORA::DATE 
                          FROM TBAVALIACAO
                          JOIN TBSETOR
                         USING (SETCODIGO)
                         WHERE AVADATAHORA >= DATE_TRUNC('WEEK', CURRENT_DATE)";

        if ('' !== $setcodigo){
            $sql .= " AND SETCODIGO = $1";

            $this->setValues([$setcodigo]);
        }

        $sql .= " ) O
                GROUP BY AVADATAHORA
                ORDER BY AVADATAHORA";

        $this->setSQL($sql);
    }
    
    public function setSqlGraficoMes($setcodigo) {
        $sql = "SELECT COUNT(1) AS AVALIACOES,
                       TO_CHAR(AVADATAHORA, 'DD/MM/YYYY') AS DATA 
                  FROM (SELECT DISTINCT AVACODIGO, 
                               DATE_TRUNC('WEEK', AVADATAHORA) AS AVADATAHORA 
                          FROM TBAVALIACAO
                          JOIN TBSETOR
                         USING (SETCODIGO)
                         WHERE AVADATAHORA >= DATE_TRUNC('MONTH', CURRENT_DATE)";
                            
        if ('' !== $setcodigo){
            $sql .= " AND SETCODIGO = $1";

            $this->setValues([$setcodigo]);
        }
                            
        $sql .= ") O
                 GROUP BY AVADATAHORA
                 ORDER BY AVADATAHORA";
        
        $this->setSQL($sql);
    }
    
    public function setSqlGraficoSemestre($setcodigo) {
        $sql = "SELECT COUNT(1) AS AVALIACOES,
                       TO_CHAR(AVADATAHORA, 'MM/YYYY') AS DATA 
                  FROM (SELECT DISTINCT AVACODIGO,
                               AVADATAHORA::DATE
                          FROM TBAVALIACAO
                          JOIN TBSETOR
                         USING (SETCODIGO)
                         WHERE AVADATAHORA >= CASE WHEN NOW() > CAST('01/06/'||EXTRACT(YEAR FROM CURRENT_DATE) AS DATE)
                                                   THEN CAST('01/06/'||EXTRACT(YEAR FROM CURRENT_DATE) AS DATE)
                                                   ELSE CAST('01/01/'||EXTRACT(YEAR FROM CURRENT_DATE) AS DATE)
                                                    END
                           AND AVADATAHORA <= CASE WHEN NOW() > CAST('01/06/'||EXTRACT(YEAR FROM CURRENT_DATE) AS DATE)
                                                   THEN CAST('31/12/'||EXTRACT(YEAR FROM CURRENT_DATE) AS DATE)
                                                   ELSE CAST('01/06/'||EXTRACT(YEAR FROM CURRENT_DATE) AS DATE)
                                                    END";
             
        if ('' !== $setcodigo){
            $sql .= " AND SETCODIGO = $1";

            $this->setValues([$setcodigo]);
        }
        
        $sql .= ") O
                 GROUP BY 2
                 ORDER BY 2";

        $this->setSQL($sql);
    }
    
    public function setSqlGraficoAno($setcodigo) {
        $sql = "SELECT COUNT(1) AS AVALIACOES,
                       TO_CHAR(AVADATAHORA, 'MM/YYYY') AS DATA 
                  FROM (SELECT DISTINCT AVACODIGO, 
                               AVADATAHORA::DATE 
                          FROM TBAVALIACAO
                          JOIN TBSETOR
                         USING (SETCODIGO)
                         WHERE AVADATAHORA >= DATE_TRUNC('YEAR', CURRENT_DATE)";
                             
        if ('' !== $setcodigo){
            $sql .= " AND SETCODIGO = $1";

            $this->setValues([$setcodigo]);
        }
        
        $sql .= ") O
                 GROUP BY 2
                 ORDER BY 2";
        
        $this->setSQL($sql);
    }

}