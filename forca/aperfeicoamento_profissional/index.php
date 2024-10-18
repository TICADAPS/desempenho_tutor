<?php
session_start();
require __DIR__ . "/../../source/autoload.php";
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';

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
$ano = $_SESSION['ano'];
$ciclo = $_SESSION['ciclo'];
$ctap = 0;
$sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes,
 m.ine, ivs.descricao as ivs from medico m left join ivs on m.fkivs = ivs.idivs inner join aperfeicoamentoprofissional a on 
m.cpf = a.cpf and m.ibge = a.ibge and m.cnes = a.cnes and m.ine = a.ine where a.ano = '$ano' and a.ciclo = '$ciclo' order by m.nome";
$query = mysqli_query($conn, $sql);
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);
//var_dump($rs);
$contt = 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>AGSUS - Aperfeiçoamento Profissional</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Custom fonts for this template-->
        <link rel="shortcut icon" href="../../img_agsus/iconAdaps.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <style>
            /* Reduzindo o tamanho da fonte em 20% */
            body {
              font-size: 85%;
            }
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
            ul {
                margin-left: -18px;
            }
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
                max-height:450px;
                overflow-y:auto;
            }
            .table-hover tbody tr:hover td {
                background: #f0f8ff;
            }
            /* Estilizando o tooltip */
            .tooltip-inner {
                background-color: #ffffff !important; /* Fundo branco */
                color: #1432FF !important; /* Texto preto */
                border: 1px solid #dddddd; /* Borda cinza clara */
            }

            /* Remover ou ajustar a sombra do tooltip */
            .tooltip.bs-tooltip-top .arrow::before,
            .tooltip.bs-tooltip-bottom .arrow::before,
            .tooltip.bs-tooltip-left .arrow::before,
            .tooltip.bs-tooltip-right .arrow::before {
                border-top-color: #ffffff !important; /* Cor branca na seta */
                border-bottom-color: #ffffff !important; /* Para setas que apontam para cima/baixo */
                border-left-color: #ffffff !important; /* Para setas que apontam para a direita/esquerda */
                border-right-color: #ffffff !important;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-3">
                    <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-9 mt-5 ">
                    <h4 class="mb-4 font-weight-bold text-center">Unidade de Serviços em Saúde &nbsp;|&nbsp; Aperfeiçoamento Profissional</h4>
                    <h5 class="mb-4 text-primary text-center">Ano: <?= $ano ?> &nbsp;-&nbsp; <?= $ciclo ?>º Ciclo</h5>
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
                                <li class="nav-item">
                                    <a href="../index.php" class="nav-link">Inicio </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">|</a>
                                </li>
                                <!-- Navbar dropdown -->
                                <li class="nav-item dropdown">
                                    <!--<a class="nav-link dropdown-toggle" href="../relatorios/relatorio_geral_igad.php">Relatório Geral IGAD - 1º ciclo de 2023</a>-->
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Relatórios</a>
                                    <div class="dropdown-menu">
                                        <?php if ($perfil === '3' && $nivel === '1') { ?>
                                            <a class="dropdown-item" href="../../relatorios/relatorioGeralAP.php?a=<?= $ano ?>&c=<?= $ciclo ?>">Relatório Aperfeiçoamento Profissional Ano <?= $ano ?> - <?= $ciclo ?>º Ciclo</a>
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
                                        &nbsp;<img class="float-right" src="../../img/carregando.gif" width="40" height="40" />
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
                <div class="col-md-12 shadow rounded pr-2 pl-2 mb-1">
                    <div class="row p-3">
                        <div class="col-md-12 mt-2">
                            <fieldset class="form-group border pr-2 pl-2">
                                <legend class="w-auto pr-2 pl-2"><h5>Aperfeiçoamento Profissional - Tutores</h5></legend>
                                <div class="mb-3 table-responsive text-nowrap table-overflow2">
                                    <table id="dtBasicExample" class="table table-hover table-bordered table-striped rounded">
                                        <thead class="bg-gradient-dark text-white">
                                            <tr class="bg-gradient-dark text-light font-weight-bold">
                                                <?php if ($perfil === '3' && $nivel === '1') { ?>
                                                    <td class="bg-gradient-dark text-light align-middle text-center" style="width: 10%;position: sticky; top: 0px;" title="Detalhamento"><i class="fas fa-info-circle"></i></td>
                                                <?php } ?>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 40%; position: sticky; top: 0px;">TUTOR</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">CPF</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">TIPOLOGIA</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 5%;position: sticky; top: 0px;">IVS</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">MUNICÍPIO</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">UF</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">IBGE</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">CNES</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="width: 10%;position: sticky; top: 0px;">INE</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($nrrs > 0) {
                                                    do {
                                                        $contt++;
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
                                                        $cnes = $rs['cnes'];
                                                        $ine = $rs['ine'];
                                                        $ivs = strtoupper($rs['ivs']);
                                                        $datacadastro = vemdata($rs['datacadastro']);
                                                        ?>
                                                        <tr>
                                                            <?php
                                                            if ($perfil === '3' && $nivel === '1') {
                                                                //barreira para não permitir mais de um cadastro por ciclo
                                                                $sqlALD = "select * from aperfeicoamentoprofissional where cpf='$cpftratado' and ibge='$ibge' and cnes='$cnes' and ine='$ine' and ano='$ano' and ciclo='$ciclo'";
                                                                $qALD = mysqli_query($conn, $sqlALD) or die(mysqli_error($conn));
                                                                $nrALD = mysqli_num_rows($qALD);
                                                                $rsALD = mysqli_fetch_array($qALD);
//                                                    var_dump($nrALD);
                                                                $flagup = $flagparecer = $flagemail = '';
                                                                if ($nrALD > 0) {
                                                                    do {
                                                                        $idap = $rsALD['id'];
                                                                        $flagparecer = $rsALD['flagparecer'];
                                                                        $flagemail = $rsALD['flagemail'];
                                                                        $flagup = $rsALD['flagup'];
//                                                                        var_dump ("Flagemail: ".$flagemail);
//                                                                        var_dump ("Flagup: ".$flagup);
                                                                        $flagterminou = $rsALD['flagterminou'];
                                                                        $flagretorno = $rsALD['flagretorno'];
//                                                                        var_dump ("Flagretorno: ".$flagretorno);
                                                                        $flagatvld = $rsALD['flagativlongduracao'];
                                                                        if ($flagup === null) {
                                                                            $flagup = '';
                                                                        }
                                                                        if ($flagparecer === null) {
                                                                            $flagparecer = '';
                                                                        }
                                                                        if ($flagemail === null) {
                                                                            $flagemail = '';
                                                                        }
                                                                    } while ($rsALD = mysqli_fetch_array($qALD));
                                                                    if ($flagatvld !== null) {
                                                                        $ctap++;
                                                                        if ($flagterminou !== null && $flagterminou === '1') {
                                                                            ?>
                                                                        <td class=" text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Processo finalizado." target="_blank"><i class="fas fa-check text-success" ></i></a></td>
                                                                            <?php
                                                                        } elseif ($flagup === '') {
                                                                            if ($flagparecer !== '') {
                                                                                if ($flagemail !== '') {
                                                                                    ?>  
                                                                                    <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" title="Análise feita e E-Mail enviado." data-toggle="tooltip" target="_blank"><i class="fas fa-info-circle text-warning"></i></a></td>
                                                                                <?php } else { ?>
                                                                                    <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Análise feita. Falta enviar E-mail." target="_blank"><i class="fas fa-info-circle text-primary"></i></a></td>
                                                                                <?php }
                                                                            } else { ?>
                                                                                <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Formulário recebido, mas não avaliado." target="_blank"><i class="fas fa-info-circle text-dark"></i></a></td>
                                                                            <?php
                                                                            }
                                                                        } elseif ($flagup === '0') {
                                                                            if ($flagretorno === '1') {
                                                                                ?>
                                                                                <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Réplica analisada e E-Mail enviado." target="_blank"><i class="fab fa-r-project text-warning"></i></a></td>        
                                                                            <?php } else { ?>
                                                                                <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Análise feita e E-Mail enviado." target="_blank"><i class="fas fa-info-circle text-warning"></i></a></td> 
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            if ($flagretorno === '1') {
                                                                                $boolparecerqc = $boolparecergepe = $boolparecerit = false;
                                                                                $mitup = (new Source\Models\Medico_inovtecnologica())->findJItUp($idap);
                                                                                if ($mitup !== null) {
                                                                                    foreach ($mitup as $mi) {
                                                                                        if ($mi->pareceruser !== null) {
                                                                                            $boolparecerit = true;
                                                                                        } else {
                                                                                            $boolparecerit = false;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                }
                                                                                $mgepeup = (new Source\Models\Medico_gesenspesext())->findJGepeUp($idap);
                                                                                if ($mgepeup !== null) {
                                                                                    foreach ($mgepeup as $mg) {
                                                                                        if ($mg->pareceruser !== null) {
                                                                                            $boolparecergepe = true;
                                                                                        } else {
                                                                                            $boolparecergepe = false;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                }
                                                                                $mqcup = (new Source\Models\Medico_qualifclinica())->findJQCUp($idap);
                                                                                if ($mqcup !== null) {
                                                                                    foreach ($mqcup as $mq) {
                                                                                        if ($mq->pareceruser !== null) {
                                                                                            $boolparecerqc = true;
                                                                                        } else {
                                                                                            $boolparecerqc = false;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                }
//                                                                                var_dump ($boolparecerqc,$boolparecergepe,$boolparecerit);
                                                                                if ($flagemail === '0') {
                                                                                    if ($boolparecerqc === false || $boolparecergepe === false || $boolparecerit === false) {
                                                                                        ?>
                                                                                        <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Réplica recebida, mas não avalidada." target="_blank"><i class="fab fa-r-project text-dark"></i></a></td> 
                                                                                    <?php } else { ?>
                                                                                        <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Réplica analisada. Falta enviar E-mail." target="_blank"><i class="fab fa-r-project text-primary"></i></a></td>
                                                                                    <?php }
                                                                                } else { ?>
                                                                                    <td class="text-center"><a href="../detalhamento/index.php?ct=<?= $cpftratado ?>&ib=<?= $ibge ?>&c=<?= $cnes ?>&i=<?= $ine ?>&a=<?= $ano ?>&ci=<?= $ciclo ?>" class="btn btn-light btn-sm shadow-sm text-center" data-toggle="tooltip" title="Réplica analisada. E-mail enviado." target="_blank"><i class="fab fa-r-project text-warning"></i></a></td>   
                                                                                <?php }
                                                                            } else { ?>
                                                                                <td></td>
                                                                                <?php }
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                        <td></td>     
                                                                    <?php }
                                                                }
                                                            } ?>
                                                            <td><?= $nome ?></td>
                                                            <td><?= $cpf ?></td>
                                                            <td><?= $tipologia ?></td>
                                                            <td><?= $ivs ?></td>
                                                            <td><?= $municipio ?></td>
                                                            <td><?= $uf ?></td>
                                                            <td><?= $ibge ?></td>
                                                            <td><?= $cnes ?></td>
                                                            <td><?= $ine ?></td>
                                                        </tr>
                                                    <?php
                                                } while ($rs = mysqli_fetch_array($query));
                                            }else{ ?>
                                                        <tr><td colspan="10" class="bg-warning text-dark"><i class="fas fa-chevron-circle-right"></i>&nbsp; Não existem tutores para o <?= $ciclo ?>º ciclo.</td></tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="">Tutores: </label>
                                    <label class="text-info"><?= $contt ?></label>
                                </div>
                                <div class="col-sm-12">
                                    <label class="">Formulários enviados: </label>
                                    <label class="text-info"><?= $ctap ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 px-3">
            <div class="col-12">
                <i class="fas fa-info-circle text-dark"></i> <label class="text-info">&nbsp; Formulário recebido, mas não avaliado.</label>
            </div>
            <div class="col-12">
                <i class="fas fa-info-circle text-primary"></i><label class="text-info">&nbsp; Análise feita. Falta enviar E-mail.</label>
            </div>
            <div class="col-12">
                <i class="fas fa-info-circle text-warning"></i><label class="text-info">&nbsp; Análise feita e E-Mail enviado.</label>
            </div>
            <div class="col-12">
                <i class="fab fa-r-project text-dark"></i><label class="text-info">&nbsp; Réplica recebida, mas não avaliada.</label>
            </div>
            <div class="col-12">
                <i class="fab fa-r-project text-primary"></i><label class="text-info">&nbsp; Réplica analisada. Falta enviar E-mail.</label>
            </div>
            <div class="col-12">
                <i class="fab fa-r-project text-warning"></i><label class="text-info">&nbsp; Réplica analisada e E-Mail enviado.</label>
            </div>
            <div class="col-12">
                <i class="fas fa-check text-success" ></i><label class="text-info">&nbsp; Análise finalizada.</label>
            </div>
        </div>
<?php include '../../includes/footer.php'; ?>
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
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
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
    </body>
</html>