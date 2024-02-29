<?php
session_start();
include '../conexao-agsus.php';
include '../Controller_agsus/fdatas.php';
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
//if (!isset($_SESSION['cpf'])) {
//   header("Location: derruba_session.php"); exit();
//}
//$cpf = $_SESSION['cpf'];
//$cpf = '001.018.311-61';
//$cpf = '029.502.963-35';
$cpf = '091.328.314-20';
//$cpf = '106.423.006-74';

date_default_timezone_set('America/Sao_Paulo');
//$anoAtual = date('Y');
$anoAtual = 2023;
$ano = 2023;
$ciclo = 1;
$periodo = 25;
$flagincent = 0;
$cpftratado = str_replace("-", "", $cpf);
$cpftratado = str_replace(".", "", $cpftratado);
$cpftratado = str_replace(".", "", $cpftratado);
$sql = "select distinct m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes, 
    m.ine, d.iddemonstrativo, d.ano, d.ciclo, d.qualidade, d.competencias, d.aperfeicoamento, i.nivel, i.valor
    from medico m inner join demonstrativo d on m.cpf = d.fkcpf and d.fkibge = m.ibge and d.fkcnes = m.cnes and d.fkine = m.ine 
    inner join incentivo i on d.fkincentivo = i.idincentivo 
    where m.cpf = '$cpftratado' and d.ano = '$ano' and d.ciclo = '$ciclo' and i.flaginativo = '$flagincent' and d.fkperiodo = '$periodo';";
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
            $nome1 = $rs['nome'];
            $ano1 = $rs['ano'];
            $ciclo1 = $rs['ciclo'];
            $iddemonstrativo = $rs['iddemonstrativo'];
        } while ($rs1 = mysqli_fetch_array($query));
    }
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
        </style>
    </head>

    <body>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-4">
                    <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 mt-5 ">
                    <h4 class="mb-4 font-weight-bold">1º Ciclo do Programa de Avaliação de Desempenho do Tutor Médico - Ano <?= $ano1 ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>


                        <div id="menuPrincipal" class="collapse navbar-collapse pr-2 pl-2">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a href="../index.php" class="nav-link">Inicio </a>
                                </li>
                                <!-- Navbar dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Ano </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="../ano.php?c=<?= $cpftratado ?>&a=2024">2024</a>
                                        <a class="dropdown-item" href="../ano.php?c=<?= $cpftratado ?>&a=2023">2023</a>
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
                                        &nbsp;<img class="float-right" src="../img_agsus/carregando.gif" width="40" height="40" />
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav> 
                </div>
            </div>
            <div class="row p-2">
            <?php echo $_SESSION['msg'] ?>
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
                        $datacadastro = $rs['datacadastro'];
                        $ano = $rs['ano'];
                        $ciclo = $rs['ciclo'];
                        $nivel = $rs['nivel'];
                        $valor = $rs['valor'];
                        $valortext = number_format($valor, 2, ',', ' ');
                        $sql2 = "select distinct p.idperiodo, p.descricaoperiodo, d.prenatal_consultas, d.prenatal_sifilis_hiv, d.cobertura_citopatologico, 
                            d.hipertensao, d.diabetes 
                            from periodo p inner join desempenho d on p.idperiodo = d.idperiodo
                            where d.cpf = '$cpftratado' and d.ano = '$ano' and d.idperiodo = '$periodo';";
                        $query2 = mysqli_query($conn, $sql2);
                        $rs2 = mysqli_fetch_array($query2);
                        $prenatal_consultas = $prenatal_sifilis_hiv = $cobertura_citopatologico = $hipertensao = $diabetes = 0;
                        if($rs2){
                            $periodo = $rs2['descricaoperiodo'];
                            $idperiodo = $rs2['idperiodo'];
                            $prenatal_consultas = $rs2['prenatal_consultas'];
    //                        var_dump("prenatal_consultas",$prenatal_consultas);
                            $prenatal_consultas = $prenatal_consultas/45;
    //                        var_dump("prenatal_consultas-Fator",$prenatal_consultas);
                            $prenatal_sifilis_hiv = $rs2['prenatal_sifilis_hiv'];
    //                        var_dump("prenatal_sifilis_hiv",$prenatal_sifilis_hiv);
                            $prenatal_sifilis_hiv = $prenatal_sifilis_hiv/60;
    //                        var_dump("prenatal_sifilis_hiv-Fator",$prenatal_sifilis_hiv);
                            $cobertura_citopatologico = $rs2['cobertura_citopatologico'];
    //                        var_dump("cobertura_citopatologico",$cobertura_citopatologico);
                            $cobertura_citopatologico = $cobertura_citopatologico/40;
    //                        var_dump("cobertura_citopatologico-Fator",$cobertura_citopatologico);
                            $hipertensao = $rs2['hipertensao'];
    //                        var_dump("hipertensao",$hipertensao);
                            $hipertensao = $hipertensao/50;
    //                        var_dump("hipertensao-Fator",$hipertensao);
                            $hipertensaotext = str_replace(",", "", $hipertensao);
                            $hipertensaotext = str_replace(".", ",", $hipertensaotext);
                            $diabetes = $rs2['diabetes'];
    //                        var_dump("diabetes",$diabetes);
                            $diabetes = $diabetes/50;
    //                        var_dump("diabetes-Fator",$diabetes);
                            $diabetestext = str_replace(",", "", $diabetes);
                            $diabetestext = str_replace(".", ",", $diabetestext);
                        }
                        
                        
                        //proporção da Qualidade assistencial
                        $qa = ($prenatal_consultas + $prenatal_sifilis_hiv + $cobertura_citopatologico + $hipertensao + $diabetes)*10;
                        $qa = round(($qa * 0.5),2);
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
                                            <div class="col-md-12 shadow rounded p-5">
                                                <div class="row" >
                                                    <div class="col-md-8 mb-1">
                                                        <label class="font-weight-bold text-info">Nome: </label><label class="font-weight-bold  text-info"> &nbsp;<?= $nome ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font-weight-bold text-info">CPF: </label><label class="text-info"> &nbsp;&nbsp;<?= $cpf ?></label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="font-weight-bold">Município-UF: </label><label>&nbsp;&nbsp;<?php echo "$municipio-$uf"; ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font-weight-bold">Cargo: </label><label> &nbsp;&nbsp;<?= $cargo ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font-weight-bold">Tipologia: </label><label> &nbsp;&nbsp;<?= $tipologia ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font-weight-bold">CNES: </label><label>&nbsp;&nbsp;<?= $cnes ?></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="font-weight-bold">INE: </label><label>&nbsp;&nbsp;<?= $ine ?></label>
                                                    </div>
