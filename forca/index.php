<?php
session_start();
include '../conexao-agsus.php';
include '../Controller_agsus/maskCpf.php';
include '../Controller_agsus/fdatas.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
if (!isset($_SESSION['pgmsg'])) {
    $_SESSION['pgmsg'] = "1";
}
if (!isset($_SESSION['cpf'])) {
   header("Location: ../derruba_session.php"); exit();
}
$cpf = $_SESSION['cpf'];
if (!isset($_SESSION['idUser'])) {
    header("Location: ../derruba_session.php");
    exit();
}
if (!isset($_SESSION['perfil'])) {
    header("Location: ../derruba_session.php");
    exit();
}
if (!isset($_SESSION['nivel'])) {
    header("Location: ../derruba_session.php");
    exit();
}
if($_SESSION['perfil'] !== '2' && $_SESSION['perfil'] !== '3' && $_SESSION['perfil'] !== '6' && $_SESSION['perfil'] !== '7' && $_SESSION['perfil'] !== '8'){
    header("Location: ../derruba_session.php");
    exit();
}
$perfil = $_SESSION['perfil'];
$nivel = $_SESSION['nivel'];
//$perfil = '3';
//$nivel = '1';
date_default_timezone_set('America/Sao_Paulo');
//$anoAtual = date('Y');
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
                <div class="col-12 col-md-3">
                    <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-9 mt-5 ">
                    <h4 class="mb-4 font-weight-bold">Unidade da Força - Programa de Avaliação de Desempenho do Tutor Médico</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <div id="menuPrincipal" class="collapse navbar-collapse pr-2 pl-3">
                            <ul class="navbar-nav">
<!--                                <li class="nav-item">
                                    <a href="../index.php" class="nav-link">Inicio </a>
                                </li>
                                 Navbar dropdown 
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Ano </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">2024</a>
                                        <a class="dropdown-item" href="#">2023</a>
                                    </div>
                                </li>-->
