<?php
session_start();
include_once '../../recursos_online/api/v1/config.php';
include_once '../../recursos_online/api/libs/Database.php';
include_once '../../Controller_agsus/maskCpf.php';

if(!isset($_SESSION['cpfgestor']) || trim($_SESSION['cpfgestor']) === '' || $_SESSION['cpfgestor'] === null){
    $_SESSION['msg'] = '<span class="yellow-text">* Faça o login.</span>';
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../derruba_session.php\"'>"; exit();
}
if(!isset($_SESSION['NomeGestor']) || trim($_SESSION['NomeGestor']) === '' || $_SESSION['NomeGestor'] === null){
    $_SESSION['msg'] = '<span class="yellow-text">* Faça o login.</span>';
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../derruba_session.php\"'>"; exit();
}
$NomeGestor = $_SESSION['NomeGestor'];
$ibge = $_SESSION['ibge'];
//$NomeGestor = 'Ricardo Lima Amaral';
date_default_timezone_set('America/Sao_Paulo');
$datahoje = date('d/m/Y');
//$ibge = '290390';
$ide = substr($ibge, 0,2);
$pide = [
    ':id' => $ide
];
$mysql_options = [
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATABASE,
    'username' => MYSQL_USERNAME,
    'password' => MYSQL_PASSWORD,
];
$db = new Database($mysql_options);
$rse = $db->execute_query("SELECT * FROM estado where cod_uf = :id", $pide);
//var_dump($rse);
$uf = $mun = "";
foreach ($rse->results as $r){
    $uf = $r->UF;
}
$pidm = [
    ':ibge' => $ibge
];
$rsmun = $db->execute_query("SELECT * FROM municipio WHERE cod_munc = :ibge", $pidm);
//var_dump($rsmun);
foreach ($rsmun->results as $r){
    $mun = $r->Municipio;
}
$rsm = $db->execute_query("SELECT * FROM medico WHERE ibge = :ibge order by cnes, nome", $pidm);
//var_dump($rsm);
$rsano = $db->execute_query("SELECT distinct ano FROM demonstrativo");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação de desempenho do médico tutor</title>
    <link rel="shortcut icon" href="./../../img_agsus/iconAdaps.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <style>
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

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-4 mt-4 pl-5">
                <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 mt-4 ">
                <h4 class="mb-4 font-weight-bold text-center">Programa de Avaliação de Desempenho do Médico Tutor</h4>
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
                                <a class="nav-link" href="../../../sistema-adaps/gestor/menu/" target="_parent" title="Página de entrada">Início</a>
                            </li>
                            <li class="nav-item">
                                <button type="button" data-toggle="modal" data-target="#infoDem" class="mt-1 btn btn-light btn-sm text-secondary" title="Painel de Resultados dos Tutores do Município">Painel de Resultados dos Tutores do Município</button>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../../../sistema-adaps/gestor/controller/derruba_session.php" target="_parent" title="Sair"><i class="fas fa-sign-out-alt pt-1"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav> 
            </div>
        </div>
        <div class="text-right text-muted lead small"><b>Gestor(a): </b><?= $NomeGestor ?>&nbsp; - &nbsp;Brasília-DF, <?= $datahoje ?>.</div>
        <div class="row p-2">
            <div class="col-md-12 shadow rounded pr-1 pl-1">
                <div class="row p-3">
                    <div class="col-md-12 mt-1 mb-1">
                        <fieldset class="form-group border pr-1 pl-1">
                            <legend class="w-auto pr-2 pl-2"><h5>Município <?= $mun ?>-<?= $uf ?></h5></legend>
                            <div class="mb-3 table-responsive text-nowrap table-overflow2">
                                <table id="dtBasicExample" class="table table-hover table-bordered table-striped rounded">
                                    <thead class="bg-gradient-dark text-white">
                                        <tr class="bg-dark text-light font-weight-bold">
                                            <td class="bg-dark text-light align-middle" style="height: 70px;position: sticky; top: 0px;">CNES</td>
                                            <td class="bg-dark text-light align-middle" style="position: sticky; top: 0px;">INE</td>
                                            <td class="bg-dark text-light align-middle" style="position: sticky; top: 0px;">NOME</td>
                                            <td class="bg-dark text-light align-middle" style="position: sticky; top: 0px;">CPF</td>
                                            <td class="bg-dark text-light align-middle" style="position: sticky; top: 0px;">Cargo</td>
                                            <td class="bg-dark text-light align-middle text-center" style="position: sticky; top: 0px;" title="Evolução da Qualidade Assistencial" >Qualidade<br>Assistencial</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($rsm !== null){
                                            $x=0;
                                        foreach ($rsm->results as $r){
                                            $x++;
                                            $cnes = $r->cnes;
                                            $ine = $r->ine;
                                            $nome = $r->nome;
                                            $cpf = $r->cpf;
                                            $cargo = $r->cargo;
                                            $cpftratado = mask($cpf, "###.###.###-##");
                                        ?>
                                        <tr>
                                            <td><?= $cnes ?></td>
                                            <td><?= $ine ?></td>
                                            <td><?= $nome ?></td>
                                            <td><?= $cpftratado ?></td>
                                            <td><?= $cargo ?></td>
                                            <td><center><button type="button" data-toggle="modal" data-target="#infoQA<?= $x ?>" class="shadow btn btn-outline-secondary" title="Evolução da Qualidade Assistencial dos Tutores"><img src="../../img/desempenho2.png" width="28"></button></center></td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="infoQA<?= $x ?>" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <form method="get" action="../qa/index.php">
                                                    <input type="hidden" name="i" value="<?= $ine ?>">
                                                <div class="modal-content p-1 bg-light">
                                                  <div class="modal-header border-top border-left border-right"  style="background-color: #0055A1;">
                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Evolução da Qualidade Assistencial</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body border-top border-left border-right">
                                                      <div class="row">
                                                          <div class="col-md-4 p-2 text-nowrap">
                                                              <span class="d-inline-block text-truncate" style="max-width: 150px;">Selecione o ano para ter acesso às informações sobre a evolução da qualidade assistencial 
                                                                  do médico <?= $nome ?></span>
                                                          </div>
                                                          <div class="col-md-12 p-2">
                                                              <label><b>Ano</b></label>
                                                              <select name="a" class="form-control">
                                                                  <option value="" >[--SELECIONE--]</option>
                                                                  <?php
                                                                  if($rsano !== null){
                                                                      foreach ($rsano->results as $ra){
                                                                          $ano = $ra->ano;
                                                                      }
                                                                  ?>
                                                                  <option><?= $ano ?></option>
                                                                  <?php } ?>
                                                              </select>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer border">
                                                      <button type="button" class="btn btn-secondary " data-dismiss="modal">NÃO</button> &nbsp; 
                                                      <button type="submit" name="enviaCadastro" class="btn btn-success">&nbsp; SIM &nbsp;</button>
                                                  </div>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
                                            <div class="modal fade" id="infoDem" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <form method="get" action="../demonstrativo/index.php">
                                                    <input type="hidden" name="i" value="<?= $ine ?>">
                                                <div class="modal-content p-1 bg-light">
                                                  <div class="modal-header border-top border-left border-right"  style="background-color: #0055A1;">
                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Painel de Resultados dos Tutores</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body border-top border-left border-right">
                                                      <div class="row">
                                                          <div class="col-md-4 p-2 text-nowrap">
                                                              <span class="d-inline-block text-truncate" style="max-width: 150px;">Selecione o ano para ter acesso às informações sobre a evolução da qualidade assistencial 
                                                                  do médico <?= $nome ?></span>
                                                          </div>
                                                          <div class="col-md-12 p-2">
                                                              <label><b>Ano</b></label>
                                                              <select name="a" class="form-control">
                                                                  <option value="" >[--SELECIONE--]</option>
                                                                  <?php
                                                                  if($rsano !== null){
                                                                      foreach ($rsano->results as $ra){
                                                                          $ano = $ra->ano;
                                                                      }
                                                                  ?>
                                                                  <option><?= $ano ?></option>
                                                                  <?php } ?>
                                                              </select>
                                                          </div>
                                                          <div class="col-md-12 p-2">
                                                              <label><b>Ciclo</b></label>
                                                              <select name="c" class="form-control">
                                                                  <option value="" >[--SELECIONE--]</option>
                                                                  <option value="1" >1º Ciclo</option>
                                                                  <option value="2" >2º Ciclo</option>
                                                                  <option value="3" >3º Ciclo</option>
                                                              </select>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="modal-footer border">
                                                      <button type="button" class="btn btn-secondary " data-dismiss="modal">NÃO</button> &nbsp; 
                                                      <button type="submit" name="enviaCadastro" class="btn btn-success">&nbsp; SIM &nbsp;</button>
                                                  </div>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
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
    <br>
    <br><br>
    <div class="container-fluid mt-2" style="margin-bottom:0;background-color: #1A1A37">
            <div class="row">
                <div class="col-md-3 mb-5">
                    <img class="img-fluid py-5" src="./../../img/logo-adaps-text-white.png" alt="logo adaps" />
                    <h4 class="small text-white">Redes sociais</h4>
                    <a target="_blank" href="https://www.facebook.com/agenciasus">
                        <i class="fab fa-facebook text-white fa-2x mr-2 pl-2"></i>
                    </a>
                    <a target="_blank" href="https://www.instagram.com/agenciasus/">
                        <i class="fab fa-instagram text-white fa-2x mr-2"></i>
                    </a>
                    <a target="_blank" href="https://www.linkedin.com/company/84489833/admin/feed/posts/">
                        <i class="fab fa-linkedin text-white fa-2x mr-2"></i>
                    </a>
                    <a target="_blank" href="https://twitter.com/agenciasus">
                        <i class="fab fa-twitter text-white fa-2x mr-2"></i>
                    </a>
                    <a target="_blank" href="https://www.youtube.com/channel/UCLSEqv-F8oUfcHdyIgRhC9Q">
                        <i class="fab fa-youtube text-white fa-2x"></i>
                    </a>
                </div>
                <div class="col-md-3">
                    <p>
                    <h5 class="pt-5"><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/quem-somos/">Quem Somos</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/conselho/">Conselho</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/diretoria-executiva/">Diretoria Executiva</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/noticias/">Noticia</a></h5>
                    </p>
                </div>
                <div class="col-md-3">
                    <p>
                    <h5 class="pt-5"><a class="small text-white" href="https://www.agenciasus.org.br/transparencia-e-prestacao-de-contas/">Transparência</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/ouvidoria/">Ouvidoria</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/prestacao-de-contas/">Prestação de Contas</a></h5>
                    </p>
                    <p>
                    <h5><a class="small text-white" target="_blank" href="https://www.agenciasus.org.br/programa-medicos-pelo-brasil/">Programa Médicos pelo Brasil</a></h5>
                    </p>
                </div>
                <div class="col-md-3">
                    <p class="small text-white"><i class="fas fa-phone text-white fa-2x pt-5"></i> (61) 3686-4144</p>
                    <p class="small text-white"><i class="fas fa-map-marker-alt text-white fa-2x"></i>
                        SHN – Quadra 1, Bloco E, Conj A, 2º andar, Asa Sul, Brasília – DF -CEP: 70.701-050
                    </p>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="background-color: #FF0000">
            <div class="row pt-2">
                <div class="col-6 text-center">
                    <p class="small text-white">&COPY;Todos os direitos reservados | AgSUS 2024</p>
                </div>
                <div class="col-6 text-center">
                    <a class="small text-white" href="https://www.agenciasus.org.br/politica-de-privacidade-e-seguranca/">
                        Política de Privacidade | Termos de Uso
                    </a>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('[data-toggle="popover"]').popover();
            });
        </script>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>