<!--                                                    <div class="col-md-4">
                                                        <fieldset class="border rounded pr-3 pl-3"><legend>Incentivo de Desempenho</legend>
                                                            <div class="row">
                                                                <div class="col-md-12"><label class="font-weight-bold">Nível: </label><label>&nbsp;&nbsp;<?= $nivel ?></label></div>
                                                                <div class="col-md-12"><label class="font-weight-bold">Valor: </label><label>&nbsp;&nbsp;R$ <?= $valortext ?></label></div>
                                                            </div>
                                                        </fieldset>
                                                    </div>-->
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
<!--                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-1 mb-3">
                                                                <div class="card bg-gradient-secondary" >
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-11">
                                                                                <h6 class="card-title small text-white font-weight-bold">Indicador Global da Avaliação de Desempenho - IGAD: <?= $mftext ?>%</h6>
                                                                                <p class="card-text small text-white">
                                                                                    Incentivo de Desempenho Adquirido: <label class="text-info">R$ <?php echo number_format(round((($valor * $mf)/100),2), 2, ',', '.'); ?></label>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <i class="fas fa-user-md text-white"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>-->
                                                    <div class="col-md-12 pl-3 pr-4 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-1 mb-3">
                                                                <div class="card" style="background-color: #1160AD;">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-10">
                                                                                <h6 class="card-title small text-white font-weight-bold">Qualidade Assistencial: <?= $qatext ?>%</h6>
                                                                                <p class="card-text small text-white">Detalhes...</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <img src="../icones/qualidade_assistencial_branco.png" style="width: 130%; opacity: 0.8;" >
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
                                                                            <div class="col-md-10">
                                                                                <h6 class="card-title small text-white font-weight-bold">Qualidade Tutoria: <?= $qnotatext ?>%</h6>
                                                                                <p class="card-text small text-white">Detalhes...</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <img src="../icones/qualidade_branco.png" style="width: 130%; opacity: 0.8;" >
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
                                                                            <div class="col-md-10">
                                                                                <h6 class="card-title small text-white font-weight-bold">Aperfeiçoamento Profissional: <?= $anotatext ?>%</h6>
                                                                                <p class="card-text small text-white">Detalhes...</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <img src="../icones/aperficoamento_branco.png" style="width: 130%; opacity: 0.8;" >
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
                                                                            <div class="col-md-10">
                                                                                <h6 class="card-title small text-white font-weight-bold">Competências Profissionais: <?= $cpossuitext ?>%</h6>
                                                                                <p class="card-text small text-white">Detalhes...</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <img src="../icones/competencias_branco.png" style="width: 130%; opacity: 0.8;" >
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
                                                                            <div class="col-md-10">
                                                                                <h6 class="card-title small text-dark font-weight-bold">Deixou de pontuar: <?= $faltamtext ?>%</h6>
                                                                                <p class="card-text small text-dark">Detalhes...</p>
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <img src="../icones/deixou_de_pontuar_branco.png" style="width: 130%; opacity: 0.8;" >
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
                                                                            <div class="card-body">
                                                                                <h6 class="card-title font-weight-bold text-info">Indicador Global da Avaliação de Desempenho - IGAD</h6>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <div class="box">
                                                                                            <div class="chart" data-percent="<?= $mf ?>" data-scale-color="#ffb400"><?= $mftext ?>%</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="card-text small mt-3">
                                                                                    Incentivo de Desempenho Adquirido: <label class="text-info">R$ <?php echo number_format(round((($valor * $mf)/100),2), 2, ',', '.'); ?></label>
                                                                                </p>
                                                                            </div>
                                                                          </div>
                                                                    </div>
                                                                </div>
                                                            </div>
