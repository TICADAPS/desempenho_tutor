<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '4096M');
set_time_limit(100);
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
$arquivo = 'RelatorioMedicoSemTutor.xlsx';

$html = '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="9">ADAPS - Relatorio de Medico Sem Tutor</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Médico Bolsista</th>';
$html .= '<th width="130px">CPF</th>';
$html .= '<th>UF</th>';
$html .= '<th>Município</th>';
$html .= '<th>Convocação</th>';
$html .= '</tr>';

$result_transacoes = "select mb.nome_medico, mb.cpf_medico, e.UF, mu.Municipio, m.Convocacao 
from medico_bolsista mb
inner join medico m on m.idMedico = mb.idMedico
inner join estado e on e.cod_uf = m.Estado_idEstado
inner join municipio mu on mu.cod_munc = m.Municipio_id
where mb.idMedico not in (select idMedico from vaga_tutoria) order by e.UF";

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