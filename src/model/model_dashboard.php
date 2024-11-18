<?php

class ModelDashboard{
    private $sql;

    public function setSQL($sql){
        $this->sql = $sql;
    }

    public function execute(){

        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql($this->sql);
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }

    public function setSqlNotaSetor() {
        $this->setSQL("select setdescricao,
                              coalesce((select cast(sum(avaresposta::numeric) / count(1)::numeric as numeric(10,2))
                                          from tbavaliacao 
                                         where setcodigo = tbsetor.setcodigo),0) as nota
                         from tbsetor
                        where setativo = 1");
    }
    
    public function setSqlRespostas() {
        $this->setSQL("select count(distinct avacodigo) resphoje,
                              (select count(distinct avacodigo)
	                             from tbavaliacao) as resptodos,
	                          cast((select sum(avaresposta)::numeric / count(avacodigo)::numeric 
                                      from tbavaliacao) as numeric(10,2)) as mediageral
                         from tbavaliacao
                        where avadatahora::date = now()::date");
    }
    
    public function setSqlUltimoFeedback() {
        $this->setSQL("select avafeedback,
                              setdescricao,
                              perpergunta,
                              to_char(avadatahora, 'dd/mm/yyyy hh24:mi:ss') as avadatahora
                         from tbavaliacao a 
                         join tbsetor
                        using (setcodigo)
                         join tbpergunta
                        using (percodigo)
                        where avafeedback <> ''
                          and avadatahora = (select max(avadatahora)
                                               from tbavaliacao b
                                              where b.setcodigo = a.setcodigo
                                                and b.avafeedback <> '')
                        order by avadatahora desc");
    }
    
    public function setSqlGraficoSemana() {
        $this->setSQL("select count(1) as avaliacoes,
                              to_char(avadatahora, 'dd/mm/yyyy') as data 
                         from (select distinct avacodigo, 
                                      avadatahora::date 
                                 from tbavaliacao
                                where avadatahora >= date_trunc('week', current_date)
                            ) o
                        group by avadatahora
                        order by avadatahora");
    }
    
    public function setSqlGraficoMes() {
        $this->setSQL("select count(1) as avaliacoes,
                              to_char(avadatahora, 'dd/mm/yyyy') as data 
                         from (select distinct avacodigo, 
                                      date_trunc('week', avadatahora) as avadatahora 
                                 from tbavaliacao
                                where avadatahora >= date_trunc('month', current_date)
                            ) o
                        group by avadatahora
                        order by avadatahora");
    }
    
    public function setSqlGraficoSemestre() {
        $this->setSQL("select count(1) as avaliacoes,
                              to_char(avadatahora, 'mm/yyyy') as data 
                         from (select distinct avacodigo,
                                      avadatahora::date
                                 from tbavaliacao
                                where avadatahora >= case when now() > cast('01/06/'||extract(year from current_date) as date)
                                                          then cast('01/06/'||extract(year from current_date) as date)
                                                          else cast('01/01/'||extract(year from current_date) as date)
                                                           end
                                  and avadatahora <= case when now() > cast('01/06/'||extract(year from current_date) as date)
                                                          then cast('31/12/'||extract(year from current_date) as date)
                                                          else cast('01/06/'||extract(year from current_date) as date)
                                                           end
                            ) o
                        group by 2
                        order by 2");
    }
    
    public function setSqlGraficoAno() {
        $this->setSQL("select count(1) as avaliacoes,
                              to_char(avadatahora, 'mm/yyyy') as data 
                         from (select distinct avacodigo, 
                                      avadatahora::date 
                                 from tbavaliacao
                                where avadatahora >= date_trunc('year', current_date)
                            ) o
                        group by 2
                        order by 2");
    }

}