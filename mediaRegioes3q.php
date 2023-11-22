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
                    <h4 class="mb-4 text-center">Média dos Indicadores por Região - Ano <?= $anoAtual ?> - 3º Quadrimestre.</h4>
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
            //média por região
            $mediaNortePreCons = $mediaNortePreSif = $mediaNorteCitop = $mediaNorteHiper = $mediaNorteDiab = $somaNortePreCons = $somaNortePreSif = $somaNorteCitop = $somaNorteHiper = $somaNorteDiab = 0;
            $mediaNordestePreCons = $mediaNordestePreSif = $mediaNordesteCitop = $mediaNordesteHiper = $mediaNordesteDiab =  $somaNordestePreCons = $somaNordestePreSif = $somaNordesteCitop = $somaNordesteHiper = $somaNordesteDiab = 0;
            $mediaCentroPreCons = $mediaCentroPreSif = $mediaCentroCitop = $mediaCentroHiper = $mediaCentroDiab = $somaCentroPreCons = $somaCentroPreSif = $somaCentroCitop = $somaCentroHiper = $somaCentroDiab = 0;
            $mediaSudestePreCons = $mediaSudestePreSif = $mediaSudesteCitop = $mediaSudesteHiper = $mediaSudesteDiab = $somaSudestePreCons = $somaSudestePreSif = $somaSudesteCitop = $somaSudesteHiper = $somaSudesteDiab = 0;
            $mediaSulPreCons = $mediaSulPreSif = $mediaSulCitop = $mediaSulHiper = $mediaSulDiab = $somaSulPreCons = $somaSulPreSif = $somaSulCitop = $somaSulHiper = $somaSulDiab = 0;
            
            //Região Norte
            $sqlNorteT = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where d.ibge like '1%' and ano = '$anoAtual' and d.idperiodo = 25";
            $qNorteT = mysqli_query($conn, $sqlNorteT);
            $rowsNorteT = mysqli_num_rows($qNorteT);
            
            $sqlNorte = "SELECT * FROM `desempenho` where ibge like '1%' and ano = '$anoAtual' and idperiodo = 25";
            $queryNorte = mysqli_query($conn, $sqlNorte);
            $rowsNorte = mysqli_num_rows($queryNorte);
            $rsNorte = mysqli_fetch_array($queryNorte);
            if($rsNorte){
                do{
                    $somaNortePreCons += $rsNorte['prenatal_consultas'];
                    $somaNortePreSif += $rsNorte['prenatal_sifilis_hiv'];
                    $somaNorteCitop += $rsNorte['cobertura_citopatologico'];
                    $somaNorteHiper += $rsNorte['hipertensao'];
                    $somaNorteDiab += $rsNorte['diabetes'];
                }while($rsNorte = mysqli_fetch_array($queryNorte));
                $mediaNortePreCons = round(($somaNortePreCons/$rowsNorte),2);
                $mediaNortePreSif = round(($somaNortePreSif/$rowsNorte),2);
                $mediaNorteCitop = round(($somaNorteCitop/$rowsNorte),2);
                $mediaNorteHiper = round(($somaNorteHiper/$rowsNorte),2);
                $mediaNorteDiab = round(($somaNorteDiab/$rowsNorte),2);
            }
            
            //Região Nordeste
            $sqlNordesteT = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where d.ibge like '2%' and ano = '$anoAtual' and d.idperiodo = 25";
            $qNordesteT = mysqli_query($conn, $sqlNordesteT);
            $rowsNordesteT = mysqli_num_rows($qNordesteT);
            
            $sqlNordeste = "SELECT * FROM `desempenho` where ibge like '2%' and ano = '$anoAtual' and idperiodo = 25";
            $queryNordeste = mysqli_query($conn, $sqlNordeste);
            $rowsNordeste = mysqli_num_rows($queryNordeste);
            $rsNordeste = mysqli_fetch_array($queryNordeste);
            if($rsNordeste){
                do{
                    $somaNordestePreCons += $rsNordeste['prenatal_consultas'];
                    $somaNordestePreSif += $rsNordeste['prenatal_sifilis_hiv'];
                    $somaNordesteCitop += $rsNordeste['cobertura_citopatologico'];
                    $somaNordesteHiper += $rsNordeste['hipertensao'];
                    $somaNordesteDiab += $rsNordeste['diabetes'];
                }while($rsNordeste = mysqli_fetch_array($queryNordeste));
                $mediaNordestePreCons = round(($somaNordestePreCons/$rowsNordeste),2);
                $mediaNordestePreSif = round(($somaNordestePreSif/$rowsNordeste),2);
                $mediaNordesteCitop = round(($somaNordesteCitop/$rowsNordeste),2);
                $mediaNordesteHiper = round(($somaNordesteHiper/$rowsNordeste),2);
                $mediaNordesteDiab = round(($somaNordesteDiab/$rowsNordeste),2);
            }
            
            //Região Sudeste
            $sqlSudesteT = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where d.ibge like '3%' and ano = '$anoAtual' and d.idperiodo = 25";
            $qSudesteT = mysqli_query($conn, $sqlSudesteT);
            $rowsSudesteT = mysqli_num_rows($qSudesteT);
            
            $sqlSudeste = "SELECT * FROM `desempenho` where ibge like '3%' and ano = '$anoAtual' and idperiodo = 25";
            $querySudeste = mysqli_query($conn, $sqlSudeste);
            $rowsSudeste = mysqli_num_rows($querySudeste);
            $rsSudeste = mysqli_fetch_array($querySudeste);
            if($rsSudeste){
                do{
                    $somaSudestePreCons += $rsSudeste['prenatal_consultas'];
                    $somaSudestePreSif += $rsSudeste['prenatal_sifilis_hiv'];
                    $somaSudesteCitop += $rsSudeste['cobertura_citopatologico'];
                    $somaSudesteHiper += $rsSudeste['hipertensao'];
                    $somaSudesteDiab += $rsSudeste['diabetes'];
                }while($rsSudeste = mysqli_fetch_array($querySudeste));
                $mediaSudestePreCons = round(($somaSudestePreCons/$rowsSudeste),2);
                $mediaSudestePreSif = round(($somaSudestePreSif/$rowsSudeste),2);
                $mediaSudesteCitop = round(($somaSudesteCitop/$rowsSudeste),2);
                $mediaSudesteHiper = round(($somaSudesteHiper/$rowsSudeste),2);
                $mediaSudesteDiab = round(($somaSudesteDiab/$rowsSudeste),2);
            }
            
            //Região Sul
            $sqlSulT = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where d.ibge like '4%' and ano = '$anoAtual' and d.idperiodo = 25";
            $qSulT = mysqli_query($conn, $sqlSulT);
            $rowsSulT = mysqli_num_rows($qSulT);
            
            $sqlSul = "SELECT * FROM `desempenho` where ibge like '4%' and ano = '$anoAtual' and idperiodo = 25";
            $querySul = mysqli_query($conn, $sqlSul);
            $rowsSul = mysqli_num_rows($querySul);
            $rsSul = mysqli_fetch_array($querySul);
            if($rsSul){
                do{
                    $somaSulPreCons += $rsSul['prenatal_consultas'];
                    $somaSulPreSif += $rsSul['prenatal_sifilis_hiv'];
                    $somaSulCitop += $rsSul['cobertura_citopatologico'];
                    $somaSulHiper += $rsSul['hipertensao'];
                    $somaSulDiab += $rsSul['diabetes'];
                }while($rsSul = mysqli_fetch_array($querySul));
                $mediaSulPreCons = round(($somaSulPreCons/$rowsSul),2);
                $mediaSulPreSif = round(($somaSulPreSif/$rowsSul),2);
                $mediaSulCitop = round(($somaSulCitop/$rowsSul),2);
                $mediaSulHiper = round(($somaSulHiper/$rowsSul),2);
                $mediaSulDiab = round(($somaSulDiab/$rowsSul),2);
            }
            
            //Região Centro-Oeste
            $sqlCentroT = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where d.ibge like '5%' and ano = '$anoAtual' and d.idperiodo = 25";
            $qCentroT = mysqli_query($conn, $sqlCentroT);
            $rowsCentroT = mysqli_num_rows($qCentroT);
            
            $sqlCentro = "SELECT * FROM `desempenho` where ibge like '5%' and ano = '$anoAtual' and idperiodo = 25";
            $queryCentro = mysqli_query($conn, $sqlCentro);
            $rowsCentro = mysqli_num_rows($queryCentro);
            $rsCentro = mysqli_fetch_array($queryCentro);
            if($rsCentro){
                do{
                    $somaCentroPreCons += $rsCentro['prenatal_consultas'];
                    $somaCentroPreSif += $rsCentro['prenatal_sifilis_hiv'];
                    $somaCentroCitop += $rsCentro['cobertura_citopatologico'];
                    $somaCentroHiper += $rsCentro['hipertensao'];
                    $somaCentroDiab += $rsCentro['diabetes'];
                }while($rsCentro = mysqli_fetch_array($queryCentro));
                $mediaCentroPreCons = round(($somaCentroPreCons/$rowsCentro),2);
                $mediaCentroPreSif = round(($somaCentroPreSif/$rowsCentro),2);
                $mediaCentroCitop = round(($somaCentroCitop/$rowsCentro),2);
                $mediaCentroHiper = round(($somaCentroHiper/$rowsCentro),2);
                $mediaCentroDiab = round(($somaCentroDiab/$rowsCentro),2);
            }
            ?>
            <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3 mb-2">
                <div class="row p-3">
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold mb-3">Média dos Indicadores por Região</h6>
                                <p class="small text-danger"> * Clique nos indicadores para saber mais detalhes sobre a sinalização semafórica.</p>
                            </div>
                        </div>
                        <div class="modal fad qd1 mt-5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="card shadow divexp1r">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Pré-Natal (6 consultas) - Sinalização semafórica do alcance (metas) dos indicadores</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pr-2 pl-2">
                                                    <div class="col-md-12 pr-3 pl-3 pt-2">
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
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-danger form-control">< 18%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-warning form-control">>= 18% < 31%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-success form-control">>= 31% < 45%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-primary form-control">>= 45%</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="font-weight-bold btn-sm btn btn-secondary border-light shadow-sm rounded ml-5" data-dismiss="modal">FECHAR</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fad qd2 mt-5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="card shadow divexp1r">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Pré-Natal (Sífilis e HIV) - Sinalização semafórica do alcance (metas) dos indicadores</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pr-2 pl-2">
                                                    <div class="col-md-12 pr-3 pl-3 pt-2">
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
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-danger form-control">< 24%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-warning form-control">>= 24% < 42%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-success form-control">>= 42% < 60%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-primary form-control">>= 60%</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="font-weight-bold btn-sm btn btn-secondary border-light shadow-sm rounded ml-5" data-dismiss="modal">FECHAR</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fad qd3 mt-5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="card shadow divexp1r">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Cobertura Citopatológico - Sinalização semafórica do alcance (metas) dos indicadores</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pr-2 pl-2">
                                                    <div class="col-md-12 pr-3 pl-3 pt-2">
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
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-danger form-control">< 16%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-warning form-control">>= 16% < 28%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-success form-control">>= 28% < 40%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-primary form-control">>= 40%</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="font-weight-bold btn btn-sm btn-secondary border-light shadow-sm rounded ml-5" data-dismiss="modal">FECHAR</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fad qd4 mt-5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="card shadow divexp1r">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Hipertensão (PA Aferida) - Sinalização semafórica do alcance (metas) dos indicadores</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pr-2 pl-2">
                                                    <div class="col-md-12 pr-3 pl-3 pt-2">
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
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-danger form-control">< 20%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-warning form-control">>= 20% < 35%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-success form-control">>= 35% < 50%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-primary form-control">>= 50%</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="font-weight-bold btn btn-sm btn-secondary border-light shadow-sm rounded ml-5" data-dismiss="modal">FECHAR</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fad qd5 mt-5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-4">
                                        <div class="card shadow divexp1r">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Diabetes (Hemoglobina Glicada) - Sinalização semafórica do alcance (metas) dos indicadores</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pr-2 pl-2">
                                                    <div class="col-md-12 pr-3 pl-3 pt-2">
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
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-danger form-control">< 20%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-warning form-control">>= 20% < 35%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-success form-control">>= 35% < 50%</button>
                                                            </div>
                                                            <div class="col-12 mb-1">
                                                                <button class="btn btn-primary form-control">>= 50%</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="font-weight-bold btn btn-sm btn-secondary border-light shadow-sm rounded ml-5" data-dismiss="modal">FECHAR</button>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 pl-2">
                            <div class="col-md-2 shadow rounded mt-3 ml-2 pt-2 pr-3 pl-3">
                                <div class="row mt-2 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold btn-sm">Norte: <?= $rowsNorteT ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -2%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaNortePreCons<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNortePreCons<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNortePreCons<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                             <?= str_replace(".", ",", $mediaNortePreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaNortePreSif<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNortePreSif<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNortePreSif<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNortePreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaNorteCitop<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNorteCitop<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNorteCitop<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNorteCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaNorteHiper<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNorteHiper<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNorteHiper<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNorteHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaNorteDiab<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNorteDiab<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNorteDiab<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNorteDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-2 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Nordeste: <?= $rowsNordesteT ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaNordestePreCons<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNordestePreCons<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNordestePreCons<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNordestePreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaNordestePreSif<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNordestePreSif<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNordestePreSif<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNordestePreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaNordesteCitop<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNordesteCitop<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNordesteCitop<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNordesteCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaNordesteHiper<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNordesteHiper<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNordesteHiper<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNordesteHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaNordesteDiab<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaNordesteDiab<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaNordesteDiab<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaNordesteDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-2 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Centro-Oeste: <?= $rowsCentroT ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaCentroPreCons<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCentroPreCons<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCentroPreCons<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCentroPreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaCentroPreSif<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCentroPreSif<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCentroPreSif<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCentroPreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaCentroCitop<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCentroCitop<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCentroCitop<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCentroCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaCentroHiper<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCentroHiper<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCentroHiper<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCentroHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaCentroDiab<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCentroDiab<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCentroDiab<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCentroDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-2 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Sudeste: <?= $rowsSudesteT ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaSudestePreCons<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSudestePreCons<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSudestePreCons<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSudestePreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaSudestePreSif<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSudestePreSif<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSudestePreSif<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSudestePreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaSudesteCitop<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSudesteCitop<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSudesteCitop<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSudesteCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaSudesteHiper<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSudesteHiper<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSudesteHiper<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSudesteHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaSudesteDiab<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSudesteDiab<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSudesteDiab<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSudesteDiab) ?>%</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 shadow rounded mt-3 ml-2 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">Sul: <?= $rowsSulT ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaSulPreCons<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSulPreCons<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSulPreCons<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSulPreCons) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaSulPreSif<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSulPreSif<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSulPreSif<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSulPreSif) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaSulCitop<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSulCitop<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSulCitop<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSulCitop) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaSulHiper<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSulHiper<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSulHiper<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSulHiper) ?>%</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaSulDiab<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaSulDiab<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaSulDiab<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaSulDiab) ?>%</label></h6>
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
                                <div class="card shadow divexp1r">
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
                                                            <div class="col-10">
                                                                <label class="small text-justify">< 18%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 18% < 31%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 31% < 45%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
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
                                                            <div class="col-10">
                                                                <label class="small text-justify">< 24%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 24% < 42%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 42% < 60%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
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
                                                            <div class="col-10">
                                                                <label class="small text-justify">< 16%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 16% < 28%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 28% < 40%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
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
                                                            <div class="col-10">
                                                                <label class="small text-justify">< 20%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 20% < 35%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 35% < 50%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
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
                                                            <div class="col-10">
                                                                <label class="small text-justify">< 20%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 20% < 35%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
                                                                <label class="small text-justify">>= 35% < 50%</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-1 mt-1">
                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                            </div>
                                                            <div class="col-10">
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
                labels: ["Norte", "Nordeste", "Centro-Oeste", "Sudeste", "Sul"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaNortePreCons < 18) { echo "#d10e0e"; }elseif($mediaNortePreCons < 31){ echo "#e6b20b"; }elseif($mediaNortePreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaNordestePreCons < 18) { echo "#d10e0e"; }elseif($mediaNordestePreCons < 31){ echo "#e6b20b"; }elseif($mediaNordestePreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaCentroPreCons < 18) { echo "#d10e0e"; }elseif($mediaCentroPreCons < 31){ echo "#e6b20b"; }elseif($mediaCentroPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSudestePreCons < 18) { echo "#d10e0e"; }elseif($mediaSudestePreCons < 31){ echo "#e6b20b"; }elseif($mediaSudestePreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSulPreCons < 18) { echo "#d10e0e"; }elseif($mediaSulPreCons < 31){ echo "#e6b20b"; }elseif($mediaSulPreCons < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaNortePreCons < 18) { echo "#ba0a0a"; }elseif($mediaNortePreCons < 31){ echo "#d2a208"; }elseif($mediaNortePreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaNordestePreCons < 18) { echo "#ba0a0a"; }elseif($mediaNordestePreCons < 31){ echo "#d2a208"; }elseif($mediaNordestePreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaCentroPreCons < 18) { echo "#ba0a0a"; }elseif($mediaCentroPreCons < 31){ echo "#d2a208"; }elseif($mediaCentroPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSudestePreCons < 18) { echo "#ba0a0a"; }elseif($mediaSudestePreCons < 31){ echo "#d2a208"; }elseif($mediaSudestePreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSulPreCons < 18) { echo "#ba0a0a"; }elseif($mediaSulPreCons < 31){ echo "#d2a208"; }elseif($mediaSulPreCons < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaNortePreCons; ?>,<?php echo $mediaNordestePreCons; ?>,<?php echo $mediaCentroPreCons; ?>,<?php echo $mediaSudestePreCons; ?>,<?php echo $mediaSulPreCons; ?>]
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
                labels: ["Norte", "Nordeste", "Centro-Oeste", "Sudeste", "Sul"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaNortePreSif < 24) { echo "#d10e0e"; }elseif($mediaNortePreSif < 42){ echo "#e6b20b"; }elseif($mediaNortePreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaNordestePreSif < 24) { echo "#d10e0e"; }elseif($mediaNordestePreSif < 42){ echo "#e6b20b"; }elseif($mediaNordestePreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaCentroPreSif < 24) { echo "#d10e0e"; }elseif($mediaCentroPreSif < 42){ echo "#e6b20b"; }elseif($mediaCentroPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSudestePreSif < 24) { echo "#d10e0e"; }elseif($mediaSudestePreSif < 42){ echo "#e6b20b"; }elseif($mediaSudestePreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSulPreSif < 24) { echo "#d10e0e"; }elseif($mediaSulPreSif < 42){ echo "#e6b20b"; }elseif($mediaSulPreSif < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaNortePreSif < 24) { echo "#ba0a0a"; }elseif($mediaNortePreSif < 42){ echo "#d2a208"; }elseif($mediaNortePreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaNordestePreSif < 24) { echo "#ba0a0a"; }elseif($mediaNordestePreSif < 42){ echo "#d2a208"; }elseif($mediaNordestePreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaCentroPreSif < 24) { echo "#ba0a0a"; }elseif($mediaCentroPreSif < 42){ echo "#d2a208"; }elseif($mediaCentroPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSudestePreSif < 24) { echo "#ba0a0a"; }elseif($mediaSudestePreSif < 42){ echo "#d2a208"; }elseif($mediaSudestePreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSulPreSif < 24) { echo "#ba0a0a"; }elseif($mediaSulPreSif < 42){ echo "#d2a208"; }elseif($mediaSulPreSif < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaNortePreSif; ?>,<?php echo $mediaNordestePreSif; ?>,<?php echo $mediaCentroPreSif; ?>,<?php echo $mediaSudestePreSif; ?>,<?php echo $mediaSulPreSif; ?>]
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
                labels: ["Norte", "Nordeste", "Centro-Oeste", "Sudeste", "Sul"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaNorteCitop < 16) { echo "#d10e0e"; }elseif($mediaNorteCitop < 28){ echo "#e6b20b"; }elseif($mediaNorteCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaNordesteCitop < 16) { echo "#d10e0e"; }elseif($mediaNordesteCitop < 28){ echo "#e6b20b"; }elseif($mediaNordesteCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaCentroCitop < 16) { echo "#d10e0e"; }elseif($mediaCentroCitop < 28){ echo "#e6b20b"; }elseif($mediaCentroCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSudesteCitop < 16) { echo "#d10e0e"; }elseif($mediaSudesteCitop < 28){ echo "#e6b20b"; }elseif($mediaSudesteCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSulCitop < 16) { echo "#d10e0e"; }elseif($mediaSulCitop < 28){ echo "#e6b20b"; }elseif($mediaSulCitop < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaNorteCitop < 16) { echo "#ba0a0a"; }elseif($mediaNorteCitop < 28){ echo "#d2a208"; }elseif($mediaNorteCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaNordesteCitop < 16) { echo "#ba0a0a"; }elseif($mediaNordesteCitop < 28){ echo "#d2a208"; }elseif($mediaNordesteCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaCentroCitop < 16) { echo "#ba0a0a"; }elseif($mediaCentroCitop < 28){ echo "#d2a208"; }elseif($mediaCentroCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSudesteCitop < 16) { echo "#ba0a0a"; }elseif($mediaSudesteCitop < 28){ echo "#d2a208"; }elseif($mediaSudesteCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSulCitop < 16) { echo "#ba0a0a"; }elseif($mediaSulCitop < 28){ echo "#d2a208"; }elseif($mediaSulCitop < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaNorteCitop; ?>,<?php echo $mediaNordesteCitop; ?>,<?php echo $mediaCentroCitop; ?>,<?php echo $mediaSudesteCitop; ?>,<?php echo $mediaSulCitop; ?>]
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
                labels: ["Norte", "Nordeste", "Centro-Oeste", "Sudeste", "Sul"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaNorteHiper < 20) { echo "#d10e0e"; }elseif($mediaNorteHiper < 35){ echo "#e6b20b"; }elseif($mediaNorteHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaNordesteHiper < 20) { echo "#d10e0e"; }elseif($mediaNordesteHiper < 35){ echo "#e6b20b"; }elseif($mediaNordesteHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaCentroHiper < 20) { echo "#d10e0e"; }elseif($mediaCentroHiper < 35){ echo "#e6b20b"; }elseif($mediaCentroHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSudesteHiper < 20) { echo "#d10e0e"; }elseif($mediaSudesteHiper < 35){ echo "#e6b20b"; }elseif($mediaSudesteHiper < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSulHiper < 20) { echo "#d10e0e"; }elseif($mediaSudesteDiab < 35){ echo "#e6b20b"; }elseif($mediaSudesteDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaNorteHiper < 20) { echo "#ba0a0a"; }elseif($mediaNorteHiper < 35){ echo "#d2a208"; }elseif($mediaNorteHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaNordesteHiper < 20) { echo "#ba0a0a"; }elseif($mediaNordesteHiper < 35){ echo "#d2a208"; }elseif($mediaNordesteHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaCentroHiper < 20) { echo "#ba0a0a"; }elseif($mediaCentroHiper < 35){ echo "#d2a208"; }elseif($mediaCentroHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSudesteHiper < 20) { echo "#ba0a0a"; }elseif($mediaSudesteHiper < 35){ echo "#d2a208"; }elseif($mediaSudesteHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSulHiper < 20) { echo "#ba0a0a"; }elseif($mediaSulHiper < 35){ echo "#d2a208"; }elseif($mediaSulHiper < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaNorteHiper; ?>,<?php echo $mediaNordesteHiper; ?>,<?php echo $mediaCentroHiper; ?>,<?php echo $mediaSudesteHiper; ?>,<?php echo $mediaSulHiper; ?>]
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
                labels: ["Norte", "Nordeste", "Centro-Oeste", "Sudeste", "Sul"],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($mediaNorteDiab< 20) { echo "#d10e0e"; }elseif($mediaNorteDiab < 35){ echo "#e6b20b"; }elseif($mediaNorteDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($mediaNordesteDiab < 20) { echo "#d10e0e"; }elseif($mediaNordesteDiab < 35){ echo "#e6b20b"; }elseif($mediaNordesteDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaCentroDiab < 20) { echo "#d10e0e"; }elseif($mediaCentroDiab < 35){ echo "#e6b20b"; }elseif($mediaCentroDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSudesteDiab < 20) { echo "#d10e0e"; }elseif($mediaSudesteDiab < 35){ echo "#e6b20b"; }elseif($mediaSudesteDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($mediaSulDiab < 20) { echo "#d10e0e"; }elseif($mediaSulDiab < 35){ echo "#e6b20b"; }elseif($mediaSulDiab < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($mediaNorteDiab < 20) { echo "#ba0a0a"; }elseif($mediaNorteDiab < 35){ echo "#d2a208"; }elseif($mediaNorteDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($mediaNordesteDiab < 20) { echo "#ba0a0a"; }elseif($mediaNordesteDiab < 35){ echo "#d2a208"; }elseif($mediaNordesteDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaCentroDiab < 20) { echo "#ba0a0a"; }elseif($mediaCentroDiab < 35){ echo "#d2a208"; }elseif($mediaCentroDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSudesteDiab < 20) { echo "#ba0a0a"; }elseif($mediaSudesteDiab < 35){ echo "#d2a208"; }elseif($mediaSudesteDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($mediaSulDiab < 20) { echo "#ba0a0a"; }elseif($mediaSulDiab < 35){ echo "#d2a208"; }elseif($mediaSulDiab < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $mediaNorteDiab; ?>,<?php echo $mediaNordesteDiab; ?>,<?php echo $mediaCentroDiab; ?>,<?php echo $mediaSudesteDiab; ?>,<?php echo $mediaSulDiab; ?>]
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
