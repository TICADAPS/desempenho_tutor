<?php
session_start();
require __DIR__ . "/../../../source/autoload.php";
include '../../../conexao-agsus.php';
include '../../../Controller_agsus/maskCpf.php';
include '../../../Controller_agsus/fdatas.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
$id = $_REQUEST['id'];
$perfil = '3';
$nivel = '1';
$cp = (new Source\Models\Competencias_profissionais())->findById($id);
//var_dump($cp);
$ano=$ciclo=$cpf=$ibge=$cnes=$ine='';
if($cp !== null){
    $ano = $cp->ano;
    $ciclo = $cp->ciclo;
    $cpf = $cp->cpf;
    $ibge = $cp->ibge;
    $cnes = $cp->cnes;
    $ine = $cp->ine;
    
    $p1_1 = $cp->p1_1;
    $p1_2 = $cp->p1_2;
    $p1_3 = $cp->p1_3;
    $p1_4 = $cp->p1_4;
    $p1_5 = $cp->p1_5;
    $p2_1 = $cp->p2_1;
    $p2_2 = $cp->p2_2;
    $p2_3 = $cp->p2_3;
    $p2_4 = $cp->p2_4;
    $p2_5 = $cp->p2_5;
    $p3_1 = $cp->p3_1;
    $p3_2 = $cp->p3_2;
    $p3_3 = $cp->p3_3;
    $p4_1 = $cp->p4_1;
    $p4_2 = $cp->p4_2;
    $p4_3 = $cp->p4_3;
    $p4_4 = $cp->p4_4;
    $p5_1 = $cp->p5_1;
    $p5_2 = $cp->p5_2;
    $p5_3 = $cp->p5_3;
    $p5_4 = $cp->p5_4;
    $p6_1 = $cp->p6_1;
    $p6_2 = $cp->p6_2;
    $p6_3 = $cp->p6_3;
    $p7_1 = $cp->p7_1;
    $p7_2 = $cp->p7_2;
    $p7_3 = $cp->p7_3;
    $p7_4 = $cp->p7_4;
    $p7_5 = $cp->p7_5;
    $p8_1 = $cp->p8_1;
    $p8_2 = $cp->p8_2;
    $p8_3 = $cp->p8_3;
    $p8_4 = $cp->p8_4;
    $p9_1 = $cp->p9_1;
    $p9_2 = $cp->p9_2;
    $p9_3 = $cp->p9_3;
    $p9_4 = $cp->p9_4;
    $r1_1 = $cp->r1_1;
    $r1_2 = $cp->r1_2;
    $r1_3 = $cp->r1_3;
    $r1_4 = $cp->r1_4;
    $r1_5 = $cp->r1_5;
    $r2_1 = $cp->r2_1;
    $r2_2 = $cp->r2_2;
    $r2_3 = $cp->r2_3;
    $r2_4 = $cp->r2_4;
    $r2_5 = $cp->r2_5;
    $r3_1 = $cp->r3_1;
    $r3_2 = $cp->r3_2;
    $r3_3 = $cp->r3_3;
    $r4_1 = $cp->r4_1;
    $r4_2 = $cp->r4_2;
    $r4_3 = $cp->r4_3;
    $r4_4 = $cp->r4_4;
    $r5_1 = $cp->r5_1;
    $r5_2 = $cp->r5_2;
    $r5_3 = $cp->r5_3;
    $r5_4 = $cp->r5_4;
    $r6_1 = $cp->r6_1;
    $r6_2 = $cp->r6_2;
    $r6_3 = $cp->r6_3;
    $r7_1 = $cp->r7_1;
    $r7_2 = $cp->r7_2;
    $r7_3 = $cp->r7_3;
    $r7_4 = $cp->r7_4;
    $r7_5 = $cp->r7_5;
    $r8_1 = $cp->r8_1;
    $r8_2 = $cp->r8_2;
    $r8_3 = $cp->r8_3;
    $r8_4 = $cp->r8_4;
    $r9_1 = $cp->r9_1;
    $r9_2 = $cp->r9_2;
    $r9_3 = $cp->r9_3;
    $r9_4 = $cp->r9_4;
    $dthrenvio = $cp->dthrenvio;
    $dthrenvemail = $cp->dthrenvemail;
    $flagenvemail = $cp->flagenvemail;
    $flagenvio = $cp->flagenvio;
}
if($flagenvio !== null && $flagenvio !== '' && $flagenvio === '1'){
    $dthrenvio = vemdata($dthrenvio).", às ". hora2($dthrenvio);
}
if($flagenvemail !== null && $flagenvemail !== '' && $flagenvemail === '1'){
    $dthrenvemail = "E-Mail enviado: ".vemdata($dthrenvemail).", às ". hora2($dthrenvemail);
}
$cpfmask = mask($cpf, "###.###.###-##");
$sql = "select m.nome, m.admissao, m.cargo, mun.Municipio, e.UF, ivs.descricao 
    from medico m inner join competencias_profissionais cp on m.cpf = cp.cpf and 
    m.ibge = cp.ibge and m.cnes = cp.cnes and m.ine = cp.ine 
    inner join municipio mun on mun.cod_munc = m.ibge 
    inner join estado e on mun.Estado_cod_uf = e.cod_uf 
    inner join ivs on ivs.idivs = m.fkivs 
    where m.cpf = '$cpf' and m.ibge = '$ibge' and m.cnes = '$cnes' and m.ine = '$ine' "
        . "and cp.ano = '$ano' and cp.ciclo='$ciclo'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);
