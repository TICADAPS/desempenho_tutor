<?php
include '../conexao-agsus.php';
include '../Controller_agsus/fdatas.php';
include '../Controller_agsus/maskCpf.php';

ini_set('memory_limit', '4096M');
set_time_limit(1000);

//$ciclo = $_GET['ciclo'];
//$ano = $_GET['ano'];
//$periodo = $_GET['periodo'];
//var_dump($ciclo,$idCalendario);
$anoAtual = 2023;
$ano = 2023;
$ciclo = 1;
$idperiodo = 25;
$sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes,
 m.ine, ivs.descricao as ivs, p.descricaoperiodo, de.iddemonstrativo, de.ano, de.ciclo, de.competencias, de.aperfeicoamento, de.qualidade 
 from medico m inner join demonstrativo de on de.fkcpf = m.cpf and de.fkibge = m.ibge and de.fkcnes = m.cnes and de.fkine = m.ine 
 inner join periodo p on p.idperiodo = de.fkperiodo 
 left join ivs on m.fkivs = ivs.idivs 
 where de.ano = '$ano' and de.ciclo = '$ciclo' and (de.flaginativo is null or de.flaginativo <> 1)";
$query = mysqli_query($conn, $sql);
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
        $arquivo = "Relatorio_geral_IGAD.xlsx";
        $x = 0;
        $html = '<table id="dtBasicExample" class="table table-hover table-bordered table-striped rounded">';
        $html .= '<thead>';
        $html .= ' <tr class="bg-dark text-light font-weight-bold">';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 40%;position: sticky; top: 0px;">TUTOR</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">CPF</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">TIPOLOGIA</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">IVS</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">MUNICÍPIO</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">UF</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">IBGE</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">CNES</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">INE</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">IGAD</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">QA</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">QT</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">CP</td>';
        $html .= '  <td class="bg-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">AP</td>';
        $html .= '  <td class="bg-dark text-light align-middle text-center" style="width: 10%;position: sticky; top: 0px;">Data Cadastro</td>';
        $html .= ' </tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        if ($rscpf === true) {
            if ($nrrs > 0) {
                do {
                    $iddemonstrativo = $rs['iddemonstrativo'];
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
                    $uf = $rs['uf'];
                    $municipio = $rs['municipio'];
                    $ibge = $rs['ibge'];
                    $cnes = $rs['cnes'];
                    $ine = $rs['ine'];
                    $datacadastro = vemdata($rs['datacadastro']);
                    $ano = $rs['ano'];
                    $ciclo = $rs['ciclo'];
                    $sql2 = "select distinct p.idperiodo, p.descricaoperiodo, d.prenatal_consultas, d.prenatal_sifilis_hiv, d.cobertura_citopatologico, 
                        d.hipertensao, d.diabetes 
                        from periodo p inner join desempenho d on p.idperiodo = d.idperiodo
                        where d.cpf = '$cpftratado' and d.ano = '$ano' and d.idperiodo = '$idperiodo';";
                    $query2 = mysqli_query($conn, $sql2);
                    $rs2 = mysqli_fetch_array($query2);
                    $prenatal_consultas = $prenatal_sifilis_hiv = $cobertura_citopatologico = $hipertensao = $diabetes = 0;
                    if ($rs2) {
                        $periodo = $rs2['descricaoperiodo'];
                        $idperiodo = $rs2['idperiodo'];
                        $prenatal_consultas = $rs2['prenatal_consultas'];
                        //                        var_dump("prenatal_consultas",$prenatal_consultas);
                        $prenatal_consultas = ($prenatal_consultas / 45)*10;
                        if($prenatal_consultas > 10){
                            $prenatal_consultas = 10;
                        }
                        //                        var_dump("prenatal_consultas-Fator",$prenatal_consultas);
                        $prenatal_sifilis_hiv = $rs2['prenatal_sifilis_hiv'];
                        //                        var_dump("prenatal_sifilis_hiv",$prenatal_sifilis_hiv);
                        $prenatal_sifilis_hiv = ($prenatal_sifilis_hiv / 60)*10;
                        if($prenatal_sifilis_hiv > 10){
                            $prenatal_sifilis_hiv = 10;
                        }
                        //                        var_dump("prenatal_sifilis_hiv-Fator",$prenatal_sifilis_hiv);
                        $cobertura_citopatologico = $rs2['cobertura_citopatologico'];
                        //                        var_dump("cobertura_citopatologico",$cobertura_citopatologico);
                        $cobertura_citopatologico = ($cobertura_citopatologico / 40)*10;
                        if($cobertura_citopatologico > 10){
                            $cobertura_citopatologico = 10;
                        }
                        //                        var_dump("cobertura_citopatologico-Fator",$cobertura_citopatologico);
                        $hipertensao = $rs2['hipertensao'];
                        //                        var_dump("hipertensao",$hipertensao);
                        $hipertensao = ($hipertensao / 50)*10;
                        if($hipertensao > 10){
                            $hipertensao = 10;
                        }
                        //                        var_dump("hipertensao-Fator",$hipertensao);
                        $hipertensaotext = str_replace(",", "", $hipertensao);
                        $hipertensaotext = str_replace(".", ",", $hipertensaotext);
                        $diabetes = $rs2['diabetes'];
                        //                        var_dump("diabetes",$diabetes);
                        $diabetes = ($diabetes / 50)*10;
                        if($diabetes > 10){
                            $diabetes = 10;
                        }
                        //                        var_dump("diabetes-Fator",$diabetes);
                        $diabetestext = str_replace(",", "", $diabetes);
                        $diabetestext = str_replace(".", ",", $diabetestext);
                    }

                     //proporção da Qualidade assistencial
                        $qa = $prenatal_consultas + $prenatal_sifilis_hiv + $cobertura_citopatologico + $hipertensao + $diabetes;
                        $qatext = number_format($qa, 2, ',', ' ');
                        
                        //proporção da Qualidade da Tutoria
                        $qnota = $rs['qualidade'];
//                        var_dump($qnota);
//                        $qnota = (($qnota - 1)*10)/4;

                        $qnota = round($qnota,2);
                        $qnotatext = number_format($qnota, 2, ',', '.');
                        
                        //proporção da Competência Profissional
                        $cpossui = $rs['competencias'];
                        if($cpossui === '1'){
                            $cpossui = 30.00;
                            $cpossuitext = number_format(30, 2, ',', '.');
                        }else{
                            $cpossui = 0.00;
                            $cpossuitext = number_format(0, 2, ',', '.');
                        }
                        $anota = $rs['aperfeicoamento'];
                        if($anota >= 50){
                            $anota = 10.00;
                            $anotatext = number_format(10, 2, ',', '.');
                        }else{
                            $anota = 0.00;
                            $anotatext = number_format(0, 2, ',', '.');
                        }
                        $ar = $qa + $qnota + $anota;
                        $artext = number_format($ar, 2, ',', '.');
                        $mf = round(($ar + $cpossui),2);
//                        $mf= 49.99;
                        $mftext = number_format($mf, 2, ',', '.');
                        $faltam = 100 - $mf;
                        $faltamtext = number_format($faltam, 2, ',', '.');

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
        $html .= "  <td>$mftext%</td>";
        $html .= "  <td>$qatext%</td>";
        $html .= "  <td>$qnotatext%</td>";
        $html .= "  <td>$cpossuitext%</td>";
        $html .= "  <td>$anotatext%</td>";
        $html .= "  <td>$datacadastro</td>";
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
