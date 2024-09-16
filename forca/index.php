<?php
session_start();
include '../conexao_agsus_2.php';
include '../conexao-agsus.php';
include '../Controller_agsus/maskCpf.php';
include '../Controller_agsus/fdatas.php';
//if (!isset($_SESSION['cpf'])) {
//   header("Location: ../derruba_session.php"); exit();
//}
//$cpf = $_SESSION['cpf'];
//if (!isset($_SESSION['idUser'])) {
//    header("Location: ../derruba_session.php");
//    exit();
//}
//if (!isset($_SESSION['perfil'])) {
//    header("Location: ../derruba_session.php");
//    exit();
//}
//if (!isset($_SESSION['nivel'])) {
//    header("Location: ../derruba_session.php");
//    exit();
//}
//if($_SESSION['perfil'] !== '2' && $_SESSION['perfil'] !== '3' && $_SESSION['perfil'] !== '6' && $_SESSION['perfil'] !== '7' && $_SESSION['perfil'] !== '8'){
//    header("Location: ../derruba_session.php");
//    exit();
//}
//$perfil = $_SESSION['perfil'];
//$nivel = $_SESSION['nivel'];
$perfil = '3';
$nivel = '1';
$_SESSION['perfil'] = $perfil;
$_SESSION['nivel'] = $nivel;
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
if (!isset($_SESSION['cpft'])) {
    $_SESSION['cpft'] = '';
}
if (!isset($_SESSION['nome'])) {
    $_SESSION['nome'] = '';
}
if (!isset($_SESSION['ibgeO'])) {
    $_SESSION['ibgeO'] = '';
}
if (!isset($_SESSION['cnes'])) {
    $_SESSION['cnes'] = '';
}
if (!isset($_SESSION['ine'])) {
    $_SESSION['ine'] = '';
}
if (!isset($_SESSION['ano'])) {
    $_SESSION['ano'] = '';
}
if (!isset($_SESSION['ciclo'])) {
    $_SESSION['ciclo'] = '';
}
$_SESSION["idUser"] = 2765;
//var_dump($_SESSION['msg']);
//$cpftratado = '00101831161';
//$_SESSION['cpf'] = $cpftratado;
//$cpf = substr_replace($cpftratado, "-", 9, 0);
//$cpf = substr_replace($cpf, ".", 6, 0);
//$cpf = substr_replace($cpf, ".", 3, 0);
//$medico = 'CAROLINA MILITAO SPAGNOL';
//$ibgeO = '352690';
//$cnes = '3797902';
//$ine = '1587021';
//$_SESSION['cpft'] = $cpftratado;
//$_SESSION['nome'] = $medico;
//$_SESSION['ibgeO'] = $ibgeO;
//$_SESSION['cnes'] = $cnes;
//$_SESSION['ine'] = $ine;
$sqlano = "select ano from anoacicloavaliacao group by ano";
$queryano = mysqli_query($conn, $sqlano) or die(mysqli_error($conn));
$rsano = mysqli_fetch_array($queryano);
$sqlano2 = "select ano from anoacicloavaliacao group by ano";
$queryano2 = mysqli_query($conn, $sqlano2) or die(mysqli_error($conn));
$rsano2 = mysqli_fetch_array($queryano2);
$sqlano3 = "select ano from anoacicloavaliacao group by ano";
$queryano3 = mysqli_query($conn, $sqlano3) or die(mysqli_error($conn));
$rsano3 = mysqli_fetch_array($queryano3);
$sqlano4 = "select ano from anoacicloavaliacao group by ano";
$queryano4 = mysqli_query($conn, $sqlano4) or die(mysqli_error($conn));
$rsano4 = mysqli_fetch_array($queryano4);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aperfeiçoamento Profissional</title>
        <link rel="shortcut icon" href="../img_agsus/iconAdaps.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-12 col-md-3 mt-4 pl-5">
                    <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-9 mt-5">
                    <h4 class="mb-4 font-weight-bold text-left">Unidade de Serviços em Saúde &nbsp;|&nbsp; Painel da Avaliação de Desempenho</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="menuPrincipal" class="collapse navbar-collapse">
                            <ul class="navbar-nav p-1">
                                <li class="text-secondary pl-2 pr-2"><a href="" class="btn">Início</a></li>
                                <li class="text-secondary pl-2 pr-2"><a href="./controller/derruba_session.php" class="btn"><i class="fas fa-sign-out-alt"></i></a></li>

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-12 shadow rounded pt-3 pb-3 mb-3">
                <div class="p-2">
                    <div class="card">
                        <div class="card-header" style="background-color: #0055A1; color: #fff;"><b>Avaliação de Desempenho</b></div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-3">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item active small" id="itemAtivado">
                                        <a class="nav-link" data-toggle="tab" href="#home">Domínios</a>
                                    </li>
                                    <li class="nav-item small" onclick="itemDesativado();">
                                        <a class="nav-link" data-toggle="tab" href="#menu1">Resultado da Avaliação de Desempenho</a>
                                    </li>
                                    <li class="nav-item small" onclick="itemDesativado();">
                                        <a class="nav-link" data-toggle="tab" href="#menu2">Abertura e Fechamento de Ciclo</a>
                                    </li>
