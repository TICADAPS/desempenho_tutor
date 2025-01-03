<?php
session_start();
include './conexao-agsus.php';
//if (!isset($_SESSION['cpf'])) {
//   header("Location: derruba_session.php"); exit();
//}
//$cpf = $_SESSION['cpf'];
//$cpf = '001.417.733-16';
date_default_timezone_set('America/Sao_Paulo');
$anoAtual = date('Y');
//$cpftratado = str_replace("-", "", $cpf);
//$cpftratado = str_replace(".", "", $cpftratado);
//$cpftratado = str_replace(".", "", $cpftratado);
//$sql = "select * from medico m inner join desempenho d on m.cpf = d.cpf and m.ibge = d.ibge"
//        . " inner join periodo p on p.idperiodo = d.idperiodo where m.cpf = '$cpftratado' and ano = '$anoAtual';";
//$query = mysqli_query($conn, $sql);
//$nrrs = mysqli_num_rows($query);
//$rs = mysqli_fetch_array($query);
//$rscpf = false;
//if ($nrrs > 0) {
//    $rscpf = true;
//}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>AGSUS - Avaliação de Desempenho</title>
        
        <!-- Custom fonts for this template-->
        <link rel="shortcut icon" href="./img_agsus/iconAdaps.png"/>
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-2">
                    <img src="./img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-10 mt-5">
                    <h4 class="mb-4 text-center">Programa de Avaliação de Desempenho Tutor Médico</h4>
                    <h4 class="mb-4 text-center">Média dos Indicadores por Região - Ano <?= $anoAtual ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <div id="menuPrincipal" class="collapse navbar-collapse">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a href="./index.php" class="nav-link">Inicio </a>
                                </li>
                                <!-- Navbar dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Ano </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="./ano.php?c=<?= $cpftratado ?>&a=2023">2023</a>
                                    </div>
                                </li>