<!--                                                            <div class="col-md-12 shadow rounded p-2 mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                              Featured
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <h6 class="card-title font-weight-bold">Special title treatment</h6>
                                                                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                                            </div>
                                                                          </div>
                                                                    </div>
                                                                </div>
                                                            </div>-->
                                                            <div class="col-md-12 shadow rounded p-2 mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6>Constestação</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <?php
                                                                                $sqlc = "select * from contestacao where fkdemonstrativo = '$iddemonstrativo'";
                                                                                $queryc = mysqli_query($conn, $sqlc);
                                                                                $nrrsc = mysqli_num_rows($queryc);
                                                                                $rsc = mysqli_fetch_array($queryc);
                                                                                if($nrrsc === 0){
                                                                                ?> 
                                                                                <p>Descrição...</p>
                                                                                <button type="button" data-toggle="modal" data-target=".modalContestacao" class="btn btn-warning shadow-sm "><i class="fas fa-arrow-circle-right"></i> &nbsp;FAZER CONTESTAÇÃO</button>
                                                                                <?php }else{ ?>
                                                                                    <?php
                                                                                    do{
                                                                                        echo "Contestação do Médico Tutor: &nbsp;".$rsc['texto']."<br><br>";
                                                                                        echo "Contestação enviada em: &nbsp;".vemdata($rsc['datahora'])."<br><br>";
                                                                                        if($rsc['flagresposta'] === '0'){
                                                                                            echo "<label class='text-danger'>* Em análise.</label>";
                                                                                        }else{
                                                                                            echo "Resposta da Contestação: &nbsp;".$rsc['resposta']."<br>";
                                                                                        }
                                                                                    }while ($rsc = mysqli_fetch_array($queryc));
                                                                                    ?>
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
                                                    <div class="col-md-12 pl-5 pr-3">
                                                        <div class="row">
                                                            <div class="col-md-12 shadow rounded p-2 mb-2">
                                                                <div class="card">
                                                                <div class="row p-3">
                                                                    <div class="col-md-12 mt-3 mb-4">
                                                                        <figure class="highcharts-figure">
                                                                            <div id="container"></div>
                                                                            <p class="highcharts-description">
                                                                              <i>*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</i>
                                                                            </p>
                                                                        </figure>
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
                            <!-- modal modalContestacao -->
                            <div class="modal fad modalContestacao mt-2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <form method="post" action="../Controller_agsus/contestacao.php">
                                <div class="modal-dialog mw-100 w-75">
                                    <div class="modal-content">
                                        <input type="hidden" name="iddemonstrativo" value="<?= $iddemonstrativo ?>">
                                        <input type="hidden" name="cpf" value="<?= $cpftratado ?>">
                                        <input type="hidden" name="ibge" value="<?= $ibge ?>">
                                        <input type="hidden" name="cnes" value="<?= $cnes ?>">
                                        <input type="hidden" name="ine" value="<?= $ine ?>">
                                        <div class="modal-header bg-light">
                                            <div class="col-10 mt-1">
                                                <h5 class="modal-title text-left text-primary" id="exampleModalLabel"><i class="fas fa-arrow-circle-right"></i> Formulário de Contestação</h5>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="bg-light close" data-dismiss="modal" aria-label="close">
                                                    <span aria-hidden="true">&times;</span> </button>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mt-1">
                                                <div class="col-sm-12">
                                                    <h6 class="text-dark">Registre a sua contestação</h6>
                                                    <textarea name="contestacao" class="" rows="4" style="width: 100%; resize: none;"></textarea>
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalac -->
                            <!-- modal modalaqa -->
                            <div class="modal fad modalaqa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
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
                                            <button type="button" class="font-weight-bold btn btn-primary border-light shadow-sm rounded ml-5 mr-5 ppt-2 pb-2 pl-4 pr-4" data-dismiss="modal"> OK </button>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- fim do modal modalcp -->
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
                    text: 'Indicador Global da Avaliação de Desempenho - IGAD: <?= $mftext ?>%',
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
