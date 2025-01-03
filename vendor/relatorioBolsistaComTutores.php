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
$arquivo = 'Bolsistas_vinculados_a_tutores.xlsx';

$html = '<table border=1>';
$html .= '<tr>';
$html .= "<th colspan='12'>Bolsistas vinculados a tutores</th>";
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Tutor</th>';
$html .= '<th>CPF Tutor</th>';
$html .= '<th>Município Tutor</th>';
$html .= '<th>UF</th>';
$html .= '<th>IBGE</th>';
$html .= '<th>Vaga Disponível</th>';
$html .= '<th>Bolsista</th>';
$html .= '<th>CPF Bolsista</th>';
$html .= '<th>IBGE Bolsista</th>';
$html .= '<th>Município Bolsista</th>';
$html .= '<th>UF</th>';
$html .= '</tr>';

$result_transacoes = "select m.NomeMedico as Tutor, m.CpfMedico as cpf_tutor,tm.municipio as municipio_tutor,e.UF as uf_tutor,tm.cod_munc as ibge_tutor,tm.vaga_tutor as vaga_disponivel,
mb.nome_medico as Bolsista, mb.cpf_medico as cpf_bolsista,m1.Municipio_id as ibge_bolsista,vt.munic_origem as municipio_bolsista,vt.uf_origem as uf_bolsista
from tutor_municipio tm
inner join medico m on tm.idTutor = m.idMedico
inner join estado e on e.cod_uf = tm.codUf
inner join vaga_tutoria vt on vt.idTutor = tm.idTutor
inner join medico_bolsista mb on mb.idMedico = vt.idMedico
inner join medico m1 on m1.idMedico = mb.idMedico;";
$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['Tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['cpf_tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['municipio_tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['uf_tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['ibge_tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['vaga_disponivel'] . "</td>";
    $html .= '<td>' . $row_transacoes['Bolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['cpf_bolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['ibge_bolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['municipio_bolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['uf_bolsista'] . "</td>";    
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