<!--                                <li class="nav-item">
                                        <a class="nav-link" href="">|</a>
                                    </li>-->
                                    <!-- Navbar dropdown -->
                                    <li class="nav-item dropdown">
                                        <!--<a class="nav-link dropdown-toggle" href="../relatorios/relatorio_geral_igad.php">Relatório Geral IGAD - 1º ciclo de 2023</a>-->
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Relatórios</a>
                                        <div class="dropdown-menu">
                                            <?php if($perfil === '3' && $nivel === '1'){ ?>
                                            <a class="dropdown-item" href="../relatorios/relatorio_geral_igad.php">Relatório Geral IGAD - 1º ciclo de 2023</a>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="">|</a>
                                    </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../derruba_session.php"><i class="fas fa-sign-out-alt pt-1"></i></a>
                                </li>
                                <li class="nav-item">
                                    <div id="loading">
                                        &nbsp;<img class="float-right" src="../img_agsus/carregando.gif" width="40" height="40" />
                                    </div>
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
                                    <legend class="w-auto pr-2 pl-2"><h5>Listagem dos tutores</h5></legend>
                                <div class="mb-3 table-responsive text-nowrap table-overflow2">
                                    <table id="dtBasicExample" class="table table-hover table-bordered table-striped rounded">
                                        <thead class="bg-gradient-dark text-white">
                                            <tr class="bg-gradient-dark text-light font-weight-bold">
                                                <?php if($perfil === '3' && $nivel === '1'){ ?>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="width: 5%;position: sticky; top: 0px;"><i class="fas fa-user-edit"></i></td>
                                                <?php } ?>
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
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">INCENTIVO</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Qualidade Assistencial">QA</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Qualidade Tutoria">QT</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Competências Profissionais">CP</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;" title="Aperfeiçoamento Profissional">AP</td>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="width: 10%;position: sticky; top: 0px;"><i class="fas fa-calendar-alt"></i></td>
                                                <?php if($perfil === '3' && $nivel === '1'){ ?>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="width: 10%;position: sticky; top: 0px;"><i class="far fa-eye"></i></td>
                                                <?php } ?>
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
                                                <?php if($perfil === '3' && $nivel === '1'){ ?>
                                                <td>
                                                    <?php
                                                    $sqlc = "select * from contestacao inner join contestacao_assunto on idcontestacao = fkcontestacao "
                                                            . "inner join assunto on fkassunto = idassunto where fkdemonstrativo = '$iddemonstrativo' order by idassunto desc";
                                                    $queryc = mysqli_query($conn, $sqlc);
                                                    $nrrsc = mysqli_num_rows($queryc);
                                                    $rsc = mysqli_fetch_array($queryc);
                                                    $contestacao = array();
                                                    $assunto = array();
                                                    $a=0;
                                                    if($nrrsc > 0){ 
                                                        do{
                                                            if ($rsc['fkassunto'] === '1') {
                                                                $assun = trim($rsc['assuntonovo']);
                                                                $assun = str_replace("'", "", $assun);
                                                                $assun = str_replace("\"", "", $assun);
                                                                $assunto[$a] = $assun;
                                                            } else {
                                                                $assun = trim($rsc['titulo']);
                                                                $assun = str_replace("'", "", $assun);
                                                                $assun = str_replace("\"", "", $assun);
                                                                $assunto[$a] = $assun;
                                                            }
                                                            $idcontestacao = trim($rsc['idcontestacao']);
                                                            $contes = trim($rsc['contestacao']);
                                                            $contes = str_replace("'", "", $contes);
                                                            $contes = str_replace("\"", "", $contes);
                                                            $contestacao[$a] = $contes;
                                                            $datahora = $rsc['datahora'];
                                                            $dataresposta = $rsc['dataresposta'];
                                                            $flagresposta = $rsc['flagresposta'];
                                                            $resposta = trim($rsc['resposta']);
                                                            $resposta = str_replace("'", "", $resposta);
                                                            $resposta = str_replace("\"", "", $resposta);
                                                            $a++;
                                                        }while ($rsc = mysqli_fetch_array($queryc));
                                                          if($flagresposta==='0'){
                                                    ?>
                                                        <button type="button" data-toggle="modal" data-target=".modalContestacao<?= $iddemonstrativo ?>" class="btn btn-light shadow-sm "><i class="fas fa-user-edit text-info"></i></button>
                                                        <!-- modal modalContestacao -->
                                                        <div class="modal fad modalContestacao<?= $iddemonstrativo ?> mt-2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <form method="post" action="../Controller_agsus/respcontestacao.php">
                                                            <div class="modal-dialog mw-100 w-75">
                                                                <div class="modal-content">
                                                                    <input type="hidden" name="iddemonstrativo" value="<?= $iddemonstrativo ?>">
                                                                    <input type="hidden" name="cpf" value="<?= $cpftratado ?>">
                                                                    <input type="hidden" name="ibge" value="<?= $ibge ?>">
                                                                    <input type="hidden" name="cnes" value="<?= $cnes ?>">
                                                                    <input type="hidden" name="ine" value="<?= $ine ?>">
                                                                    <div class="modal-header bg-light">
                                                                        <div class="col-10 mt-1">
                                                                            <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-arrow-circle-right"></i> Contestação registrada</h5>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                                                <span aria-hidden="true">&times;</span> </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-body pr-3 pl-3">
                                                                        <div class="row mt-2">
                                                                            <div class="col-sm-6">
                                                                                <label class="font-weight-bold">Médico Tutor: </label>&nbsp; <label><?= $nome ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">CPF: </label>&nbsp; <label><?= $cpf ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="font-weight-bold">Município/UF: </label>&nbsp; <label><?= $municipio ?>-<?= $uf ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">CNES: </label>&nbsp; <label><?= $cnes ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">INE: </label>&nbsp; <label><?= $ine ?></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="font-weight-bold">IBGE: </label>&nbsp; <label><?= $ibge ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">Tipologia: </label>&nbsp; <label><?= $cnes ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">IVS: </label>&nbsp; <label><?= $ivs ?></label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="idcontestacao" value="<?= $idcontestacao ?>">
                                                                        <div class="row mt-1">
                                                                            <div class="col-sm-12">
                                                                                <h5 class="text-dark font-weight-bold">Contestação registrada: </h5>
                                                                            </div>
                                                                            <?php
                                                                                if($nrrsc > 0){
                                                                                    for($i=0; $i < count($assunto); $i++){
                                                                                        $assu = $assunto[$i];
                                                                                        $conte = $contestacao[$i];
                                                                                ?>
                                                                            <div class="col-sm-12">
                                                                                <label class='text-dark font-weight-bold'><?= $assu ?></label><br>
                                                                                <textarea class="form-control text-justify bg-white" rows="4" disabled="true" style="resize: none;"><?= $conte ?></textarea><br>
                                                                            </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="row mt-1">
                                                                            <div class="col-sm-12">
                                                                                <h6 class="text-dark font-weight-bold">Resposta da contestação</h6>
                                                                                <textarea name="respcontestacao" class="" rows="4" style="width: 100%; resize: none;"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" name="enviarResposta" value="1" class="btn btn-success shadow-sm rounded ml-5 mr-5 p-2">&nbsp;&nbsp; ENVIAR &nbsp;&nbsp;</button>
                                                                        <button type="reset" class="btn btn-light shadow-sm rounded ml-5 mr-5 p-2" data-dismiss="modal"> CANCELAR </button>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>
                                                              <?php }}else{ ?>
                                                        <button type="button" data-toggle="modal" data-target=".modalResposta<?= $iddemonstrativo ?>" class="btn btn-light shadow-sm "><i class="fas fa-check text-success"></i></button>
                                                        <!-- modal modalResposta -->
                                                        <div class="modal fad modalResposta<?= $iddemonstrativo ?> mt-2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog mw-100 w-75">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-light">
                                                                        <div class="col-10 mt-1">
                                                                            <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-arrow-circle-right"></i> &nbsp;Contestação</h5>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                                                <span aria-hidden="true">&times;</span> </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-body pr-3 pl-3">
                                                                        <div class="row mt-2">
                                                                            <div class="col-sm-6">
                                                                                <label class="font-weight-bold">Médico Tutor: </label>&nbsp; <label><?= $nome ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">CPF: </label>&nbsp; <label><?= $cpf ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="font-weight-bold">Município/UF: </label>&nbsp; <label><?= $municipio ?>-<?= $uf ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">CNES: </label>&nbsp; <label><?= $cnes ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">INE: </label>&nbsp; <label><?= $ine ?></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="font-weight-bold">IBGE: </label>&nbsp; <label><?= $ibge ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">Tipologia: </label>&nbsp; <label><?= $cnes ?></label>
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <label class="font-weight-bold">IVS: </label>&nbsp; <label><?= $ivs ?></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-1">
                                                                            <div class="col-sm-12">
                                                                                <h6 class="text-info font-weight-bold">Contestação registrada: </h6>
                                                                                <input type="hidden" name="idcontestacao" value="<?= $idcontestacao ?>">
                                                                                <div class='row'>
                                                                                    <?php
                                                                                        if($nrrsc > 0){
                                                                                            for($i=0; $i < count($assunto); $i++){
                                                                                                $assu = $assunto[$i];
                                                                                                $conte = $contestacao[$i];
                                                                                        ?>
                                                                                    <div class="col-sm-12">
                                                                                        <label class='text-dark font-weight-bold'><?= $assu ?></label><br>
                                                                                        <textarea class="form-control text-justify bg-white" rows="4" disabled="true" style="resize: none;"><?= $conte ?></textarea><br>
                                                                                    </div>
                                                                                    <?php }} ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-1 mb-2">
                                                                            <div class="col-sm-12">
                                                                                <h6 class="text-info font-weight-bold">Resposta da contestação</h6>
                                                                                <textarea class="form-control text-justify bg-white" rows="4" disabled="true" style="resize: none;"><?= $resposta ?></textarea>
                                                                                <?php
                                                                                    echo "<br>Data da resposta: &nbsp;".vemdata($dataresposta);
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="reset" class="btn btn-outline-danger shadow-sm rounded ml-5 mr-5 p-2" data-dismiss="modal"> &nbsp;FECHAR&nbsp; </button>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        <?php } ?>
                                                   <?php }?>
                                                </td>
                                                <?php } ?>
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
                                                <?php if($mf >= 70){ ?>
                                                <td>R$ <?php echo number_format($valor, 2, ',', '.'); ?></td>
                                                <?php }else{ ?>
                                                <td class="text-danger">R$ <?php echo number_format(round((($valor * $mf)/100),2), 2, ',', '.'); ?></td>
                                                <?php } ?>
                                                <td><?= $qatext ?></td>
                                                <td><?= $qnotatext ?></td>
                                                <td><?= $cpossuitext ?></td>
                                                <td><?= $anotatext ?></td>
                                                <td><?= $datacadastro ?></td>
                                                <?php if($perfil === '3' && $nivel === '1'){ ?>
                                                <td><a href="demonstrativo.php?c=<?= $cpftratado ?>&a=<?= $ano ?>&cl=<?= $ciclo ?>&p=<?= $idperiodo ?>" class="btn btn-light shadow-sm" title="Demonstrativo"><i class="far fa-eye"></i></a></td>
                                                <?php } ?>
                                            </tr>
                                            <?php }while($rs = mysqli_fetch_array($query));
                                            }}?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="">Total de Tutores: </label>
                                    <label class="text-info"><?= $contt ?></label>
                                </div>
                                <?php
                                //conversão decimal com vírgula - porcentagens acima e abaixo de 70
                                $mfat = round((($conta/$contt) * 100),2);
                                $mfat = str_replace(".", ",", $mfat);
                                $mfbt = round((($contb/$contt) * 100),2);
                                $mfbt = str_replace(".", ",", $mfbt);
                                ?>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                            <!-- modal modalar -->
