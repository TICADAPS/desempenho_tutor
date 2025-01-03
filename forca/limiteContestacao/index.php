<?php
session_start();
include '../../conexao_agsus_2.php';
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';
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
$_SESSION['perfil'] = $perfil;
$_SESSION['nivel'] = $nivel;
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
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
$sqlano = "select * from anocicloavaliacao group by ano";
$queryano = mysqli_query($conn, $sqlano) or die(mysqli_error($conn));
$rsano = mysqli_fetch_array($queryano);
$sql = "select * from anocicloavaliacao";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$rs = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aperfeiçoamento Profissional</title>
        <link rel="shortcut icon" href="../../img_agsus/iconAdaps.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <style>
            .table-overflow {
                max-height:500px;
                overflow-y:auto;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-12 col-md-3 mt-4 pl-5">
                    <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-9 mt-5">
                    <h4 class="mb-4 font-weight-bold text-left">Unidade de Serviços em Saúde &nbsp;|&nbsp; Tempo limite de contestação</h4>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 mb-2">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div id="menuPrincipal" class="collapse navbar-collapse">
                            <ul class="navbar-nav p-1">
                                <li class="text-secondary pl-2 pr-2"><a href="../" class="btn">Início</a></li>
                                <li class="text-secondary pl-2 pr-2"><a href="derruba_session.php" class="btn"><i class="fas fa-sign-out-alt"></i></a></li>
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
            <div class="col-12 shadow rounded pt-3 pb-3 mb-4">
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="card ">
                                <div class="card-header text-white" style="background-color: #1B48AB;"><h5>Tempo limite de contestação</h5></div>
                                <div class="card-body">
                                    <form method="post" action="../controller/ldt.php">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-12"><b>Escolha o ano:</b></div>
                                                    <div class="col-12">
                                                        <select class="form-control" name="ano" id="anoc">
                                                            <option value="">[--SELECIONE--]</option>
                                                            <?php
                                                            if($rsano){
                                                                do{
                                                                    $ano1 = $rsano['ano'];
                                                            ?>
                                                            <option><?= $ano1 ?></option>        
                                                            <?php        
                                                                }while($rsano = mysqli_fetch_array($queryano));
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-12"><b>Escolha o ciclo:</b></div>
                                                    <div class="col-12">
                                                        <select class="form-control" name="ciclo" id="cicloc">
                                                            <option value="">[--SELECIONE--]</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-12"><b>Data limite:</b></div>
                                                    <div class="col-12">
                                                        <input type="date" class="form-control" name="dtlimite" id="dtlimite">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-info form-control shadow-sm border-white mt-4" data-toggle="modal" data-target="#modalDtlimite">SALVAR &nbsp;<i class="fas fa-save"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3 mt-2">
                                                    <?php
                                                    if ($_SESSION['msg'] !== "") {
                                                        echo $_SESSION['msg'];
                                                    }
                                                    $_SESSION['msg'] = "";
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal modalDtlimite -->
                                        <div class="modal fade" id="modalDtlimite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-warning">
                                                        <h5 class="modal-title text-dark" id="exampleModalLabel">Data Limite de Contestação &nbsp;&nbsp;<img src="../../img/time_limit.png" width="8%"></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Deseja salvar a data limite de contestação?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                                                        <input type="submit" name="btsalvar" value='SALVAR' class="btn btn-primary">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIM do Modal modalDtlimite -->
                        <div class="col-md-8 mt-2 overflow">
                            <fieldset class="form-group border pr-2 pl-2 rounded">
                                <legend class="w-auto pr-2 pl-2"><h6>LISTAGEM DOS CICLOS</h6></legend>
                                <table class="table table-striped table-hover table-sm table-bordered rounded">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="position: sticky; top: 48;">ANO</th>
                                            <th style="position: sticky; top: 48;">CICLO</th>
                                            <th style="position: sticky; top: 48;">DATA INÍCIO</th>
                                            <th style="position: sticky; top: 48;">DATA FIM</th>
                                            <th style="position: sticky; top: 48;">DATA LIMITE CONTESTAÇÃO</th>
                                            <th style="position: sticky; top: 48;">SITUAÇÃO</th>
                                            <th style="position: sticky; top: 48;">INATIVAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($rs){
//                                     var_dump($rs);
                                        do{
                                            $ano = $rs['ano'];
                                            $ciclo = $rs['ciclo'];
                                            $dtinicio = vemdata($rs['dtinicio']);
                                            $dtfim = vemdata($rs['dtfim']);
                                            $dtlimit = vemdata($rs['dtlimitecontestacao']);
                                            if($dtlimit === '//' ){
                                                $dtlimit = '';
                                            }
                                            $flagdtlim = $rs['flagdtlimitecontestacao'];
                                            if($flagdtlim === null){
                                                $flagdtlim = '0';
                                            }
                                            $id = $rs['id'];
                                    ?>
                                        <tr>
                                            <td><?= $ano ?></td>
                                            <td><?= $ciclo ?></td>
                                            <td><?= $dtinicio ?></td>
                                            <td><?= $dtfim ?></td>
                                            <td><?= $dtlimit ?></td>
                                    <?php
                                        if($flagdtlim === '1'){
                                    ?>
                                            <td>ATIVO</td>
                                    <?php }else{ ?>
                                            <td>INATIVO</td>
                                    <?php } ?>
                                    <?php
                                        if($flagdtlim === '1'){
                                    ?>
                                            <td><center>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDtlimiteParar<?= $id ?>">
                                                    <i class="fas fa-times-circle"></i>  
                                                </button></center>
                                            </td>
                                    <?php }else{ ?>
                                            <td></td>
                                    <?php } ?>
                                        </tr>
                                        <!-- Modal modalDtlimiteParar -->
                                        <div class="modal fade" id="modalDtlimiteParar<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form method="post" action="../controller/ldt.php">
                                                    <div class="modal-header bg-light">
                                                        <h5 class="modal-title text-dark" id="exampleModalLabel">Data Limite de Contestação &nbsp;&nbsp;<img src="../../img/time_limit.png" width="8%"></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Deseja inativar a data limite da contestação?</p>
                                                    </div>
                                                    <input type="hidden" name="idcontest" value="<?= $id ?>">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>
                                                            <input type="submit" name="btparar" value='INATIVAR' class="btn btn-primary">
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIM do Modal modalDtlimite -->
                                    <?php
                                        }while($rs = mysqli_fetch_array($query));
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../includes/footer.php' ?>
        <script src="../js_agsus/jquery-3.1.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../ciclo.js"></script>
        <script>
        $(document).ready(function () {
            $("#btdemons").hide();
        });
        $("#anoc").change(function () {
            let ano = $("#anoc").val();
            addciclo6(ano);
        });
        </script>
    </body>
</html>