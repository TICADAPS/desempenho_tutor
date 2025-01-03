<?php
session_start();
require __DIR__ . "/../../source/autoload.php";
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = '';
}
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('Y-m-d');
$dtano = (int) date('Y');
$nivel = '1';
$perfil = '3';
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
        <link rel="shortcut icon" href="../../img_agsus/iconAdaps.png"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrcp.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrcp.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Custom styles for this template-->
        <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="../../js/highcharts.js"></script>
        <script src="../../js/highcharts-3d.js"></script>
        <script src="../../js/accessibility.js"></script>
        <script src="../../js/jquery.easypiechart.js"></script>
        <script src="../../js/jquery.easypiechart2.js"></script>
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
                max-height:472px;
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
                <div class="col-12 col-md-3 mt-2 mb-2">
                    <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-9 mt-4 ">
                    <h4 class="mb-4 font-weight-bold text-center">Unidade de Serviços em Saúde &nbsp;|&nbsp; Abertura e Fechamento de Ciclo</h4>
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
                                <li class="text-secondary pl-2 pr-2"><a href="" class="btn"> | </a></li>
                                <!-- Navbar dropdown -->
<!--                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">&nbsp;Relatórios</a>
                                    <div class="dropdown-menu">
                                        <?php if($perfil === '3' && $nivel === '1'){ ?>
                                        <a class="dropdown-item" href="relatorios/relatorioCP.php?id=<?= $id ?>">Planilha</a>
                                        <?php } ?>
                                    </div>
                                </li>-->
                                <li class="nav-item">
                                    <a class="nav-link" href="../derruba_session.php">&nbsp;&nbsp;<i class="fas fa-sign-out-alt pt-1"></i></a>
                                </li>
                                <li class="nav-item">
                                    <div id="loading">
                                        &nbsp;&nbsp;<img class="float-right" src="../../img/carregando.gif" width="40" height="40" />
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav> 
                </div>
            </div>
            <div class="row p-3">
                <div class="col-md-12 shadow rounded mb-1 p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-white" style="background-color: #1B48AB;">
                                    <b>Cadastro de Novo Ciclo</b>
                                </div>
                                <div class="card-body px-4">
                                <?php
                                if ($perfil === '3' && $nivel === '1') {
                                    ?>
                                    <form method="post" action="resp.php">
                                    <div class="row mb-1">
                                      <div class="col-md-12"><b>ANO: </b></div>
                                      <div class="col-md-12">
                                          <select name="ano" id="ano" class="form-control">
                                              <option value="">[-SELECIONE-]</option>
                                              <?php
                                              $anodt = $dtano;
                                              for($x = 0; $x <=5; $x++){
                                                  $anodt = $dtano + $x;
                                              ?>
                                              <option><?= $anodt ?></option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                      <div class="col-md-12"><b>CICLO: </b></div>
                                      <div class="col-md-12">
                                          <select name="ciclo" id="ciclo" class="form-control">
                                              <option value="">[-SELECIONE-]</option>
                                              <option value="1">1º CICLO</option>
                                              <option value="2">2º CICLO</option>
                                              <option value="3">3º CICLO</option>
                                          </select>
                                      </div>
                                      <div class="col-md-12"><b>DESCRIÇÃO: </b></div>
                                      <div class="col-md-12">
                                          <textarea class="form-control" name="descricao" id="descricao" rows="4" style="resize: none;"></textarea>
                                      </div>
                                      <div class="col-md-12"><b>INÍCIO: </b></div>
                                      <div class="col-md-12">
                                          <input type="date" min="<?= $dthoje ?>" class="form-control" name="dtinicio" id="dtinicio" />
                                      </div>
                                      <div class="col-md-12"><b>FIM: </b></div>
                                      <div class="col-md-12">
                                          <input type="date" min="<?= $dthoje ?>" class="form-control" name="dtfim" id="dtfim" />
                                      </div>
                                      <div class="col-md-12 mt-4">
                                          <button type="submit" class="btn btn-info form-control shadow-sm border-white" name="btenv">SALVAR NOVO CICLO &nbsp;<i class="fas fa-save"></i></button>
                                      </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <?php
                                            if ($_SESSION['msg'] !== "") {
                                                echo $_SESSION['msg'];
                                            }
                                            $_SESSION['msg'] = "";
                                            ?>
                                        </div>
                                    </div>
                                    </form>
                                <?php } ?>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <fieldset class="form-group border pr-2 pl-2 rounded">
                                <legend class="w-auto pr-2 pl-2"><h6>LISTAGEM DOS CICLOS</h6></legend>
                                <div class="mb-3 table-responsive text-nowrap table-overflow2">
                                    <table id="dtBasicExample" class="table table-hover table-bordered table-sm table-striped rounded">
                                        <thead class="bg-gradient-dark text-white">
                                            <tr class="bg-gradient-dark text-light font-weight-bold">
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="position: sticky; top: 0px;">ANO</td>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="position: sticky; top: 0px;">CICLO</td>
                                                <td class="bg-gradient-dark text-light align-middle" style="position: sticky; top: 0px;">DESCRIÇÃO</td>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="position: sticky; top: 0px;">INÍCIO</td>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="position: sticky; top: 0px;">FIM</td>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="position: sticky; top: 0px;">ATIVO</td>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="position: sticky; top: 0px;">AÇÃO</td>
                                                <td class="bg-gradient-dark text-light align-middle text-center" style="position: sticky; top: 0px;">EXCLUIR</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $anoall = $cicloall = $descricao = $dtinicio = $dtfim = $flagativo = '';
                                            $allac = (new Source\Models\Anocicloavaliacao())->findTudo();
                                            if($allac !== null){
                                                $maiorciclo = 0;
                                                foreach ($allac as $a){
                                                    $cicloall = $a->ciclo;
                                                    $cicloA = (int)$cicloall;
                                                    if($maiorciclo < $cicloA){
                                                        $maiorciclo = $cicloA;
                                                    }
                                                }
                                                foreach ($allac as $ac){
                                                    $id = $ac->id;
                                                    $anoall = $ac->ano;
                                                    $cicloall = $ac->ciclo;
                                                    $cicloA = (int)$cicloall;
                                                    $descricao = $ac->descricao;
                                                    $dtinicio = vemdata($ac->dtinicio);
                                                    $dtfim1 = $ac->dtfim;
                                                    $dtfim = vemdata($dtfim1);
                                                    $flagativo = $ac->flagativo;
                                                    if($flagativo === '1'){
                                                        $flagativo = 'SIM';
                                                    }else{
                                                        $flagativo = 'NÃO';
                                                    }
                                            ?>
                                            <tr>            
                                                <td class="text-center"><?= $anoall ?></td>
                                                <td class="text-center"><?= $cicloall ?></td>
                                                <td><?= $descricao ?></td>
                                                <td class="text-center"><?= $dtinicio ?></td>
                                                <td class="text-center"><?= $dtfim ?></td>
                                                <td class="text-center"><?= $flagativo ?></td>
                                                <?php
                                                $dtfim1 = (string)substr($dtfim1, 0,10);
                                                $dthoje = (string)substr($dthoje, 0,10);
                                                // Convertendo as strings de data para objetos DateTime
                                                $dtTime1 = DateTime::createFromFormat('Y-m-d', $dtfim1);
                                                $dtTime2 = DateTime::createFromFormat('Y-m-d', $dthoje);

                                                // Calculando a diferença entre as datas
                                                $intervalo = $dtTime1->diff($dtTime2);
                                                // Exibindo a diferença total em dias (sempre positivo)
                                                $diffEmDias = $intervalo->days;
                                                if ($dtTime1 < $dtTime2) {
                                                   $diffEmDias *= -1; // Inverte o sinal se a data final for anterior
                                                }
                                                if($diffEmDias >= 0){
                                                ?>
                                                <td class="text-center">
                                                    <?php if($flagativo == 'NÃO'){ ?>
                                                    <button type="button" class="btn btn-success shadow-sm border-white" data-toggle="modal" data-target="#modalAbrir<?= $id ?>">ABRIR</button>
                                                <?php }elseif($flagativo == 'SIM'){ ?>   
                                                    <button type="button" class="btn btn-danger shadow-sm border-white" data-toggle="modal" data-target="#modalFechar<?= $id ?>">FECHAR</button>
                                                <?php } ?>
                                                    </td>
                                                <?php
                                                //$anoaux >= 2024 e $cicloA > 2 porque os ciclos anteriores ao 3º de 2024 não possuem dados em AP e CP. 
                                                //o botão de excluir Ciclo.
                                                $anoaux = (int) $anoall;
                                                $aperf = (new Source\Models\Aperfeicoamentoprofissional())->findAnoCiclo($anoall, $cicloall);
                                                if($aperf === null && $anoaux >= 2024){
                                                ?>
                                                <td class="text-center"><button type="button" class="btn btn-light shadow-sm border-white" data-toggle="modal" data-target="#modalExclui<?= $id ?>"><i class="fas fa-trash-alt text-danger"></i></button></td>
                                                <?php }else{ ?>
                                                <td></td>
                                                <?php } ?>
                                                <!-- Modal modalAbrir -->
                                                <div class="modal fade" id="modalAbrir<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">FECHAMENTO DO CICLO</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <h6>Deseja ABRIR o <?= $cicloA ?>º ciclo?
                                                      </div>
                                                      <div class="modal-footer">
                                                       <form method="get" action="abreciclo.php">
                                                           <input type="hidden" value="<?= $id ?>" name="id">
                                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">NÃO</button>
                                                           <button type="submit" class="btn btn-primary">FECHAR</button>
                                                       </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!-- Modal modalFechar -->
                                                <div class="modal fade" id="modalFechar<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">FECHAMENTO DO CICLO</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <h6>Deseja FECHAR o <?= $cicloA ?>º ciclo?
                                                      </div>
                                                      <div class="modal-footer">
                                                       <form method="get" action="fechaciclo.php">
                                                           <input type="hidden" value="<?= $id ?>" name="id">
                                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">NÃO</button>
                                                           <button type="submit" class="btn btn-primary">FECHAR</button>
                                                       </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!-- Modal modalExclui -->
                                                <div class="modal fade" id="modalExclui<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">APAGAR/EXCLUIR CICLO</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <h6>Deseja excluir o <?= $cicloA ?>º ciclo?
                                                      </div>
                                                      <div class="modal-footer">
                                                       <form method="get" action="exclui.php">
                                                           <input type="hidden" value="<?= $id ?>" name="id">
                                                           <button type="button" class="btn btn-secondary" data-dismiss="modal">NÃO</button>
                                                           <button type="submit" class="btn btn-primary">EXCLUIR</button>
                                                       </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            <?php }else{ ?>
                                            <td></td><td></td>
                                            <?php } ?>
                                           </tr>
                                           <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
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