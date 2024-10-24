<?php
header('Access-Control-Allow-Origin: admin.html'); 

require_once('../db.php');

$tipo = filter_var($_POST['tipo'], FILTER_SANITIZE_NUMBER_INT);

switch ($tipo) {
   case 1:
      $sql = "select count(1) as avaliacoes,
                     to_char(avadatahora, 'dd/mm/yyyy') as data 
                from (
              select distinct avacodigo, 
                     avadatahora::date 
                from tbavaliacao
               where avadatahora >= date_trunc('week', current_date)
              ) o
              group by avadatahora
              order by avadatahora";
      break;
   case 2:
      $sql = "select count(1) as avaliacoes,
                     to_char(avadatahora, 'dd/mm/yyyy') as data 
                from (
              select distinct avacodigo, 
                     date_trunc('week', avadatahora) as avadatahora 
                from tbavaliacao
               where avadatahora >= date_trunc('month', current_date)
              ) o
              group by avadatahora
              order by avadatahora";
      break;
   case 3:
      $sql = "select count(1) as avaliacoes,
                    to_char(avadatahora, 'mm/yyyy') as data 
               from (
              select distinct avacodigo,
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
              order by 2";
         break;
   case 4:
      $sql = "select count(1) as avaliacoes,
                     to_char(avadatahora, 'mm/yyyy') as data 
                from (
              select distinct avacodigo, 
                     avadatahora::date 
                from tbavaliacao
               where avadatahora >= date_trunc('year', current_date)
              ) o
              group by 2
              order by 2";
      break;
   default:
      # code...
      break;
}

$result = execConsulta($db,$sql);

echo $result;