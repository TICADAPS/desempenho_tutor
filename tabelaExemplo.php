<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AGSUS - Avaliação de Desempenho</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="row">
        <div class="col-12 col-md-4 col-sm-6">
            <img src="./img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
        </div>
        <div class="col-12 col-md-8 col-sm-6 mt-5 ">
            <h4 class="mb-4">Avaliação de Desempenho do Médico Tutor</h4>
        </div>
    </div>
    <div class="container-fluid mt-2 mb-4">
        <div class="row">
            <div class="col-12 mb-2">
                <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                    <!-- Container wrapper -->
                    <div class="container-fluid">
                        <!-- Toggle button -->
                        <button
                            class="navbar-toggler"
                            type="button"
                            data-mdb-toggle="collapse"
                            data-mdb-target="#navbarLeftAlignExample"
                            aria-controls="navbarLeftAlignExample"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                            >
                            <i class="fas fa-bars"></i>
                        </button>

                        <!-- Collapsible wrapper -->
                        <div class="collapse navbar-collapse" id="navbarLeftAlignExample">
                            <!-- Left links -->
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Início</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">|</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Aba1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">|</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Aba2</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">|</a>
                                </li>
                                <!-- Navbar dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Relatórios</a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Relatório 1</a>
                                        <!--<a class="dropdown-item" href="relatorios/relatorioTeste.php?pib=<?= $pib ?>&pfb=<?= $pfb ?>">Relatório de deslocamentos cadastrados no período</a>-->
                                        <a class="dropdown-item" href="#">Relatório 2</a>
                                        <a class="dropdown-item" href="#">Relatório 3</a>
                                        <a class="dropdown-item" href="#">Relatório 4</a>
                                        <a class="dropdown-item" href="#">Relatório 5</a>
                                        <a class="dropdown-item" href="#">Relatório 6</a>
                                        <a class="dropdown-item" href="#">Relatório 7</a>
                                        <!--                                          <div class="dropdown-divider"></div>-->
                                        <a class="dropdown-item" href="#">Relatório 8</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">|</a>
                                </li>  
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Nova Aba</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">|</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt pt-1"></i></a>
                                </li>
                                <li class="nav-item">
                                    <div id="loading">
                                        &nbsp;&nbsp;<img class="float-right" src="./img_agsus/carregando.gif" width="40" height="40" />
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav> 
            </div>
        </div>
        <div class="col-12 shadow rounded pt-2">
            <div class="pb-1">
                <h4 class="text-info mt-3">Tabela</h4>
                <div class="mt-3 mb-3 table-responsive text-nowrap table-overflow">
                    <table id="dtBasicExample" class="table table-hover table-bordered table-striped rounded">
                        <thead class="thead-dark border-white">
                            <tr>
                                <th colspan="9" class="bg-dark  border-white" style="position: sticky; top: 0;">
                                    <center><h5 class='bg-dark text-light'>Lista...</h5></center>
                                </th>
                            </tr>
                            <tr class="bg-dark c font-weight-bold border-white">
                                <td class="bg-dark text-light text-center align-middle" style="width: 5%;position: sticky; top: 48;"><i class="fas fa-envelope"></i></td>
                                <td class="bg-dark text-light text-center align-middle" style="width: 5%;position: sticky; top: 48;"><i class="fas fa-dollar-sign"></i></td>
                                <td class="bg-dark text-light  align-middle" style="width: 16%;position: sticky; top: 48;">Bolsista</td>
                                <td class="bg-dark text-light  align-middle" style="width: 15%;position: sticky; top: 48;">E-Mail</td>
                                <td class="bg-dark text-light  align-middle" style="width: 8%;position: sticky; top: 48;">Telefone</td>
                                <td class="bg-dark text-light  align-middle" style="width: 14%;position: sticky; top: 48;">CPF Bolsista</td>
                                <td class="bg-dark text-light  align-middle" style="width: 15%;position: sticky; top: 48;">Origem</td>
                                <td class="bg-dark text-light  align-middle" style="width: 15%;position: sticky; top: 48;">Destino</td>
                                <td class="bg-dark text-light  align-middle" style="width: 7%;position: sticky; top: 48;">Distância (Km)</td>
                            </tr>
                        </thead>
                        <tbody>
                         
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row ml-1">
                <div class="col-1">
                    <i class='fas fa-check text-success'></i> <label class="text-info"></label>
                </div>
            </div>
        </div>
    </div>
<?php include './includes/footer.php' ?>
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
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
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
