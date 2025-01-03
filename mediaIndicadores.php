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
                    <h4 class="mb-4 text-center">Média de Todos os Indicadores - ano <?= $anoAtual ?>.</h4>
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
            //variáveis para média dos indicadores do 1o quadrimestre.
            $mediaPreCons1q  = $mediaPreSif1q = $mediaCitop1q = $mediaHiper1q = $mediaDiab1q = $somaPreCons1q =  $somaPreSif1q = $somaCitop1q = $somaHiper1q = $somaDiab1q = 0;
            $qtdMetaPreCons1q = $qtdMetaPreSif1q = $qtdMetaCitop1q = $qtdMetaHiper1q = $qtdMetaDiab1q = $metaPreCons1q = $metaPreSif1q = $metaCitop1q = $metaHiper1q = $metaDiab1q = 0;
            $ctPreCons1q = $ctPreSif1q = $ctCitop1q = $ctHiper1q = $ctDiab1q = 0;
            //média dos indicadores do 1o quadrimestre
            $sql1q = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where ano = '$anoAtual' and d.idperiodo = 23";
            $q1q = mysqli_query($conn, $sql1q);
            $rows1q = mysqli_num_rows($q1q);
            
            $sqlInd1q = "SELECT * FROM `desempenho` where ano = '$anoAtual' and idperiodo = 23";
            $queryInd1q = mysqli_query($conn, $sqlInd1q);
            $rowsInd1q = mysqli_num_rows($queryInd1q);
            $rsInd1q = mysqli_fetch_array($queryInd1q);
            if($rsInd1q){
                do{
                    $somaPreCons1q += $rsInd1q['prenatal_consultas'];
                    $somaPreSif1q += $rsInd1q['prenatal_sifilis_hiv'];
                    $somaCitop1q += $rsInd1q['cobertura_citopatologico'];
                    $somaHiper1q += $rsInd1q['hipertensao'];
                    $somaDiab1q += $rsInd1q['diabetes'];
                    $ctPreCons1q++;
                    $ctPreSif1q++;
                    $ctCitop1q++;
                    $ctHiper1q++;
                    $ctDiab1q++;
                    if($rsInd1q['prenatal_consultas'] > 45.00){
                        $qtdMetaPreCons1q++;
                    }
                    if($rsInd1q['prenatal_sifilis_hiv'] > 60.00){
                        $qtdMetaPreSif1q++;
                    }
                    if($rsInd1q['cobertura_citopatologico'] > 40.00){
                        $qtdMetaCitop1q++;
                    }
                    if($rsInd1q['hipertensao'] > 50.00){
                        $qtdMetaHiper1q++;
                    }
                    if($rsInd1q['diabetes'] > 50.00){
                        $qtdMetaDiab1q++;
                    }
                }while($rsInd1q = mysqli_fetch_array($queryInd1q));
                $mediaPreCons1q = round(($somaPreCons1q/$rowsInd1q),2);
                $mediaPreSif1q = round(($somaPreSif1q/$rowsInd1q),2);
                $mediaCitop1q = round(($somaCitop1q/$rowsInd1q),2);
                $mediaHiper1q = round(($somaHiper1q/$rowsInd1q),2);
                $mediaDiab1q = round(($somaDiab1q/$rowsInd1q),2);
                $metaPreCons1q = round(($qtdMetaPreCons1q/$ctPreCons1q)*100,2);
                $metaPreSif1q = round(($qtdMetaPreSif1q/$ctPreSif1q)*100,2);
                $metaCitop1q = round(($qtdMetaCitop1q/$ctCitop1q)*100,2);
                $metaHiper1q = round(($qtdMetaHiper1q/$ctHiper1q)*100,2);
                $metaDiab1q= round(($qtdMetaDiab1q/$ctDiab1q)*100,2);
            }
            
            //variáveis para média dos indicadores do 2o quadrimestre.
            $mediaPreCons2q  = $mediaPreSif2q = $mediaCitop2q = $mediaHiper2q = $mediaDiab2q = $somaPreCons2q =  $somaPreSif2q = $somaCitop2q = $somaHiper2q = $somaDiab2q = 0;
            $qtdMetaPreCons2q = $qtdMetaPreSif2q = $qtdMetaCitop2q = $qtdMetaHiper2q = $qtdMetaDiab2q = $metaPreCons2q = $metaPreSif2q = $metaCitop2q = $metaHiper2q = $metaDiab2q = 0;
            $ctPreCons2q = $ctPreSif2q = $ctCitop2q = $ctHiper2q = $ctDiab2q = 0;
            //média dos indicadores do 1o quadrimestre
            $sql2q = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where ano = '$anoAtual' and d.idperiodo = 24";
            $q2q = mysqli_query($conn, $sql2q);
            $rows2q = mysqli_num_rows($q2q);
            
            $sqlInd2q = "SELECT * FROM `desempenho` where ano = '$anoAtual' and idperiodo = 24";
            $queryInd2q = mysqli_query($conn, $sqlInd2q);
            $rowsInd2q = mysqli_num_rows($queryInd2q);
            $rsInd2q = mysqli_fetch_array($queryInd2q);
            if($rsInd2q){
                do{
                    $somaPreCons2q += $rsInd2q['prenatal_consultas'];
                    $somaPreSif2q += $rsInd2q['prenatal_sifilis_hiv'];
                    $somaCitop2q += $rsInd2q['cobertura_citopatologico'];
                    $somaHiper2q += $rsInd2q['hipertensao'];
                    $somaDiab2q += $rsInd2q['diabetes'];
                    $ctPreCons2q++;
                    $ctPreSif2q++;
                    $ctCitop2q++;
                    $ctHiper2q++;
                    $ctDiab2q++;
                    if($rsInd2q['prenatal_consultas'] > 45.00){
                        $qtdMetaPreCons2q++;
                    }
                    if($rsInd2q['prenatal_sifilis_hiv'] > 60.00){
                        $qtdMetaPreSif2q++;
                    }
                    if($rsInd2q['cobertura_citopatologico'] > 40.00){
                        $qtdMetaCitop2q++;
                    }
                    if($rsInd2q['hipertensao'] > 50.00){
                        $qtdMetaHiper2q++;
                    }
                    if($rsInd2q['diabetes'] > 50.00){
                        $qtdMetaDiab2q++;
                    }
                }while($rsInd2q = mysqli_fetch_array($queryInd2q));
                $mediaPreCons2q = round(($somaPreCons2q/$rowsInd2q),2);
                $mediaPreSif2q = round(($somaPreSif2q/$rowsInd2q),2);
                $mediaCitop2q = round(($somaCitop2q/$rowsInd2q),2);
                $mediaHiper2q = round(($somaHiper2q/$rowsInd2q),2);
                $mediaDiab2q = round(($somaDiab2q/$rowsInd2q),2);
                $metaPreCons2q = round(($qtdMetaPreCons2q/$ctPreCons2q)*100,2);
                $metaPreSif2q = round(($qtdMetaPreSif2q/$ctPreSif2q)*100,2);
                $metaCitop2q = round(($qtdMetaCitop2q/$ctCitop2q)*100,2);
                $metaHiper2q = round(($qtdMetaHiper2q/$ctHiper2q)*100,2);
                $metaDiab2q= round(($qtdMetaDiab2q/$ctDiab2q)*100,2);
            }
            
            //variáveis para média dos indicadores do 3o quadrimestre.
            $mediaPreCons3q  = $mediaPreSif3q = $mediaCitop3q = $mediaHiper3q = $mediaDiab3q = $somaPreCons3q =  $somaPreSif3q = $somaCitop3q = $somaHiper3q = $somaDiab3q = 0;
            $qtdMetaPreCons3q = $qtdMetaPreSif3q = $qtdMetaCitop3q = $qtdMetaHiper3q = $qtdMetaDiab3q = $metaPreCons3q = $metaPreSif3q = $metaCitop3q = $metaHiper3q = $metaDiab3q = 0;
            $ctPreCons3q = $ctPreSif3q = $ctCitop3q = $ctHiper3q = $ctDiab3q = 0;
            //média dos indicadores do 1o quadrimestre
            $sql3q = "SELECT * FROM medico m inner join desempenho d on d.cpf = m.cpf and d.ibge = m.ibge and m.cnes = m.cnes and d.ine = m.ine where ano = '$anoAtual' and d.idperiodo = 25";
            $q3q = mysqli_query($conn, $sql3q);
            $rows3q = mysqli_num_rows($q3q);
            
            $sqlInd3q = "SELECT * FROM `desempenho` where ano = '$anoAtual' and idperiodo = 25";
            $queryInd3q = mysqli_query($conn, $sqlInd3q);
            $rowsInd3q = mysqli_num_rows($queryInd3q);
            $rsInd3q = mysqli_fetch_array($queryInd3q);
            if($rsInd3q){
                do{
                    $somaPreCons3q += $rsInd3q['prenatal_consultas'];
                    $somaPreSif3q += $rsInd3q['prenatal_sifilis_hiv'];
                    $somaCitop3q += $rsInd3q['cobertura_citopatologico'];
                    $somaHiper3q += $rsInd3q['hipertensao'];
                    $somaDiab3q += $rsInd3q['diabetes'];
                    $ctPreCons3q++;
                    $ctPreSif3q++;
                    $ctCitop3q++;
                    $ctHiper3q++;
                    $ctDiab3q++;
                    if($rsInd3q['prenatal_consultas'] > 45.00){
                        $qtdMetaPreCons3q++;
                    }
                    if($rsInd3q['prenatal_sifilis_hiv'] > 60.00){
                        $qtdMetaPreSif3q++;
                    }
                    if($rsInd3q['cobertura_citopatologico'] > 40.00){
                        $qtdMetaCitop3q++;
                    }
                    if($rsInd3q['hipertensao'] > 50.00){
                        $qtdMetaHiper3q++;
                    }
                    if($rsInd3q['diabetes'] > 50.00){
                        $qtdMetaDiab3q++;
                    }
                }while($rsInd3q = mysqli_fetch_array($queryInd3q));
                $mediaPreCons3q = round(($somaPreCons3q/$rowsInd3q),2);
                $mediaPreSif3q = round(($somaPreSif3q/$rowsInd3q),2);
                $mediaCitop3q = round(($somaCitop3q/$rowsInd3q),2);
                $mediaHiper3q = round(($somaHiper3q/$rowsInd3q),2);
                $mediaDiab3q = round(($somaDiab3q/$rowsInd3q),2);
                $metaPreCons3q = round(($qtdMetaPreCons3q/$ctPreCons3q)*100,2);
                $metaPreSif3q = round(($qtdMetaPreSif3q/$ctPreSif3q)*100,2);
                $metaCitop3q = round(($qtdMetaCitop3q/$ctCitop3q)*100,2);
                $metaHiper3q = round(($qtdMetaHiper3q/$ctHiper3q)*100,2);
                $metaDiab3q= round(($qtdMetaDiab3q/$ctDiab3q)*100,2);
            }
            ?>
            <div class="col-md-12 shadow rounded pt-2 mb-2">
                <div class="row p-2">
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold mb-3">Média de todos os indicadores por quadrimestre no ano <?= $anoAtual ?></h6>
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
                        <div class="row mt-2 p-2">
                            <div class="col-md-4 shadow rounded mt-3 pt-2 pr-3 pl-3">
                                <div class="row mt-2 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold btn-sm">1º Quadrimestre: <?= $rows1q ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -2%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold text-center">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaPreCons1q<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaPreCons1q<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaPreCons1q<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                             <?= str_replace(".", ",", $mediaPreCons1q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaPreCons1q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaPreCons1q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaPreSif1q<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaPreSif1q<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaPreSif1q<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaPreSif1q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaPreSif1q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaPreSif1q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaCitop1q<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCitop1q<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCitop1q<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCitop1q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaCitop1q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaCitop1q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaHiper1q<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaHiper1q<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaHiper1q<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaHiper1q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaHiper1q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaHiper1q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaDiab1q<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaDiab1q<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaDiab1q<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaDiab1q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaDiab1q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaDiab1q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 shadow rounded mt-3 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">2º Quadrimestre: <?= $rows2q ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold text-center">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaPreCons2q<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaPreCons2q<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaPreCons2q<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaPreCons2q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaPreCons2q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaPreCons2q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaPreSif2q<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaPreSif2q<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaPreSif2q<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaPreSif2q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaPreSif2q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaPreSif2q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaCitop2q<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCitop2q<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCitop2q<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCitop2q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaCitop2q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaCitop2q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaHiper2q<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaHiper2q<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaHiper2q<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaHiper2q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaHiper2q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaHiper2q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaDiab2q<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaDiab2q<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaDiab2q<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaDiab2q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaDiab2q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaDiab2q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 shadow rounded mt-3 pt-2 pr-3 pl-3">
                                <div class="row mt-3 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold">3º Quadrimestre: <?= $rows3q ?> Tutores.</h6>
                                    </div>
                                </div>
                                <hr style="margin-top: -1%;">
                                <div class="row pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-secondary small font-weight-bold text-center">Indicadores</h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd1">Pré-Natal  (6 consultas): 
                                            <label <?php 
                                            if($mediaPreCons3q<18.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaPreCons3q<31.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaPreCons3q<45.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaPreCons3q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaPreCons3q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaPreCons3q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd2">Pré-Natal (Sífilis e HIV): 
                                            <label <?php 
                                            if($mediaPreSif3q<24.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaPreSif3q<42.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaPreSif3q<60.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaPreSif3q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaPreSif3q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaPreSif3q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd3">Cobertura Citopatológico: 
                                            <label <?php 
                                            if($mediaCitop3q<16.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaCitop3q<28.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaCitop3q<40.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaCitop3q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaCitop3q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaCitop3q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd4">Hipertensão (PA Aferida): 
                                            <label <?php 
                                            if($mediaHiper3q<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaHiper3q<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaHiper3q<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaHiper3q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaHiper3q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaHiper3q) ?>% atingiram a meta</label></h6>
                                    </div>
                                </div>
                                <div class="row pl-1">
                                    <div class="col-md-7">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;' data-toggle="modal" data-target=".qd5">Diabetes (Hemoglobina Glicada): 
                                            <label <?php 
                                            if($mediaDiab3q<20.00){ ?>
                                            class="text-danger font-weight-bold"
                                            <?php }elseif($mediaDiab3q<35.00){?>
                                            class="text-warning font-weight-bold"
                                            <?php }elseif($mediaDiab3q<50.00){?>
                                            class="text-success font-weight-bold"
                                             <?php }else{?>
                                            class="text-primary font-weight-bold"
                                             <?php }?>>
                                            <?= str_replace(".", ",", $mediaDiab3q) ?>%</label></h6>
                                    </div>
                                    <div class="col-md-5">
                                        <h6 class="btn btn-light btn-sm form-control" style='font-size: 0.6em;'>
                                            <label <?php 
                                            if($qtdMetaDiab3q > 0){ ?>
                                            class="text-primary font-weight-bold"
                                            <?php }else{ ?>
                                            class="text-danger font-weight-bold"
                                            <?php } ?>>
                                            <?= str_replace(".", ",", $metaDiab3q) ?>% atingiram a meta</label></h6>
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