<!--                            <div class="modal fad modalar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <h6 class="text-secondary">A avaliação de resultados correspondente até 70% dp resultado final.</h6>
                                                    <h6 class="text-secondary">Resultado:  &nbsp;<label class="text-danger"><?= $artext ?>%</label>&nbsp; do resultado final.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!-- fim do modal modalar -->
                            <!-- modal modalac -->
<!--                            <div class="modal fad modalac" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!-- fim do modal modalac -->
                            <!-- modal modalaqa -->
<!--                            <div class="modal fad modalaqa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
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
                                        <div class="modal-body p-4">
                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <h6 class="text-secondary">A qualidade assistencial corresponde até 50% do resultado final.</h6>
                                                    <h6 class="text-secondary">Resultado:  &nbsp;<label class="text-danger"><?= $qatext ?>%</label>&nbsp; do resultado final.</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!-- fim do modal modalaqa -->
                            <!-- modal modalqt -->
<!--                            <div class="modal fad modalqt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!-- fim do modal modalqt -->
                            <!-- modal modalap -->
<!--                            <div class="modal fad modalap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!-- fim do modal modalap -->
                            <!-- modal modalcp -->
<!--                            <div class="modal fad modalcp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <!-- fim do modal modalcp -->
                    <?php
//                    }while($rs = mysqli_fetch_array($query));
//                }
//            } else {
                ?>
<!--                <div class="col-12 shadow rounded pt-2 mb-2">
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
                </div>-->
                
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
