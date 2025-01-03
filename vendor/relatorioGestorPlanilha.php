<?php
session_start();
include_once("../setor-admin/conexao.php");
include_once("../setor-admin/Controller/fdatas.php");


ini_set('memory_limit', '4096M');
set_time_limit(1000);
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
$arquivo = 'RelatorioPlanilha.xlsx';

$html = '<table border=1>';
$html .= '<tr>';
$html .= "<th colspan='7'>Lista de Gestores</th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Nome do Gestor</th>';
$html .= '<th width="130px">CPF-Gestor</th>';
$html .= '<th>Telefone</th>';
$html .= '<th>E-mail</th>';
$html .= '<th>Função</th>';
$html .= '<th>Município</th>';
$html .= '<th>Estado</th>';
$html .= '</tr>';

$result_transacoes = "select g.NomeGestor,g.CpfGestor,g.fone_zap,g.email,g.Funcao,m.Municipio,e.UF
from gestor g
inner join estado e on e.cod_uf = g.Estado_idEstado
inner join municipio m on m.cod_munc = g.Municipio_cod_munc;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeGestor'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['CpfGestor'] . "</td>";
    $html .= '<td>' . $row_transacoes['fone_zap'] . "</td>";
    $html .= '<td>' . $row_transacoes['email'] . "</td>";
    $html .= '<td>' . $row_transacoes['Funcao'] . "</td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
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