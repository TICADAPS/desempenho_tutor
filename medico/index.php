<?php
session_start();
include '../conexao_agsus_2.php';
include '../conexao-agsus.php';
include '../Controller_agsus/maskCpf.php';
include '../Controller_agsus/fdatas.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
if (!isset($_SESSION['cpf'])) {
   header("Location: controller/derruba_session.php"); exit();
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
//var_dump($_SESSION['msg']);
$cpftratado = $_SESSION['cpf'];
$cpf = str_replace(".", "", $cpftratado);
$cpf = str_replace(".", "", $cpf);
$cpf = str_replace("-", "", $cpf);
//var_dump($cpf);
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('d/m/Y');
$sqlu = "select * from medico where cpf = '$cpf' limit 1";
$queryu = mysqli_query($conn, $sqlu) or die(mysqli_error($conn));
$nrrsu = mysqli_num_rows($queryu);
$rsu = mysqli_fetch_array($queryu);
$medico = '';
if($nrrsu > 0){
    do{
        $medico = $rsu['nome'];
        $ibgeO = $rsu['ibge'];
        $cnes = $rsu['cnes'];
        $ine = $rsu['ine'];
    }while($rsu = mysqli_fetch_array($queryu));
}
$_SESSION['cpft'] = $cpf;
$_SESSION['nome'] = $medico;
$_SESSION['ibgeO'] = $ibgeO;
$_SESSION['cnes'] = $cnes;
$_SESSION['ine'] = $ine;
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
                <div class="col-12 col-md-4 mt-4 pl-5">
                    <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 mt-5">
                    <h4 class="mb-4 font-weight-bold text-left">Médico Tutor &nbsp;|&nbsp; Painel dos Domínios da Avaliação de Desempenho</h4>
                </div>
            </div>
            <div class="row mb-4 mt-2">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="menuPrincipal" class="collapse navbar-collapse">
                            <ul class="navbar-nav p-1">
                                <li class="text-secondary pl-2 pr-2"><a href="" class="btn">Início</a></li>
                                <li class="text-secondary pl-2 pr-2"><a href="controller/derruba_session.php" class="btn"><i class="fas fa-sign-out-alt"></i></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <?php
            if($nrrsu > 0){
            ?>
            <div class="row">
                <div class="col-12 text-right">
                    <label><small>Bem-vindo, <?= $medico ?>, Brasília-DF, <?= $dthoje ?>.</small></label>
                </div>
            </div>
            <div class="col-12 shadow rounded pt-3 pb-3 mb-5">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-light rounded" data-toggle="modal" data-target="#modalQA">
                                <img src="./../img/desempenho2.jpg" class="img-fluid rounded" width="50%">
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-light rounded" data-toggle="modal" data-target="#modalAP">
                                <img src="./../img/aperfeicoamento.png" class="img-fluid rounded" width="50%">
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-light rounded" data-toggle="modal" data-target="#modalCP">
                                <img src="./../img/autoavaliacao.png" class="img-fluid rounded" width="50%">
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-light rounded" data-toggle="modal" data-target="#modalDem">
                                <img src="./../img/demostrativo.png" class="img-fluid rounded" width="50%">
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalQA" tabindex="-1" aria-labelledby="modalQA" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="post" enctype="multipart/form-data" action="qa.php">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #E0E4E9;">
                                <h5 class="modal-title text-primary" id="exampleModalLabel">Qualidade Assistencial &nbsp;<img src="./../img/desempenho2.jpg" class="img-fluid rounded-circle" width="10%"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card ">
                                    <div class="card-body">
                                        <blockquote class="blockquote mb-3">
                                            <input type="hidden" value="<?= $ine ?>" name="i">
                                            <p>Texto explicativo - conteúdo com opção de escolha do ano.</p>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="col-12"><b>Escolha o ano:</b></div>
                                                    <div class="col-12">
                                                        <select class="form-control" name="ano" id="ano">
                                                            <option value="">[--SELECIONE--]</option>
                                                            <?php
                                                            if ($rsano) {
                                                                do {
                                                                    $ano = $rsano['ano'];
                                                                    ?>
                                                                    <option><?= $ano ?></option>
                                                                    <?php
                                                                } while ($rsano = mysqli_fetch_array($queryano));
                                                            }
                                                            ?>
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
                <div class="modal fade" id="modalAP" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data" action="./controller/transfdadosap.php">
                                <div class="modal-header" style="background-color: #E0E4E9;">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Aperfeiçoamento Profissional &nbsp;<img src="./../img/aperfeicoamento.png" class="img-fluid rounded-circle" width="10%;"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card ">
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-3">
                                                <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                <input type="hidden" value="<?= $medico ?>" name="nome">
                                                <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                <input type="hidden" value="<?= $ine ?>" name="ine">
                                                <p>Texto explicativo - conteúdo com opção de escolha do ano e do ciclo.</p>
                                                <div class="row mt-2">
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
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalCP" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data" action="./controller/transfdadoscp.php">
                                <div class="modal-header" style="background-color: #E0E4E9;">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Aperfeiçoamento Profissional &nbsp;<img src="./../img/autoavaliacao.png" class="img-fluid rounded-circle" width="10%;"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card ">
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-3">
                                                <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                <input type="hidden" value="<?= $medico ?>" name="nome">
                                                <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                <input type="hidden" value="<?= $ine ?>" name="ine">
                                                <p>Texto explicativo - conteúdo com opção de escolha do ano e do ciclo.</p>
                                                <div class="row mt-2">
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
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="modalDem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data" action="./controller/transfdadosd.php">
                                <div class="modal-header" style="background-color: #E0E4E9;">
                                    <h5 class="modal-title text-primary" id="exampleModalLabel">Demonstrativo &nbsp;<img src="./../img/demostrativo.png" class="img-fluid rounded-circle" width="10%;"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card ">
                                        <div class="card-body">
                                            <blockquote class="blockquote mb-3">
                                                <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                <input type="hidden" value="<?= $ine ?>" name="ine">
                                                <p>Texto explicativo - conteúdo com opção de escolha do ano e do ciclo.</p>
                                                <div class="row mt-2">
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
                                    <button type="submit" class="btn btn-primary">ENTRAR <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="col-12 shadow rounded pt-3 pb-3 mb-5">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-body p-5">
                                    <h5 class="text-center text-primary">Caro tutor, seu nome ainda 
                                        não consta em nossa base de dados referente ao Programa de Avaliação de Desempenho.<br>
                                    Favor aguardar a ciclo para inserção.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                            
            <?php } ?>
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