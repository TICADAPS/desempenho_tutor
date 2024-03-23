<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '2048M');
set_time_limit(300);
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Área do médico</title>
        
    </head>
    <body>
<?php
// nome do arquivo que será exportado
/*
Nº da convocação do bolsista/ Nome do bolsista/ E-mail do bolsista/CPF do bolsista/ Município de origem/ UF de origem/ Nome do tutor/ E-mail do tutor/ Município do tutor/
 UF do tutor/ Confirmou disponibilidade para a tutoria?/ Realizou a tutoria?/ Data da tutoria inicial/ Data da tutoria final/.
*/
$arquivo = 'relatorioDisponibilidadePlanilha.xlsx';
$html = '<table border=1>';
$html .= '<tr>';
$html .= '<th colspan="9">Relatório estratégico para distribuição do calendário</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Convocação</th>';
$html .= '<th>Situação Bolsista</th>';
$html .= '<th>Edição</th>';
$html .= '<th>E-mail bolsista</th>';
$html .= '<th width="130px">CPF bolsista</th>';
$html .= '<th>Município de origem</th>';
$html .= '<th>UF de Origem</th>';
$html .= '<th>Tutor</th>';
$html .= '<th>CPF Tutor</th>';
$html .= '<th>E-mail tutor</th>';
$html .= '<th>Situação Tutor</th>';
$html .= '<th>Município tutor</th>';
$html .= '<th>UF tutor</th>';
$html .= '<th>Distância</th>';
$html .= '<th>Disponibilidade</th>';
$html .= '<th>Realizou tutoria</th>';
$html .= '<th>Justificativa</th>';
$html .= '<th>Período Inicial</th>';
$html .= '<th>Período final</th>';
$html .= '</tr>';


$result_transacoes = "select m.NomeMedico as bolsista, m.Convocacao,m.situacao,cc.Edicao, m.email as email_bolsista, m.CpfMedico as CPF_bolsista,vt.munic_origem,vt.uf_origem,
mt.NomeMedico as tutor,mt.CpfMedico as cpf_tutor, mt.email as email_tutor,mt.situacao as situacao_tutor,vt.munic_escolhido,vt.uf_escolhida,vt.distancia,
case 
    when cc.FlagDisponibilidade = 1 then 'Sim' 
    when cc.FlagDisponibilidade = 0 then 'Não' 
    when cc.FlagDisponibilidade = NULL then 'Não confirmou' 
end as Disponibilidade, cc.FlagRealizouTutoria as Realizou_Tutoria,cc.JustificativaTutoria,ct.PeriodoInicial,ct.PeriodoFinal    
from medico m
inner join vaga_tutoria vt on m.idMedico = vt.idMedico
inner join tutor_municipio tm on vt.idTutor = tm.idTutor
inner join medico mt on tm.idTutor = mt.idMedico
inner join ControleCalendario cc on cc.idMedico = vt.idMedico
inner join CalendarioTutoria ct on ct.idCalendario = cc.idCalendario and ct.Edicao = cc.Edicao
order by m.NomeMedico, mt.NomeMedico;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['bolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['Convocacao'] . "</td>";
    $html .= '<td>' . $row_transacoes['situacao'] . "</td>";
    $html .= '<td>' . $row_transacoes['Edicao'] . "</td>";
    $html .= '<td>' . $row_transacoes['email_bolsista'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['CPF_bolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['munic_origem'] . "</td>";    
    $html .= '<td>' . $row_transacoes['uf_origem'] . "</td>";    
    $html .= '<td>' . $row_transacoes['tutor'] . "</td>";    
    $html .= '<td>' . $row_transacoes['cpf_tutor'] . "</td>";    
    $html .= '<td>' . $row_transacoes['email_tutor'] . "</td>";    
    $html .= '<td>' . $row_transacoes['situacao_tutor'] . "</td>";    
    $html .= '<td>' . $row_transacoes['munic_escolhido'] . "</td>";    
    $html .= '<td>' . $row_transacoes['uf_escolhida'] . "</td>";    
    $html .= '<td>' . $row_transacoes['distancia'] . "</td>";    
    $html .= '<td>' . $row_transacoes['Disponibilidade'] . "</td>";    
    $html .= '<td>' . $row_transacoes['Realizou_Tutoria'] . "</td>";    
    $html .= '<td>' . $row_transacoes['JustificativaTutoria'] . "</td>"; 
    $html .= '<td>' . $row_transacoes['PeriodoInicial'] . "</td>";    
    $html .= '<td>' . $row_transacoes['PeriodoFinal'] . "</td>";    
    $html .= '</tr>';
}
$html .= '</table>';

// configurações header para forçar o download
    header("Expires: Mon, 30 Out 2099 10:00:00 GMT");
    header("Last-Modified: ". gmdate("D,d M YH:i:s")." GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/x-msexcel");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header("Content-Description: PHP Generated Data" );
      
    // envia o conteúdo do arquivo
    echo $html;
    exit;
?>
    </body>
</html>