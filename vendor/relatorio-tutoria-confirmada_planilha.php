<?php
include_once("../setor-admin/conexao.php");
ini_set('memory_limit', '2048M');
set_time_limit(300);
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
$arquivo = 'relatorioTutoriaConfirmadaPlanilha.xlsx';
$html = '<table border=1>';
$html .= '<tr>';
$html .= '<th colspan="7">Relatório dos Médicos que Realizaram Tutoria</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Bolsista</th>';
$html .= '<th width="130px">CPF Bolsista</th>';
$html .= '<th>Telefone</th>';
$html .= '<th>E-Mail</th>';
$html .= '<th>Início da Tutoria</th>';
$html .= '<th>Fim da Tutoria</th>';
$html .= '<th>Realizou Tutoria?</th>';
$html .= '</tr>';

$result_transacoes = "select m.NomeMedico, m.CpfMedico, m.fone_zap, m.email, ct.PeriodoInicial, ct.PeriodoFinal, 
    cc.FlagRealizouTutoria
from CalendarioTutoria ct
inner join ControleCalendario cc on ct.idCalendario = cc.idCalendario 
INNER JOIN medico_bolsista mb on cc.idMedico = mb.idMedico 
INNER JOIN vaga_tutoria vt on mb.idMedico = vt.idMedico 
INNER JOIN medico m on vt.idMedico = m.idMedico
order by ct.PeriodoInicial desc;";
/*where cc.FlagRealizouTutoria = 'Sim'*/

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['CpfMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['fone_zap'] . "</td>";
    $html .= '<td>' . $row_transacoes['email'] . "</td>";
    $dtFormatada1 = new DateTime($row_transacoes['PeriodoInicial']);
    $html .= '<td>' . $dtFormatada1->format("d/m/Y") . "</td>";    
    $dtFormatada2 = new DateTime($row_transacoes['PeriodoFinal']);
    $html .= '<td>' . $dtFormatada2->format("d/m/Y") . "</td>";  
    if($row_transacoes['FlagRealizouTutoria']=="Sim"){
        $html .= '<td><center>Sim</center></td>';
    }else if($row_transacoes['FlagRealizouTutoria']=="Não"){
        $html .= '<td><center>Não</center></td>';
    }else{
        $html .= '<td><center></center></td>';
    }
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