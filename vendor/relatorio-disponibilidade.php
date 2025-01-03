<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '2048M');
set_time_limit(1000);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Bolsista</th>';
$html .= '<th>CPF Bolsista</th>';
$html .= '<th>Solicita passagem</th>';
$html .= '<th>Não necessita de hospedagem</th>';
$html .= '<th>Aceita os termos</th>';
$html .= '<th>Ciente da portaria</th>';
$html .= '<th>Registrado em</th>';
$html .= '<th>Inicio em</th>';
$html .= '<th>Fim em</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "select m.NomeMedico, m.CpfMedico, 
case when cc.FlagSolicitaPassagem = 0 then 'Não' 
when cc.FlagSolicitaPassagem = 1 then 'sim' end as Solicita_Passagem, 
case when cc.FlagDispensaHospedagem = 0 then 'Não' 
when cc.FlagDispensaHospedagem = 1 then 'sim' end as Solicita_hospedagem,
case when cc.FlagTermoResponsabilidade = 0 then 'Não' 
when cc.FlagTermoResponsabilidade = 1 then 'sim' end as Aceita_termos,
case when cc.FlagCienciaPortaria = 0 then 'Não' 
when cc.FlagCienciaPortaria = 1 then 'sim' end as Ciente_Portaria,
cc.DataCreate as Registrado, ct.PeriodoInicial, ct.PeriodoFinal
from ControleCalendario cc 
inner join medico m on cc.idMedico = m.idMedico
inner join CalendarioTutoria ct on ct.idCalendario = cc.idCalendario and cc.Edicao = ct.Edicao
where cc.Edicao = 1
order by cc.DataCreate desc;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['CpfMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['Solicita_Passagem'] . "</td>";
    $html .= '<td>' . $row_transacoes['Solicita_hospedagem'] . "</td>";
    $html .= '<td>' . $row_transacoes['Aceita_termos'] . "</td>";    
    $html .= '<td>' . $row_transacoes['Ciente_Portaria'] . "</td>";    
    $html .= '<td>' . $row_transacoes['Registrado'] . "</td>";    
    $html .= '<td>' . $row_transacoes['PeriodoInicial'] . "</td>";    
    $html .= '<td>' . $row_transacoes['PeriodoFinal'] . "</td>";    
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table';

//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once("./autoload.php");

//Criando a Instancia
$dompdf = new DOMPDF();
$dompdf->setPaper('A3', 'landscape'); //Paisagem
// Carrega seu HTML
$dompdf->load_html('
			<h1 style="text-align: center;">ADAPS - Relatório Calendário de tutoria</h1>
			' . $html . '
		');

//Renderizar o html
$dompdf->render();

//Exibibir a página
$dompdf->stream(
    "relatorio_adaps.pdf", array(
        "Attachment" => false //Para realizar o download somente alterar para true
    )
);
?>