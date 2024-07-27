<?php
session_start();
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';
include_once '../../recursos_online/api/v1/config.php';
include_once '../../recursos_online/api/libs/Database.php';
include_once '../../Controller_agsus/maskCpf.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
if (!isset($_SESSION['pgmsg'])) {
    $_SESSION['pgmsg'] = "1";
}
if(!isset($_SESSION['cpfgestor']) || trim($_SESSION['cpfgestor']) === '' || $_SESSION['cpfgestor'] === null){
    $_SESSION['msg'] = '<span class="yellow-text">* Faça o login.</span>';
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../derruba_session.php\"'>"; exit();
}
if(!isset($_SESSION['NomeGestor']) || trim($_SESSION['NomeGestor']) === '' || $_SESSION['NomeGestor'] === null){
    $_SESSION['msg'] = '<span class="yellow-text">* Faça o login.</span>';
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../derruba_session.php\"'>"; exit();
}
$NomeGestor = $_SESSION['NomeGestor'];
$ibge = $_SESSION['ibge'];
$cpf = $_SESSION['cpfgestor'];
$ide = substr($ibge, 0,2);
$pide = [
    ':id' => $ide
];
$mysql_options = [
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATABASE,
    'username' => MYSQL_USERNAME,
    'password' => MYSQL_PASSWORD,
];
$db = new Database($mysql_options);
$rse = $db->execute_query("SELECT * FROM estado where cod_uf = :id", $pide);
//var_dump($rse);
$uf = $mun = "";
foreach ($rse->results as $r){
    $uf = $r->UF;
}
$pidm = [
    ':ibge' => $ibge
];
$rsmun = $db->execute_query("SELECT * FROM municipio WHERE cod_munc = :ibge", $pidm);
//var_dump($rsmun);
foreach ($rsmun->results as $r){
    $mun = $r->Municipio;
}
date_default_timezone_set('America/Sao_Paulo');
$anoAtual = date('Y');
$ano = $_GET['a'];
$ciclo = $_GET['c'];
$idperiodo = 25;
$sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes,
 m.ine, ivs.descricao as ivs, p.descricaoperiodo, de.iddemonstrativo, de.ano, de.ciclo, de.competencias, de.aperfeicoamento, de.qualidade 
 from medico m inner join demonstrativo de on de.fkcpf = m.cpf and de.fkibge = m.ibge and de.fkcnes = m.cnes and de.fkine = m.ine 
 inner join periodo p on p.idperiodo = de.fkperiodo 
 left join ivs on m.fkivs = ivs.idivs 
 where de.ano = '$ano' and de.ciclo = '$ciclo' and m.ibge = '$ibge' and (de.flaginativo is null or de.flaginativo <> 1)";