$municipioO = $ufO = $flagemail = $dthremail = "";
if($rs){
    do{
        $medico = $rs['nome'];
        $admissao = $rs['admissao'];
        $cargo = $rs['cargo'];
        $municipioO = $rs['Municipio'];
        $ufO = $rs['UF'];
        $ivs = $rs['descricao'];
    }while ($rs = mysqli_fetch_array($query));
}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>AGSUS - Competências Profissionais</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrcp.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        <!-- Custom fonts for this template-->
        <link rel="shortcut icon" href="../../../img_agsus/iconAdaps.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrcp.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrcp.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Custom styles for this template-->
        <link href="../../../css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="../../../js/highcharts.js"></script>
        <script src="../../../js/highcharts-3d.js"></script>
        <script src="../../../js/accessibility.js"></script>
        <script src="../../../js/jquery.easypiechart.js"></script>
        <script src="../../../js/jquery.easypiechart2.js"></script>
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
                max-height:450px;
                overflow-y:auto;
            }
            .table-hover tbody tr:hover td {
                background: #f0f8ff;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3">
                    <img src="../../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-9 mt-5 ">
                    <h4 class="mb-4 font-weight-bold text-center">Unidade de Serviços em Saúde &nbsp;|&nbsp; Competências Profissionais</h4>
                    <h5 class="mb-4 text-primary text-center">Ano: <?= $ano ?> &nbsp;-&nbsp; <?= $ciclo ?>º Ciclo</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-1">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <div id="menuPrincipal" class="collapse navbar-collapse pr-2 pl-3">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a href="../index.php" class="nav-link">&nbsp;Inicio </a>
                                </li>
                                <!-- Navbar dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">&nbsp;Relatórios</a>
                                    <div class="dropdown-menu">
                                        <?php if($perfil === '3' && $nivel === '1'){ ?>
                                        <a class="dropdown-item" href="relatorios/relatorioCP.php?id=<?= $id ?>">Planilha</a>
                                        <?php } ?>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../derruba_session.php">&nbsp;&nbsp;<i class="fas fa-sign-out-alt pt-1"></i></a>
                                </li>
                                <li class="nav-item">
                                    <div id="loading">
                                        &nbsp;&nbsp;<img class="float-right" src="../../../img/carregando.gif" width="40" height="40" />
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav> 
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="msg"></div>
                </div>
            </div>
            <?php
            if($nrrs > 0){
            ?>
            <div class="row p-3">
                <div class="col-md-12 shadow rounded mb-1 p-3">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #4BA439;">
                                    <b>Dados do Tutor</b>
                                </div>
                                <div class="card-body px-4">
                                    <div class="row mb-1">
                                      <div class="col-md-5">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>Nome: </b><?= $medico ?></li>
                                          </ul>
                                      </div>
                                      <div class="col-md-2">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>CPF: </b><?= $cpfmask ?></li>
                                          </ul>
                                      </div>
                                      <div class="col-md-2">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>Cargo: </b><?= $cargo ?></li>
                                          </ul>
                                      </div>
                                      <div class="col-md-3">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>Admissão: </b><?= $admissao ?></li>
                                          </ul>
                                      </div>
                                    </div>
                                    <div class="row mb-1">
                                      <div class="col-md-5">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>Munic. Origem: </b><?= $municipioO ?>-<?= $ufO ?></li>
                                          </ul>
                                      </div>
                                      <div class="col-md-2">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>CNES: </b><?= $cnes ?></li>
                                          </ul>
                                      </div>
                                      <div class="col-md-2">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>INE: </b><?= $ine ?></li>
                                          </ul>
                                      </div>
                                      <div class="col-md-3">
                                          <ul class="list-group">
                                              <li class="list-group-item bg-light"><b>IVS: </b><?= $ivs ?></li>
                                          </ul>
                                      </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                        <?php
                        if($nrrs > 0 && $flagenvio === '1'){
                        ?>
                        <div class="col-md-12 mt-1">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #4BA439;">
                                    <b>Competências Profissionais - Autoavaliação</b>&nbsp;<a href="./../relatorios/cppdf.php?id=<?= $id ?>" target="_blank" class="btn btn-light float-right"><i class="far fa-file-pdf text-danger"></i></a>
                                </div>
                                <div class="card-body">
                                  <div class="row mb-1">
                                      <div class="col-md-12">
                                          <div id="p1" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">1.0 - PROFISSIONALISMO</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p1_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p1_1 ?></div>
                                          <?php
                                          switch($r1_1){
                                            case '1': $r1_1 = "1- Não atendo"; break;
                                            case '2': $r1_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_1 = "4- Atendo plenamente"; break;
                                            case '5': $r1_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r1_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r1_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p1_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p1_2 ?></div>
                                          <?php
                                          switch($r1_2){
                                            case '1': $r1_2 = "1- Não atendo"; break;
                                            case '2': $r1_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_2 = "4- Atendo plenamente"; break;
                                            case '5': $r1_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r1_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r1_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p1_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p1_3 ?></div>
                                          <?php
                                          switch($r1_3){
                                            case '1': $r1_3 = "1- Não atendo"; break;
                                            case '2': $r1_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_3 = "4- Atendo plenamente"; break;
                                            case '5': $r1_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r1_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r1_3 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p1_4" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p1_4 ?></div>
                                          <?php
                                          switch($r1_4){
                                            case '1': $r1_4 = "1- Não atendo"; break;
                                            case '2': $r1_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_4 = "4- Atendo plenamente"; break;
                                            case '5': $r1_4 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r1_4" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r1_4 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p1_5" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p1_5 ?></div>
                                          <?php
                                          switch($r1_5){
                                            case '1': $r1_5 = "1- Não atendo"; break;
                                            case '2': $r1_5 = "2- Atendo parcialmente"; break;
                                            case '3': $r1_5 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r1_5 = "4- Atendo plenamente"; break;
                                            case '5': $r1_5 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r1_5" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r1_5 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p2" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">2.0 - COMUNICAÇÃO</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p2_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p2_1 ?></div>
                                          <?php
                                          switch($r2_1){
                                            case '1': $r2_1 = "1- Não atendo"; break;
                                            case '2': $r2_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_1 = "4- Atendo plenamente"; break;
                                            case '5': $r2_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r2_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r2_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p2_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p2_2 ?></div>
                                          <?php
                                          switch($r2_2){
                                            case '1': $r2_2 = "1- Não atendo"; break;
                                            case '2': $r2_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_2 = "4- Atendo plenamente"; break;
                                            case '5': $r2_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r2_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r2_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p2_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p2_3 ?></div>
                                          <?php
                                          switch($r2_3){
                                            case '1': $r2_3 = "1- Não atendo"; break;
                                            case '2': $r2_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_3 = "4- Atendo plenamente"; break;
                                            case '5': $r2_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r2_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r2_3 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p2_4" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p2_4 ?></div>
                                          <?php
                                          switch($r2_4){
                                            case '1': $r2_4 = "1- Não atendo"; break;
                                            case '2': $r2_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_4 = "4- Atendo plenamente"; break;
                                            case '5': $r2_4 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r2_4" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r2_4 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p2_5" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p2_5 ?></div>
                                          <?php
                                          switch($r2_5){
                                            case '1': $r2_5 = "1- Não atendo"; break;
                                            case '2': $r2_5 = "2- Atendo parcialmente"; break;
                                            case '3': $r2_5 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r2_5 = "4- Atendo plenamente"; break;
                                            case '5': $r2_5 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r2_5" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r2_5 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p3" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">3.0 - LIDERANÇA</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p3_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p3_1 ?></div>
                                          <?php
                                          switch($r3_1){
                                            case '1': $r3_1 = "1- Não atendo"; break;
                                            case '2': $r3_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r3_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r3_1 = "4- Atendo plenamente"; break;
                                            case '5': $r3_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r3_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r3_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p2_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p3_2 ?></div>
                                          <?php
                                          switch($r3_2){
                                            case '1': $r3_2 = "1- Não atendo"; break;
                                            case '2': $r3_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r3_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r3_2 = "4- Atendo plenamente"; break;
                                            case '5': $r3_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r3_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r3_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p3_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p3_3 ?></div>
                                          <?php
                                          switch($r3_3){
                                            case '1': $r3_3 = "1- Não atendo"; break;
                                            case '2': $r3_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r3_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r3_3 = "4- Atendo plenamente"; break;
                                            case '5': $r3_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r3_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r3_3 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p4" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">4.0 - GOVERNANÇA CLÍNICA</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p4_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p4_1 ?></div>
                                          <?php
                                          switch($r4_1){
                                            case '1': $r4_1 = "1- Não atendo"; break;
                                            case '2': $r4_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_1 = "4- Atendo plenamente"; break;
                                            case '5': $r4_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r4_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r4_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p4_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p4_2 ?></div>
                                          <?php
                                          switch($r4_2){
                                            case '1': $r4_2 = "1- Não atendo"; break;
                                            case '2': $r4_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_2 = "4- Atendo plenamente"; break;
                                            case '5': $r4_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r4_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r4_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p4_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p4_3 ?></div>
                                          <?php
                                          switch($r4_3){
                                            case '1': $r4_3 = "1- Não atendo"; break;
                                            case '2': $r4_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_3 = "4- Atendo plenamente"; break;
                                            case '5': $r4_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r4_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r4_3 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p4_4" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p4_4 ?></div>
                                          <?php
                                          switch($r4_4){
                                            case '1': $r4_4 = "1- Não atendo"; break;
                                            case '2': $r4_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r4_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r4_4 = "4- Atendo plenamente"; break;
                                            case '5': $r4_4 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r4_4" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r4_4 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p5" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">5.0 - ADVOCACIA PELA SAÚDE</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p5_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p5_1 ?></div>
                                          <?php
                                          switch($r5_1){
                                            case '1': $r5_1 = "1- Não atendo"; break;
                                            case '2': $r5_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_1 = "4- Atendo plenamente"; break;
                                            case '5': $r5_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r5_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r5_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p5_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p5_2 ?></div>
                                          <?php
                                          switch($r5_2){
                                            case '1': $r5_2 = "1- Não atendo"; break;
                                            case '2': $r5_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_2 = "4- Atendo plenamente"; break;
                                            case '5': $r5_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r5_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r5_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p5_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p5_3 ?></div>
                                          <?php
                                          switch($r5_3){
                                            case '1': $r5_3 = "1- Não atendo"; break;
                                            case '2': $r5_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_3 = "4- Atendo plenamente"; break;
                                            case '5': $r5_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r5_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r5_3 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p5_4" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p5_4 ?></div>
                                          <?php
                                          switch($r5_4){
                                            case '1': $r5_4 = "1- Não atendo"; break;
                                            case '2': $r5_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r5_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r5_4 = "4- Atendo plenamente"; break;
                                            case '5': $r5_4 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r4_4" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r4_4 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p6" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">6.0 - DEDICAÇÃO ACADÊMICA</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p6_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p6_1 ?></div>
                                          <?php
                                          switch($r6_1){
                                            case '1': $r6_1 = "1- Não atendo"; break;
                                            case '2': $r6_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r6_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r6_1 = "4- Atendo plenamente"; break;
                                            case '5': $r6_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r6_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r6_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p6_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p6_2 ?></div>
                                          <?php
                                          switch($r6_2){
                                            case '1': $r6_2 = "1- Não atendo"; break;
                                            case '2': $r6_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r6_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r6_2 = "4- Atendo plenamente"; break;
                                            case '5': $r6_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r6_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r6_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p6_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p6_3 ?></div>
                                          <?php
                                          switch($r6_3){
                                            case '1': $r6_3 = "1- Não atendo"; break;
                                            case '2': $r6_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r6_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r6_3 = "4- Atendo plenamente"; break;
                                            case '5': $r6_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r6_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r6_3 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p7" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">7.0 - COLABORAÇÃO</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p7_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p7_1 ?></div>
                                          <?php
                                          switch($r7_1){
                                            case '1': $r7_1 = "1- Não atendo"; break;
                                            case '2': $r7_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_1 = "4- Atendo plenamente"; break;
                                            case '5': $r7_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r7_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r7_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p7_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p7_2 ?></div>
                                          <?php
                                          switch($r7_2){
                                            case '1': $r7_2 = "1- Não atendo"; break;
                                            case '2': $r7_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_2 = "4- Atendo plenamente"; break;
                                            case '5': $r7_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r7_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r7_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p7_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p7_3 ?></div>
                                          <?php
                                          switch($r7_3){
                                            case '1': $r7_3 = "1- Não atendo"; break;
                                            case '2': $r7_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_3 = "4- Atendo plenamente"; break;
                                            case '5': $r7_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r7_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r7_3 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p7_4" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p7_4 ?></div>
                                          <?php
                                          switch($r7_4){
                                            case '1': $r7_4 = "1- Não atendo"; break;
                                            case '2': $r7_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_4 = "4- Atendo plenamente"; break;
                                            case '5': $r7_4 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r7_4" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r7_4 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p7_5" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p7_5 ?></div>
                                          <?php
                                          switch($r7_5){
                                            case '1': $r7_5 = "1- Não atendo"; break;
                                            case '2': $r7_5 = "2- Atendo parcialmente"; break;
                                            case '3': $r7_5 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r7_5 = "4- Atendo plenamente"; break;
                                            case '5': $r7_5 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r7_5" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r7_5 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p8" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">8.0 - CONDUTA ÉTICA E RESPEITOSA</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p8_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p8_1 ?></div>
                                          <?php
                                          switch($r8_1){
                                            case '1': $r8_1 = "1- Não atendo"; break;
                                            case '2': $r8_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_1 = "4- Atendo plenamente"; break;
                                            case '5': $r8_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r8_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r8_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p8_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p8_2 ?></div>
                                          <?php
                                          switch($r8_2){
                                            case '1': $r8_2 = "1- Não atendo"; break;
                                            case '2': $r8_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_2 = "4- Atendo plenamente"; break;
                                            case '5': $r8_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r8_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r8_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p8_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p8_3 ?></div>
                                          <?php
                                          switch($r8_3){
                                            case '1': $r8_3 = "1- Não atendo"; break;
                                            case '2': $r8_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_3 = "4- Atendo plenamente"; break;
                                            case '5': $r8_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r8_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r8_3 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p8_4" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p8_4 ?></div>
                                          <?php
                                          switch($r8_4){
                                            case '1': $r8_4 = "1- Não atendo"; break;
                                            case '2': $r8_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r8_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r8_4 = "4- Atendo plenamente"; break;
                                            case '5': $r8_4 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r8_4" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r8_4 ?></div>
                                      </div>
                                      <div class="col-md-12">
                                          <div id="p9" class="border p-2 bg-dark text-white" style="border-top-left-radius: 4px; border-top-right-radius: 4px;">9.0 - ADERÊNCIA AO MODELO DE ATENÇÃO</div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p9_1" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p9_1 ?></div>
                                          <?php
                                          switch($r9_1){
                                            case '1': $r9_1 = "1- Não atendo"; break;
                                            case '2': $r9_1 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_1 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_1 = "4- Atendo plenamente"; break;
                                            case '5': $r9_1 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r9_1" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r9_1 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p9_2" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p9_2 ?></div>
                                          <?php
                                          switch($r9_2){
                                            case '1': $r9_2 = "1- Não atendo"; break;
                                            case '2': $r9_2 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_2 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_2 = "4- Atendo plenamente"; break;
                                            case '5': $r9_2 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r9_2" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r9_2 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-1">
                                          <div id="p9_3" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p9_3 ?></div>
                                          <?php
                                          switch($r9_3){
                                            case '1': $r9_3 = "1- Não atendo"; break;
                                            case '2': $r9_3 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_3 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_3 = "4- Atendo plenamente"; break;
                                            case '5': $r9_3 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r9_3" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r9_3 ?></div>
                                      </div>
                                      <div class="col-md-12 mb-2">
                                          <div id="p9_4" class="border p-2 bg-light" style="border-top-left-radius: 4px; border-top-right-radius: 4px;"><?= $p9_4 ?></div>
                                          <?php
                                          switch($r9_4){
                                            case '1': $r9_4 = "1- Não atendo"; break;
                                            case '2': $r9_4 = "2- Atendo parcialmente"; break;
                                            case '3': $r9_4 = "3- Atendo satisfatoriamente"; break;
                                            case '4': $r9_4 = "4- Atendo plenamente"; break;
                                            case '5': $r9_4 = "5- Supero as expectativas"; break;
                                          }
                                          ?>
                                          <div id="r9_4" class="border p-2" style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"><i class="fas fa-arrow-circle-right text-info"></i>&nbsp; <?= $r9_4 ?></div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <a href="./../relatorios/cppdf.php?id=<?= $id ?>" target="_blank"  class="btn btn-light shadow-sm float-right"><i class="far fa-file-pdf text-danger"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php }else{ ?>
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #4BA439;">
                                    <b>Competências Profissionais - Autoavaliação</b>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-center">O tutor ainda não realizou a autoavaliação.</h5>
                                </div>
                              </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="row p-2">
                <div class="col-md-12 shadow rounded pr-2 pl-2 mb-1">
                    <div class="row p-3">
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-primary text-center">Não constam dados de competências profissionais sobre este tutor.</h5>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php include '../../../includes/footer.php'; ?>
        <!-- Bootstrap core JavaScript-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../../../vendor/jquery/jquery.min.js"></script>
        <script src="../../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../../../vendor/chart.js/Chart.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#msg").html('');
            });
            
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
//                document.getElementById("conteudo").style.display = "inline";
            }, 1000);
            
        </script>
    </body>
</html>