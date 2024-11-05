<?php
session_start();
include '../conexao-agsus.php';
include '../conexao_agsus_2.php';
include '../Controller_agsus/fdatas.php';
include '../Controller_agsus/maskCpf.php';

//if (!isset($_SESSION['perfil'])) {
//    header("Location: ../derruba_session.php");
//    exit();
//}
//if (!isset($_SESSION['nivel'])) {
//    header("Location: ../derruba_session.php");
//    exit();
//}
//if($_SESSION['perfil'] !== '3'){
//    header("Location: ../derruba_session.php");
//    exit();
//}

ini_set('memory_limit', '4096M');
set_time_limit(1000);

$ano = $_REQUEST['a'];
$ciclo = $_REQUEST['c'];
date_default_timezone_set('America/Sao_Paulo');
$ctap = 0;
$sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, 
    m.datacadastro, m.cpf, m.ibge, m.cnes, m.ine, 
    ivs.descricao as ivs, ap.id, ap.pontuacao, ap.flaginativo, ap.flagterminou, 
    case 
        when ap.flagterminou = 1 then 'SIM' 
        else 'NÃO' 
    end as flagterminou
from medico m 
inner join aperfeicoamentoprofissional ap on ap.cpf = m.cpf 
    and ap.ibge = m.ibge and ap.cnes = m.cnes and ap.ine = m.ine 
left join ivs on m.fkivs = ivs.idivs 
where ap.ano = '$ano' 
  and ap.ciclo = '$ciclo';";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);
$rscpf = false;
if ($nrrs > 0) {
    $rscpf = true;
}
?>
<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Logística</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/estilo.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="shortcut icon" href="img/iconAdaps.png"/>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
// nome do arquivo que será exportado
        $arquivo = "Relatorio_AP.xlsx";
        $x = 0;
        $html = '<table id="dtBasicExample" class="table table-hover table-bordered table-striped rounded">';
        $html .= '<thead>';
        $html .= ' <tr class="bg-dark text-light font-weight-bold">';
        $html .= '  <td>TUTOR</td>';
        $html .= '  <td>CPF</td>';
        $html .= '  <td>TIPOLOGIA</td>';
        $html .= '  <td>IVS</td>';
        $html .= '  <td>MUNICÍPIO</td>';
        $html .= '  <td>UF</td>';
        $html .= '  <td>IBGE</td>';
        $html .= '  <td>CNES</td>';
        $html .= '  <td>INE</td>';
        $html .= '  <td>PONTUAÇÃO</td>';
        $html .= '  <td>PROCESSO FINALIZADO?</td>';
        $html .= '  <td>OBSERVAÇÃO</td>';
        $html .= ' </tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        if ($rscpf === true) {
            if ($nrrs > 0) {
                $soma = 0;
                do {
                    $idap = $rs['id'];
                    $nome = $rs['nome'];
                    $cpftratado = $rs['cpf'];
                    $cpftratado = str_replace("-", "", $cpftratado);
                    $cpftratado = str_replace(".", "", $cpftratado);
                    $cpftratado = str_replace(".", "", $cpftratado);
                    $cpf = mask($cpftratado, "###.###.###-##");
                    $ibge = $rs['ibge'];
                    $admissao = $rs['admissao'];
                    $cargo = $rs['cargo'];
                    $tipologia = $rs['tipologia'];
                    $ivs = strtoupper($rs['ivs']);
                    $ivs = str_replace ("á", "Á", $ivs);
                    $ivs = str_replace ("é", "É", $ivs);
                    $ivs = str_replace ("í", "Í", $ivs);
                    $ivs = str_replace ("ó", "Ó", $ivs);
                    $ivs = str_replace ("ú", "Ú", $ivs);
                    $uf = $rs['uf'];
                    $municipio = $rs['municipio'];
                    $cnes = $rs['cnes'];
                    $ine = $rs['ine'];
                    $flaginativo = '';
                    if($rs['flaginativo'] !== null){
                        $flaginativo = $rs['flaginativo'];
                    }
                    $ptap = $rs['pontuacao'];
                    $soma += $ptap;
                    $flagterminou = $rs['flagterminou'];
                    $ano = $ano;
                    $ciclo = $ciclo;
                    //montante da QC
                    $sqlqc = "select qc.pontuacao from medico_qualifclinica qc inner join "
                            . "aperfeicoamentoprofissional ap on ap.id = qc.idaperfprof "
                            . "where ap.id = '$idap' and qc.pontuacao > 0";
                    $qqc = mysqli_query($conn, $sqlqc);
                    $nrrsqc = mysqli_num_rows($qqc);
                    $rsqc = mysqli_fetch_array($qqc);
                    if($nrrsqc > 0){
                        $ptqc = 0;
                        do{
                            $ptqc += $rsqc['pontuacao'];
                        }while($rsqc = mysqli_fetch_array($qqc));
                        $soma += $ptqc;
                    }
                    
                    //montante da GEPE
                    $sqlgepe = "select gepe.pontuacao from medico_gesenspesext gepe inner join "
                            . "aperfeicoamentoprofissional ap on ap.id = gepe.idaperfprof "
                            . "where ap.id = '$idap' and gepe.pontuacao > 0";
                    $qgepe = mysqli_query($conn, $sqlgepe);
                    $nrrsgepe = mysqli_num_rows($qgepe);
                    $rsgepe = mysqli_fetch_array($qgepe);
                    if($nrrsgepe > 0){
                        $ptgepe = 0;
                        do{
                            $ptgepe += $rsgepe['pontuacao'];
                        }while($rsgepe = mysqli_fetch_array($qgepe));
                        $soma += $ptgepe;
                    }
                    
                    //montante da IT
                    $sqlit = "select it.pontuacao from medico_inovtecnologica it inner join "
                            . "aperfeicoamentoprofissional ap on ap.id = it.idaperfprof "
                            . "where ap.id = '$idap' and it.pontuacao > 0";
                    $qit = mysqli_query($conn, $sqlit);
                    $nrrsit = mysqli_num_rows($qit);
                    $rsit = mysqli_fetch_array($qit);
                    if($nrrsit > 0){
                        $ptit = 0;
                        do{
                            $ptit += $rsit['pontuacao'];
                        }while($rsit = mysqli_fetch_array($qit));
                        $soma += $ptit;
                    }
                    
        $html .= ' <tr>';
        $html .= "  <td>$nome</td>";
        $html .= "  <td>$cpf</td>";
        $html .= "  <td>$tipologia</td>";
        $html .= "  <td>$ivs</td>";
        $html .= "  <td>$municipio</td>";
        $html .= "  <td>$uf</td>";
        $html .= "  <td>$ibge</td>";
        $html .= "  <td>$cnes</td>";
        $html .= "  <td>$ine</td>";
        $html .= "  <td>$soma</td>";
        $html .= "  <td>$flagterminou</td>";
        if($flaginativo === '1'){
            $html .= "  <td>INATIVO</td>";
        }else{
            $html .= "  <td></td>";
        }
        $html .= " </tr>";
                }while($rs = mysqli_fetch_array($query));
            }
        }
        $html .= '</tbody>';
        $html .= '</table>';

        // configurações header para forçar o download
        header("Expires: Mon, 30 Out 2099 10:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
//    header ('Content-Type: application/vnd.ms-excel');
//    header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
        header("Content-Description: PHP Generated Data");

        echo $html;
        exit();
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../js/mask.js" type="text/javascript"></script>
    </body>
</html>
