<?php
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
$html .= '<th colspan="11">Cargo</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Cargo</th>';
$html .= '<th>Nome</th>';
$html .= '<th width="130">CPF-Médico</th>';
$html .= '<th>Data apresentação</th>';
$html .= '<th>Convocação</th>';
$html .= '<th>Municipio</th>';
$html .= '<th>UF</th>';
$html .= '</tr>';

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
order by m.DataApresentacao desc;";
$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['Descricao_cargo'] . "</td>";
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td width="130">' . $row_transacoes['CpfMedico'] . "</td>";
    $html .= '<td>' . vemdata($row_transacoes['DataApresentacao']) . "</td>";
    $html .= '<td><center>' . $row_transacoes['Convocacao'] . "</center></td>";
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