<?php
session_start();
include '../conexao-agsus.php';
//if (!isset($_SESSION['cpf'])) {
//   header("Location: derruba_session.php"); exit();
//}
//$cpf = $_SESSION['cpf'];
$cpf = '001.018.311-61';
date_default_timezone_set('America/Sao_Paulo');
//$anoAtual = date('Y');
$anoAtual = 2023;
$cpftratado = str_replace("-", "", $cpf);
$cpftratado = str_replace(".", "", $cpftratado);
$cpftratado = str_replace(".", "", $cpftratado);
$sql = "select m.nome, m.admissao, m.cargo, m.tipologia, m.uf, m.municipio, m.datacadastro, m.cpf, m.ibge, m.cnes, m.ine, p.descricaoperiodo, "
        . "demo.ano, demo.ciclo, d.idperiodo, d.prenatal_consultas, d.prenatal_sifilis_hiv, d.cobertura_citopatologico, d.hipertensao, d.diabetes, "
        . "q.nota as qnota, c.possui as cpossui, a.nota as anota "
        . "from medico m inner join desempenho d on m.cpf = d.cpf "
        . "inner join periodo p on p.idperiodo = d.idperiodo "
        . "inner join demonstrativo demo on demo.ano = d.demonstrativo_ano and demo.ciclo = d.demonstrativo_ciclo "
        . "left join qualidade q on q.FKcpf = m.cpf "
        . "left join aperfeicoamento a on a.medico_cpf = m.cpf "
        . "left join competencias c on c.medico_cpf = m.cpf "
        . "where m.cpf = '$cpftratado' and d.ano = 2023 and p.idperiodo = 24 and d.demonstrativo_ano = 2023 and d.demonstrativo_ciclo = 2;";
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
        <link rel="shortcut icon" href="img/iconAdaps.png"/>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
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
        </style>
    </head>

    <body>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-4">
                    <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 mt-5 ">
                    <h4 class="mb-4 font-weight-bold">Programa de Avaliação de Desempenho - Ano <?= $ano1 ?> - <?= $ciclo1 ?>º Ciclo</h4>
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
                                    <div id="loading2">
                                        &nbsp;<img class="float-right" src="../img_agsus/carregando.gif" width="40" height="40" />
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav> 
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
                        $datacadastro = $rs['datacadastro'];
                        $ano = $rs['ano'];
                        $ciclo = $rs['ciclo'];
                        $periodo = $rs['descricaoperiodo'];
                        $idperiodo = $rs['idperiodo'];
                        $prenatal_consultas = $rs['prenatal_consultas'];
//                        var_dump("prenatal_consultas",$prenatal_consultas);
                        $prenatal_consultas = $prenatal_consultas/45;
//                        var_dump("prenatal_consultas-Fator",$prenatal_consultas);
                        $prenatal_sifilis_hiv = $rs['prenatal_sifilis_hiv'];
//                        var_dump("prenatal_sifilis_hiv",$prenatal_sifilis_hiv);
                        $prenatal_sifilis_hiv = $prenatal_sifilis_hiv/60;
//                        var_dump("prenatal_sifilis_hiv-Fator",$prenatal_sifilis_hiv);
                        $cobertura_citopatologico = $rs['cobertura_citopatologico'];
//                        var_dump("cobertura_citopatologico",$cobertura_citopatologico);
                        $cobertura_citopatologico = $cobertura_citopatologico/40;
//                        var_dump("cobertura_citopatologico-Fator",$cobertura_citopatologico);
                        $hipertensao = $rs['hipertensao'];
//                        var_dump("hipertensao",$hipertensao);
                        $hipertensao = $hipertensao/50;
//                        var_dump("hipertensao-Fator",$hipertensao);
                        $hipertensaotext = str_replace(",", "", $hipertensao);
                        $hipertensaotext = str_replace(".", ",", $hipertensaotext);
                        $diabetes = $rs['diabetes'];
//                        var_dump("diabetes",$diabetes);
                        $diabetes = $diabetes/50;
//                        var_dump("diabetes-Fator",$diabetes);
                        $diabetestext = str_replace(",", "", $diabetes);
                        $diabetestext = str_replace(".", ",", $diabetestext);
                        $qa = round((($prenatal_consultas + $prenatal_sifilis_hiv + $cobertura_citopatologico + $hipertensao + $diabetes)*10),2);
                        $qatext = number_format($qa, 2, ',', ' ');
                        $qnota = $rs['qnota']/2;
