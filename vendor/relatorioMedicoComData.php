<?php
include_once("../setor-admin/conexao.php");
include_once("../setor-admin/Controller/fdatas.php");
ini_set('memory_limit', '2048M');
set_time_limit(1000);

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
$html .= '<th>UF</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "select c.Descricao_cargo, m.NomeMedico,m.Convocacao,m.email,m.CpfMedico,
    m.fone_zap,m.DataApresentacao,
case
   when m.flagatividade = 0 then 'Não iniciou'
   else m.dataInicioAtividade
end as Inicio,mu.cod_munc, mu.Municipio, e.UF 
from medico m
inner join cargo c on c.idCargo = m.idCargo
inner join municipio mu on mu.cod_munc = m.Municipio_id
inner join estado e on e.cod_uf = m.Estado_idEstado
where m.DataApresentacao is not null
order by m.DataApresentacao desc LIMIT 1000;";
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
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
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
			<h1 style="text-align: center;">Relação dos últimos 1000 médicos</h1>
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