<!--                                    <li class="nav-item small" onclick="itemDesativado();">
                                        <a class="nav-link" data-toggle="tab" href="#menu3">Demonstrativo</a>
                                    </li>-->
                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in show active">
                                        <div class="p-2">
                                            <div class="card border-0">
                                                <div class="card-body">
                                                    <blockquote class="blockquote mb-3">
                                                        <ul class="nav nav-tabs">
                                                            <li class="nav-item active small" id="itemAtivado">
                                                                <a class="nav-link" data-toggle="tab" href="#home2">Aperfeiçoamento Profissional</a>
                                                            </li>
                                                            <li class="nav-item small" onclick="itemDesativado();">
                                                                <a class="nav-link" data-toggle="tab" href="#menu2_1">Competências Profissionais</a>
                                                            </li>
<!--                                                            <li class="nav-item small" onclick="itemDesativado();">
                                                                <a class="nav-link" data-toggle="tab" href="#menu2">Avaliação de Competências Profissionais</a>
                                                            </li>-->
                        <!--                                    <li class="nav-item small" onclick="itemDesativado();">
                                                                <a class="nav-link" data-toggle="tab" href="#menu3">Demonstrativo</a>
                                                            </li>-->
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div id="home2" class="tab-pane fade in show active">
                                                                <div class="p-2">
                                                                    <h5 class="text-info mt-3">Aperfeiçoamento Profissional</h5>
                                                                    <div class="card ">
                                                                        <div class="card-body">
                                                                            <blockquote class="blockquote mb-3">
                                                                                <form method="post" enctype="multipart/form-data" action="./controller/lap.php">
                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12"><b>Escolha o ano:</b></div>
                                                                                            <div class="col-12">
                                                                                                <select class="form-control" name="ano" id="anoap">
                                                                                                    <option value="">[--SELECIONE--]</option>
                                                                                                    <?php
                                                                                                    if ($rsano2) {
                                                                                                        do {
                                                                                                            $ano2 = $rsano2['ano'];
                                                                                                            ?>
                                                                                                            <option><?= $ano2 ?></option>
                                                                                                            <?php
                                                                                                        } while ($rsano2 = mysqli_fetch_array($queryano2));
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                                                            <div class="col-12">
                                                                                                <select class="form-control" name="ciclo" id="cicloap">
                                                                                                    <option value="">[--SELECIONE--]</option>

                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12">&nbsp;</div>
                                                                                            <div class="col-12">
                                                                                                <button type="submit" class="btn btn-primary form-control" >Pesquisar <i class="fas fa-search"></i></button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12 text-center"><img src="./../img/aperfeicoamento.png" class="btn rounded-circle" width="60%;"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </blockquote>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="menu2_1" class="tab-pane fade">
                                                                <div class="p-2">
                                                                    <h5 class="text-info mt-3">Competências Profissionais</h5>
                                                                    <div class="card ">
                                                                        <div class="card-body">
                                                                            <blockquote class="blockquote mb-3">
                                                                                <form method="post" enctype="multipart/form-data" action="./controller/lacp.php">
                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12"><b>Escolha o ano:</b></div>
                                                                                            <div class="col-12">
                                                                                                <select class="form-control" name="ano" id="anoav">
                                                                                                    <option value="">[--SELECIONE--]</option>
                                                                                                    <?php
                                                                                                    if ($rsano3) {
                                                                                                        do {
                                                                                                            $ano3 = $rsano3['ano'];
                                                                                                            ?>
                                                                                                            <option><?= $ano3 ?></option>
                                                                                                            <?php
                                                                                                        } while ($rsano3 = mysqli_fetch_array($queryano3));
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                                                            <div class="col-12">
                                                                                                <select class="form-control" name="ciclo" id="cicloav">
                                                                                                    <option value="">[--SELECIONE--]</option>
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12">&nbsp;</div>
                                                                                            <div class="col-12">
                                                                                                <button type="submit" class="btn btn-primary form-control" >Pesquisar <i class="fas fa-search"></i></button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <div class="col-12 text-center"><img src="./../img/autoavaliacao.png" class="btn rounded-circle" width="60%;"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </blockquote>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <div class="p-2">
                                            <h5 class="text-info mt-3">Resultado da Avaliação de Desempenho</h5>
                                            <div class="card ">
                                                <div class="card-body">
                                                    <blockquote class="blockquote mb-3">
                                                        <form method="post" enctype="multipart/form-data" action="./controller/ldem.php">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="col-12"><b>Escolha o ano:</b></div>
                                                                    <div class="col-12">
                                                                        <select class="form-control" name="ano" id="anod">
                                                                            <option value="">[--SELECIONE--]</option>
                                                                            <?php
                                                                            if ($rsano4) {
                                                                                do {
                                                                                    $ano4 = $rsano4['ano'];
                                                                                    ?>
                                                                                    <option><?= $ano4 ?></option>
                                                                                    <?php
                                                                                } while ($rsano4 = mysqli_fetch_array($queryano4));
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                                    <div class="col-12">
                                                                        <select class="form-control" name="ciclo" id="ciclod">
                                                                            <option value="">[--SELECIONE--]</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="col-12"><b>Escolha o período:</b></div>
                                                                    <div class="col-12">
                                                                        <select class="form-control" name="periodo" id="periodod">
                                                                            <option value="">[--SELECIONE--]</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="col-12">&nbsp;</div>
                                                                    <div class="col-12">
                                                                        <button type="submit" id="btdemons" class="btn btn-primary form-control" >Pesquisar <i class="fas fa-search"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="col-12 text-center"><img src="./../img/desempenho2.jpg" class="btn rounded-circle border-info" width="50%;"></div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="menu2" class="tab-pane fade">
                                        <div class="p-2">
                                            <h5 class="text-info mt-3">Abertura e Fechamento de Ciclo</h5>
                                            <div class="card ">
                                                <div class="card-body">
                                                    <blockquote class="blockquote mb-3">
                                                        <form method="post" enctype="multipart/form-data" action="./controller/lafc.php">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="col-12"><b>Escolha o ano:</b></div>
                                                                    <div class="col-12">
                                                                        <select class="form-control" name="ano" id="anoav">
                                                                            <option value="">[--SELECIONE--]</option>
                                                                            <option>2024</option>
                                                                            <option>2025</option>
                                                                            <option>2026</option>
                                                                            <option>2027</option>
                                                                            <option>2028</option>
                                                                            <option>2029</option>
                                                                            <option>2030</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                                    <div class="col-12">
                                                                        <select class="form-control" name="ciclo" id="cicloav">
                                                                            <option value="">[--SELECIONE--]</option>
                                                                            <option value="1">1º Ciclo</option>
                                                                            <option value="2">2º Ciclo</option>
                                                                            <option value="3">3º Ciclo</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="col-12">&nbsp;</div>
                                                                    <div class="col-12">
                                                                        <button type="submit" class="btn btn-primary form-control" >Pesquisar <i class="fas fa-search"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="col-12 text-center"><img src="./../img/ciclo.jpg" class="btn rounded-circle" width="50%;"></div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="menu3" class="tab-pane fade">
                                        <div class="p-2">
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../includes/footer.php' ?>
        <script src="../js_agsus/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="ciclo.js"></script>
        <script>
        $(document).ready(function () {
            $("#btdemons").hide();
        });
        $("#anoap").change(function () {
            let ano = $("#anoap").val();
            addciclo(ano);
        });
        $("#anoav").change(function () {
            let ano = $("#anoav").val();
            addciclo2(ano);
        });
        $("#anod").change(function () {
            $("#btdemons").hide();
            let ano = $("#anod").val();
            addciclo3(ano);
        });
        $("#ciclod").change(function () {
            $("#btdemons").hide();
            let ano = $("#anod").val();
            let ciclo = $("#ciclod").val();
            addperiodo(ano, ciclo);
        });
        $("#periodod").change(function () {
            $("#btdemons").hide();
            let ano = $("#anod").val();
            let ciclo = $("#ciclod").val();
            let periodo = $("#periodod").val();
            if (ano !== null && ano !== '' && ciclo !== null && ciclo !== '' && periodo !== null && periodo !== '') {
                $("#btdemons").show();
            } else {
                $("#btdemons").hide();
            }
        });
        </script>
    </body>
</html>