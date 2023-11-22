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
                    <h4 class="mb-4 text-center">Média dos Indicadores por Município - Ano <?= $anoAtual ?>.</h4>
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
            <div class="col-md-12 shadow rounded pt-2 mb-2">
                <div class="row p-2">
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold mb-3">Média dos indicadores por município no ano <?= $anoAtual ?></h6>
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
                            <div class="col-md-12 shadow rounded mt-3 pt-2 pr-3 pl-3">
                                <div class="row mt-2 pl-1">
                                    <div class="col-md-12">
                                        <h6 class="text-dark small font-weight-bold btn-sm">Selecione o município desejado:</h6>
                                    </div>
                                </div>
                                <div class="row pl-1 mb-4">
                                    <div class="col-md-2">
                                        <h6 class="ml-2">UF</h6>
                                        <select class="form-control" name="uf" id="ufp">
                                            <option value="-">[-SELECIONE-]</option>
                                            <?php
                                            $sqlUf = "select * from estado";
                                            $qUf = mysqli_query($conn, $sqlUf);
                                            $rsUf = mysqli_fetch_array($qUf);
                                            var_dump($rsUf);
                                            if($rsUf){
                                                do{
                                            ?>
                                            <option value="<?= $rsUf['cod_uf'] ?>"><?= $rsUf['UF'] ?></option>
                                            <?php }while($rsUf = mysqli_fetch_array($qUf));
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="ml-2">Município</h6>
                                        <select class="form-control" name="ibgeMun" id="ibgeMun">
                                            <option value="-">[-SELECIONE-]</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="ml-2 text-white">.</h6>
                                        <input type="submit" value="PESQUISAR" name="pesqibge" id="pesqibge" class="font-weight-bold btn btn-outline-info border-light shadow-sm pl-3 pr-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 p-2" id="indicadores"></div>
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
            //Pesquisando Município selecionado
            $(document).ready(function () {
                $('#ufp').change(function(){
                    var uf = $('#ufp').val();
                    console.log(uf);
                    $('#ibgeMun').load("ajax_agsus/listaMunUF.php?uf="+uf);
                });
                $('#pesqibge').click(function(){
                    var ibge = $('#ibgeMun').val();
                    console.log(ibge);
                    $('#indicadores').fadeOut();
                    $('#indicadores').fadeIn(700);
                    $('#indicadores').load("ajax_agsus/ajaxMediaIndPorMun.php?ibge="+ibge);
                });
            });
            
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
