<?php
session_start();
include '../conexao-agsus.php';
include '../Controller_agsus/fdatas.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
if (!isset($_SESSION['pgmsg'])) {
    $_SESSION['pgmsg'] = "1";
}
if (!isset($_SESSION['cpfgestor'])) {
   header("Location: ../derruba_session.php"); exit();
}
if (!isset($_SESSION['ibge'])) {
   header("Location: ../derruba_session.php"); exit();
}
if (!isset($_SESSION['NomeGestor'])) {
   header("Location: ../derruba_session.php"); exit();
}
$cpf = $_SESSION['cpfgestor'];
$ibge = $_SESSION['ibge'];
$NomeGestor = $_SESSION['NomeGestor'];
$cpf = $_GET['c'];
//$cpf = '04365468413';
date_default_timezone_set('America/Sao_Paulo');
$anoAtual = date('Y');
//$anoAtual = 2023;
$ano = $_GET['a'];
$ciclo = $_GET['cl'];
$idperiodo = $_GET['p'];
$flagincent = 0;
$cpftratado = str_replace("-", "", $cpf);
$cpftratado = str_replace(".", "", $cpftratado);
$cpftratado = str_replace(".", "", $cpftratado);
$sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes, 
    m.ine, ivs.descricao as ivs, d.iddemonstrativo, d.ano, d.ciclo, d.qualidade, d.competencias, d.aperfeicoamento, i.nivel, i.valor
    from medico m inner join demonstrativo d on m.cpf = d.fkcpf and d.fkibge = m.ibge and d.fkcnes = m.cnes and d.fkine = m.ine 
    inner join incentivo i on d.fkincentivo = i.idincentivo 
    left join ivs on m.fkivs = ivs.idivs 
    where m.cpf = '$cpftratado' and d.ano = '$ano' and d.ciclo = '$ciclo' and i.flaginativo = '$flagincent' and d.fkperiodo = '$idperiodo'"
        . "and m.ibge = '$ibge' and (d.flaginativo is null or d.flaginativo <> 1);";
$query = mysqli_query($conn, $sql);
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);
$rs1 = mysqli_fetch_array($query);
$rscpf = false;
if ($nrrs > 0) {
    $rscpf = true;
}
if ($rscpf === true) {
    if ($nrrs == 1) {
        do {
            $cpftutor = $rs['cpf'];
            $ibgetutor = $rs['ibge'];
            $cnestutor = $rs['cnes'];
            $inetutor = $rs['ine'];
            $nome1 = $rs['nome'];
            $ano1 = $rs['ano'];
            $ciclo1 = $rs['ciclo'];
            $iddemonstrativo = $rs['iddemonstrativo'];
        } while ($rs1 = mysqli_fetch_array($query));
    }
}else{
    $ano1 = $ano;
}

$sqlqa = "select * from medico m inner join desempenho d on m.cpf = d.cpf and m.ibge = d.ibge"
        . " inner join periodo p on p.idperiodo = d.idperiodo where m.cpf = '$cpftratado' and ano = '$ano' and p.idperiodo = '$idperiodo';";
$queryqa = mysqli_query($conn, $sqlqa);
$nrrsqa = mysqli_num_rows($queryqa);
$rsqa = mysqli_fetch_array($queryqa);
$prenatal_consultastext = $prenatal_sifilis_hivtext = $cobertura_citopatologicotext = $hipertensaotext = $diabetestext = $periodoqa = "";
if ($nrrsqa > 0) {
    do {
        $prenatal_consultas = $rsqa['prenatal_consultas'];
        $prenatal_consultastext = str_replace(",", "", $prenatal_consultas);
        $prenatal_consultastext = str_replace(".", ",", $prenatal_consultastext);
        $prenatal_sifilis_hiv = $rsqa['prenatal_sifilis_hiv'];
        $prenatal_sifilis_hivtext = str_replace(",", "", $prenatal_sifilis_hiv);
        $prenatal_sifilis_hivtext = str_replace(".", ",", $prenatal_sifilis_hivtext);
        $cobertura_citopatologico = $rsqa['cobertura_citopatologico'];
        $cobertura_citopatologicotext = str_replace(",", "", $cobertura_citopatologico);
        $cobertura_citopatologicotext = str_replace(".", ",", $cobertura_citopatologicotext);
        $hipertensao = $rsqa['hipertensao'];
        $hipertensaotext = str_replace(",", "", $hipertensao);
        $hipertensaotext = str_replace(".", ",", $hipertensaotext);
        $diabetes = $rsqa['diabetes'];
        $diabetestext = str_replace(",", "", $diabetes);
        $diabetestext = str_replace(".", ",", $diabetestext);
        $periodoqa = $rsqa['descricaoperiodo'];
    } while ($rsqa = mysqli_fetch_array($queryqa));
}
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
        <link rel="shortcut icon" href="../img_agsus/iconAdaps.png"/>
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="../js/highcharts.js"></script>
        <script src="../js/highcharts-3d.js"></script>
        <!--<script src="../js/exporting.js"></script>-->
        <!--<script src="../js/export-data.js"></script>-->
        <script src="../js/accessibility.js"></script>
        <script src="../js/jquery.easypiechart.js"></script>
        <script src="../js/jquery.easypiechart2.js"></script>
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
            
            dl{
                font-weight: bold;
            }
            dt{
                font-weight: bold;
                margin-left: 35px;
                text-align: justify;
            }
            dd{
                font-weight: 500;
                margin-left: 70px;
                text-align: justify;
            }
            ddd{
                font-weight: 500;
                margin-left: 30px;
                text-align: justify;
            }
            
            #incentivo:hover{
                font-size: 13px;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-3 mt-4 pl-5">
                    <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-9 mt-2 text-center">
                    <img src="../img_agsus/TESTEIRA001.png" class="img-fluid">
<!--                    <h4 class="mb-4 font-weight-bold text-center">Painel de Resultados</h4> 
                    <h4 class="mb-4 font-weight-bold text-center">1º Ciclo do Programa de Avaliação de Desempenho do Médico Tutor - Ano <?= $ano1 ?></h4>-->
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <!--Container wrapper-->
                        <div class="container-fluid">
                            <!--Toggle button-->
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLeftAlignExample" aria-controls="navbarLeftAlignExample" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                            </button>

                            <!--Collapsible wrapper-->
                            <div class="collapse navbar-collapse" id="navbarLeftAlignExample">
                                <!--Left links-->
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#"><small>Painel de Resultados dos Tutores do Município</small></a>
                                    </li>
<!--                                    <li class="nav-item">
                                        <a class="nav-link" href="https://agsusbrasil.org/desempenho_tutor/forca/demonstrativo.php?c=94616922691&a=2023&cl=1&p=25" target="_blank"><small>Qualidade Assistencial do Tutor</small></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="https://agsusbrasil.org/desempenho_tutor/gestor/" target="_blank"><small>Qualidade Assistencial do Tutor</small></a>
                                    </li>-->
                                    <!--Navbar dropdown-->
