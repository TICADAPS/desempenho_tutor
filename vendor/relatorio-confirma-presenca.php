<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '2048M');
set_time_limit(1000);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Nome</th>';
$html .= '<th width="130px">CPF</th>';
$html .= '<th>e-mail</th>';
$html .= '<th>Tutoria</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "select m.NomeMedico,m.CpfMedico,m.email,cc.Edicao
from medico m 
inner join ControleCalendario cc on m.idMedico = cc.idMedico
where cc.FlagDisponibilidade is not null and cc.FlagDisponibilidade = 1 and cc.Edicao = 1
order by m.NomeMedico;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";  
    $html .= '<td width="130px">' . $row_transacoes['CpfMedico'] . "</td>";    
    $html .= '<td>' . $row_transacoes['email'] . "</td>"; 
    $html .= '<td>' . $row_transacoes['Edicao'] . "</td>"; 
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';
$sqlCout = "select count(idMedico) as qntd from ControleCalendario
where FlagDisponibilidade = 1 and Edicao = 1;";
$qntd = 0;
$sqlCout = mysqli_query($conn, $sqlCout);
while ($row_Count = mysqli_fetch_assoc($sqlCout)){
    $qntd =  $row_Count['qntd'];
}
$html .= '<h3>Quantidade de confirmação de presença na tutoria = '.$qntd;



//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once("./autoload.php");

//Criando a Instancia
$dompdf = new DOMPDF();
$dompdf->setPaper('A4', 'portrait'); //Paisagem
// Carrega seu HTML
$dompdf->load_html('
<h1 style="text-align: center;">ADAPS - Confirmação de presença de tutoria</h1>
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