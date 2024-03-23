<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '2048M');
set_time_limit(10000);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>BOLSISTA</th>';
$html .= '<th>MUNICÍPIO DO BOLSISTA</th>';
$html .= '<th>UF DO BOLSISTA</th>';
$html .= '<th>CPF DO BOLSISTA</th>';
$html .= '<th>E-MAIL DO BOLSISTA</th>';
$html .= '<th>ADMISSÃO DO BOLSISTA</th>';
$html .= '<th>NR TUTORIAS REALIZADAS</th>';
$html .= '<th>NR TUTORIAS REALIZADAS (HISTÓRICO)</th>';
$html .= '<th>NR TUTORIAS REALIZADAS (TOTAL)</th>';
$html .= '<th>NR TUTORIAS AGENDADAS (A PARTIR DE 17-07-2023)</th>';
$html .= '<th>TUTOR</th>';
$html .= '<th>MUNICÍPIO DO TUTOR</th>';
$html .= '<th>UF DO TUTOR</th>';
$html .= '<th>ADMISSÃO DO TUTOR</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$preencheTabela = "call sp_rel_qtdTutorias_agendamento_datainicial('2023-07-17')";
$r_preencheTabela = mysqli_query($conn, $preencheTabela);

sleep(40);

$sqlrelatorio = "select * from relatorio_qtd order by BOLSISTA;";
$q_relatorio = mysqli_query($conn, $sqlrelatorio);
while ($row_transacoes = mysqli_fetch_assoc($q_relatorio)) {  
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['BOLSISTA'] . "</td>";
    $html .= '<td>' . $row_transacoes['vmunic_origem'] . "</td>";
    $html .= '<td>' . $row_transacoes['vuf_origem'] . "</td>";
    $html .= '<td>' . $row_transacoes['vCpfBolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['vemail'] . "</td>";    
    $html .= '<td>' . $row_transacoes['vadmissaoBolsista'] . "</td>";    
    $html .= '<td>' . $row_transacoes['nrTutorias'] . "</td>";    
    $html .= '<td>' . $row_transacoes['nrTutoriasHistorico'] . "</td>";    
    $html .= '<td>' . $row_transacoes['totalTutorias'] . "</td>";      
    $html .= '<td>' . $row_transacoes['qtdAgendada'] . "</td>";  
    $html .= '<td>' . $row_transacoes['TUTOR'] . "</td>";
    $html .= '<td>' . $row_transacoes['vmunic_escolhido'] . "</td>";
    $html .= '<td>' . $row_transacoes['vuf_escolhida'] . "</td>";
    $html .= '<td>' . $row_transacoes['vadmissaoTutor'] . "</td>";
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

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