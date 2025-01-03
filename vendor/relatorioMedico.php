<?php
include_once("../setor-admin/conexao.php");
include_once("../setor-admin/Controller/fdatas.php");
ini_set('memory_limit', '4096M');
set_time_limit(10000);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Cargo</th>';
$html .= '<th>Nome</th>';
$html .= '<th width="130px">CPF-Médico</th>';
$html .= '<th>Data apresentação</th>';
$html .= '<th>Início de Atividade</th>';
$html .= '<th>Convocação</th>';
$html .= '<th>Municipio</th>';
$html .= '<th>Gestor</th>';
$html .= '<th width="130px">CPF-Gestor</th>';
$html .= '<th>Email Gestor</th>';
$html .= '<th>Data Registro</th>';
$html .= '<th>Hora Registro</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "SELECT cargo.Descricao_cargo,medico.NomeMedico,medico.Convocacao,medico.email,medico.CpfMedico,
medico.fone_zap,medico.DataApresentacao,case when medico.flagatividade = 0 then 'Não iniciou' else medico.dataInicioAtividade end as Inicio,
municipio.cod_munc,municipio.Municipio,gestor.NomeGestor, medico.cpfGestor,
gestor.email, medico.dataLog 
FROM medico,gestor,cargo,municipio 
WHERE medico.cpfGestor = gestor.CpfGestor and medico.idCargo = cargo.idCargo and 
municipio.cod_munc = medico.Municipio_id and medico.DataApresentacao is not null ORDER BY medico.DataApresentacao desc;";
$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['Descricao_cargo'] . "</td>";
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['CpfMedico'] . "</td>";
    $html .= '<td><center>' . vemdata($row_transacoes['DataApresentacao']) . "</center></td>";
    $html .= '<td><center>' . $row_transacoes['Inicio'] . "</center></td>";
    $html .= '<td><center>' . $row_transacoes['Convocacao'] . "</center></td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['NomeGestor'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['cpfGestor'] . "</td>";
    $html .= '<td>' . $row_transacoes['email'] . "</td>";
    $html .= '<td><center>' . vemdata($row_transacoes['dataLog']) . "</center></td>";
    $html .= '<td><center>' . horaEmin($row_transacoes['dataLog']) . "</center></td>";
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
			<h1 style="text-align: center;">ADAPS - Relatório de Transações</h1>
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