<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '1024M');
set_time_limit(200);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Médico Bolsista</th>';
$html .= '<th width="130px">CPF</th>';
$html .= '<th>UF</th>';
$html .= '<th>Município</th>';
$html .= '<th>Convocação</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "select mb.nome_medico, mb.cpf_medico, e.UF, mu.Municipio,m.Convocacao 
from medico_bolsista mb
inner join medico m on m.idMedico = mb.idMedico
inner join estado e on e.cod_uf = m.Estado_idEstado
inner join municipio mu on mu.cod_munc = m.Municipio_id
where mb.idMedico not in (select idMedico from vaga_tutoria) order by e.UF;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['nome_medico'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['cpf_medico'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['Convocacao'] . "</td>";
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
$dompdf->setPaper('A4', 'landscape'); //Paisagem
// Carrega seu HTML
$dompdf->load_html('
			<h1 style="text-align: center;">ADAPS - Relatório de bolsista sem tutor</h1>
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