//                        var_dump($qnota);
                        $qnota = (($qnota - 1)*10)/4;
                        $qnota = round($qnota,2);
                        $qnotatext = number_format($qnota, 2, ',', '.');
                        $cpossui = $rs['cpossui'];
                        if($cpossui === 'Sim'){
                            $cpossui = 30.00;
                            $cpossuitext = number_format(30, 2, ',', '.');
                        }else{
                            $cpossui = 0.00;
                            $cpossuitext = number_format(0, 2, ',', '.');
                        }
                        $anota = $rs['anota'];
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
                        $mftext = number_format($mf, 2, ',', '.');
                        ?>
                            <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3 mb-2">
                                <div class="row p-3">
                                    <div class="col-md-12 mt-3 mb-4">
                                        <div class="row mt-3 mb-2">
                                            <div class="col-md-4 mb-4">
                                                <div class="row" >
                                                                <div class="col-md-12 mb-1">
                                                                    <label class="font-weight-bold">Nome: </label><label class="font-weight-bold"> &nbsp;<?= $nome ?></label>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="font-weight-bold">CPF: </label><label> &nbsp;&nbsp;<?= $cpf ?></label>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="font-weight-bold">Município-UF: </label><label>&nbsp;&nbsp;<?php echo "$municipio-$uf"; ?></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="font-weight-bold">Cargo: </label><label> &nbsp;&nbsp;<?= $cargo ?></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="font-weight-bold">Tipologia: </label><label> &nbsp;&nbsp;<?= $tipologia ?></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="font-weight-bold">CNES: </label><label>&nbsp;&nbsp;<?= $cnes ?></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="font-weight-bold">INE: </label><label>&nbsp;&nbsp;<?= $ine ?></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="font-weight-bold">Ano: </label><label>&nbsp;&nbsp;<?= $ano ?></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="font-weight-bold">Ciclo: </label><label>&nbsp;&nbsp;<?= $ciclo ?>º</label>
                                                                </div>
                                                                <div class="col-md-6 offset-3 mt-5 mb-2">
                                                                    <label class="font-weight-bold">IGAD: </label><label class="text-danger"> &nbsp;&nbsp;<?= $mftext ?>%</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                            <div class="col-md-8 mb-3">
                                                <div class="row">
                                                    <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3 mb-2">
                                                        <div class="row p-3">
                                                            <div class="col-md-12 mt-3 mb-4">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h6 class="font-weight-bold text-center text-white bg-dark form-control" style="height: 60px;line-height: 50px;">Indicador Global da Avaliação de Desempenho - IGAD: <?= $mftext ?>%</h6>   
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2" >
                                                                        <h6 class="font-weight-bold text-center text-white bg-dark form-control" style="height: 100px;line-height: 90px;">Eixo</h6> 
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <button class="text-center btn btn-info border-light shadow-sm rounded form-control"  data-toggle="modal" title="Avaliação de Resultados" data-target=".modalar" id="modalar" style="height: 100px;">Avaliação de Resultados<br><?= $artext ?>%</button> 
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="text-center btn btn-info border-light shadow-sm rounded form-control" data-toggle="modal" data-target=".modalac" id="modalac" style="height: 100px;">Avaliação de<br>Competências<br><?= $cpossuitext ?>%</button> 
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <h6 class="font-weight-bold text-center text-white bg-dark form-control" style="height: 100px;line-height: 90px;">Domínio</h6> 
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button class="text-center btn btn-warning text-dark border-light shadow-sm rounded form-control" data-toggle="modal" data-target=".modalaqa" id="modalaqa" style="height: 100px;">Qualidade assistencial<br><?= $qatext ?>%</button> 
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="text-center btn btn-warning text-dark border-light shadow-sm rounded form-control" data-toggle="modal" data-target=".modalqt" id="modalqt" style="height: 100px;">Qualidade da<br>tutoria<br><?= $qnotatext ?>%</button> 
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <button class="text-center btn btn-warning text-dark border-light shadow-sm rounded form-control" data-toggle="modal" data-target=".modalap" id="modalap" style="height: 100px;">Aperfeiçoamento<br>profissional<br><?= $anotatext ?>%</button> 
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="text-center btn btn-warning text-dark border-light shadow-sm rounded form-control" data-toggle="modal" data-target=".modalcp" id="modalcp" style="height: 100px;">Competências<br>profissionais<br><?= $cpossuitext ?>%</button> 
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="text-danger small">* Clique  nos botões para visualizar os resultados</label> 
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
        <script src="../js/demo/chart-bar-diabetes.js"></script>
        <script>
            $(".btn_sub").click(function () {
                //console.log("clicou");
                document.getElementById("loading2").style.display = "block";
            });
            var i = setInterval(function () {
                clearInterval(i);
                // O código desejado é apenas isto:
                document.getElementById("loading2").style.display = "none";
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
            
            // myBarPrenatal
            var ctx = document.getElementById("myBarPrenatal");
            var myBarPrenatal = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($pn1 < 18) { echo "#d10e0e"; }elseif($pn1 < 31){ echo "#e6b20b"; }elseif($pn1 < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($pn2 < 18) { echo "#d10e0e"; }elseif($pn2 < 31){ echo "#e6b20b"; }elseif($pn2 < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($pn3 < 18) { echo "#d10e0e"; }elseif($pn3 < 31){ echo "#e6b20b"; }elseif($pn3 < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($pn1 < 18) { echo "#ba0a0a"; }elseif($pn1 < 31){ echo "#d2a208"; }elseif($pn1 < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($pn2 < 18) { echo "#ba0a0a"; }elseif($pn2 < 31){ echo "#d2a208"; }elseif($pn2 < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($pn3 < 18) { echo "#ba0a0a"; }elseif($pn3 < 31){ echo "#d2a208"; }elseif($pn3 < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $pn1; ?>,<?php echo $pn2; ?>,<?php echo $pn3; ?>]
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
            
            // myBarChartSifilis
            var ctx = document.getElementById("myBarChartSifilis");
            var myBarChartSifilis = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($psh1 < 24) { echo "#d10e0e"; }elseif($psh1 < 42){ echo "#e6b20b"; }elseif($psh1 < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($psh2 < 24) { echo "#d10e0e"; }elseif($psh2 < 42){ echo "#e6b20b"; }elseif($psh2 < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($psh3 < 24) { echo "#d10e0e"; }elseif($psh3 < 42){ echo "#e6b20b"; }elseif($psh3 < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($psh1 < 24) { echo "#ba0a0a"; }elseif($psh1 < 42){ echo "#d2a208"; }elseif($psh1 < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($psh2 < 24) { echo "#ba0a0a"; }elseif($psh2 < 42){ echo "#d2a208"; }elseif($psh2 < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($psh3 < 24) { echo "#ba0a0a"; }elseif($psh3 < 42){ echo "#d2a208"; }elseif($psh3 < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $psh1; ?>,<?php echo $psh2; ?>,<?php echo $psh3; ?>]
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
            
            // myBarChartCitopatologico
            var ctx = document.getElementById("myBarChartCitopatologico");
            var myBarChartCitopatologico = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($cc1 < 16) { echo "#d10e0e"; }elseif($cc1 < 28){ echo "#e6b20b"; }elseif($cc1 < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($cc2 < 16) { echo "#d10e0e"; }elseif($cc2 < 28){ echo "#e6b20b"; }elseif($cc2 < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($cc3 < 16) { echo "#d10e0e"; }elseif($cc3 < 28){ echo "#e6b20b"; }elseif($cc3 < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($cc1 < 16) { echo "#ba0a0a"; }elseif($cc1 < 28){ echo "#d2a208"; }elseif($cc1 < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($cc2 < 16) { echo "#ba0a0a"; }elseif($cc2 < 28){ echo "#d2a208"; }elseif($cc2 < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($cc3 < 16) { echo "#ba0a0a"; }elseif($cc3 < 28){ echo "#d2a208"; }elseif($cc3 < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $cc1; ?>,<?php echo $cc2; ?>,<?php echo $cc3; ?>]
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
            
            // myBarChartHipertensao
            var ctx = document.getElementById("myBarChartHipertensao");
            var myBarChartHipertensao = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($hi1 < 20) { echo "#d10e0e"; }elseif($hi1 < 35){ echo "#e6b20b"; }elseif($hi1 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($hi2 < 20) { echo "#d10e0e"; }elseif($hi2 < 35){ echo "#e6b20b"; }elseif($hi2 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($hi3 < 20) { echo "#d10e0e"; }elseif($hi3 < 35){ echo "#e6b20b"; }elseif($hi3 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($hi1 < 20) { echo "#ba0a0a"; }elseif($hi1 < 35){ echo "#d2a208"; }elseif($hi1 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($hi2 < 20) { echo "#ba0a0a"; }elseif($hi2 < 35){ echo "#d2a208"; }elseif($hi2 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($hi3 < 20) { echo "#ba0a0a"; }elseif($hi3 < 35){ echo "#d2a208"; }elseif($hi3 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $hi1; ?>,<?php echo $hi2; ?>,<?php echo $hi3; ?>]
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
            
            // myBarChartDiabetes
            var ctx = document.getElementById("myBarChartDiabetes");
            var myBarChartDiabetes = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($diab1 < 20) { echo "#d10e0e"; }elseif($diab1 < 35){ echo "#e6b20b"; }elseif($diab1 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($diab2 < 20) { echo "#d10e0e"; }elseif($diab2 < 35){ echo "#e6b20b"; }elseif($diab2 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($diab3 < 20) { echo "#d10e0e"; }elseif($diab3 < 35){ echo "#e6b20b"; }elseif($diab3 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($diab1 < 20) { echo "#ba0a0a"; }elseif($diab1 < 35){ echo "#d2a208"; }elseif($diab1 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($diab2 < 20) { echo "#ba0a0a"; }elseif($diab2 < 35){ echo "#d2a208"; }elseif($diab2 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($diab3 < 20) { echo "#ba0a0a"; }elseif($diab3 < 35){ echo "#d2a208"; }elseif($diab3 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $diab1; ?>,<?php echo $diab2; ?>,<?php echo $diab3; ?>]
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
