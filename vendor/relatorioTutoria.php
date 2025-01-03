<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '2048M');
set_time_limit(2000);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Médico Bolsista</th>';
$html .= '<th width="130px">CPF</th>';
$html .= '<th>UF</th>';
$html .= '<th>Código</th>';
$html .= '<th>Opção Escolhida</th>';
$html .= '<th>Código</th>';
$html .= '<th>1 Opção</th>';
$html .= '<th>Código</th>';
$html .= '<th>2 Opção</th>';
$html .= '<th>Código</th>';
$html .= '<th>3 Opção</th>';
$html .= '<th>Tutor</th>';
$html .= '<th>Qntd Vaga</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "SELECT distinct nome_medico,cpf_medico,est.UF, opcao_escolhida,tm.municipio as 'escolhida', opcao1,m1.Municipio as 'op1',opcao2, m2.Municipio as 'op2',opcao3,
       m3.Municipio as 'op3',NomeMedico,vaga_tutor 
FROM vaga_tutoria vt
	INNER JOIN medico_bolsista mb 
    	on mb.idMedico = vt.idMedico
	INNER JOIN tutor_municipio tm 
    	on tm.idTutor = vt.idTutor
	INNER JOIN medico m 
    	on m.idMedico = tm.idTutor
    INNER JOIN municipio as m1
    	on m1.cod_munc = vt.opcao1
     INNER JOIN municipio as m2
    	on m2.cod_munc = vt.opcao2
      INNER JOIN municipio as m3
    	on m3.cod_munc = vt.opcao3
      INNER JOIN estado as est
      	on est.cod_uf = tm.codUf
order by est.UF, tm.municipio, nome_medico";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['nome_medico'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['cpf_medico'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao_escolhida'] . "</td>";
    $html .= '<td>' . $row_transacoes['escolhida'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao1'] . "</td>";
    $html .= '<td>' . $row_transacoes['op1'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao2'] . "</td>";
    $html .= '<td>' . $row_transacoes['op2'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao3'] . "</td>";
    $html .= '<td>' . $row_transacoes['op3'] . "</td>";
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['vaga_tutor'] . "</td>";
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
			<h1 style="text-align: center;">ADAPS - Relatório de pedido de tutoria</h1>
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