$query = mysqli_query($conn, $sql);
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);
$rscpf = false;
if ($nrrs > 0) {
    $rscpf = true;
}
$contt = $conta = $contb = 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>AGSUS - Demonstrativo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        <!-- Custom fonts for this template-->
        <link rel="shortcut icon" href="../../img_agsus/iconAdaps.png"/>
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Custom styles for this template-->
        <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="../../js/highcharts.js"></script>
        <script src="../../js/highcharts-3d.js"></script>
        <!--<script src="../js/exporting.js"></script>-->
        <!--<script src="../js/export-data.js"></script>-->
        <script src="../../js/accessibility.js"></script>
        <script src="../../js/jquery.easypiechart.js"></script>
        <script src="../../js/jquery.easypiechart2.js"></script>
        <style>
        #container {
            height: 400px;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
        </style>
        <style>
            ul {margin-left: -18px;}
            .tooltip-inner {
                background-color: #0f547cad;
            }
            .tooltip.bs-tooltip-right .arrow:before {
                border-right-color: #0f547cad !important;
            }
            .tooltip.bs-tooltip-left .arrow:before {
                border-left-color: #0f547cad !important;
            }
            .tooltip.bs-tooltip-bottom .arrow:before {
                border-bottom-color: #0f547cad !important;
            }
            .tooltip.bs-tooltip-top .arrow:before {
                border-top-color: #0f547cad !important;
            }
            
            .box .chart{
                position: relative;
                width: 110px;
                height: 110px;
                margin: 0 auto;
                text-align: center;
                font-size: 18px;
                line-height: 110px;
            }
            .box canvas{
                position: absolute;
                top: 0;
                left: 0;
            }
            
            .table-overflow {
                max-height:550px;
                overflow-y:auto;
            }
            .table-overflow2 {
                max-height:360px;
                overflow-y:auto;
            }
            .table-hover tbody tr:hover td {
                background: #f0f8ff;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-4 mt-4 pl-5">
                    <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 mt-4 ">
                    <h4 class="mb-4 font-weight-bold text-center">Programa de Avaliação de Desempenho do Médico Tutor</h4>
                    <h4 class="mb-4 font-weight-bold text-center">Município <?= $mun ?>-<?= $uf ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        &nbsp;&nbsp;<button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="menuPrincipal" class="collapse navbar-collapse">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="../../../sistema-adaps/gestor/menu/" target="_parent" title="Página de entrada">Início</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../../../sistema-adaps/gestor/controller/derruba_session.php" target="_parent" title="Sair"><i class="fas fa-sign-out-alt pt-1"></i></a>
                                </li>
                            </ul>
                        </div>
                    </nav> 
                </div>
            </div>
            <div class="row p-2">
                <div class="col-12">
                    <?php 
                        if ($_SESSION['pgmsg'] === '2') {
                            if ($_SESSION['msg'] !== null && $_SESSION['msg'] !== '') {
                                echo $_SESSION['msg'];
                            }
                            $_SESSION['pgmsg'] = '1';
                        } else {
                            $_SESSION['msg'] = '';
                        }
                    ?>
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-12 shadow rounded pr-3 pl-3 mb-2">
                    <div class="row p-3">
                        <div class="col-md-12 mt-2">
                            <fieldset class="form-group border pr-2 pl-2">
                                <legend class="w-auto pr-2 pl-2"><label class="h5"><b>Listagem dos tutores de <?= $mun ?>-<?= $uf ?></b></label></legend>
                                <div class="mb-3 table-responsive text-nowrap table-overflow2">
                                    <table id="dtBasicExample" class="table table-hover table-bordered table-striped rounded">
                                        <thead class="bg-gradient-dark text-white">
                                            <tr class="bg-gradient-dark text-light font-weight-bold">
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 40%; height: 70px;position: sticky; top: 0px;">TUTOR</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">CPF</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">TIPOLOGIA</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">IVS</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">MUNICÍPIO</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">UF</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">IBGE</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">CNES</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">INE</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">IGAD</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Qualidade Assistencial">QA</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Qualidade Tutoria">QT</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Competências Profissionais">CP</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Aperfeiçoamento Profissional">AP</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($rscpf === true) {
                                                if ($nrrs > 0) {
                                                    do {
                                                        $contt++;
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
                                                        $uf = $rs['uf'];
                                                        $municipio = $rs['municipio'];
                                                        $ibge = $rs['ibge'];
                                                        $cnes = $rs['cnes'];
                                                        $ine = $rs['ine'];
                                                        $ivs = strtoupper($rs['ivs']);
                                                        $datacadastro = vemdata($rs['datacadastro']);
                                                        $ano = $rs['ano'];
                                                        $ciclo = $rs['ciclo'];
                                                        $sql2 = "select p.idperiodo, p.descricaoperiodo, d.prenatal_consultas, d.prenatal_sifilis_hiv, d.cobertura_citopatologico, 
                                                            d.hipertensao, d.diabetes 
                                                            from periodo p inner join desempenho d on p.idperiodo = d.idperiodo
                                                            where d.cpf = '$cpftratado' and d.ano = '$ano' and d.idperiodo = '$idperiodo' limit 1;";
                                                        $query2 = mysqli_query($conn, $sql2);
                                                        $rs2 = mysqli_fetch_array($query2);
                                                        $prenatal_consultas = $prenatal_sifilis_hiv = $cobertura_citopatologico = $hipertensao = $diabetes = 0;
                                                        if($rs2){
                                                            do{
                                                                $periodo = $rs2['descricaoperiodo'];
                                                                $idperiodo = $rs2['idperiodo'];
                                                                $prenatal_consultas = $rs2['prenatal_consultas'];
                                        //                        var_dump("prenatal_consultas",$prenatal_consultas);
                                                                $prenatal_consultas = ($prenatal_consultas/45)*10;
                                                                if($prenatal_consultas > 10){
                                                                    $prenatal_consultas = 10;
                                                                }
                                        //                        var_dump("prenatal_consultas-Fator",$prenatal_consultas);
                                                                $prenatal_sifilis_hiv = $rs2['prenatal_sifilis_hiv'];
                                        //                        var_dump("prenatal_sifilis_hiv",$prenatal_sifilis_hiv);
                                                                $prenatal_sifilis_hiv = ($prenatal_sifilis_hiv/60)*10;
                                                                if($prenatal_sifilis_hiv > 10){
                                                                    $prenatal_sifilis_hiv = 10;
                                                                }
                                        //                        var_dump("prenatal_sifilis_hiv-Fator",$prenatal_sifilis_hiv);
                                                                $cobertura_citopatologico = $rs2['cobertura_citopatologico'];
                                        //                        var_dump("cobertura_citopatologico",$cobertura_citopatologico);
                                                                $cobertura_citopatologico = ($cobertura_citopatologico/40)*10;
                                                                if($cobertura_citopatologico > 10){
                                                                    $cobertura_citopatologico = 10;
                                                                }
                                        //                        var_dump("cobertura_citopatologico-Fator",$cobertura_citopatologico);
                                                                $hipertensao = $rs2['hipertensao'];
                                        //                        var_dump("hipertensao",$hipertensao);
                                                                $hipertensao = ($hipertensao/50)*10;
                                                                if($hipertensao > 10){
                                                                    $hipertensao = 10;
                                                                }
                                        //                        var_dump("hipertensao-Fator",$hipertensao);
                                                                $hipertensaotext = str_replace(",", "", $hipertensao);
                                                                $hipertensaotext = str_replace(".", ",", $hipertensaotext);
                                                                $diabetes = $rs2['diabetes'];
                                        //                        var_dump("diabetes",$diabetes);
                                                                $diabetes = ($diabetes/50)*10;
                                                                if($diabetes > 10){
                                                                    $diabetes = 10;
                                                                }
                                        //                        var_dump("diabetes-Fator",$diabetes);
                                                                $diabetestext = str_replace(",", "", $diabetes);
                                                                $diabetestext = str_replace(".", ",", $diabetestext);
                                                            }while($rs2 = mysqli_fetch_array($query2));
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
                                                        $valor = 1400;
                                                        if($mf > 70){
                                                            $conta++;
                                                        }else{
                                                            $contb++;
                                                        }
                                //                        $mf= 49.99;
                                                        $mftext = number_format($mf, 2, ',', '.');
                                                        $faltam = 100 - $mf;
                                                        $faltamtext = number_format($faltam, 2, ',', '.');
                                            ?>
                                            <tr>
                                                <td><?= $nome ?></td>
                                                <td><?= $cpf ?></td>
                                                <td><?= $tipologia ?></td>
                                                <td><?= $ivs ?></td>
                                                <td><?= $municipio ?></td>
                                                <td><?= $uf ?></td>
                                                <td><?= $ibge ?></td>
                                                <td><?= $cnes ?></td>
                                                <td><?= $ine ?></td>
                                                <?php if($mf >= 70){ ?>
                                                <td><?= $mftext ?></td>
                                                <?php }else{ ?>
                                                <td class="text-danger"><?= $mftext ?></td>
                                                <?php } ?>
                                                <td><?= $qatext ?></td>
                                                <td><?= $qnotatext ?></td>
                                                <td><?= $cpossuitext ?></td>
                                                <td><?= $anotatext ?></td>
                                            </tr>
                                            <?php }while($rs = mysqli_fetch_array($query));
                                            }}?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-sm-3">
                                    QA - Qualidade Assistencial
                                </div>
                                <div class="col-sm-3">
                                    QT - Qualidade Tutoria
                                </div>
                                <div class="col-sm-3">
                                    CP - Competências Profissionais
                                </div>
                                <div class="col-sm-3">
                                    AP - Aperfeiçoamento Profissional
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <label class="font-weight-bold">Total de Tutores: </label>
                                    <label class="text-info font-weight-bold"><?= $contt ?></label>
                                </div>
                                <?php
                                //conversão decimal com vírgula - porcentagens acima e abaixo de 70
                                if($contt > 0){
                                    $mfat = round((($conta/$contt) * 100),2);
                                    $mfat = str_replace(".", ",", $mfat);
                                    $mfbt = round((($contb/$contt) * 100),2);
                                    $mfbt = str_replace(".", ",", $mfbt);
                                
                                ?>
                                <div class="col-sm-12">
                                    <label class="">IGAD - Indicador Geral da Avaliação de Desempenho</label>
                                </div>
                                <div class="col-sm-12">
                                    <label class="">IGAD <i class="fas fa-level-up-alt text-primary"></i> 70,00: </label>
                                    <label class="text-primary"><?= $conta ?></label>
                                    <label>&nbsp; <i class="fas fa-arrow-right"></i> </label>
                                    <label class="text-primary"><?= $mfat ?>% </label>
                                    <label>dos tutores</label>
                                </div>
                                <div class="col-sm-12">
                                    <label class="">IGAD <i class="fas fa-level-down-alt text-danger"></i> 70,00: </label>
                                    <label class="text-danger"><?= $contb ?></label>
                                    <label>&nbsp; <i class="fas fa-arrow-right"></i> </label>
                                    <label class="text-danger"><?= $mfbt ?>% </label>
                                    <label>dos tutores</label>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="container-fluid mt-2" style="margin-bottom:0;background-color: #1A1A37">
            <div class="row">
                <div class="col-md-3 mb-5">
                    <img class="img-fluid py-5" src="./../../img/logo-adaps-text-white.png" alt="logo adaps" />
                    <h4 class="small text-white">Redes sociais</h4>
                    <a target="_blank" href="https://www.facebook.com/agenciasus">
                        <i class="fab fa-facebook text-white fa-2x mr-2 pl-2"></i>
                    </a>
                    <a target="_blank" href="https://www.instagram.com/agenciasus/">
                        <i class="fab fa-instagram text-white fa-2x mr-2"></i>
                    </a>
                    <a target="_blank" href="https://www.linkedin.com/company/84489833/admin/feed/posts/">
                        <i class="fab fa-linkedin text-white fa-2x mr-2"></i>
                    </a>
                    <a target="_blank" href="https://twitter.com/agenciasus">
                        <i class="fab fa-twitter text-white fa-2x mr-2"></i>
                    </a>
                    <a target="_blank" href="https://www.youtube.com/channel/UCLSEqv-F8oUfcHdyIgRhC9Q">
                        <i class="fab fa-youtube text-white fa-2x"></i>
                    </a>
                </div>
                <div class="col-md-3">
                    <p>
                    <h5 class="pt-5"><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/quem-somos/">Quem Somos</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/conselho/">Conselho</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/diretoria-executiva/">Diretoria Executiva</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/noticias/">Noticia</a></h5>
                    </p>
                </div>
                <div class="col-md-3">
                    <p>
                    <h5 class="pt-5"><a class="small text-white" href="https://www.agenciasus.org.br/transparencia-e-prestacao-de-contas/">Transparência</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/ouvidoria/">Ouvidoria</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/prestacao-de-contas/">Prestação de Contas</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/programa-medicos-pelo-brasil/">Programa Médicos pelo Brasil</a></h5>
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="small text-white"><i class="fas fa-phone text-white fa-2x pt-5"></i> (61) 3686-4144</p>
                    <p class="small text-white"><i class="fas fa-map-marker-alt text-white fa-2x"></i>
                        SHN – Quadra 1, Bloco E, Conj A, 2º andar, Asa Sul, Brasília – DF -CEP: 70.701-050
                    </p>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="background-color: #FF0000">
            <div class="row pt-2">
                <div class="col-6 text-center">
                    <p class="small text-white">&COPY;Todos os direitos reservados | AgSUS 2024</p>
                </div>
                <div class="col-6 text-center">
                    <a class="small text-white" href="https://www.agenciasus.org.br/politica-de-privacidade-e-seguranca/">
                        Política de Privacidade | Termos de Uso
                    </a>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../../js/demo/chart-bar-prenatal-1q.js"></script>
        <script src="../../js/demo/chart-bar-prenatal-sifilis.js"></script>
        <script src="../../js/demo/chart-bar-citopatologico.js"></script>
        <script src="../../js/demo/chart-bar-hipertensao.js"></script>
        <script>
            $(function () {
              $('.dropdown-toggle').dropdown();
            }); 
            $(document).on('click', '.dropdown-toggle ', function (e) {
                e.stopPropagation();
              });
              
            $(document).ready(function () {
                //console.log("clicou");
                document.getElementById("loading").style.display = "block";
            });
            var i = setInterval(function () {
                clearInterval(i);
                // O código desejado é apenas isto:
                document.getElementById("loading").style.display = "none";
                document.getElementById("conteudo").style.display = "inline";
            }, 1000);
        </script>
        <script>
            Highcharts.chart('container', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Avaliação de Resultados e Avaliação de Competências',
                    align: 'left'
                },
                subtitle: {
                    text: 'ÍNDICE GLOBAL DE AVALIAÇÃO DE DESEMPENHO - IGAD: <?= $mftext ?>%',
                    align: 'left'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Resultado',
                    data: [
                        ['Competências profissionais: <?= $cpossuitext ?>% do IGAD', <?= $cpossui ?>],
                        ['Qualidade assistencial: <?= $qatext ?>% do IGAD', <?= $qa ?>],
                        ['Qualidade da tutoria: <?= $qnotatext ?>% do IGAD', <?= $qnota ?>],
                        ['Aperfeiçoamento profissional: <?= $anotatext ?>% do IGAD', <?= $anota ?>],
                        {
                            name: 'Deixou de pontuar: <?= $faltamtext ?>%',
                            y: <?= $faltam ?>,
                            sliced: false,
                            selected: false
                        }
                        /*['Vivo', 8],
                        ['Others', 30]*/
                    ]
                }]
            });
            
            $(function() {
                if(<?= $mf ?> < 70){
                    $('.chart').easyPieChart({
                        //your options goes here
                    });
                }else{
                    $('.chart').easyPieChart2({
                        //your options goes here
                    });
                }
            });
            </script>
    </body>

</html>