<!--                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Quadrimestres</a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="./ano.php?c=<?= $cpftratado ?>&q=23">1º Quadrimestre</a>
                                        <a class="dropdown-item" href="./ano.php?c=<?= $cpftratado ?>&q=24">2º Quadrimestre</a>
                                        <a class="dropdown-item" href="./ano.php?c=<?= $cpftratado ?>&q=25">3º Quadrimestre</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">|</a>
                                </li>-->
                                <li class="nav-item">
                                    <a class="nav-link" href="https://appsadapsbrasil.com/sistema-adaps/painelMedico.php"><i class="fas fa-sign-out-alt pt-1"></i></a>
                                </li>
                                <li class="nav-item">
                                    <div id="loading">
                                        &nbsp;<img class="float-right" src="img_agsus/carregando.gif" width="40" height="40" />
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav> 
                </div>
            </div>
            <?php 
            //média das UF da região Norte
            $mediaRondoniaPreCons = $mediaRondoniaPreSif = $mediaRondoniaCitop = $mediaRondoniaHiper = $mediaRondoniaDiab = $somaRondoniaPreCons = $somaRondoniaPreSif = $somaRondoniaCitop = $somaRondoniaHiper = $somaRondoniaDiab = 0;
            $mediaAcrePreCons = $mediaAcrePreSif = $mediaAcreCitop = $mediaAcreHiper = $mediaAcreDiab =  $somaAcrePreCons = $somaAcrePreSif = $somaAcreCitop = $somaAcreHiper = $somaAcreDiab = 0;
            $mediaAmazonasPreCons = $mediaAmazonasPreSif = $mediaAmazonasCitop = $mediaAmazonasHiper = $mediaAmazonasDiab = $somaAmazonasPreCons = $somaAmazonasPreSif = $somaAmazonasCitop = $somaAmazonasHiper = $somaAmazonasDiab = 0;
            $mediaRoraimaPreCons = $mediaRoraimaPreSif = $mediaRoraimaCitop = $mediaRoraimaHiper = $mediaRoraimaDiab = $somaRoraimaPreCons = $somaRoraimaPreSif = $somaRoraimaCitop = $somaRoraimaHiper = $somaRoraimaDiab = 0;
            $mediaParaPreCons = $mediaParaPreSif = $mediaParaCitop = $mediaParaHiper = $mediaParaDiab = $somaParaPreCons = $somaParaPreSif = $somaParaCitop = $somaParaHiper = $somaParaDiab = 0;
            $mediaAmapaPreCons = $mediaAmapaPreSif = $mediaAmapaCitop = $mediaAmapaHiper = $mediaAmapaDiab = $somaAmapaPreCons = $somaAmapaPreSif = $somaAmapaCitop = $somaAmapaHiper = $somaAmapaDiab = 0;
            $mediaTocantinsPreCons = $mediaTocantinsPreSif = $mediaTocantinsCitop = $mediaTocantinsHiper = $mediaTocantinsDiab = $somaTocantinsPreCons = $somaTocantinsPreSif = $somaTocantinsCitop = $somaTocantinsHiper = $somaTocantinsDiab = 0;
            
            //Região Rondônia
            $sqlRondonia = "SELECT * FROM `desempenho` where ibge like '11%' and ano = '$anoAtual'";
            $queryRondonia = mysqli_query($conn, $sqlRondonia);
            $rowsRondonia = mysqli_num_rows($queryRondonia);
            $rsRondonia = mysqli_fetch_array($queryRondonia);
            if($rsRondonia){
                do{
                    $somaRondoniaPreCons += $rsRondonia['prenatal_consultas'];
                    $somaRondoniaPreSif += $rsRondonia['prenatal_sifilis_hiv'];
                    $somaRondoniaCitop += $rsRondonia['cobertura_citopatologico'];
                    $somaRondoniaHiper += $rsRondonia['hipertensao'];
                    $somaRondoniaDiab += $rsRondonia['diabetes'];
                }while($rsRondonia = mysqli_fetch_array($queryRondonia));
                $mediaRondoniaPreCons = round(($somaRondoniaPreCons/$rowsRondonia),2);
                $mediaRondoniaPreSif = round(($somaRondoniaPreSif/$rowsRondonia),2);
                $mediaRondoniaCitop = round(($somaRondoniaCitop/$rowsRondonia),2);
                $mediaRondoniaHiper = round(($somaRondoniaHiper/$rowsRondonia),2);
                $mediaRondoniaDiab = round(($somaRondoniaDiab/$rowsRondonia),2);
            }
            
            //Acre
            $sqlAcre = "SELECT * FROM `desempenho` where ibge like '12%' and ano = '$anoAtual'";
            $queryAcre = mysqli_query($conn, $sqlAcre);
            $rowsAcre = mysqli_num_rows($queryAcre);
            $rsAcre = mysqli_fetch_array($queryAcre);
            if($rsAcre){
                do{
                    $somaAcrePreCons += $rsAcre['prenatal_consultas'];
                    $somaAcrePreSif += $rsAcre['prenatal_sifilis_hiv'];
                    $somaAcreCitop += $rsAcre['cobertura_citopatologico'];
                    $somaAcreHiper += $rsAcre['hipertensao'];
                    $somaAcreDiab += $rsAcre['diabetes'];
                }while($rsAcre = mysqli_fetch_array($queryAcre));
                $mediaAcrePreCons = round(($somaAcrePreCons/$rowsAcre),2);
                $mediaAcrePreSif = round(($somaAcrePreSif/$rowsAcre),2);
                $mediaAcreCitop = round(($somaAcreCitop/$rowsAcre),2);
                $mediaAcreHiper = round(($somaAcreHiper/$rowsAcre),2);
                $mediaAcreDiab = round(($somaAcreDiab/$rowsAcre),2);
            }
            
            //Amazonas
            $sqlAmazonas = "SELECT * FROM `desempenho` where ibge like '13%' and ano = '$anoAtual'";
            $queryAmazonas = mysqli_query($conn, $sqlAmazonas);
            $rowsAmazonas = mysqli_num_rows($queryAmazonas);
            $rsAmazonas = mysqli_fetch_array($queryAmazonas);
            if($rsAmazonas){
                do{
                    $somaAmazonasPreCons += $rsAmazonas['prenatal_consultas'];
                    $somaAmazonasPreSif += $rsAmazonas['prenatal_sifilis_hiv'];
                    $somaAmazonasCitop += $rsAmazonas['cobertura_citopatologico'];
                    $somaAmazonasHiper += $rsAmazonas['hipertensao'];
                    $somaAmazonasDiab += $rsAmazonas['diabetes'];
                }while($rsAmazonas = mysqli_fetch_array($queryAmazonas));
                $mediaAmazonasPreCons = round(($somaAmazonasPreCons/$rowsAmazonas),2);
                $mediaAmazonasPreSif = round(($somaAmazonasPreSif/$rowsAmazonas),2);
                $mediaAmazonasCitop = round(($somaAmazonasCitop/$rowsAmazonas),2);
                $mediaAmazonasHiper = round(($somaAmazonasHiper/$rowsAmazonas),2);
                $mediaAmazonasDiab = round(($somaAmazonasDiab/$rowsAmazonas),2);
            }
            
            //Roraima
            $sqlRoraima = "SELECT * FROM `desempenho` where ibge like '14%' and ano = '$anoAtual'";
            $queryRoraima = mysqli_query($conn, $sqlRoraima);
            $rowsRoraima = mysqli_num_rows($queryRoraima);
            $rsRoraima = mysqli_fetch_array($queryRoraima);
            if($rsRoraima){
                do{
                    $somaRoraimaPreCons += $rsRoraima['prenatal_consultas'];
                    $somaRoraimaPreSif += $rsRoraima['prenatal_sifilis_hiv'];
                    $somaRoraimaCitop += $rsRoraima['cobertura_citopatologico'];
                    $somaRoraimaHiper += $rsRoraima['hipertensao'];
                    $somaRoraimaDiab += $rsRoraima['diabetes'];
                }while($rsRoraima = mysqli_fetch_array($queryRoraima));
                $mediaRoraimaPreCons = round(($somaRoraimaPreCons/$rowsRoraima),2);
                $mediaRoraimaPreSif = round(($somaRoraimaPreSif/$rowsRoraima),2);
                $mediaRoraimaCitop = round(($somaRoraimaCitop/$rowsRoraima),2);
                $mediaRoraimaHiper = round(($somaRoraimaHiper/$rowsRoraima),2);
                $mediaRoraimaDiab = round(($somaRoraimaDiab/$rowsRoraima),2);
            }
            
            //Região Sul
            $sqlPara = "SELECT * FROM `desempenho` where ibge like '15%' and ano = '$anoAtual'";
            $queryPara = mysqli_query($conn, $sqlPara);
            $rowsPara = mysqli_num_rows($queryPara);
            $rsPara = mysqli_fetch_array($queryPara);
            if($rsPara){
                do{
                    $somaParaPreCons += $rsPara['prenatal_consultas'];
                    $somaParaPreSif += $rsPara['prenatal_sifilis_hiv'];
                    $somaParaCitop += $rsPara['cobertura_citopatologico'];
                    $somaParaHiper += $rsPara['hipertensao'];
                    $somaParaDiab += $rsPara['diabetes'];
                }while($rsPara = mysqli_fetch_array($queryPara));
                $mediaParaPreCons = round(($somaParaPreCons/$rowsPara),2);
                $mediaParaPreSif = round(($somaParaPreSif/$rowsPara),2);
                $mediaParaCitop = round(($somaParaCitop/$rowsPara),2);
                $mediaParaHiper = round(($somaParaHiper/$rowsPara),2);
                $mediaParaDiab = round(($somaParaDiab/$rowsPara),2);
            }
            
            //Região Centro-Oeste
            $sqlAmapa = "SELECT * FROM `desempenho` where ibge like '16%' and ano = '$anoAtual'";
            $queryAmapa = mysqli_query($conn, $sqlAmapa);
            $rowsAmapa = mysqli_num_rows($queryAmapa);
            $rsAmapa = mysqli_fetch_array($queryAmapa);
            if($rsAmapa){
                do{
                    $somaAmapaPreCons += $rsAmapa['prenatal_consultas'];
                    $somaAmapaPreSif += $rsAmapa['prenatal_sifilis_hiv'];
                    $somaAmapaCitop += $rsAmapa['cobertura_citopatologico'];
                    $somaAmapaHiper += $rsAmapa['hipertensao'];
                    $somaAmapaDiab += $rsAmapa['diabetes'];
                }while($rsAmapa = mysqli_fetch_array($queryAmapa));
                $mediaAmapaPreCons = round(($somaAmapaPreCons/$rowsAmapa),2);
                $mediaAmapaPreSif = round(($somaAmapaPreSif/$rowsAmapa),2);
                $mediaAmapaCitop = round(($somaAmapaCitop/$rowsAmapa),2);
                $mediaAmapaHiper = round(($somaAmapaHiper/$rowsAmapa),2);
                $mediaAmapaDiab = round(($somaAmapaDiab/$rowsAmapa),2);
            }
            
            //Região Centro-Oeste
            $sqlTocantins = "SELECT * FROM `desempenho` where ibge like '17%' and ano = '$anoAtual'";
            $queryTocantins = mysqli_query($conn, $sqlTocantins);
            $rowsTocantins = mysqli_num_rows($queryTocantins);
            $rsTocantins = mysqli_fetch_array($queryTocantins);
            if($rsTocantins){
                do{
                    $somaTocantinsPreCons += $rsTocantins['prenatal_consultas'];
                    $somaTocantinsPreSif += $rsTocantins['prenatal_sifilis_hiv'];
                    $somaTocantinsCitop += $rsTocantins['cobertura_citopatologico'];
                    $somaTocantinsHiper += $rsTocantins['hipertensao'];
                    $somaTocantinsDiab += $rsTocantins['diabetes'];
                }while($rsTocantins = mysqli_fetch_array($queryTocantins));
                $mediaTocantinsPreCons = round(($somaTocantinsPreCons/$rowsTocantins),2);
                $mediaTocantinsPreSif = round(($somaTocantinsPreSif/$rowsTocantins),2);
                $mediaTocantinsCitop = round(($somaTocantinsCitop/$rowsTocantins),2);
                $mediaTocantinsHiper = round(($somaTocantinsHiper/$rowsTocantins),2);
                $mediaTocantinsDiab = round(($somaTocantinsDiab/$rowsTocantins),2);
            }
            ?>
            <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3 mb-2">
                <div class="row p-3">
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold mb-3">Média dos Indicadores por Região</h6>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-3 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Norte </h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal  (6 consultas): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRondoniaPreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal (Sífilis e HIV): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRondoniaPreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Cobertura Citopatológico: <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRondoniaCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Hipertensão (PA Aferida): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRondoniaHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Diabetes (Hemoglobina Glicada): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRondoniaDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-3 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Nordeste </h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal  (6 consultas): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAcrePreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal (Sífilis e HIV): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAcrePreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Cobertura Citopatológico: <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAcreCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Hipertensão (PA Aferida): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAcreHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Diabetes (Hemoglobina Glicada): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAcreDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-3 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Centro-Oeste </h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal  (6 consultas): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAmazonasPreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal (Sífilis e HIV): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAmazonasPreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Cobertura Citopatológico: <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAmazonasCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Hipertensão (PA Aferida): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAmazonasHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Diabetes (Hemoglobina Glicada): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaAmazonasDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-3 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Sudeste </h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal  (6 consultas): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRoraimaPreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal (Sífilis e HIV): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRoraimaPreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Cobertura Citopatológico: <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRoraimaCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Hipertensão (PA Aferida): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRoraimaHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Diabetes (Hemoglobina Glicada): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaRoraimaDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-3 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Sul </h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal  (6 consultas): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaParaPreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Pré-Natal (Sífilis e HIV): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaParaPreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Cobertura Citopatológico: <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaParaCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Hipertensão (PA Aferida): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaParaHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="small">Diabetes (Hemoglobina Glicada): <label class="text-primary font-weight-bold"><?= str_replace(".", ",", $mediaParaDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3 mb-2">
                <div class="row p-3">
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold mb-3">Média dos Indicadores por Região</h6>
                            </div>
                            <div class="col-md-4">
                                <!-- Bar Chart -->
                                <div class="card shadow mb-4 divexp1r">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pré-Natal (6 consultas)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="regioesPrenatal"></canvas>
                                        </div>
                                        <div class="row mt-3 pr-2 pl-2">
                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify">
                                                            Proporção de gestantes com pelo menos 6 (seis) consultas pré-natal realizadas,
                                                            sendo a 1ª (primeira) até a 12ª (décima segunda) semana de gestação.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            META: 45%
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">< 18%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 18% < 31%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 31% < 45%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 45%</label>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Bar Chart -->
                                <div class="card shadow mb-4 divexp2r">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pré-Natal (Sífilis e HIV)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="regioesSifilis"></canvas>
                                        </div>
                                        <div class="row mt-3 pr-2 pl-2">
                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify">
                                                            Proporção de gestantes com realização de exames para sífilis e HIV.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            META: 60%
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">< 24%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 24% < 42%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 42% < 60%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 60%</label>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Bar Chart -->
                                <div class="card shadow mb-4 divexp3r">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Cobertura Citopatológico</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="regioesCitopatologico"></canvas>
                                        </div>
                                        <div class="row mt-3 pr-2 pl-2">
                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify">
                                                            Proporção de mulheres com coleta de citopatológico na APS.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            META: 40%
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">< 16%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 16% < 28%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 28% < 40%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 40%</label>
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
                        <div class="row mt-3 pr-2 pl-2">
                            <div class="col-md-6">
                                <!-- Bar Chart -->
                                <div class="card shadow mb-4 divexp4r">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Hipertensão (PA Aferida)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="regioesHipertensao"></canvas>
                                        </div>
                                        <div class="row mt-3 pr-2 pl-2">
                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify">
                                                            Proporção de pessoas com hipertensão, com consulta e pressão arterial aferida no semestre.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            META: 50%
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">< 20%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 20% < 35%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 35% < 50%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 50%</label>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Bar Chart -->
                                <div class="card shadow mb-4 divexp5r">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Diabetes (Hemoglobina Glicada)</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="regioesDiabetes"></canvas>
                                        </div>
                                        <div class="row mt-3 pr-2 pl-2">
                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify">
                                                            Proporção de pessoas com diabetes, com consulta e hemoglobina glicada solicitada no semestre.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            META: 50%
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="small text-justify font-weight-bold text-primary">
                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">< 20%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 20% < 35%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 35% < 50%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="small text-justify">>= 50%</label>
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
        </div>
        <?php include './footer.php' ?>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
