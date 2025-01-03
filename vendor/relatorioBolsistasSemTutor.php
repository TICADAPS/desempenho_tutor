<?php
session_start();
require_once ("../setor-admin/conexao.php");
if(!isset($_SESSION['cpf'])){
    header("Location: ../logout.php"); exit();
}
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
    $arquivo = 'medicosPorMunicipios.xlsx';
        
    // criando uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<th colspan="10">Relatório dos médicos bolsistas sem tutor</th>';
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td><b>Código</b></td>';
    $html .= '<td><b>Médico Bolsista</b></td>';
    $html .= '<td><b>CPF</b></td>';
    $html .= '<td><b>E-Mail</b></td>';
    $html .= '<td><b>Telefone</b></td>';
    $html .= '<td><b>IBGE</b></td>';
    $html .= '<td><b>Municícpio de Lotação</b></td>';
    $html .= '<td><b>UF de Lotação</b></td>';
    $html .= '<td><b>Admissão</b></td>';
    $html .= '<td><b>Participou de tutoria?</b></td>';
    $html .= '</tr>';
       
    // trazendo os dados do bd
    $sql = "select m.idMedico, m.NomeMedico, m.CpfMedico, m.email, m.fone_zap, m.Municipio_id, mun.Municipio as municipioOrigem,e.UF as ufOrigem, 
        m.admissao from medico m
    INNER JOIN municipio mun on m.Municipio_id = mun.cod_munc 
    INNER JOIN estado e on m.Estado_idEstado = e.cod_uf 
    INNER JOIN medico_bolsista mb on mb.idMedico = m.idMedico
    where m.idMedico not in (select idMedico from vaga_tutoria) and idCargo = 1
    order by m.NomeMedico;";
    $smtm = mysqli_query($conn, $sql)or die(mysqli_errno($conn));
    while ($row_query = mysqli_fetch_assoc($smtm)) {
        $idMedico = $row_query['idMedico'];
        
        $sqlH = "select idmedico from historico where ufescolhida is not null and idmedico = '$idMedico'";
        $smtH = mysqli_query($conn, $sqlH)or die(mysqli_errno($conn));
        $nrlinhasH = mysqli_num_rows($smtH);
  
        $NomeMedico = $row_query['NomeMedico'];
        $CpfMedico = $row_query['CpfMedico'];
        $email = $row_query['email'];
        $fone_zap = $row_query['fone_zap'];
        $Municipio_id = $row_query['Municipio_id'];
        $municipioOrigem = $row_query['municipioOrigem'];
        $ufOrigem = $row_query['ufOrigem'];
        $admissao = "";
        if($row_query['admissao'] !== null){
            $admissao = $row_query['admissao'];
            $admissao = date('d/m/Y', strtotime($admissao));
        }

    $html .= '<tr>';
        $html .= '<td>'.$idMedico.'</td>';
        $html .= '<td>'.$NomeMedico.'</td>';
        $html .= '<td>'.$CpfMedico.'</td>';
        $html .= '<td>'.$email.'</td>';
        $html .= '<td>'.$fone_zap.'</td>';
        $html .= '<td>'.$Municipio_id.'</td>';
        $html .= '<td>'.$municipioOrigem.'</td>';
        $html .= '<td>'.$ufOrigem.'</td>';
        $html .= '<td>'.$admissao.'</td>';
        if($nrlinhasH > 0){
            $html .= '<td><center>Sim</center></td>';
        }else{
            $html .= '<td>Não</td>';
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