<!--                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><small>Página 3</small></a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">...</a>
                                            <a class="dropdown-item" href="#">...</a>
                                            <a class="dropdown-item" href="#">...</a>
                                        </div>
                                    </li>-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="controller/derruba_session.php"><i class="fas fa-sign-out-alt pt-1"></i></a>
                                    </li>
                                    <!--                          <li class="nav-item">
                            <div id="loading">
                                &nbsp;<img class="float-right" src="img/carregando.gif" width="40" height="40" />
                            </div>
                          </li>-->
                                </ul>
                                <!--Left links-->
                            </div>
                            <!--Collapsible wrapper-->
                        </div>
                        <!--Container wrapper-->
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
            <?php
            if ($rscpf === true) {
                if ($nrrs == 1) {
                    do {
                        $nome = $rs['nome'];
                        $ibge = $rs['ibge'];
                        $admissao = $rs['admissao'];
                        $cargo = $rs['cargo'];
                        $tipologia = $rs['tipologia'];
                        $uf = $rs['uf'];
                        $municipio = $rs['municipio'];
                        $cnes = $rs['cnes'];
                        $ine = $rs['ine'];
                        $ivs = strtoupper($rs['ivs']);
                        $datacadastro = $rs['datacadastro'];
                        $ano = $rs['ano'];
                        $ciclo = $rs['ciclo'];
                        $nivel = $rs['nivel'];
                        $valor = $rs['valor'];
                        $valortext = number_format($valor, 2, ',', ' ');
                        $sql2 = "select distinct p.idperiodo, p.descricaoperiodo, d.prenatal_consultas, d.prenatal_sifilis_hiv, d.cobertura_citopatologico, 
                            d.hipertensao, d.diabetes 
                            from periodo p inner join desempenho d on p.idperiodo = d.idperiodo
                            where d.cpf = '$cpftratado' and d.ano = '$ano' and d.idperiodo = '$idperiodo';";
                        $query2 = mysqli_query($conn, $sql2);
                        $rs2 = mysqli_fetch_array($query2);
                        $prenatal_consultas = $prenatal_sifilis_hiv = $cobertura_citopatologico = $hipertensao = $diabetes = 0;
                        $rpc = $rph = $rcc = $rh = $rd = 0;
                        $rpctxt = $rphtxt = $rcctxt = $rhtxt = $rdtxt = "";
                        $rpctxt2 = $rphtxt2 = $rcctxt2 = $rhtxt2 = $rdtxt2 = "";
                        if($rs2){
                            do{
                                $periodo = $rs2['descricaoperiodo'];
                                $idperiodo = $rs2['idperiodo'];
                                $prenatal_consultas = $rs2['prenatal_consultas'];
                                $rpctxt2 = $prenatal_consultas;
                                $rpctxt2 = str_replace(",", "", $rpctxt2);
                                $rpctxt2 = str_replace(".", ",", $rpctxt2);
        //                        var_dump("prenatal_consultas",$prenatal_consultas);
                                $prenatal_consultas = ($prenatal_consultas/45)*10;
                                $rpc = round($prenatal_consultas,2);
                                $rpctxt = str_replace(",", "", $rpc);
                                $rpctxt = str_replace(".", ",", $rpctxt);
                                if($prenatal_consultas > 10){
                                    $prenatal_consultas = 10;
                                }
        //                        var_dump("prenatal_consultas-Fator",$prenatal_consultas);
                                $prenatal_sifilis_hiv = $rs2['prenatal_sifilis_hiv'];
                                $rphtxt2 = $prenatal_sifilis_hiv;
                                $rphtxt2 = str_replace(",", "", $rphtxt2);
                                $rphtxt2 = str_replace(".", ",", $rphtxt2);
        //                        var_dump("prenatal_sifilis_hiv",$prenatal_sifilis_hiv);
                                $prenatal_sifilis_hiv = ($prenatal_sifilis_hiv/60)*10;
                                $rph = round($prenatal_sifilis_hiv,2);
                                $rphtxt = str_replace(",", "", $rph);
                                $rphtxt = str_replace(".", ",", $rphtxt);
                                if($prenatal_sifilis_hiv > 10){
                                    $prenatal_sifilis_hiv = 10;
                                }
        //                        var_dump("prenatal_sifilis_hiv-Fator",$prenatal_sifilis_hiv);
                                $cobertura_citopatologico = $rs2['cobertura_citopatologico'];
                                $rcctxt2 = $cobertura_citopatologico;
                                $rcctxt2 = str_replace(",", "", $rcctxt2);
                                $rcctxt2 = str_replace(".", ",", $rcctxt2);
        //                        var_dump("cobertura_citopatologico",$cobertura_citopatologico);
                                $cobertura_citopatologico = ($cobertura_citopatologico/40)*10;
                                $rcc = round($cobertura_citopatologico,2);
                                $rcctxt = str_replace(",", "", $rcc);
                                $rcctxt = str_replace(".", ",", $rcctxt);
                                if($cobertura_citopatologico > 10){
                                    $cobertura_citopatologico = 10;
                                }
        //                        var_dump("cobertura_citopatologico-Fator",$cobertura_citopatologico);
                                $hipertensao = $rs2['hipertensao'];
                                $rhtxt2 = $hipertensao;
                                $rhtxt2 = str_replace(",", "", $rhtxt2);
                                $rhtxt2 = str_replace(".", ",", $rhtxt2);
        //                        var_dump("hipertensao",$hipertensao);
                                $hipertensao = ($hipertensao/50)*10;
                                $rh = round($hipertensao,2);
                                $rhtxt = str_replace(",", "", $rh);
                                $rhtxt = str_replace(".", ",", $rhtxt);
                                if($hipertensao > 10){
                                    $hipertensao = 10;
                                }
        //                        var_dump("hipertensao-Fator",$hipertensao);
                                $hipertensaotext = str_replace(",", "", $hipertensao);
                                $hipertensaotext = str_replace(".", ",", $hipertensaotext);
                                $diabetes = $rs2['diabetes'];
                                $rdtxt2 = $diabetes;
                                $rdtxt2 = str_replace(",", "", $rdtxt2);
                                $rdtxt2 = str_replace(".", ",", $rdtxt2);
        //                        var_dump("diabetes",$diabetes);
                                $diabetes = ($diabetes/50)*10;
                                $rd = round($diabetes,2);
                                $rdtxt = str_replace(",", "", $rd);
                                $rdtxt = str_replace(".", ",", $rdtxt);
                                if($diabetes > 10){
                                    $diabetes = 10;
                                }
        //                        var_dump("diabetes-Fator",$diabetes);
                                $diabetestext = str_replace(",", "", $diabetes);
                                $diabetestext = str_replace(".", ",", $diabetestext);
                            }while($rs2 = mysqli_fetch_array($query2));
                            $rs2 = null;
                        }
                        
                        
                        //proporção da Qualidade assistencial
                        $qa = $prenatal_consultas + $prenatal_sifilis_hiv + $cobertura_citopatologico + $hipertensao + $diabetes;
                        //cálculo nota do domínimo
                        $qand = $qa;
                        $qandtext = number_format($qand, 2, ',', ' ');
//                        $qa = round(($qa * 0.5),2);
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
//                        var_dump($qa,$qnota,$cpossui,$anota,$mf,$faltam);
                        //parcelas proporcionais ao IGAD
//                        $qap = round(($qa/$mf)*100,2);
//                        var_dump($qap);
//                        $qnotap = round(($qnota/$mf)*100,2);
//                        var_dump($qnotap);
//                        $cpossuip = round(($cpossui/$mf)*100,2);
//                        var_dump($cpossuip);
//                        $qnotap = round(($qnota/$mf)*100,2);
//                        var_dump($qnotap);
                        ?>
                            <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3">
                                <div class="row p-3">
                                    <div class="col-md-12 mt-2 pl-3 pr-3">
                                        <div class="row">
                                            <div class="col-md-12 shadow rounded p-2">
                                                <div class="card">
                                                    <div class="card-body p-3">
                                                        <div class="row">
                                                            <div class="col-md-2 text-center">
                                                                <img src="../img_agsus/pad.png" class="img-fluid" width="90%">
                                                            </div>
                                                            <div class="col-md-10 p-3 mt-2">
                                                                <div class="row mt-3">
                                                                    <div class="col-md-6">
                                                                        <label class="font-weight-bold text-primary">Nome: &nbsp;<?= $nome ?></label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="font-weight-bold text-primary">CPF: &nbsp;<?= $cpf ?></label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="font-weight-bold">Cargo: </label><label> &nbsp;&nbsp;<?= $cargo ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label class="font-weight-bold">Município-UF: </label><label>&nbsp;&nbsp;<?php echo "$municipio-$uf"; ?></label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="font-weight-bold">CNES: </label><label>&nbsp;&nbsp;<?= $cnes ?></label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="font-weight-bold">INE: </label><label>&nbsp;&nbsp;<?= $ine ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label class="font-weight-bold">Tipologia: </label><label> &nbsp;&nbsp;<?= $tipologia ?></label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="font-weight-bold">IVS: </label><label> &nbsp;&nbsp;<?= $ivs ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-3">
                                    <div class="col-md-12 mb-3">
                                        <div class="row mt-3 mb-2">
                                            <div class="col-md-4 mb-3">
                                                <div class="row">
                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <p class="text-justify ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A avaliação de Desempenho abrange as especificidades técnicas, profissionais, relacionadas às atividades do cargo,
                                                            e características comportamentais, relacionadas à interação do empregado com a equipe, com a gestão municipal, 
                                                            com o ambiente de trabalho e com a instituição.</p>
                                                    </div>
                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-1 mb-3">
                                                                <div class="card" style="background-color: #1160AD;">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <img src="../icones/qualidade_assistencial_branco.png" style="width: 20%; opacity: 0.8; margin-right: -10px;" class="img-fluid float-right" alt="Responsive image">
                                                                            </div>
                                                                            <div class="col-10" style="margin-top: -80px;">
                                                                                <!--<h6 class="card-title  text-white font-weight-bold">Qualidade Assistencial: <?= $qatext ?>%</h6>-->
                                                                                <h6 class="card-title text-white font-weight-bold">Qualidade Assistencial:</h6>
                                                                                <p class="card-text  text-white text-justify">Domínio mensurado por meio de indicadores de saúde- SISAB/Previne Brasil, que 
                                                                                    tem a participação direta do profissional médico e da equipe de médicos bolsista de   cada tutor no cuidado - 
                                                                                    Compõem 50% do valor total da nota. </p>
                                                                                <button type="button" data-toggle="modal" data-target=".modalaqa" class="btn btn-info shadow-sm text-white">Mais detalhes...</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-1 mb-3">
                                                                <div class="card" style="background-color: #17A086;">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <img src="../icones/qualidade_branco.png" style="width: 20%; opacity: 0.8; margin-right: -10px;" class="img-fluid float-right" alt="Responsive image">
                                                                            </div>
                                                                            <div class="col-10" style="margin-top: -80px;">
                                                                                <!--<h6 class="card-title  text-white font-weight-bold">Qualidade da Tutoria: <?= $qnotatext ?>%</h6>-->
                                                                                <h6 class="card-title text-white font-weight-bold">Qualidade da Tutoria:</h6>
                                                                                <p class="card-text  text-white text-justify">Domínio mensurado por meio da Avaliação dos bolsistas em relação às vivências 
                                                                                    de tutorias clínicas: sistema da UNASUS, essa aferição da qualidade da tutoria é realizada pelos médicos 
                                                                                    bolsistas em relação a seus tutores tem se dado de forma contínua desde o início do programa a cada tutoria no 
                                                                                    SISPMB (Sistema do Programa Médicos pelo Brasil). Compõem 10% do valor total da nota.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-1 mb-3">
                                                                <div class="card" style="background-color: #94B856;">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <img src="../icones/aperficoamento_branco.png" style="width: 20%; opacity: 0.8; margin-right: -10px;" class="img-fluid float-right" alt="Responsive image">
                                                                            </div>
                                                                            <div class="col-10" style="margin-top: -80px;">
                                                                                <!--<h6 class="card-title  text-white font-weight-bold">Aperfeiçoamento Profissional: <?= $anotatext ?>%</h6>-->
                                                                                <h6 class="card-title text-white font-weight-bold">Aperfeiçoamento Profissional:</h6>
                                                                                <p class="card-text  text-white text-justify">Domínio mensurado por meio da quantidade de créditos alcançados em atividades 
                                                                                    desenvolvidas no semestre conforme os comprovantes registrados dos cursos realizados e inseridos no sistema na 
                                                                                    plataforma sênior. Compõem 10% do valor total da nota.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-1 mb-3">
                                                                <div class="card" style="background-color: #F49C07;">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <img src="../icones/competencias_branco.png" style="width: 20%; opacity: 0.8; margin-right: -10px;" class="img-fluid float-right" alt="Responsive image">
                                                                            </div>
                                                                            <div class="col-10" style="margin-top: -80px;">
                                                                                <!--<h6 class="card-title  text-white font-weight-bold">Competências Profissionais: <?= $cpossuitext ?>%</h6>-->
                                                                                <h6 class="card-title text-white font-weight-bold">Competências Profissionais:</h6>
                                                                                <p class="card-text  text-white text-justify">Domínio mensurado por meio da Autoavaliação do médico tutor, que envolve capacidades 
                                                                                    técnicas e comportamentos desejáveis para o exercício do cargo, alinhados na direção da missão, valores, propósitos da 
                                                                                    agência-AgSUS.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-1 mb-3">
                                                                <div class="card" style="background-color: #f1f4f8;">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <img src="../icones/deixou_de_pontuar_branco.png" style="width: 20%; opacity: 0.8; margin-right: -10px;" class="img-fluid float-right" alt="Responsive image">
                                                                            </div>
                                                                            <div class="col-10" style="margin-top: -80px;">
                                                                                <h6 class="card-title text-dark font-weight-bold">Vamos melhorar? Você precisa atingir mais <?= $faltamtext ?>% para alcançar a excelência.</h6>
                                                                                <?php if($faltam > 0){ ?>
                                                                                    <p class="text-justify ">Saiba em que competências há oportunidades de melhoria.</p>
                                                                                    <button type="button" data-toggle="modal" data-target=".modaldp" class="btn btn-info shadow-sm text-white">Mais detalhes...</button>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="row">
                                                    <div class="col-md-12 pl-4 pr-2 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-2 mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card">
                                                                            <div class="card-header text-info font-weight-bold">
                                                                                <h6 class="card-title text-primary">IGAD - ÍNDICE GLOBAL DE AVALIAÇÃO DE DESEMPENHO</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <div class="box">
                                                                                            <div class="chart" data-percent="<?= $mf ?>" data-scale-color="#ffb400"><?= $mftext ?>%</div>
                                                                                        </div>
                                                                                        <p class="text-center  text-primary mt-1 font-weight-bold">IGAD  (percentual alcançado)</p>
                                                                                    </div>
                                                                                    <div class="col-sm-12 ">
                                                                                        <p class="card-text mt-3 font-weight-bold">
                                                                                            <?php if($mf >= 70){ ?>
                                                                                                <label class="text-danger">*</label> Incentivo de Desempenho Alcançado: <label class="text-info">R$ <?php echo number_format($valor, 2, ',', '.'); ?></label>
                                                                                            <?php }else{ ?>
                                                                                                <label class="text-danger">*</label> Incentivo de Desempenho Alcançado: <label class="text-info">R$ <?php echo number_format(round((($valor * $mf)/100),2), 2, ',', '.'); ?></label>
                                                                                            <?php } ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mt-2">
                                                                                    <div class="col-sm-12">
                                                                                        <button type="button" data-toggle="modal" data-target=".modaligad" class="btn btn-light shadow-sm text-info">Mais detalhes...</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                          </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 pl-4 pr-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-2 mb-2">
                                                                <div class="card">
                                                                    <div class="row p-3">
                                                                        <div class="col-md-12 mt-3 mb-4">
                                                                            <figure class="highcharts-figure">
                                                                                <div id="container"></div>
                                                                                    <p class="highcharts-description small">
                                                                                      <i>* Representação gráfica dos domínios.</i>
                                                                                    </p>
                                                                            </figure>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12 pl-4 pr-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-2 mb-2">
                                                                <div class="card">
                                                                    <div class="row p-3">
                                                                        <div class="col-md-6">
                                                                            <img src="../img_agsus/pad.png" class="img-fluid" width="90%">
                                                                        </div>
                                                                        <?php
                                                                            $sqlt = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes,
                                                                            m.ine, ivs.descricao as ivs, p.descricaoperiodo, de.iddemonstrativo, de.ano, de.ciclo, de.competencias, de.aperfeicoamento, de.qualidade 
                                                                            from medico m inner join demonstrativo de on de.fkcpf = m.cpf and de.fkibge = m.ibge and de.fkcnes = m.cnes and de.fkine = m.ine 
                                                                            inner join periodo p on p.idperiodo = de.fkperiodo 
                                                                            left join ivs on m.fkivs = ivs.idivs 
                                                                            where de.ano = '$ano' and de.ciclo = '$ciclo' and (de.flaginativo is null or de.flaginativo <> 1)";
                                                                           $queryt = mysqli_query($conn, $sqlt);
                                                                           $nrrst = mysqli_num_rows($queryt);
                                                                           $rst = mysqli_fetch_array($queryt);
                                                                           $contt = $contat = $contbt = 0;
                                                                           $rscpft = false;
                                                                           if ($nrrst > 0) {
                                                                               $rscpft = true;
                                                                           }
                                                                           if ($rscpft === true) {
                                                                            if ($nrrst > 0) {
                                                                                 do {
                                                                                     $contt++;
                                                                                     $cpftratadot = $rst['cpf'];
                                                                                     $cpftratadot = str_replace("-", "", $cpftratadot);
                                                                                     $cpftratadot = str_replace(".", "", $cpftratadot);
                                                                                     $cpftratado = str_replace(".", "", $cpftratadot);
                                                                                     $anot = $rst['ano'];
                                                                                     $ciclot = $rst['ciclo'];
                                                                                     $sqlt2 = "select p.idperiodo, p.descricaoperiodo, d.prenatal_consultas, d.prenatal_sifilis_hiv, d.cobertura_citopatologico, 
                                                                                         d.hipertensao, d.diabetes 
                                                                                         from periodo p inner join desempenho d on p.idperiodo = d.idperiodo
                                                                                         where d.cpf = '$cpftratadot' and d.ano = '$anot' and d.idperiodo = '$idperiodo' limit 1;";
                                                                                     $queryt2 = mysqli_query($conn, $sqlt2);
                                                                                     $rst2 = mysqli_fetch_array($queryt2);
                                                                                     $prenatal_consultast = $prenatal_sifilis_hivt = $cobertura_citopatologicot = $hipertensaot = $diabetest = 0;
                                                                                     if($rst2){
                                                                                         do{
                                                                                             $periodot = $rst2['descricaoperiodo'];
                                                                                             $idperiodot = $rst2['idperiodo'];
                                                                                             $prenatal_consultast = $rst2['prenatal_consultas'];
                                                                     //                        var_dump("prenatal_consultas",$prenatal_consultas);
                                                                                             $prenatal_consultast = ($prenatal_consultast/45)*10;
                                                                                             if($prenatal_consultast > 10){
                                                                                                 $prenatal_consultast = 10;
                                                                                             }
                                                                     //                        var_dump("prenatal_consultas-Fator",$prenatal_consultas);
                                                                                             $prenatal_sifilis_hivt = $rst2['prenatal_sifilis_hiv'];
                                                                     //                        var_dump("prenatal_sifilis_hiv",$prenatal_sifilis_hiv);
                                                                                             $prenatal_sifilis_hivt = ($prenatal_sifilis_hivt/60)*10;
                                                                                             if($prenatal_sifilis_hivt> 10){
                                                                                                 $prenatal_sifilis_hivt = 10;
                                                                                             }
                                                                     //                        var_dump("prenatal_sifilis_hiv-Fator",$prenatal_sifilis_hiv);
                                                                                             $cobertura_citopatologicot = $rst2['cobertura_citopatologico'];
                                                                     //                        var_dump("cobertura_citopatologico",$cobertura_citopatologico);
                                                                                             $cobertura_citopatologicot = ($cobertura_citopatologicot/40)*10;
                                                                                             if($cobertura_citopatologicot > 10){
                                                                                                 $cobertura_citopatologicot = 10;
                                                                                             }
                                                                     //                        var_dump("cobertura_citopatologico-Fator",$cobertura_citopatologico);
                                                                                             $hipertensaot = $rst2['hipertensao'];
                                                                     //                        var_dump("hipertensao",$hipertensao);
                                                                                             $hipertensaot = ($hipertensaot/50)*10;
                                                                                             if($hipertensaot > 10){
                                                                                                 $hipertensaot = 10;
                                                                                             }
                                                                     //                        var_dump("hipertensao-Fator",$hipertensao);
                                                                                             $hipertensaotextt = str_replace(",", "", $hipertensaot);
                                                                                             $hipertensaotextt = str_replace(".", ",", $hipertensaotextt);
                                                                                             $diabetest = $rst2['diabetes'];
                                                                     //                        var_dump("diabetes",$diabetes);
                                                                                             $diabetest = ($diabetest/50)*10;
                                                                                             if($diabetest > 10){
                                                                                                 $diabetest = 10;
                                                                                             }
                                                                     //                        var_dump("diabetes-Fator",$diabetes);
                                                                                             $diabetestextt = str_replace(",", "", $diabetest);
                                                                                             $diabetestextt = str_replace(".", ",", $diabetestextt);
                                                                                         }while($rst2 = mysqli_fetch_array($queryt2));
                                                                                     }
                                                                                     //proporção da Qualidade assistencial
                                                                                     $qat = $prenatal_consultast + $prenatal_sifilis_hivt + $cobertura_citopatologicot + $hipertensaot + $diabetest;
                                                                                     $qatextt = number_format($qat, 2, ',', ' ');

                                                                                     //proporção da Qualidade da Tutoria
                                                                                     $qnotat = $rst['qualidade'];
                                                             //                        var_dump($qnota);
                                                             //                        $qnota = (($qnota - 1)*10)/4;

                                                                                     $qnotat = round($qnotat,2);
                                                                                     $qnotatextt = number_format($qnotat, 2, ',', '.');

                                                                                     //proporção da Competência Profissional
                                                                                     $cpossuit = $rst['competencias'];
                                                                                     if($cpossuit === '1'){
                                                                                         $cpossuit = 30.00;
                                                                                         $cpossuitextt = number_format(30, 2, ',', '.');
                                                                                     }else{
                                                                                         $cpossuit = 0.00;
                                                                                         $cpossuitextt = number_format(0, 2, ',', '.');
                                                                                     }
                                                                                     $anotat = $rst['aperfeicoamento'];
                                                                                     if($anotat >= 50){
                                                                                         $anotat = 10.00;
                                                                                         $anotatextt = number_format(10, 2, ',', '.');
                                                                                     }else{
                                                                                         $anotat = 0.00;
                                                                                         $anotatextt = number_format(0, 2, ',', '.');
                                                                                     }
                                                                                     $art = $qat + $qnotat + $anotat;
                                                                                     $artextt = number_format($art, 2, ',', '.');
                                                                                     $mft = round(($art + $cpossuit),2);
                                                                                     $valort = 1400;
                                                                                     if($mft > 70){
                                                                                         $contat++;
                                                                                     }else{
                                                                                         $contbt++;
                                                                                     }
                                                             //                        $mf= 49.99;
                                                                                     $mftextt = number_format($mft, 2, ',', '.');
                                                                                     $faltamt = 100 - $mft;
                                                                                     $faltamtextt = number_format($faltamt, 2, ',', '.');
                                                                                 } while ($rst = mysqli_fetch_array($queryt));
                                                                             }
                                                                             $mfat = round((($contat/$contt) * 100),2);
                                                                             $mfat = str_replace(".", ",", $mfat);
                                                                            }
                                                                            ?>
                                                                        <div class="col-md-6 mt-3">
                                                                            <p class="text-center align-content-center p-4 "><?= $mfat ?>% dos tutores avaliados alcançou a pontuação de 70 pontos ou mais.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 pl-4 pr-2">
                                                <div class="row">
                                                    <div class="col-md-12 pl-4 pr-2 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-2 mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card">
                                                                            <div class="card-header text-primary font-weight-bold">
                                                                                <h6>FEEDBACK DO <?= $ciclo ?>º CICLO AVALIATIVO</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <p class="text-justify ">Apresentamos o resultado individual da sua Avaliação de Desempenho Individual, referente ao 1º Ciclo  de 2023, que compreendeu o período 
                                                                                            de julho a dezembro de 2023. Essa avaliação se constituiu como uma importante ferramenta para avaliar o desempenho dos empregados desta 
                                                                                            Agência, reconhecendo pontos fortes e identificando oportunidades de aprimoramento. Clique no botão abaixo para ler todo o feedback.</p>
                                                                                        <button type="button" data-toggle="modal" data-target=".modalFeedback" class="btn btn-light shadow-sm text-info">Feedback &nbsp;<i class="far fa-file-pdf text-danger"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 pl-4 pr-2 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-2 mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card">
                                                                            <div class="card-header text-primary font-weight-bold">
                                                                                <h6>CONTESTAÇÃO</h6>
                                                                            </div>
                                                                            <div class="card-body ">
                                                                            <?php
                                                                                $sqlc = "select * from contestacao inner join contestacao_assunto on fkcontestacao = idcontestacao inner join "
                                                                                    . "assunto on fkassunto = idassunto where fkdemonstrativo = '$iddemonstrativo' order by idassunto desc";
                                                                                $queryc = mysqli_query($conn, $sqlc);
                                                                                $nrrsc = mysqli_num_rows($queryc);
                                                                                $rsc = mysqli_fetch_array($queryc);
                                                                                if($nrrsc === 0){
                                                                            ?> 
                                                                            <p>Prezado(a) Colaborador(a),</p>
                                                                            <p class="text-justify">Caso tenha objeção em relação ao resultado do Índice Global de Avaliação de Desempenho (IGAD) atribuído à sua NOTA FINAL no Programa de Avaliação de Desempenho, gostaríamos de orientá-lo(a) sobre como proceder com o recurso administrativo:</p>
                                                                            <p class="text-justify">Primeiramente, acesse o detalhamento do seu desempenho na Plataforma-Painel de Resultados.</p>
                                                                            <p class="text-justify">Utilize o modelo de recurso disponibilizado. Nele, exponha seus argumentos marcando os pontos (domínios) nos quais discorda da avaliação e da nota atribuída.</p>
                                                                            <p class="text-justify">Após a elaboração do recurso, mantenha-se atento(a) aos avisos dentro do painel de resultados.</p>
                                                                            <p class="text-justify">Por favor, observe o prazo estabelecido para a contestação do recurso, que se encerra 15 (quinze) dias após a publicação do resultado.</p>
                                                                            <p class="text-justify">Estamos à disposição para fornecer esclarecimentos adicionais e agradecemos sua participação no Programa de Avaliação e Desempenho do Tutor Médico 2023.<br></p>
                                                                            <!--<button type="button" data-toggle="modal" data-target=".modalContestacao" class="btn btn-warning shadow-sm "><i class="fas fa-arrow-circle-right"></i> &nbsp;FAZER CONTESTAÇÃO</button>-->
                                                                            <?php }else{ 
                                                                                    do{
                                                                                        if($rsc['fkassunto'] === '1'){
                                                                                            echo "<label class='text-dark font-weight-bold'>".$rsc['assuntonovo']."</label><br>";
                                                                                        }else{
                                                                                            echo "<label class='text-dark font-weight-bold'>".$rsc['titulo']."</label><br>";
                                                                                        }
                                                                                        $idcontestacao = trim($rsc['idcontestacao']);
                                                                                        $contestacaotutor = trim($rsc['contestacao']);
                                                                                        $contestacaotutor = str_replace("'", "", $contestacaotutor);
                                                                                        $contestacaotutor = str_replace("\"", "", $contestacaotutor);
                                                                                        $datahora = $rsc['datahora'];
                                                                                        $dataresposta = $rsc['dataresposta'];
                                                                                        $flagresposta = $rsc['flagresposta'];
                                                                                        $resposta = trim($rsc['resposta']);
                                                                                        $resposta = str_replace("'", "", $resposta);
                                                                                        $resposta = str_replace("\"", "", $resposta);
                                                                                        echo "<label class='text-dark font-weight-bold'>Contestação do Tutor Médico: </label><label>&nbsp; $contestacaotutor</label><br>";
                                                                                    }while ($rsc = mysqli_fetch_array($queryc));
                                                                                    echo "<br><label class='text-danger'>* </label>&nbsp;<label class='text-dark'>Contestação enviada em: </label><label class='text-info'>&nbsp;".vemdata($datahora)."</label><br><br>";
                                                                                    if($flagresposta === '0'){
                                                                                        echo "<label class='text-danger'>* Em análise.</label>";
                                                                                    }else{
                                                                                        echo "<label class='text-danger mt-3 text-justify'>Resposta da Contestação: </label>&nbsp; <label class='text-justify'>$resposta</label><br>";
                                                                                        echo "<br><label class='text-danger'>* </label>&nbsp;<label class='text-dark'>Resposta enviada em: </label><label class='text-info'>&nbsp;".vemdata($dataresposta).".</label>";
                                                                                    }
                                                                                } ?>
                                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal modalFeedback -->
                            <div class="modal fad modalFeedback mt-2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog mw-100 w-75">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-arrow-circle-right"></i>&nbsp; FEEDBACK DO <?= $ciclo ?>º CICLO AVALIATIVO</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mt-1 pr-2 pl-2">
                                                <div class="col-sm-12 p-3 border rounded">
                                                    <div class="row mb-2">
                                                        <div class="col-sm-12">
                                                            <!--<h6 class="text-dark font-weight-bold text-center mb-5">PROGRAMA DE AVALIAÇÃO DE DESEMPENHO TUTOR MÉDICO <?= $ano ?></h6>-->
                                                            <div class="row mb-3">
                                                                <div class="col-sm-12  mt-2 mb-2">
                                                                    <table class="border-0">
                                                                        <tr>
                                                                            <td style="width: 60%; vertical-align: bottom;" class="mb-3"><h4 class="mt-4 font-weight-bold" style="color: #1F3B9B;">Prezado(a) Tutor(a) <?= $nome ?>,</h4></td>
                                                                            <td style="width: 40%; text-align: center;"><img src="../img_agsus/ciclo1_parabens.png" class="img-fluid rounded" width="70%"></td>
                                                                        </tr>
                                                                    </table>
                                                                    
                                                                </div>
<!--                                                                <div class="col-sm-6 text-center">
                                                                    <img src="../img_agsus/ciclo1_parabens.png" class="img-fluid rounded" width="80%">
                                                                </div>-->
                                                            </div>
<!--                                                            <p class="text-justify">Parabéns pelo seu primeiro ano de dedicação ao Programa Médicos pelo Brasil! A partir de agora, sua atuação como tutor será avaliada continuamente.</p>-->
                                                            <p class="text-justify">Neste feedback individual queremos apresentar um detalhamento do resultado do 1º ciclo da sua Avaliação de Desempenho, referente ao 
                                                                período de julho a dezembro de 2023 e instituída pela Portaria n.º 26, de 28 de fevereiro de 2023.</p>
                                                            <p class="text-justify">Esta é uma importante ferramenta da AgSUS e uma expressão do nosso compromisso em promover uma cultura de gestão com base em resultados
                                                                que visa reconhecer avanços e identificar oportunidades de aprimoramento. É uma iniciativa inspirada em práticas, nacionais e internacionais, que visam 
                                                                fortalecer a Atenção Primária à Saúde (APS).</p>
                                                            <p class="text-justify">Neste primeiro ciclo, você alcançou a Nota Geral <label class="text-danger"><?= $mftext ?></label> como resultado da sua Avaliação 
                                                                Individual, referente ao período de julho a dezembro de 2023.</p>
                                                            <p class="text-justify">A Avaliação de Desempenho é estruturada em dois eixos principais: Avaliação de Resultados e Avaliação de Competências, subdivididos 
                                                                em domínios que abrangem tanto especificidades técnicas profissionais relacionadas às atividades do cargo, quanto características comportamentais 
                                                                relacionadas à interação nos ambientes de trabalho, que diz respeito ao tratamento interpessoal com usuários, bolsistas, equipe de saúde e gestores. 
                                                                Neste sentido, seguem abaixo os domínios avaliados e seus resultados alcançados:</p>
                                                            <dl>1. Eixo I - Avaliação de Resultados
                                                                <dt>1. Qualidade Assistencial: </dt>
                                                                    <dd>1. Foi mensurado por de indicadores de boa performance na assistência à população, incluem a realização de no mínimo:
                                                                        <br><ddd>1.1. Seis consultas pré-natal com gestantes, </ddd>
                                                                        <br><ddd>1.2. Pedidos proporcionais de exames para sífilis e HIV, </ddd>
                                                                        <br><ddd>1.3. Proporção de mulheres com coleta de Citopatológico, </ddd>
                                                                        <br><ddd>1.4. Proporção de consultas relacionadas a pessoas com diabetes e solicitação de hemoglobina glicada e </ddd>
                                                                        <br><ddd>1.5. Proporção de pessoas com hipertensão, com consulta e pressão arterial aferida no semestre. </ddd>
                                                                    <dd>Os indicadores têm como unidade de análise o indivíduo e avaliam aspectos do cuidado em saúde dispensado de forma individualizada. É sabido que
                                                                        a responsabilidade pela realização das ações de saúde pela equipe é compartilhada com a gestão municipal, pois a mesma atua na manutenção dos
                                                                        recursos necessários e suporte para o adequado funcionamento da estrutura assistencial na qual o empregado está inserido. No entanto, considera-se
                                                                        que a escolha desse conjunto de indicadores, por ser fruto de processo de pactuação tripartite, pressupõe a implicação e compromisso da gestão
                                                                        municipal na busca por resultados</dd>
                                                                    <dd>2. O seu resultado nesse domínio alcançou a Nota <label class="text-danger"><?= $qatext ?></label>, você poderá obter de forma detalhada a 
                                                                        mensuração de cada indicador acessando o link https://agsusbrasil.org/sistema-integrado/login.php onde terá a evolução dos indicadores ao longo
                                                                        dos três quadrimestres de 2023.</dd>
                                                                <dt>2. Qualidade da Tutoria:</dt>
                                                                    <dd>1. A tutoria será avaliada a partir da verificação de um conjunto de evidências relacionadas às atribuições do Tutor Médico no processo de 
                                                                        realização do estágio experimental remunerado. Consiste, portanto, na opinião do bolsista em relação às vivências de tutoria clínica. Ter uma
                                                                        tutoria clínica efetiva e com a qualidade esperada é fundamental para o desenvolvimento das competências necessárias para o trabalho na APS. 
                                                                        A aferição da qualidade da tutoria foi feita com base em dados fornecidos pelos bolsistas vinculados e assistidos por cada tutor.</dd>
                                                                    <dd>2. A mensuração deste domínio com base na avaliação dos bolsistas vinculados foi <label class="text-danger"><?= $qnotatext ?></label>.</dd>
                                                                <dt>3. Aperfeiçoamento Profissional:</dt>
                                                                    <dd>1. O domínio aperfeiçoamento profissional está conectado com as atividades do Plano de Educação Continuada. O PEC organiza, por meio de um 
                                                                        sistema de créditos, o estímulo ao desenvolvimento contínuo de competências técnicas e comportamentais desses empregados, a partir da realização
                                                                        de atividades de qualificação clínica e de gestão, ensino, pesquisa, extensão e inovação tecnológica. Para tanto adotou-se o sistema de créditos
                                                                        como base para a verificação e julgamento do desempenho esperado. Os critérios e pesos das atividades de curta duração estão divulgados na 
                                                                        Instrução Normativa nº 002/2023 - Plano de Educação Continuada para os Médicos da Adaps.</dd>
                                                                    <dd>2. Com base na creditação atribuída aos documentos que você inseriu na plataforma sênior, você alcançou a pontuação 
                                                                        de <label class="text-danger"><?= $anotatext ?></label>.</dd>
                                                            </dl>    
                                                            <dl>2. Eixo II - Avaliação de Competências:
                                                                <dt>1. Competências Profissionais</dt>
                                                                    <dd>1. Trata de um conjunto de características e capacidades que podem ajudar o empregado a alcançar com maior facilidade as entregas esperadas 
                                                                        pela instituição. O instrumento para avaliação de competências é composto de nove domínios que dão conta de aspectos técnicos, que permeiam 
                                                                        a execução das atividades clínicas do médico na APS, mas também de aspectos transversais que correspondem aos comportamentos e atitudes ligadas 
                                                                        ao contexto de trabalho.</dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <p class="float-right mt-5"><div class='text-center' style="margin-bottom: 40px;"><img src='./../img_agsus/Logo_400x200.png' class='img-fluid' width="200"></div></p>
                                                        </div>
                                                        <div class="col-sm-2  mt-5">
                                                            <a id="pdffeedback" href="../demonstrativo/pdf/feedbackdemonstrativo.php?nome=<?= $nome ?>&ano=<?=$ano?>&qa=<?= $qatext ?>&qnota=<?= $qnotatext ?>&anota=<?= $anotatext ?>&mftext=<?= $mftext ?>" title="Impressão em PDF" target="_blank" class="btn btn-outline-danger shadow-sm rounded ml-5 mr-5 p-2 float-right">&nbsp;&nbsp;&nbsp; <i class="far fa-file-pdf"></i> &nbsp;&nbsp;&nbsp;</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-outline-danger shadow-sm rounded ml-5 mr-5 p-2" data-dismiss="modal">&nbsp; FECHAR &nbsp;</button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fim do modal feedback -->
                            <!-- modal modalContestacao -->
                            <div class="modal fad modalContestacao mt-2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form method="post" action="../Controller_agsus/contestacao.php">
                                <div class="modal-dialog mw-100 w-75">
                                    <div class="modal-content">
                                        <input type="hidden" name="iddemonstrativo" value="<?= $iddemonstrativo ?>">
                                        <input type="hidden" name="cpf" value="<?= $cpftutor ?>">
                                        <input type="hidden" name="ibge" value="<?= $ibgetutor ?>">
                                        <input type="hidden" name="cnes" value="<?= $cnestutor ?>">
                                        <input type="hidden" name="ine" value="<?= $inetutor ?>">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-arrow-circle-right"></i> Formulário de Contestação</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mt-2 mb-2 pr-2 pl-2">
                                                <div class="col-sm-12 pr-3 pl-2">
                                                    <div class="card border-light">
                                                        <h6 class="card-header text-dark font-weight-bold">Marque o(s) domínio(s) nos quais discorda da avaliação e da nota atribuída. &nbsp;<i class="far fa-file-alt"></i></h6>
                                                        <div class="card-body">
                                                            <div class="row pr-1 pl-1">
                                                                <div class="col-sm-12">
                                                                    <div class="input-group mb-1">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input type="checkbox" name="ckassunto1" id="ckassunto1" onclick="clickAssunto1()" value="2" aria-label="Qualidade Assistencial">
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control bg-white" value="Qualidade Assistencial" disabled aria-label="Qualidade Assistencial">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1 divassunto1 mb-3">
                                                                <div class="col-sm-12 mt-1">
                                                                    <h6 class="text-dark">Registre a sua contestação:</h6>
                                                                    <textarea name="contestacao1" id="contestacao1" class="form-control" rows="4" style="resize: none;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1">
                                                                <div class="col-sm-12">
                                                                    <div class="input-group mb-1">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input type="checkbox" name="ckassunto2" id="ckassunto2" onclick="clickAssunto2()" value="3" aria-label="Qualidade da Tutoria">
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control bg-white" value="Qualidade da Tutoria" disabled aria-label="Qualidade da Tutoria">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1 divassunto2 mb-3">
                                                                <div class="col-sm-12 mt-1">
                                                                    <h6 class="text-dark">Registre a sua contestação:</h6>
                                                                    <textarea name="contestacao2" id="contestacao2" class="form-control" rows="4" style="resize: none;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1">
                                                                <div class="col-sm-12">
                                                                    <div class="input-group mb-1">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input type="checkbox" name="ckassunto3" id="ckassunto3" onclick="clickAssunto3()" value="4" aria-label="Aperfeiçoamento Profissional">
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control bg-white" value="Aperfeiçoamento Profissional" disabled aria-label="Aperfeiçoamento Profissional">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1 divassunto3 mb-3">
                                                                <div class="col-sm-12 mt-1">
                                                                    <h6 class="text-dark">Registre a sua contestação:</h6>
                                                                    <textarea name="contestacao3" id="contestacao3" class="form-control" rows="4" style="resize: none;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1">
                                                                <div class="col-sm-12">
                                                                    <div class="input-group mb-1">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input type="checkbox" name="ckassunto4" id="ckassunto4" onclick="clickAssunto4()" value="5" aria-label="Competências Profissionais">
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control bg-white" value="Competências Profissionais" disabled aria-label="Competências Profissionais">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1 divassunto4 mb-3">
                                                                <div class="col-sm-12 mt-1">
                                                                    <h6 class="text-dark">Registre a sua contestação:</h6>
                                                                    <textarea name="contestacao4" id="contestacao4" class="form-control" rows="4" style="resize: none;"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1">
                                                                <div class="col-sm-12">
                                                                    <div class="input-group mb-1">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input type="checkbox" name="ckassunto5" onclick="clickAssunto5()" id="ckassunto5" value="1" aria-label="Outro assunto">
                                                                            </div>
                                                                        </div>
                                                                        <input type="text" class="form-control bg-white" value="Outro assunto" disabled aria-label="Outro assunto">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1">
                                                                <div class="col-sm-12">
                                                                    <h6 class="text-dark mt-3" id="hassuntonovo">Outro Assunto:</h6>
                                                                    <input type="text" name="assuntonovo" id="assuntonovo" class="form-control mb-0">
                                                                    <label class="text-danger mt-1 mb-2 " id="lassuntonovo">* Digite o assunto da contestação</label>
                                                                </div>
                                                            </div>
                                                            <div class="row pr-1 pl-1 divassunto5">
                                                                <div class="col-sm-12 mt-1">
                                                                    <h6 class="text-dark">Registre a sua contestação:</h6>
                                                                    <textarea name="contestacao5" id="contestacao5" class="form-control" rows="4" style="resize: none;"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="enviarContestacao" value="1" class="btn btn-success shadow-sm rounded ml-5 mr-5 p-2">&nbsp;&nbsp; ENVIAR &nbsp;&nbsp;</button>
                                            <button type="reset" class="btn btn-light shadow-sm rounded ml-5 mr-5 p-2" data-dismiss="modal"> CANCELAR </button>    
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- modal modalar -->
                            <div class="modal fad modalar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; Avaliação de Resultados</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <h6 class="text-secondary">A avaliação de resultados correspondente até 70% do resultado final.</h6>
                                                    <h6 class="text-secondary">Resultado:  &nbsp;<label class="text-danger"><?= $artext ?>%</label>&nbsp; do resultado final.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalar -->
                            <!-- modal modalac -->
                            <div class="modal fad modalac" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; Avaliação de Competências</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <h6 class="text-secondary">A avaliação de competências correspondente até 30% do resultado final.</h6>
                                                    <h6 class="text-secondary">Resultado:  &nbsp;<label class="text-danger"><?= $cpossuitext ?>%</label>&nbsp; do resultado final.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalac -->
                            <!-- modal modaligad -->
                            <div class="modal fad modaligad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; IGAD - ÍNDICE GLOBAL DE AVALIAÇÃO DE DESEMPENHO</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="row mt-2">
                                                        <div class="col-sm-6">
                                                            <h6 class="font-weight-bold"><u>Resultado Final - Ano <?= $ano ?>, Período <?= $periodoqa ?></u>:</h6>
                                                            <p class="font-weight-bold">Médico(a) Tutor(a): <?= $nome ?></p>
                                                            <h6 class="text-secondary font-weight-bold">Resultado final (IGAD)(%):  &nbsp;<label class="text-danger"><?= $mftext ?></label> - distribuídos em:</h6>
                                                            <ul>
                                                                <li>Qualidade Assistencial (%): <?= $qatext ?></li>
                                                                <li>Qualidade da Tutoria (%): <?= $qnotatext ?></li>
                                                                <li>Aperfeiçoamento Profissional (%): <?= $anotatext ?></li>
                                                                <li>Competências Profissionais (%): <?= $cpossuitext ?></li>
                                                            </ul>
                                                            <div class="col-sm-12">
                                                                <p>O valor pago a título de incentivo de desempenho será dimensionado da seguinte forma: </p>
                                                                <ul>
                                                                    <li><strong>IGAD igual ou maior que 70 pontos:</strong> o incentivo de desempenho será igual ao teto estabelecido em ato normativo da Agência.</li>
                                                                    <li><strong>IGAD menor que 70 pontos:</strong> o incentivo de desempenho será proporcional aos pontos alcançados.</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-sm-12">
<!--                                                                <table class="small" style="border: none;">
                                                                    <tr>
                                                                        <td class=" text-center"><img src="./../img_agsus/incentivo70.jpg" width="70%" class="img-fluid border rounded"></td>
                                                                    </tr>
                                                                </table>-->
                                                                <p class="card-text mt-3 font-weight-bold">
                                                                <?php if ($mf >= 70) { ?>
                                                                            <label class="text-danger">*</label> Incentivo de Desempenho Alcançado: <label class="text-info">R$ <?php echo number_format($valor, 2, ',', '.'); ?></label>
                                                                        <?php } else { ?>
                                                                            <label class="text-danger">*</label> Incentivo de Desempenho Alcançado: <label class="text-info">R$ <?php echo number_format(round((($valor * $mf) / 100), 2), 2, ',', '.'); ?></label>
                                                                        <?php } ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <fieldset class="border pr-3 pl-3 rounded"><legend class="border pt-2 pb-2 pr-3 pl-3 small rounded font-weight-bold bg-gradient-info text-white mb-2 ">Tabela de resultados da avaliação de desempenho</legend>
                                                            <table class="table mt-2 border">
                                                                <thead class="bg-gradient-dark text-white">
                                                                  <tr>
                                                                    <th class="">Domínio</th>
                                                                    <th class="">Nota</th>
                                                                  </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <tr>
                                                                    <td <?php if($mf < 30){ echo "class='text-danger font-weight-bold'";} else{ echo "class=''";} ?>>Muito insatisfatório</td>
                                                                    <td <?php if($mf < 30){ echo "class='text-danger font-weight-bold'";} else{ echo "class=''";} ?>>0 - 29,99 pontos</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td <?php if($mf < 50 && $mf >= 30){ echo "class='text-danger font-weight-bold'";} else{ echo "class=''";} ?>>Insatisfatório</td>
                                                                    <td <?php if($mf < 50 && $mf >= 30){ echo "class='text-danger font-weight-bold'";} else{ echo "class=''";} ?>>30 - 49,99 pontos</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td <?php if($mf < 70 && $mf >= 60){ echo "class='text-info font-weight-bold'";} else{ echo "class=''";} ?>>Regular</td>
                                                                    <td <?php if($mf < 70 && $mf >= 50){ echo "class='text-info font-weight-bold'";} else{ echo "class=''";} ?>>50 a 69,99 pontos</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td <?php if($mf < 90 && $mf >= 70){ echo "class='text-primary font-weight-bold'";} else{ echo "class=''";} ?>>Satisfatório</td>
                                                                    <td <?php if($mf < 90 && $mf >= 70){ echo "class='text-primary font-weight-bold'";} else{ echo "class=''";} ?>>70 a  89,99 pontos</td>
                                                                  </tr>
                                                                  <tr>
                                                                    <td <?php if($mf > 90){ echo "class='text-primary font-weight-bold'";} else{ echo "class=''";} ?>>Muito satisfatório</td>
                                                                    <td <?php if($mf > 90){ echo "class='text-primary font-weight-bold'";} else{ echo "class=''";} ?>>Maior que 90 pontos</td>
                                                                  </tr>
                                                                </tbody>
                                                              </table>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-12">
                                                            <fieldset class="border pr-3 pl-3 rounded"><legend class="border pt-2 pb-2 pr-3 pl-3 small rounded font-weight-bold bg-gradient-info text-white mb-2 ">Cálculo do Indicador Geral da Avaliação de Desempenho</legend>
                                                            <table class="table mt-2 border table-responsive">
                                                                <thead class="bg-gradient-dark text-white">
                                                                    <tr>
                                                                        <th class="">DOMÍNIO</th>
                                                                        <th class="">MEDIDA SÍNTESE</th>
                                                                        <th class="">DETALHAMENTO</th>
                                                                        <th class="">PONTUAÇÃO</th>
                                                                        <th class="">CÁLCULO DO IGAD</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class=" font-weight-bold">Qualidade assistencial</td>
                                                                        <td class="">Total de pontos em indicadores de saúde</td>
                                                                        <td class="">Soma de pontos por alcance de resultados em indicadores assistenciais</td>
                                                                        <td class=" text-center">0-50</td>
                                                                        <th class=" align-middle text-center font-weight-bold text-primary" rowspan="4">IGAD = Soma dos pontos obtidos nos domínios</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=" font-weight-bold">Qualidade da tutoria</td>
                                                                        <td class="">Média da avaliação da tutoria no semestre</td>
                                                                        <td class="">Média das avaliações realizadas no semestre, convertida para escala decimal</td>
                                                                        <td class=" text-center">0-10</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=" font-weight-bold">Aperfeiçoamento profissional</td>
                                                                        <td class="">Alcance do mínimo de créditos no PEC</td>
                                                                        <td class="">Sim - 10 pontos<br>Não - 0 pontos</td>
                                                                        <td class=" text-center">0 ou 10</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class=" font-weight-bold">Competências profissionais</td>
                                                                        <td class="">Realização da autoavaliação</td>
                                                                        <td class="">Sim - 30 pontos<br>Não - 0 pontos</td>
                                                                        <td class=" text-center">0 ou 30</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <p class="mt-3  text-secondary mb-0"><label class="font-weight-bold">* Fonte: </label> <a href="./../pdf/manual_2023.pdf" target="_blank">Manual Programa de Avaliação de Desempenho Tutor Médico 2023</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal">&nbsp;&nbsp; OK &nbsp;&nbsp;</button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modaligad -->
                            <!-- modal modalaqa -->
                            <div class="modal fad modalaqa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; Qualidade Assistencial</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body pr-4 pl-4 pt-2 pb-2">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="row mt-2">
                                                        <div class="col-sm-12">
                                                            <h6 class="font-weight-bold"><u>Resultado dos Indicadores - Ano <?= $ano ?> - Período <?= $periodoqa ?></u>:</h6>
                                                            <p class="font-weight-bold">Médico(a) Tutor(a): <?= $nome ?></p>
                                                            <h6 class="text-secondary font-weight-bold">Resultado:  &nbsp;<label class="text-danger"><?= $qatext ?>%</label></h6>
                                                            <h6 class="text-secondary"><i class="fas fa-arrow-alt-circle-right text-primary"></i>&nbsp; A qualidade assistencial corresponde até 50% do resultado final.</h6>
                                                            <p><i class="fas fa-arrow-alt-circle-right text-primary"></i>&nbsp; O desempenho do domínio qualidade assistencial é dado na forma do total de pontos nos indicadores de saúde.
                                                                É representado por meio de nota de desempenho (nd) com variação entre 0 e 50
                                                                pontos, que é resultante da soma das notas individuais dos indicadores (ni). Para
                                                                cada indicador a nota calculada é produto do resultado alcançado (Ri) ponderado em relação a meta (m), <label class="font-weight-bold">no limite de 10
                                                                    pontos</label>.
                                                            </p>
                                                            
                                                            <fieldset class="border pr-3 pl-3 rounded"><legend class="border pt-2 pb-2 pr-3 pl-3 rounded small font-weight-bold bg-gradient-info text-white mb-2">Cálculo da Nota do Domínio &nbsp; <i class="fas fa-arrow-right text-white"></i> &nbsp; <?= $qatext ?></legend>
                                                            <table class="table mt-2 border">
                                                                <thead class="bg-gradient-dark text-white">
                                                                    <tr>
                                                                        <th class="">Indicador</th>
                                                                        <th class="">Fórmula para cálculo <br>(Não pode exceder a 10 pontos)</th>
                                                                        <th class="">Fórmula em execução</th>
                                                                        <th class="">Resultado</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="">Pré-Natal  (consultas) - <label class="font-weight-bold">R1</label></td>
                                                                        <th class="">n1 = (R1/45)*10</th>
                                                                        <th class="">n1 = (<label class="text-primary"><?= $rpctxt2 ?></label>/45)*10</th>
                                                                        <td class="">n1 = <?= $rpctxt ?>
                                                                        <?php 
                                                                        if($rpc > 10){
                                                                            echo '<br>Excedeu a 10 pontos &nbsp; <i class="fas fa-arrow-right text-danger "></i> &nbsp; n1 = 10,00';
                                                                        }
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="">Pré-Natal  (exames) - <label class="font-weight-bold">R2</label></td>
                                                                        <th class="">n2 = (R2/60)*10</th>
                                                                        <th class="">n2 = (<label class="text-primary"><?= $rphtxt2 ?></label>/60)*10</th>
                                                                        <td class="">n2 = <?= $rphtxt ?>
                                                                        <?php 
                                                                        if($rph > 10){
                                                                            echo '<br>Excedeu a 10 pontos &nbsp; <i class="fas fa-arrow-right text-danger "></i> &nbsp; n2 = 10,00';
                                                                        }
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="">Exames Citopatológicos - <label class="font-weight-bold">R3</label></td>
                                                                        <th class="">n3 = (R3/40)*10</th>
                                                                        <th class="">n3 = (<label class="text-primary"><?= $rcctxt2 ?></label>/40)*10</th>
                                                                        <td class="">n3 = <?= $rcctxt ?>
                                                                        <?php 
                                                                        if($rcc > 10){
                                                                            echo '<br>Excedeu a 10 pontos &nbsp; <i class="fas fa-arrow-right text-danger "></i> &nbsp; n3 = 10,00';
                                                                        }
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="">Hipertensão - <label class="font-weight-bold">R4</label></td>
                                                                        <th class="">n4 = (R4/50)*10</th>
                                                                        <th class="">n4 = (<label class="text-primary"><?= $rhtxt2 ?></label>/50)*10</th>
                                                                        <td class="">n4 = <?= $rhtxt ?>
                                                                        <?php 
                                                                        if($rh > 10){
                                                                            echo '<br>Excedeu a 10 pontos &nbsp; <i class="fas fa-arrow-right text-danger "></i> &nbsp; n4 = 10,00';
                                                                        }
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="">Diabetes Mellitus - <label class="font-weight-bold">R5</label></td>
                                                                        <th class="">n5 = (R5/50)*10</th>
                                                                        <th class="">n5 = (<label class="text-primary"><?= $rdtxt2 ?></label>/50)*10</th>
                                                                        <td class="">n5 = <?= $rdtxt ?>
                                                                        <?php 
                                                                        if($rd > 10){
                                                                            echo '<br>Excedeu a 10 pontos &nbsp; <i class="fas fa-arrow-right text-danger "></i> &nbsp; n5 = 10,00';
                                                                        }
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                                <p class="mb-2 "><label class="text-danger">*</label>&nbsp; Nota domínio qualidade assistencial <label class="font-weight-bold">(nd = n1 + n2 + n3 + n4 + n5)</label> &nbsp; <i class="fas fa-arrow-right text-danger"></i> &nbsp; 
                                                                    <label class="text-danger">nd = <?= $qatext ?></label></p>
                                                            </fieldset>
                                                            </p>
                                                        </div>
<!--                                                        <div class="col-sm-6">
                                                            <h6 class="font-weight-bold"><u>Cálculo do Desempenho do Domínio Qualidade Assistencial</u></h6>
                                                            <p><img src="../img/calculoQA.png" width="100%"></p>
                                                        </div>-->
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-2">
                                                    <p class="mt-2  text-secondary mb-0"><a href="./qa_tutor.php?c=<?= $cpf ?>&a=<?= $ano ?>&cl=<?= $ciclo ?>&p=<?= $idperiodo ?>" class="btn btn-primary shadow-sm" target="_blank"><i class="fas fa-arrow-alt-circle-right"></i>&nbsp; Visite o painel da Evolução da Qualidade Assistencial</a></p>
                                                </div>
                                                <div class="col-sm-12">
                                                    <p class=" text-secondary mb-0"><label class="font-weight-bold">* Fonte: </label> <a href="./../pdf/manual_2023.pdf" target="_blank">Manual Programa de Avaliação de Desempenho Tutor Médico 2023</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal">&nbsp;&nbsp; OK &nbsp;&nbsp;</button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalaqa -->
                            <!-- modal modalqt -->
                            <div class="modal fad modalqt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; Qualidade da Tutoria</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <h6 class="text-secondary">A qualidade da tutoria corresponde até 10% do resultado final.</h6>
                                                    <h6 class="text-secondary">Resultado:  &nbsp;<label class="text-danger"><?= $qnotatext ?>%</label>&nbsp; do resultado final.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalqt -->
                            <!-- modal modalap -->
                            <div class="modal fad modalap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; Aperfeiçoamento Profissional</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <h6 class="text-secondary">O aperfeiçoamento profissional corresponde até 10% do resultado final.</h6>
                                                    <h6 class="text-secondary">Resultado:  &nbsp;<label class="text-danger"><?= $anotatext ?>%</label>&nbsp; do resultado final.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalap -->
                            <!-- modal modalcp -->
                            <div class="modal fad modalcp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; Competências Profissionais</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <h6 class="text-secondary">As competências Profissionais correspondem até 30% do resultado final.</h6>
                                                    <h6 class="text-secondary">Resultado:  &nbsp;<label class="text-danger"><?= $cpossuitext ?>%</label>&nbsp; do resultado final.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalcp -->
                            <!-- modal modaldp -->
                            <div class="modal fad modaldp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-poll"></i>&nbsp; Vamos melhorar?</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body pr-4 pl-4 pt-2 pb-2">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="row mt-2">
                                                        <div class="col-sm-12 pr-2 pl-2">
                                                            <h6 class="font-weight-bold"><u>Resultado dos Indicadores - Ano <?= $ano ?> - Período <?= $periodoqa ?></u>:</h6>
                                                            <p class="font-weight-bold">Médico(a) Tutor(a): <?= $nome ?></p>
                                                            <h6 class="text-secondary font-weight-bold">Deixou de alcançar: <label class="text-danger"><?= $faltamtext ?>%</label></h6>
                                                            <?php
                                                            if($faltamtext > 0){
                                                                echo "<h6 class='text-dark font-weight-bold'><u>Demonstrativo:</u></h6>";
                                                                if($qand < 50){
                                                                    $reqand = round((50-$qand),2);
                                                                    $reqand = str_replace(",", "", $reqand);
                                                                    $reqand = str_replace(".", ",", $reqand);
                                                                    echo "<i class='fas fa-asterisk text-danger'></i>&nbsp; <label class='text-primary'>Qualidade assistencial:</label>&nbsp; <label class='text-dark'>$qandtext de 50 pontos</label>&nbsp; <i class='fas fa-arrow-right text-info'></i>&nbsp; os $reqand que faltam estão assim distribuídos:<br>";
                                                                    ?>
                                                            <h6 class="font-weight-bold ml-4 mt-2">Indicadores que não atingiram o limite superior (10 pontos):</h6>
                                                                <ul class="ml-2">
                                                                    <?php if($rpc < 10){ ?>
                                                                    <li>Pré-Natal (Consultas): <?= $rpctxt2 ?> &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; n1 = (<label class="text-primary"><?= $rpctxt2 ?></label>/45)*10 &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; <label class="text-dark font-weight-bold">n1 = <?= $rpctxt ?></label> &nbsp;(faltam <label class="text-danger"><?php echo str_replace(".",",",(10 - $rpc)); ?></label> para chegar a 10 pontos).</li>
                                                                    <?php } ?>
                                                                    <?php if($rph < 10){ ?>
                                                                    <li>Pré-Natal (Exames): <?= $rphtxt2 ?> &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; n2 = (<label class="text-primary"><?= $rphtxt2 ?></label>/60)*10 &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; <label class="text-dark font-weight-bold">n2 = <?= $rphtxt ?></label> &nbsp;(faltam <label class="text-danger"><?php echo str_replace(".",",",(10 - $rph)); ?></label> para chegar a 10 pontos).</li>
                                                                    <?php } ?>
                                                                    <?php if($rcc < 10){ ?>
                                                                    <li>Cobertura Citopatológico: <?= $rcctxt2 ?> &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; n3 = (<label class="text-primary"><?= $rcctxt2 ?></label>/40)*10 &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; <label class="text-dark font-weight-bold">n3 = <?= $rcctxt ?></label> &nbsp;(faltam <label class="text-danger"><?php echo str_replace(".",",",(10 - $rcc)); ?></label> para chegar a 10 pontos).</li>
                                                                    <?php } ?>
                                                                    <?php if($rh < 10){ ?>
                                                                    <li>Hipertensão (PA Aferida): <?= $rhtxt2 ?> &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; n4 = (<label class="text-primary"><?= $rhtxt2 ?></label>/50)*10 &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; <label class="text-dark font-weight-bold">n4 = <?= $rhtxt ?></label> &nbsp;(faltam <label class="text-danger"><?php echo str_replace(".",",",(10 - $rh)); ?></label> para chegar a 10 pontos).</li>
                                                                    <?php } ?>
                                                                    <?php if($rd < 10){ ?>
                                                                    <li>Diabetes (Hemoglobina Glicada): <?= $rdtxt2 ?> &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; n5 = (<label class="text-primary"><?= $rdtxt2 ?></label>/50)*10 &nbsp;<i class='fas fa-arrow-right text-info'></i>&nbsp; <label class="text-dark font-weight-bold">n5 = <?= $rdtxt ?></label> &nbsp;(faltam <label class="text-danger"><?php echo str_replace(".",",",(10 - $rd)); ?></label> para chegar a 10 pontos).</li>
                                                                    <?php } ?>
                                                                </ul>
                                                            <?php    }
                                                                if($cpossui < 30){
                                                                    $rcpossui = round((30-$cpossui),2);
                                                                    $rcpossui = str_replace(",", "", $rcpossui);
                                                                    $rcpossui = str_replace(".", ",", $rcpossui);
                                                                    echo "<i class='fas fa-asterisk text-danger'></i>&nbsp; <label class='text-primary'>Competências profissionais:</label>&nbsp; <label class='text-dark'>$cpossuitext de 30 pontos</label>&nbsp; <i class='fas fa-arrow-right text-info'></i>&nbsp; Não realizou a autoavaliação.<br>";
                                                                }
                                                                if($anota < 10){
                                                                    $ranota = round((10-$anota),2);
                                                                    $ranota = str_replace(",", "", $ranota);
                                                                    $ranota = str_replace(".", ",", $ranota);
                                                                    if($anota > 0){
                                                                        echo "<i class='fas fa-asterisk text-danger'></i>&nbsp; <label class='text-primary'>Aperfeiçoamento profissional:</label>&nbsp; <label class='text-dark'>$anotatext de 10 pontos</label>&nbsp; <i class='fas fa-arrow-right text-info'></i>&nbsp; Os certificados de cursos realizados apresentados no período da avaliação não foram suficientes para alcançar o limite previsto no programa de avaliação.<br>";
                                                                    }else{
                                                                        echo "<i class='fas fa-asterisk text-danger'></i>&nbsp; <label class='text-primary'>Aperfeiçoamento profissional:</label>&nbsp; <label class='text-dark'>$anotatext de 10 pontos</label>&nbsp; <i class='fas fa-arrow-right text-info'></i>&nbsp; Não apresentou pontuação suficiente referente ao domínio.<br>";
                                                                    }
                                                                }
                                                                if($qnota < 10){
                                                                    $rqt = round((10 - $qnota),2);
                                                                    $rqt = str_replace(",", "", $rqt);
                                                                    $rqt = str_replace(".", ",", $rqt);
                                                                    echo "<i class='fas fa-asterisk text-danger'></i>&nbsp; <label class='text-primary'>Qualidade da tutoria:</label>&nbsp; <label class='text-dark'>$qnotatext de 10 pontos</label>&nbsp; <i class='fas fa-arrow-right text-info'></i>&nbsp; faltam <label class='text-danger'>$rqt</label> para completar o limite previsto de 10 pontos.<br>";
                                                                }
                                                            }
                                                            ?>
                                                        </div>
<!--                                                        <div class="col-sm-6">
                                                            <h6 class="font-weight-bold"><u>Cálculo do Desempenho do Domínio Qualidade Assistencial</u></h6>
                                                            <p><img src="../img/calculoQA.png" width="100%"></p>
                                                        </div>-->
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <p class="mt-3  text-secondary mb-0"><label class="font-weight-bold">* Fonte: </label> <a href="./../pdf/manual_2023.pdf" target="_blank">Manual Programa de Avaliação de Desempenho Tutor Médico 2023</a></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-outline-danger shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal">&nbsp;&nbsp; OK &nbsp;&nbsp;</button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalaqa -->
                    <?php
                    }while($rs = mysqli_fetch_array($query));
                }
            } else {
                ?>
                <div class="col-12 shadow rounded pt-2 mb-2">
                    <div class="p-3">
                        <div class="mt-3 mb-3 pl-4 pr-4">
                            <div class="row mt-5 mb-5 mr-2 ml-2 pt-5 pb-5 pl-2 pr-2">
                                <div class="col-md-12">
                                    <p>Prezado(a) Tutor(a) Médico(a),</p>
                                    <p class="text-justify text-dark font-weight-bolder">
                                        Não foi identificado registros de produção no período consultado.
                                    </p>
                                    <p class="text-justify">
                                    Gostaria de enfatizar a importância de um dos requisitos para a participação no Programa de Avaliação de Desempenho é a vinculação do(a) 
                                    médico(a) tutor(a) a
                                    uma Equipe de Saúde da Família. É fundamental que os profissionais médicos estejam devidamente registrados no CNES e vinculados a um INE, 
                                    assegurando a precisa identificação de suas atividades nas equipes. Isso não apenas garante a correta avaliação dos indicadores, 
                                    mas também assegura sua participação integral no programa.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
        </div>
        <?php include '../includes/footer.php' ?>
        <!-- Bootstrap core JavaScript-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/chart-bar-prenatal-1q.js"></script>
        <script src="../js/demo/chart-bar-prenatal-sifilis.js"></script>
        <script src="../js/demo/chart-bar-citopatologico.js"></script>
        <script src="../js/demo/chart-bar-hipertensao.js"></script>
        <script>
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
            $(function () {
               $('.dropdown-toggle').dropdown();
            }); 
            $(document).on('click', '.dropdown-toggle ', function (e) {
               e.stopPropagation();
            });
              
            $(document).ready(function (){
               $('#hassuntonovo').hide(); 
               $('#assuntonovo').hide(); 
               $('#lassuntonovo').hide(); 
               $('.divassunto1').hide(); 
               $('.divassunto2').hide(); 
               $('.divassunto3').hide(); 
               $('.divassunto4').hide(); 
               $('.divassunto5').hide(); 
//               if($('#ckassunto5').is(":checked")){
//                    $('#hassuntonovo').show(600); 
//                    $('#assuntonovo').show(600);
//                    $('#lassuntonovo').show(600);
//                    $('.divassunto5').show(600);
//               }else{
//                    $('#hassuntonovo').hide(400); 
//                    $('#assuntonovo').hide(400);
//                    $('#lassuntonovo').hide(400);
//                    $('.divassunto5').hide(400);
//               }
               $('#assuntonovo').keyup(function (){
                  let  assuntonovo = $.trim($('#assuntonovo').val()).length;
                  if(assuntonovo > 0){
                      $('#lassuntonovo').html('');
//                      $('#lassuntonovo').fadeOut();
                  }else{
                      $('#lassuntonovo').html('* Digite o assunto da contestação');
                  }
               });
            });
            function clickAssunto1(){
                if($('#ckassunto1').is(":checked")){
                    $('.divassunto1').show(600);
                    $("#contestacao1").focus();
               }else{
                    $('.divassunto1').hide(400);
               }
            }
            function clickAssunto2(){
                if($('#ckassunto2').is(":checked")){
                    $('.divassunto2').show(600);
                    $("#contestacao2").focus();
               }else{
                    $('.divassunto2').hide(400);
               }
            }
            function clickAssunto3(){
                if($('#ckassunto3').is(":checked")){
                    $('.divassunto3').show(600);
                    $("#contestacao3").focus();
               }else{
                    $('.divassunto3').hide(400);
               }
            }
            function clickAssunto4(){
                if($('#ckassunto4').is(":checked")){
                    $('.divassunto4').show(600);
                    $("#contestacao4").focus();
               }else{
                    $('.divassunto4').hide(400);
               }
            }
            function clickAssunto5(){
                if($('#ckassunto5').is(":checked")){
                    $('#hassuntonovo').show(600); 
                    $('#assuntonovo').show(600);
                    $('#lassuntonovo').show(600);
                    $('.divassunto5').show(600);
                    $("#assuntonovo").focus();
               }else{
                    $('#hassuntonovo').hide(400); 
                    $('#assuntonovo').hide(400);
                    $('#lassuntonovo').hide(400);
                    $('.divassunto5').hide(400);
               }
            }
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
                    text: 'Distribuição por domínio',
                    align: 'left'
                },
                subtitle: {
                    text: 'IGAD (percentual alcançado): <?= $mftext ?>%',
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
                        ['Qualidade assistencial: <?= $qatext ?>%', <?= $qa ?>],            
                        ['Qualidade da tutoria: <?= $qnotatext ?>%', <?= $qnota ?>],
                        ['Aperfeiçoamento profissional: <?= $anotatext ?>%', <?= $anota ?>],
                        ['Competências profissionais: <?= $cpossuitext ?>%', <?= $cpossui ?>],
                        {
                            name: 'Deixou de alcançar: <?= $faltamtext ?>%',
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
