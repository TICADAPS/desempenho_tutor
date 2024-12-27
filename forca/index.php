<?php
session_start();
require __DIR__ . "/../source/autoload.php";
include '../conexao_agsus_2.php';
include '../conexao-agsus.php';
include '../Controller_agsus/maskCpf.php';
include '../Controller_agsus/fdatas.php';
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
if($_SESSION['perfil'] !== '1' && $_SESSION['perfil'] !== '2' && $_SESSION['perfil'] !== '3' && $_SESSION['perfil'] !== '6' && $_SESSION['perfil'] !== '7' && $_SESSION['perfil'] !== '8'){
    header("Location: ../derruba_session.php");
    exit();
}
$perfil = $_SESSION['perfil'];
$nivel = $_SESSION['nivel'];
//$perfil = '3';
//$nivel = '1';
//$_SESSION['perfil'] = $perfil;
//$_SESSION['nivel'] = $nivel;
//$_SESSION['idUser'] = 2765;
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
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('d/m/Y');
$iduser = $_SESSION["idUser"];
$sqlu = "select * from usuarios where id_user = '$iduser'";
$queryu = mysqli_query($conn2, $sqlu) or die(mysqli_error($conn2));
$rsu = mysqli_fetch_array($queryu);
$usuario = '';
if($rsu){
    do{
        $usuario = $rsu['nome_user'];
    }while($rsu = mysqli_fetch_array($queryu));
}
$sqlano = "select ano from anocicloavaliacao group by ano";
$queryano = mysqli_query($conn, $sqlano) or die(mysqli_error($conn));
$rsano = mysqli_fetch_array($queryano);
$sqlano2 = "select ano from anocicloavaliacao group by ano";
$queryano2 = mysqli_query($conn, $sqlano2) or die(mysqli_error($conn));
$rsano2 = mysqli_fetch_array($queryano2);
$sqlano3 = "select ano from anocicloavaliacao group by ano";
$queryano3 = mysqli_query($conn, $sqlano3) or die(mysqli_error($conn));
$rsano3 = mysqli_fetch_array($queryano3);
$sqlano4 = "select ano from anocicloavaliacao group by ano";
$queryano4 = mysqli_query($conn, $sqlano4) or die(mysqli_error($conn));
$rsano4 = mysqli_fetch_array($queryano4);
?>
<!DOCTYPE html>
<html lang="pt-br">
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
            <div class="row mt-2">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="menuPrincipal" class="collapse navbar-collapse">
                            <ul class="navbar-nav p-1 w-100 d-flex">
                                <li class="text-secondary"><a href="https://agsusbrasil.org/sistema-integrado/painelAdmin.php" class="btn">Início</a></li>
                                <li class="text-secondary"><a href="derruba_session.php" class="btn"><i class="fas fa-sign-out-alt"></i></a></li>
                                <?php
                                $anocl = (new Source\Models\Anocicloavaliacao())->findTudo();
                                if($anocl !== null){
                                    $aa = $cc = '';
                                    foreach ($anocl as $ac){
                                        if($ac->flagativo === '1'){
                                            $aa = $ac->ano;
                                            $cc = $ac->ciclo;
                                            break;
                                        }
                                    }
                                    if($aa !== '' && $cc !== ''){ ?>
                                <li class="text-info mx-auto"><a href="" class="btn text-info"><i class="fas fa-hand-point-right"></i>&nbsp;&nbsp; <?= $cc ?>º Ciclo de <?= $aa ?> ABERTO &nbsp;&nbsp;<i class="fas fa-hand-point-left"></i></a></li>
                                <?php    }else{ ?>
                                <li class="text-danger mx-auto"><a href="" class="btn text-danger"><i class="fas fa-hand-point-right"></i>&nbsp;&nbsp; CICLO FECHADO &nbsp;&nbsp;<i class="fas fa-hand-point-left"></i></a></li>
                                <?php }} ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="row  ">
                <div class="col-12 text-right">
                    <label><small>Bem-vindo, <?= $usuario ?>, Brasília-DF, <?= $dthoje ?>.</small></label>
                </div>
            </div>
            <div class="row  ">
                <div class="col-12">
                    <?php
                    if ($_SESSION['msg'] !== "") {
                        echo $_SESSION['msg'];
                    }
                    $_SESSION['msg'] = "";
                    ?>
                </div>
            </div>
            <div class="col-12 shadow rounded pt-3 pb-3 mb-4">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-light rounded" data-toggle="modal" data-target="#modalAP">
                                <img src="./../img/aperfeicoamento.png" class="img-fluid rounded" width="50%">
                            </button>
                        </div>
                        <?php if($perfil === '3' && $nivel === '1'){ ?>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-light rounded" data-toggle="modal" data-target="#modalCP">
                                <img src="./../img/autoavaliacao.png" class="img-fluid rounded" width="50%">
                            </button>
                        </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-light rounded" data-toggle="modal" data-target="#modalRAD">
                                <img src="./../img/demostrativo.png" class="img-fluid rounded" width="50%">
                            </button>
                        </div>
                    </div>
                    <?php if($perfil === '3' && $nivel === '1'){ ?>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <a type="button" class="btn btn-light rounded" href="abertura_ciclo/">
                                <img src="./../img/abertura_ciclo.png" class="img-fluid rounded" width="50%">
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-light rounded" href="limiteContestacao/">
                                <img src="./../img/time_limit.png" class="img-fluid rounded" width="50%">
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalAP" tabindex="-1" aria-labelledby="modalAP" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" enctype="multipart/form-data" action="./controller/lap.php">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #E0E4E9;">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Aperfeiçoamento Profissional &nbsp;<img src="./../img/aperfeicoamento.png" class="img-fluid rounded-circle" width="10%"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card ">
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-3">
                                                <div class="row">
                                                    <div class="col-md-12">
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
                                                    <div class="col-md-12">
                                                        <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                        <div class="col-12">
                                                            <select class="form-control" name="ciclo" id="cicloap">
                                                                <option value="">[--SELECIONE--]</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                                    <button type="submit" class="btn btn-primary">ENTRAR <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalCP" tabindex="-1" aria-labelledby="modalCP" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" enctype="multipart/form-data" action="./controller/lacp.php">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #E0E4E9;">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Competências Profissionais &nbsp;<img src="./../img/autoavaliacao.png" class="img-fluid rounded-circle" width="10%"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card ">
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-3">
                                                <div class="row">
                                                    <div class="col-md-12">
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
                                                    <div class="col-md-12">
                                                        <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                        <div class="col-12">
                                                            <select class="form-control" name="ciclo" id="cicloav">
                                                                <option value="">[--SELECIONE--]</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                                    <button type="submit" class="btn btn-primary">ENTRAR <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalRAD" tabindex="-1" aria-labelledby="modalRAD" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" enctype="multipart/form-data" action="./controller/ldem.php">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #E0E4E9;">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Resultado da Avaliação de Desempenho &nbsp;<img src="./../img/desempenho2.jpg" class="img-fluid rounded-circle" width="10%"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card ">
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-3">
                                                <div class="row">
                                                    <div class="col-md-12">
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
                                                    <div class="col-md-12">
                                                        <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                        <div class="col-12">
                                                            <select class="form-control" name="ciclo" id="ciclod">
                                                                <option value="">[--SELECIONE--]</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-12"><b>Escolha o período:</b></div>
                                                        <div class="col-12">
                                                            <select class="form-control" name="periodo" id="periodod">
                                                                <option value="">[--SELECIONE--]</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                                    <button type="submit" id="btdemons" class="btn btn-primary">ENTRAR <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
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
        $("#anod").change(function () {
            $("#btdemons").hide();
            let ano = $("#anod").val();
            addciclo3(ano);
        });
        $("#ciclod").change(function () {
            $("#btdemons").hide();
            let ano = $("#anod").val();
            let ciclo = $("#ciclod").val();
            addperiodo(ano,ciclo);
        });
        $("#anoaf").change(function () {
            let ano = $("#anoaf").val();
            addciclo4(ano);
        });
        $("#anoab").change(function () {
            let ano = $("#anoab").val();
            addciclo5(ano);
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