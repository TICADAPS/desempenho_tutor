<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '256M');
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
$arquivo = 'RelatorioPedidoTutoria.xlsx';

$html = '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="4">ADAPS - Relatório de Bolsistas com Tutor</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Estado</th>';
$html .= '<th>Município</th>';
$html .= '<th>Local Tutoria</th>';
$html .= '</tr>';

$result_transacoes = "select 
  me.NomeMedico,vt.uf_origem,vt.munic_origem,vt.munic_escolhido
    from medico me   
    inner join vaga_tutoria vt on vt.idMedico = me.idMedico   
where me.idCargo = 1 order by vt.uf_origem;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['Tutoria'] . "</td>";
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