<!--        <script src="js/demo/chart-bar-prenatal-1q.js"></script>
        <script src="js/demo/chart-bar-prenatal-sifilis.js"></script>
        <script src="js/demo/chart-bar-citopatologico.js"></script>
        <script src="js/demo/chart-bar-hipertensao.js"></script>
        <script src="js/demo/chart-bar-diabetes.js"></script>-->
        <script>
            $(".btn_sub").click(function () {
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
            //Apresentação dos 
            $(document).ready(function () {
                $('.divexp1').show();
                $('.divexp2').hide();
                $('.divexp3').hide();
                $('.divexp4').hide();
                $('.divexp5').hide();
            });
            
            $(document).ready(function () {
                $('.divexp1r').mouseover(function(){
                    $('.divexp1').show();
                    $('.divexp2').hide();
                    $('.divexp3').hide();
                    $('.divexp4').hide();
                    $('.divexp5').hide();
                });
                $('.divexp2r').mouseover(function(){
                    $('.divexp1').hide();
                    $('.divexp2').show();
                    $('.divexp3').hide();
                    $('.divexp4').hide();
                    $('.divexp5').hide();
                });
                $('.divexp3r').mouseover(function(){
                    $('.divexp1').hide();
                    $('.divexp2').hide();
                    $('.divexp3').show();
                    $('.divexp4').hide();
                    $('.divexp5').hide();
                });
                $('.divexp4r').mouseover(function(){
                    $('.divexp1').hide();
                    $('.divexp2').hide();
                    $('.divexp3').hide();
                    $('.divexp4').show();
                    $('.divexp5').hide();
                });
                $('.divexp5r').mouseover(function(){
                    $('.divexp1').hide();
                    $('.divexp2').hide();
                    $('.divexp3').hide();
                    $('.divexp4').hide();
                    $('.divexp5').show();
                });
            });
        </script>
        <script>
            //Gráficos + de 1 quadrimestre - formatação
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            function number_format(number, decimals, dec_point, thousands_sep) {
              // *     example: number_format(1234.56, 2, ',', ' ');
              // *     return: '1 234,56'
              number = (number + '').replace(',', '').replace(' ', '');
              var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                  var k = Math.pow(10, prec);
                  return '' + Math.round(n * k) / k;
                };
              // Fix for IE parseFloat(0.55).toFixed(0) = 0;
              s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
              if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
              }
              if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
              }
              return s.join(dec);
            }
            
            // regioesPrenatal
            var ctx = document.getElementById("regioesPrenatal");
            var regioesPrenatal = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["Rondônia", "Acre", "Amazonas", "Roraima", "Pará", "Amapá", "Tocantins"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaRondoniaPreCons < 18) { echo "#d10e0e"; }elseif($mediaRondoniaPreCons < 31){ echo "#e6b20b"; }elseif($mediaRondoniaPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaAcrePreCons < 18) { echo "#d10e0e"; }elseif($mediaAcrePreCons < 31){ echo "#e6b20b"; }elseif($mediaAcrePreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmazonasPreCons < 18) { echo "#d10e0e"; }elseif($mediaAmazonasPreCons < 31){ echo "#e6b20b"; }elseif($mediaAmazonasPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaRoraimaPreCons < 18) { echo "#d10e0e"; }elseif($mediaRoraimaPreCons < 31){ echo "#e6b20b"; }elseif($mediaRoraimaPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaParaPreCons < 18) { echo "#d10e0e"; }elseif($mediaParaPreCons < 31){ echo "#e6b20b"; }elseif($mediaParaPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmapaPreCons < 18) { echo "#d10e0e"; }elseif($mediaAmapaPreCons < 31){ echo "#e6b20b"; }elseif($mediaAmapaPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaTocantinsPreCons < 18) { echo "#d10e0e"; }elseif($mediaTocantinsPreCons < 31){ echo "#e6b20b"; }elseif($mediaTocantinsPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaRondoniaPreCons < 18) { echo "#ba0a0a"; }elseif($mediaRondoniaPreCons < 31){ echo "#d2a208"; }elseif($mediaRondoniaPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaAcrePreCons < 18) { echo "#ba0a0a"; }elseif($mediaAcrePreCons < 31){ echo "#d2a208"; }elseif($mediaAcrePreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmazonasPreCons < 18) { echo "#ba0a0a"; }elseif($mediaAmazonasPreCons < 31){ echo "#d2a208"; }elseif($mediaAmazonasPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaRoraimaPreCons < 18) { echo "#ba0a0a"; }elseif($mediaRoraimaPreCons < 31){ echo "#d2a208"; }elseif($mediaRoraimaPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaParaPreCons < 18) { echo "#ba0a0a"; }elseif($mediaParaPreCons < 31){ echo "#d2a208"; }elseif($mediaParaPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmapaPreCons < 18) { echo "#ba0a0a"; }elseif($mediaAmapaPreCons < 31){ echo "#d2a208"; }elseif($mediaAmapaPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaTocantinsPreCons < 18) { echo "#ba0a0a"; }elseif($mediaTocantinsPreCons < 31){ echo "#d2a208"; }elseif($mediaTocantinsPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaRondoniaPreCons; ?>,<?php echo $mediaAcrePreCons; ?>,<?php echo $mediaAmazonasPreCons; ?>,<?php echo $mediaRoraimaPreCons; ?>,<?php echo $mediaParaPreCons; ?>,<?php echo $mediaAmapaPreCons; ?>,<?php echo $mediaTocantinsPreCons; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // regioesSifilis
            var ctx = document.getElementById("regioesSifilis");
            var regioesSifilis = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["Rondônia", "Acre", "Amazonas", "Roraima", "Pará", "Amapá", "Tocantins"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaRondoniaPreSif < 24) { echo "#d10e0e"; }elseif($mediaRondoniaPreSif < 42){ echo "#e6b20b"; }elseif($mediaRondoniaPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaAcrePreSif < 24) { echo "#d10e0e"; }elseif($mediaAcrePreSif < 42){ echo "#e6b20b"; }elseif($mediaAcrePreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmazonasPreSif < 24) { echo "#d10e0e"; }elseif($mediaAmazonasPreSif < 42){ echo "#e6b20b"; }elseif($mediaAmazonasPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaRoraimaPreSif < 24) { echo "#d10e0e"; }elseif($mediaRoraimaPreSif < 42){ echo "#e6b20b"; }elseif($mediaRoraimaPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaParaPreSif < 24) { echo "#d10e0e"; }elseif($mediaParaPreSif < 42){ echo "#e6b20b"; }elseif($mediaParaPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmapaPreSif < 24) { echo "#d10e0e"; }elseif($mediaAmapaPreSif < 42){ echo "#e6b20b"; }elseif($mediaAmapaPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaTocantinsPreSif < 24) { echo "#d10e0e"; }elseif($mediaTocantinsPreSif < 42){ echo "#e6b20b"; }elseif($mediaTocantinsPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaRondoniaPreSif < 24) { echo "#ba0a0a"; }elseif($mediaRondoniaPreSif < 42){ echo "#d2a208"; }elseif($mediaRondoniaPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaAcrePreSif < 24) { echo "#ba0a0a"; }elseif($mediaAcrePreSif < 42){ echo "#d2a208"; }elseif($mediaAcrePreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmazonasPreSif < 24) { echo "#ba0a0a"; }elseif($mediaAmazonasPreSif < 42){ echo "#d2a208"; }elseif($mediaAmazonasPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaRoraimaPreSif < 24) { echo "#ba0a0a"; }elseif($mediaRoraimaPreSif < 42){ echo "#d2a208"; }elseif($mediaRoraimaPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaParaPreSif < 24) { echo "#ba0a0a"; }elseif($mediaParaPreSif < 42){ echo "#d2a208"; }elseif($mediaParaPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmapaPreSif < 24) { echo "#ba0a0a"; }elseif($mediaAmapaPreSif < 42){ echo "#d2a208"; }elseif($mediaAmapaPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaTocantinsPreSif < 24) { echo "#ba0a0a"; }elseif($mediaTocantinsPreSif < 42){ echo "#d2a208"; }elseif($mediaTocantinsPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaRondoniaPreSif; ?>,<?php echo $mediaAcrePreSif; ?>,<?php echo $mediaAmazonasPreSif; ?>,<?php echo $mediaRoraimaPreSif; ?>,<?php echo $mediaParaPreSif; ?>,<?php echo $mediaAmapaPreSif; ?>,<?php echo $mediaTocantinsPreSif; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // regioesCitopatologico
            var ctx = document.getElementById("regioesCitopatologico");
            var regioesCitopatologico = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["Rondônia", "Acre", "Amazonas", "Roraima", "Pará", "Amapá", "Tocantins"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaRondoniaCitop < 16) { echo "#d10e0e"; }elseif($mediaRondoniaCitop < 28){ echo "#e6b20b"; }elseif($mediaRondoniaCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaAcreCitop < 16) { echo "#d10e0e"; }elseif($mediaAcreCitop < 28){ echo "#e6b20b"; }elseif($mediaAcreCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmazonasCitop < 16) { echo "#d10e0e"; }elseif($mediaAmazonasCitop < 28){ echo "#e6b20b"; }elseif($mediaAmazonasCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaRoraimaCitop < 16) { echo "#d10e0e"; }elseif($mediaRoraimaCitop < 28){ echo "#e6b20b"; }elseif($mediaRoraimaCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaParaCitop < 16) { echo "#d10e0e"; }elseif($mediaParaCitop < 28){ echo "#e6b20b"; }elseif($mediaParaCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmapaCitop < 16) { echo "#d10e0e"; }elseif($mediaAmapaCitop < 28){ echo "#e6b20b"; }elseif($mediaAmapaCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaTocantinsCitop < 16) { echo "#d10e0e"; }elseif($mediaTocantinsCitop < 28){ echo "#e6b20b"; }elseif($mediaTocantinsCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaRondoniaCitop < 16) { echo "#ba0a0a"; }elseif($mediaRondoniaCitop < 28){ echo "#d2a208"; }elseif($mediaRondoniaCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaAcreCitop < 16) { echo "#ba0a0a"; }elseif($mediaAcreCitop < 28){ echo "#d2a208"; }elseif($mediaAcreCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmazonasCitop < 16) { echo "#ba0a0a"; }elseif($mediaAmazonasCitop < 28){ echo "#d2a208"; }elseif($mediaAmazonasCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaRoraimaCitop < 16) { echo "#ba0a0a"; }elseif($mediaRoraimaCitop < 28){ echo "#d2a208"; }elseif($mediaRoraimaCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaParaCitop < 16) { echo "#ba0a0a"; }elseif($mediaParaCitop < 28){ echo "#d2a208"; }elseif($mediaParaCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmapaCitop < 16) { echo "#ba0a0a"; }elseif($mediaAmapaCitop < 28){ echo "#d2a208"; }elseif($mediaAmapaCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaTocantinsCitop < 16) { echo "#ba0a0a"; }elseif($mediaTocantinsCitop < 28){ echo "#d2a208"; }elseif($mediaTocantinsCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaRondoniaCitop; ?>,<?php echo $mediaAcreCitop; ?>,<?php echo $mediaAmazonasCitop; ?>,<?php echo $mediaRoraimaCitop; ?>,<?php echo $mediaParaCitop; ?>,<?php echo $mediaAmapaCitop; ?>,<?php echo $mediaTocantinsCitop; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // regioesHipertensao
            var ctx = document.getElementById("regioesHipertensao");
            var regioesHipertensao = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["Rondônia", "Acre", "Amazonas", "Roraima", "Pará", "Amapá", "Tocantins"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaRondoniaHiper < 20) { echo "#d10e0e"; }elseif($mediaRondoniaHiper < 35){ echo "#e6b20b"; }elseif($mediaRondoniaHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaAcreHiper < 20) { echo "#d10e0e"; }elseif($mediaAcreHiper < 35){ echo "#e6b20b"; }elseif($mediaAcreHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmazonasHiper < 20) { echo "#d10e0e"; }elseif($mediaAmazonasHiper < 35){ echo "#e6b20b"; }elseif($mediaAmazonasHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaRoraimaHiper < 20) { echo "#d10e0e"; }elseif($mediaRoraimaHiper < 35){ echo "#e6b20b"; }elseif($mediaRoraimaHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaParaHiper < 20) { echo "#d10e0e"; }elseif($mediaParaHiper < 35){ echo "#e6b20b"; }elseif($mediaParaHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmapaHiper < 20) { echo "#d10e0e"; }elseif($mediaAmapaHiper < 35){ echo "#e6b20b"; }elseif($mediaAmapaHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaTocantinsHiper < 20) { echo "#d10e0e"; }elseif($mediaTocantinsHiper < 35){ echo "#e6b20b"; }elseif($mediaTocantinsHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaRondoniaHiper < 20) { echo "#ba0a0a"; }elseif($mediaRondoniaHiper < 35){ echo "#d2a208"; }elseif($mediaRondoniaHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaAcreHiper < 20) { echo "#ba0a0a"; }elseif($mediaAcreHiper < 35){ echo "#d2a208"; }elseif($mediaAcreHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmazonasHiper < 20) { echo "#ba0a0a"; }elseif($mediaAmazonasHiper < 35){ echo "#d2a208"; }elseif($mediaAmazonasHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaRoraimaHiper < 20) { echo "#ba0a0a"; }elseif($mediaRoraimaHiper < 35){ echo "#d2a208"; }elseif($mediaRoraimaHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaParaHiper < 20) { echo "#ba0a0a"; }elseif($mediaParaHiper < 35){ echo "#d2a208"; }elseif($mediaParaHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmapaHiper < 20) { echo "#ba0a0a"; }elseif($mediaAmapaHiper < 35){ echo "#d2a208"; }elseif($mediaAmapaHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaTocantinsHiper < 20) { echo "#ba0a0a"; }elseif($mediaTocantinsHiper < 35){ echo "#d2a208"; }elseif($mediaTocantinsHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaRondoniaHiper; ?>,<?php echo $mediaAcreHiper; ?>,<?php echo $mediaAmazonasHiper; ?>,<?php echo $mediaRoraimaHiper; ?>,<?php echo $mediaParaHiper; ?>,<?php echo $mediaAmapaHiper; ?>,<?php echo $mediaTocantinsHiper; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // regioesDiabetes
            var ctx = document.getElementById("regioesDiabetes");
            var regioesDiabetes = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["Rondônia", "Acre", "Amazonas", "Roraima", "Pará", "Amapá", "Tocantins"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaRondoniaDiab< 20) { echo "#d10e0e"; }elseif($mediaRondoniaDiab < 35){ echo "#e6b20b"; }elseif($mediaRondoniaDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaAcreDiab < 20) { echo "#d10e0e"; }elseif($mediaAcreDiab < 35){ echo "#e6b20b"; }elseif($mediaAcreDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmazonasDiab < 20) { echo "#d10e0e"; }elseif($mediaAmazonasDiab < 35){ echo "#e6b20b"; }elseif($mediaAmazonasDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaRoraimaDiab < 20) { echo "#d10e0e"; }elseif($mediaRoraimaDiab < 35){ echo "#e6b20b"; }elseif($mediaRoraimaDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaParaDiab < 20) { echo "#d10e0e"; }elseif($mediaParaDiab < 35){ echo "#e6b20b"; }elseif($mediaParaDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaAmapaDiab < 20) { echo "#d10e0e"; }elseif($mediaAmapaDiab < 35){ echo "#e6b20b"; }elseif($mediaAmapaDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaTocantinsDiab < 20) { echo "#d10e0e"; }elseif($mediaTocantinsDiab < 35){ echo "#e6b20b"; }elseif($mediaTocantinsDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaRondoniaDiab < 20) { echo "#ba0a0a"; }elseif($mediaRondoniaDiab < 35){ echo "#d2a208"; }elseif($mediaRondoniaDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaAcreDiab < 20) { echo "#ba0a0a"; }elseif($mediaAcreDiab < 35){ echo "#d2a208"; }elseif($mediaAcreDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmazonasDiab < 20) { echo "#ba0a0a"; }elseif($mediaAmazonasDiab < 35){ echo "#d2a208"; }elseif($mediaAmazonasDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaRoraimaDiab < 20) { echo "#ba0a0a"; }elseif($mediaRoraimaDiab < 35){ echo "#d2a208"; }elseif($mediaRoraimaDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaParaDiab < 20) { echo "#ba0a0a"; }elseif($mediaParaDiab < 35){ echo "#d2a208"; }elseif($mediaParaDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaAmapaDiab < 20) { echo "#ba0a0a"; }elseif($mediaAmapaDiab < 35){ echo "#d2a208"; }elseif($mediaAmapaDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaTocantinsDiab < 20) { echo "#ba0a0a"; }elseif($mediaTocantinsDiab < 35){ echo "#d2a208"; }elseif($mediaTocantinsDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaRondoniaDiab; ?>,<?php echo $mediaAcreDiab; ?>,<?php echo $mediaAmazonasDiab; ?>,<?php echo $mediaRoraimaDiab; ?>,<?php echo $mediaParaDiab; ?>,<?php echo $mediaAmapaDiab; ?>,<?php echo $mediaTocantinsDiab; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40,
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
        </script>
        <script>
            $(".btn_sub").click(function () {
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
    </body>

</html>
