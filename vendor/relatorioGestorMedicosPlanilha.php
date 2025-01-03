<?php
session_start();
include_once("../setor-admin/conexao.php");
include_once("../setor-admin/Controller/fdatas.php");

$cpf = $_SESSION['cpf'];

$sql = "select gestor.NomeGestor, gestor.Municipio_cod_munc, municipio.Municipio from gestor INNER JOIN municipio on "
        . "municipio.cod_munc = gestor.Municipio_cod_munc where gestor.CpfGestor = '$cpf'";
$query = mysqli_query($conn, $sql)or die(mysqli_errno($conn));
$nrrows = mysqli_num_rows($query);
if($nrrows > 0){
    while ($result = mysqli_fetch_assoc($query)){
        $NomeGestor = $result['NomeGestor'];
        $idmunicipio = $result['Municipio_cod_munc'];
        $Municipio = $result['Municipio'];
    }
}

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
$html .= "<th colspan='12'>Lista de Médicos de $Municipio</th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Cargo</th>';
$html .= '<th>Nome</th>';
$html .= '<th width="130px">CPF-Médico</th>';
$html .= '<th>Data apresentação</th>';
$html .= '<th>Convocação</th>';
$html .= '<th>Municipio</th>';
$html .= '<th>Gestor</th>';
$html .= '<th width="130px">CPF-Gestor</th>';
$html .= '<th>Email Gestor</th>';
$html .= '<th>Data Registro</th>';
$html .= '<th>Hora Registro</th>';
$html .= '<th>Início das Atividades</th>';
$html .= '</tr>';

$result_transacoes = "SELECT cargo.Descricao_cargo,medico.NomeMedico,medico.email,medico.CpfMedico,
    medico.fone_zap,medico.DataApresentacao,municipio.cod_munc,municipio.Municipio,gestor.NomeGestor, 
    medico.cpfGestor, gestor.email, medico.dataLog, medico.Convocacao, medico.dataInicioAtividade 
FROM medico,gestor,cargo,municipio 
WHERE medico.cpfGestor = gestor.CpfGestor and medico.idCargo = cargo.idCargo and 
municipio.cod_munc = medico.Municipio_id and medico.DataApresentacao is not null and medico.Municipio_id = '$idmunicipio' ORDER BY medico.DataApresentacao desc";
$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['Descricao_cargo'] . "</td>";
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['CpfMedico'] . "</td>";
    $html .= '<td>' . vemdata($row_transacoes['DataApresentacao']) . "</td>";
    $html .= '<td><center>' . $row_transacoes['Convocacao'] . "</center></td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['NomeGestor'] . "</td>";
    $html .= '<td width="130px">' . $row_transacoes['cpfGestor'] . "</td>";
    $html .= '<td>' . $row_transacoes['email'] . "</td>";
    $html .= '<td>' . vemdata($row_transacoes['dataLog']) . "</td>";
    $html .= '<td><center>' . horaEmin($row_transacoes['dataLog']) . "</center></td>";
    if($row_transacoes['dataInicioAtividade'] != null && $row_transacoes['dataInicioAtividade'] != '' && 
            $row_transacoes['dataInicioAtividade'] != '0000-00-00'){
        $html .= '<td>Iniciou as atividades em ' . vemdata($row_transacoes['dataInicioAtividade']) . "</td>";
    }else{
        $html .= '<td><center>Não iniciou as atividades</center></td>';
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