<?php
session_start();
include '../../conexao_agsus_2.php';
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
$cpf = $_GET['ct'];
$cpfmask = mask($cpf, "###.###.###-##");
$ibge = $_GET['ib'];
$cnes = $_GET['c'];
$ine = $_GET['i'];
$ano = $_GET['a'];
$ciclo = $_GET['ci'];
$qcp = $gepep = $itp = 0;
$sql = "select m.nome, m.admissao, m.cargo, mun.Municipio, e.UF, ivs.descricao, ap.id, 
    ap.dthrcadastro, ap.flagativlongduracao, ap.flagparecer as flagparecerap, ap.pontuacao,
    ap.parecer as parecerap, ap.pareceruser as pareceruserap, ap.parecerdthr as parecerdthrap,
    ap.flagemail, ap.dthremail 
    from medico m inner join aperfeicoamentoprofissional ap on m.cpf = ap.cpf and 
    m.ibge = ap.ibge and m.cnes = ap.cnes and m.ine = ap.ine 
    inner join municipio mun on mun.cod_munc = m.ibge 
    inner join estado e on mun.Estado_cod_uf = e.cod_uf 
    inner join ivs on ivs.idivs = m.fkivs 
    where m.cpf = '$cpf' and m.ibge = '$ibge' and m.cnes = '$cnes' and m.ine = '$ine' "
        . "and ap.ano = '$ano' and ap.ciclo='$ciclo'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$rs = mysqli_fetch_array($query);
$municipioO = $ufO = $flagemail = $dthremail = "";
$flagld = $flagqc = $flaggepe = $flagit = false;
if($rs){
    do{
        $idap = $rs['id'];
        $medico = $rs['nome'];
        $admissao = $rs['admissao'];
        $cargo = $rs['cargo'];
        $municipioO = $rs['Municipio'];
        $ufO = $rs['UF'];
        $ivs = $rs['descricao'];
        $flagald = $rs['flagativlongduracao'];
        $flagparecerap = $rs['flagparecerap'];
        if($flagparecerap === '' || $flagparecerap === null){
            $flagld = true;
        }
        $parecerap = $rs['parecerap'];
        $pontuacaoap = $rs['pontuacao'];
        if ($pontuacaoap === null || $pontuacaoap === '') {
            $pontuacaoap = 0.00;
        }
        $pontuacaoaptxt = (string)$pontuacaoap;
        $pontuacaoaptxt = str_replace(".", ",", $pontuacaoaptxt);
        $pareceruserap = $rs['pareceruserap'];
        $parecerdthrap = vemdata($rs['parecerdthrap']);  
        $parecerdthrap .= ", às ".horaEmin($rs['parecerdthrap']).".";
        $flagemail = $rs['flagemail'];
        $dthremail = $rs['dthremail'];
    }while ($rs = mysqli_fetch_array($query));
}
if($flagemail !== null && $flagemail !== '' && $flagemail === '1'){
    $dthremail = "E-Mail enviado: ".vemdata($dthremail).", às ". hora2($dthremail);
}
//var_dump($dthremail);
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
</head>
<body>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12 col-md-4 mt-4 pl-5">
                <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 mt-5">
                <h4 class="mb-4 font-weight-bold text-left">Comprovante de Aperfeiçoamento Profissional</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-2">
                <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Menu collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <div id="menuPrincipal" class="collapse navbar-collapse pr-2 pl-3">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="../index.php" class="nav-link">Inicio </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">|</a>
                            </li>
                            <!-- Navbar dropdown -->
                            <li class="nav-item dropdown">
                                <!--<a class="nav-link dropdown-toggle" href="../relatorios/relatorio_geral_igad.php">Relatório Geral IGAD - 1º ciclo de 2023</a>-->
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Relatórios</a>
                                <div class="dropdown-menu">
                                    <?php if ($perfil === '3' && $nivel === '1') { ?>
                                        <!--<a class="dropdown-item" href="../relatorios/relatorio_geral_igad.php">Relatório Geral IGAD - 1º ciclo de 2024</a>-->
                                    <?php } ?>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">|</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../derruba_session.php"><i class="fas fa-sign-out-alt pt-1"></i></a>
                            </li>
                            <li class="nav-item">
                                <div id="loading">
                                    &nbsp;<img class="float-right" src="../../img/carregando.gif" width="40" height="40" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav> 
            </div>
        </div>
        <div class="container-fluid mt-4">
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
        <div class="row  ">
            <div class="col-12 shadow rounded  ">
                <div class="row mb-2 mt-2">
                    <div class="col-md-12 pt-2 pb-2">
                        <div class="card border-0">
                            <div class="card-header text-white bg-dark">
                                <h5 class="text-white"><b>Comprovante de Aperfeiçoamento Profissional - Formulário Preenchido</b></h5>
                            </div>
                            <div class="card-body">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-1">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Dados do Tutor</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-5">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Nome: </b><?= $medico ?></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>CPF: </b><?= $cpfmask ?></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Cargo: </b><?= $cargo ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Admissão: </b><?= $admissao ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-5">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Munic. Origem: </b><?= $municipioO ?>-<?= $ufO ?></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>CNES: </b><?= $cnes ?></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>INE: </b><?= $ine ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>IVS: </b><?= $ivs ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-1">
                    <div class="card-header bg-secondary text-white" >
                        <label><strong>Análise realizada - Pontuação Geral</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Pontuação dos itens aprovados</b></div>
                                <div class="col-md-12"><input type="text" class="form-control bg-light font-weight-bold text-primary" disabled="disabled" id="ptgeral" /></div>
                            </div>
                            <div class="col-md-4" id="email50Mais">
                                <div class="col-md-12"><b>Enviar E-Mail para o Médico - igual ou superior a 50 pontos.</b></div>
                                <div class="col-md-12"><button type="button" class="shadow-sm border-light btn btn-info form-control" data-toggle="modal" data-target="#modalSup50"><i class="fas fa-mail-bulk"></i>&nbsp; Igual ou superior a 50 pontos</button></div>
                            </div>
                            <div class="col-md-4" id="emailAbaixo50">
                                <div class="col-md-12"><b>Enviar E-Mail para o Médico - abaixo de 50 pontos</b></div>
                                <div class="col-md-12"><button type="button" class="shadow-sm border-light btn btn-warning form-control" data-toggle="modal" data-target="#modalInf50"><i class="fas fa-mail-bulk"></i>&nbsp; Abaixo de 50 pontos</button></div>
                            </div>
                            <div class="col-md-4">
                                <?php if($dthremail !== null && $dthremail !== ''){ ?>
                                <div class="col-md-12 text-info"><br><b><i class="fas fa-mail-bulk"></i> &nbsp;<i><?= $dthremail ?></i>.</b></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal #modalSup50-->
        <div class="modal fade" id="modalSup50" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="controller/upEnvSup.php">
                    <input type="hidden" value="<?= $cpf ?>" name="cpf">
                    <input type="hidden" value="<?= $ibge ?>" name="ibge">
                    <input type="hidden" value="<?= $cnes ?>" name="cnes">
                    <input type="hidden" value="<?= $ine ?>" name="ine">
                    <input type="hidden" value="<?= $idap ?>" name="idap">
                    <input type="hidden" value="<?= $ano ?>" name="ano">
                    <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
              <div class="modal-header bg-light">
                  <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-mail-bulk"></i>&nbsp; Enviar E-Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <p>O médico atingiu a pontuação prevista. Informá-lo através de uma mensagem eletrônica padrão.</p>
                  <div class="row mt-2 mb-2">
                      <div class="col-md-4 offset-4">
                          <img class="float-right" id="loading1" src="./../../img/carregando.gif" width="40" height="40" />
                      </div>
                  </div>
              </div>
              <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary" id="btenvsup50" name="envSup50">ENVIAR E-MAIL</button>
              </div>
                </form>
            </div>
          </div>
        </div>
        <!-- Fim do Modal #modalSup50-->
        <!-- Modal #modalInf50-->
        <div class="modal fade" id="modalInf50" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="controller/upEnvInf.php">
                    <input type="hidden" value="<?= $cpf ?>" name="cpf">
                    <input type="hidden" value="<?= $ibge ?>" name="ibge">
                    <input type="hidden" value="<?= $cnes ?>" name="cnes">
                    <input type="hidden" value="<?= $ine ?>" name="ine">
                    <input type="hidden" value="<?= $idap ?>" name="idap">
                    <input type="hidden" value="<?= $ano ?>" name="ano">
                    <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
              <div class="modal-header bg-light">
                  <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-mail-bulk text-warning"></i>&nbsp; Enviar E-Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <p>O médico <label class="text-danger">NÃO</label> atingiu a pontuação prevista. Informá-lo através de uma mensagem eletrônica padrão.</p>
                  <div class="row mt-2 mb-2">
                      <div class="col-md-12 mb-2"><b>Permitir que o médico refaça o envio das atividades não aprovadas?</b></div>
                      <div class="col-md-10">
                          <select name="upEnv" id="upEnv" class="form-control">
                              <option value="">[--SELECIONE--]</option>
                              <option value="1">SIM</option>
                              <option value="0">NÃO</option>
                          </select>
                      </div>
                      <div class="col-md-2">
                          <img class="float-right" id="loading2" src="./../../img/carregando.gif" width="40" height="40" />
                      </div>
                  </div>
              </div>
              <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-primary" id="btenvinf50" name="envSup50">ENVIAR E-MAIL</button>
              </div>
                </form>
            </div>
          </div>
        </div>
        <!-- Fim do Modal #modalInf50-->
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-1">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Atividade de Longa Duração</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <?php
                                if($flagald === '1'){
                                    $fald = "<label class='text-primary'>SIM</label>";
                                }else{
                                    $fald = "<label class='text-danger'>NÃO</label>";
                                }
                                ?>
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração? </b>&nbsp;<?= $fald ?></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                        if($pareceruserap !== '' && $pareceruserap !== null){
                        ?>
                        <div class="card border border">
                            <div class="card-header bg-light">
                                <label><strong>Análise realizada</strong></label>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <?php if($flagparecerap === '1'){
                                            $ldpar = "Aprovado";
                                        }else{ 
                                            $ldpar = "Não aprovado";
                                        }
                                        ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Parecer: </b><?= $ldpar ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $parecerap ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Análise realizado por: </b><?= $pareceruserap ?></li>
                                        </ul>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Data e hora do envio: </b><?= $parecerdthrap ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <?php 
                                        if($pontuacaoaptxt === '0,00'){
                                            $pontuacaoaptxt = "<label class='form-control bg-light text-danger'>$pontuacaoaptxt</label>";
                                        }else{
                                            $pontuacaoaptxt = "<label class='form-control bg-light text-primary'>$pontuacaoaptxt</label>";
                                        } ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Pontuação adquirida: </b><?= $pontuacaoaptxt ?></li>
                                        </ul>
                                        <input type="hidden" id="ptld" value="<?= $pontuacaoap ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }else{ ?>
                        <form method="post" action="controller/parecerlongd.php">
                            <input type="hidden" value="<?= $cpf ?>" name="cpf">
                            <input type="hidden" value="<?= $ibge ?>" name="ibge">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $idap ?>" name="idap">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header" style="background-color: #defff2">
                                        <label><strong>Análise sobre a atividade declarada</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-9">
                                                <div class="col-md-12"><b>Descrição da Análise</b></div>
                                                <div class="col-md-12">
                                                    <textarea style="resize: none; height: 100px;" class="form-control"  id="parecerap" name="parecerap"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="col-md-12"><b>Parecer</b></div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="flagparecerap" id="flagparecerap" value="1">Aprovado</div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="flagparecerap" id="flagparecerap" value="0">Não aprovado</div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-4">
                                            <div class="col-md-8 offset-md-2">
                                                <button type="button" class="shadow border-light btn btn-success" data-toggle="modal" data-target="#modalLongD">
                                                    ENVIAR ANÁLISE SOBRE ATIVIDADE DE LONGA DURAÇÃO
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal modalLongD -->
                        <div class="modal fade" id="modalLongD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar envio de análise</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Deseja enviar análise sobre atividade de Longa Duração?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-primary">ENVIAR</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Fim do modalLongD -->
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-1">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Qualificação Clínica</strong></label>
                    </div>
                    <div class="card-body">
                        <?php
                        $sqlqc = "select q.descricao as qcdesc, mq.id, mq.idqualifclinica, mq.titulo, mq.cargahr, mq.anexo, mq.dthrcadastro, 
                                    mq.flagparecer, mq.parecer, mq.pareceruser, mq.parecerdthr, mq.pontuacao 
                                    from aperfeicoamentoprofissional ap 
                                    inner join medico_qualifclinica mq on ap.id = mq.idaperfprof 
                                    inner join qualifclinica q on mq.idqualifclinica = q.idqualifclinica 
                                    where ap.id = '$idap';";
                        $qqc = mysqli_query($conn, $sqlqc) or die(mysqli_error($conn));
                        $nrqc = mysqli_num_rows($qqc);
                        $rsqc = mysqli_fetch_array($qqc);

                        if ($nrqc > 0) {
                            $fqc = "SIM";
                        } else {
                            $fqc = "NÃO";
                        }
                        if($nrqc > 0){
                            $auxqc = 0;
                            do{
                              $auxqc++;
                              $qcid = $rsqc['id'];  
                              $qcidqualifclinica = $rsqc['idqualifclinica'];
                              $chqc = '';
                              if($qcidqualifclinica !== null && $qcidqualifclinica !== ''){
                                  if($qcidqualifclinica === '3'){
                                      $chqc = 'Conforme CME';
                                  }else{
                                      $chqc = 'Carga Horária';
                                  }
                              }
                              $qcdesc = $rsqc['qcdesc'];  
                              $qctitulo = $rsqc['titulo'];  
                              $qccargahr = $rsqc['cargahr'];  
                              $qcanexo = $rsqc['anexo'];  
                              $qcflagparecer = $rsqc['flagparecer'];  
                              if($qcflagparecer === '' || $qcflagparecer === null){
                                  $flagqc = true;
                              }
                              $qdthrcadastro = $rsqc['dthrcadastro'];  
                              $qcparecer = trim($rsqc['parecer']);  
                              $qcpontuacao = $rsqc['pontuacao'];  
                              if($qcpontuacao === null || $qcpontuacao === ''){
                                  $qcpontuacao = 0.00;
                              }
                              $qcp += $qcpontuacao;
                              $qcpontuacaotxt = (string)$qcpontuacao;
                              $qcpontuacaotxt = str_replace(".", ",", $qcpontuacaotxt);
                              $qcpareceruser = $rsqc['pareceruser'];  
                              $qcparecerdthr = vemdata($rsqc['parecerdthr']);  
                              $qcparecerdthr .= ", às ".horaEmin($rsqc['parecerdthr']).".";
                        ?>
                        <?php
                        if($auxqc > 1){
                        ?>
                        <div class="row">
                            <div class="col-md-12 bg-dark text-white p-2 border text-center mt-4 mb-3 font-weight-bold small align-middle"><i class="fas fa-chevron-circle-right float-left mt-1"></i> &nbsp;Qualificação Clínica: Atividade <?= $auxqc ?>&nbsp; <i class="fas fa-chevron-circle-left float-right mt-1"></i></div>
                        </div>
                        <?php } ?>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Possui atividade a declarar neste item? </b>&nbsp;<?= $fqc ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Atividade: </b><?= $qcdesc ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b><?= $chqc ?>: </b><?= $qccargahr ?></li>
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Título da atividade: </b><?= $qctitulo ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Documento Anexo: </b><a class="btn btn-light text-danger" href="../../medico/aperfeicoamento_profissional/<?= $qcanexo ?>" target="_blank"><i class="far fa-file-pdf"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                        if($qcpareceruser !== '' && $qcpareceruser !== null){
                        ?>
                        <div class="card border border mb-4">
                            <div class="card-header bg-light" >
                                <label><strong>Análise realizada</strong></label>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <?php if($qcflagparecer === '1'){ 
                                            $qcpar = '<label class="text-primary">Aprovado</label>';
                                        }else{
                                            $qcpar = '<label class="text-danger">Não aprovado</label>';
                                        }
                                        ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Parecer: </b><?= $qcpar ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $qcparecer ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Análise realizado por: </b><?= $qcpareceruser ?></li>
                                        </ul>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Data e hora do envio: </b><?= $qcparecerdthr ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <?php 
                                        if($qcpontuacaotxt === '0,00'){
                                            $qcpontuacaotxt = "<label class='form-control bg-light text-danger'>$qcpontuacaotxt</label>";
                                        }else{
                                            $qcpontuacaotxt = "<label class='form-control bg-light text-primary'>$qcpontuacaotxt</label>";
                                        }
                                        ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Pontuação adquirida: </b><?= $qcpontuacaotxt ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }else{ ?>
                        <form method="post" action="controller/parecerqc.php">
                            <input type="hidden" value="<?= $cpf ?>" name="cpf">
                            <input type="hidden" value="<?= $ibge ?>" name="ibge">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $idap ?>" name="idap">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                            <input type="hidden" value="<?= $qcid ?>" name="qcid">
                            <input type="hidden" value="<?= $qccargahr ?>" name="ch">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header" style="background-color: #defff2">
                                        <label><strong>Análise sobre a atividade declarada</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-9">
                                                <div class="col-md-12"><b>Descrição da Análise</b></div>
                                                <div class="col-md-12">
                                                    <textarea style="resize: none; height: 100px;" class="form-control" name="qcparecer" id="qcparecer"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="col-md-12"><b>Parecer</b></div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="qcflagparecer" id="qcflagparecer" value="1">Aprovado</div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="qcflagparecer" id="qcflagparecer" value="0">Não aprovado</div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-4">
                                            <div class="col-md-8 offset-md-2">
                                                <button type="button" class="shadow border-light btn btn-success" data-toggle="modal" data-target="#modalQC<?= $auxqc ?>">
                                                    ENVIAR ANÁLISE SOBRE ATIVIDADE DE QUALIFICAÇÃO CLÍNICA
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal modalLongD -->
                        <div class="modal fade" id="modalQC<?= $auxqc ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar envio de análise</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Deseja enviar análise sobre atividade de Qualificação Clínica?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-primary">ENVIAR</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Fim do modalLongD -->    
                        </form>
                        <?php } ?>
                        <?php
                            }while ($rsqc = mysqli_fetch_array($qqc));
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-1">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Gestão, Ensino, Pesquisa e Extensão</strong></label>
                    </div>
                    <div class="card-body">
                        <?php
                        $sqlgepe = "select g.descricao as gdesc, mg.id, mg.idgesenspesext, mg.titulo, mg.cargahr, mg.anexo, mg.dthrcadastro, 
                                    mg.flagparecer, mg.parecer, mg.pareceruser, mg.parecerdthr,mg.pontuacao 
                                    from aperfeicoamentoprofissional ap 
                                    inner join medico_gesenspesext mg on ap.id = mg.idaperfprof 
                                    inner join gesenspesext g on mg.idgesenspesext = g.idgesenspesext  
                                    where ap.id ='$idap';";
                        $qgepe = mysqli_query($conn, $sqlgepe) or die(mysqli_error($conn));
                        $nrgepe = mysqli_num_rows($qgepe);
                        $rsgepe = mysqli_fetch_array($qgepe);

                        if ($nrgepe > 0) {
                            $fgepe = "SIM";
                        } else {
                            $fgepe = "NÃO";
                        }
                        if($nrgepe > 0){
                            $auxgepe = 0;
                            do{
                              $auxgepe++;
                              $gepeid = $rsgepe['id']; 
                              $gepeidgesenspesext = $rsgepe['idgesenspesext'];
                              $chgepe = '';
                              if($gepeidgesenspesext !== null && $gepeidgesenspesext !== ''){
                                  switch ($gepeidgesenspesext){
                                      case '1': $chgepe = 'Carga Horária'; break;
                                      case '2': $chgepe = 'Carga Horária'; break;
                                      case '3': $chgepe = 'Qtd de Publicações'; break;
                                      case '4': $chgepe = 'Qtd de Publicações'; break;
                                      case '5': $chgepe = 'Qtd de Publicações'; break;
                                      case '6': $chgepe = 'Qtd de Publicações'; break;
                                      case '7': $chgepe = 'Qtd de Participação'; break;
                                      case '8': $chgepe = 'Qtd de Participação'; break;
                                      case '9': $chgepe = 'Qtd de Participação'; break;
                                      case '10': $chgepe = 'Qtd de Horas de Atividade'; break;
                                  }
                              }
                              $gepedesc = $rsgepe['gdesc'];  
                              $gepetitulo = $rsgepe['titulo'];  
                              $gepecargahr = $rsgepe['cargahr'];  
                              $gepeanexo = $rsgepe['anexo'];  
                              $gepedthrcadastro = $rsgepe['dthrcadastro'];  
                              $gepeflagparecer = $rsgepe['flagparecer'];  
                              if($gepeflagparecer === '' || $gepeflagparecer === null){
                                  $flaggepe = true;
                              }
                              $gepeparecer = trim($rsgepe['parecer']);  
                              $gepepontuacao = $rsgepe['pontuacao'];  
                              if($gepepontuacao === null || $gepepontuacao === ''){
                                  $gepepontuacao = 0.00;
                              }
                              $gepep += $gepepontuacao;
                              $gepepontuacaotxt = (string)$gepepontuacao;  
                              $gepepontuacaotxt = str_replace(".", ",", $gepepontuacaotxt);  
                              $gepepareceruser = $rsgepe['pareceruser'];  
                              $gepeparecerdthr = vemdata($rsgepe['parecerdthr']);  
                              $gepeparecerdthr .= ", às ".horaEmin($rsgepe['parecerdthr']).".";
                        ?>
                        <?php
                        if($auxgepe > 1){
                        ?>
                        <div class="row">
                            <div class="col-md-12 bg-dark text-white p-2 border text-center mt-4 mb-3 font-weight-bold small align-middle"><i class="fas fa-chevron-circle-right float-left mt-1"></i> &nbsp;Gestão, Ensino, Pesquisa e Extensão: Atividade <?= $auxgepe ?>&nbsp; <i class="fas fa-chevron-circle-left float-right mt-1"></i></div>
                        </div>
                        <?php } ?>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Possui atividade a declarar neste item? </b>&nbsp;<?= $fgepe ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Atividade: </b><?= $gepedesc ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b><?= $chgepe ?>: </b><?= $gepecargahr ?></li>
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Título da atividade: </b><?= $gepetitulo ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Documento Anexo: </b><a class="btn btn-light text-danger" href="../../medico/aperfeicoamento_profissional/<?= $gepeanexo ?>" target="_blank"><i class="far fa-file-pdf"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                        if($gepepareceruser !== '' && $gepepareceruser !== null){
                        ?>
                        <div class="card border border mb-4">
                            <div class="card-header bg-light" >
                                <label><strong>Análise realizada</strong></label>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <?php if($gepeflagparecer === '1'){ 
                                            $gepeflagparecer = "<label class='text-primary'>Aprovado</label>";
                                        }else{
                                            $gepeflagparecer = "<label class='text-danger'>Não aprovado</label>";
                                        }
                                        ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Parecer: </b><?= $gepeflagparecer ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $gepeparecer ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Análise realizado por: </b><?= $gepepareceruser ?></li>
                                        </ul>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Data e hora do envio: </b><?= $gepeparecerdthr ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <?php 
                                        if($gepepontuacaotxt === '0,00'){
                                            $gepepontuacaotxt = "<label class='form-control bg-light text-danger'>$gepepontuacaotxt</label>";
                                        }else{
                                            $gepepontuacaotxt = "<label class='form-control bg-light text-primary'>$gepepontuacaotxt</label>";
                                        } ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Pontuação adquirida: </b><?= $gepepontuacaotxt ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }else{ ?>
                        <form method="post" action="controller/parecergepe.php">
                            <input type="hidden" value="<?= $cpf ?>" name="cpf">
                            <input type="hidden" value="<?= $ibge ?>" name="ibge">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $idap ?>" name="idap">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                            <input type="hidden" value="<?= $gepeid ?>" name="gepeid">
                            <input type="hidden" value="<?= $gepecargahr ?>" name="ch">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header" style="background-color: #defff2">
                                        <label><strong>Análise sobre a atividade declarada</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-9">
                                                <div class="col-md-12"><b>Descrição da Análise</b></div>
                                                <div class="col-md-12">
                                                    <textarea style="resize: none; height: 100px;" class="form-control"  id="gepeparecer" name="gepeparecer"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="col-md-12"><b>Parecer</b></div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="gepeflagparecer" id="gepeflagparecer" value="1">Aprovado</div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="gepeflagparecer" id="gepeflagparecer" value="0">Não aprovado</div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-4">
                                            <div class="col-md-8 offset-md-2">
                                                <button type="button" class="shadow border-light btn btn-success" data-toggle="modal" data-target="#modalgepe<?= $auxgepe ?>">
                                                    ENVIAR ANÁLISE SOBRE ATIVIDADE DE GESTÃO, ENSINO, PESQUISA E EXTENSÃO
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal modalgepe -->
                        <div class="modal fade" id="modalgepe<?= $auxgepe ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar envio de análise</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Deseja enviar análise sobre atividade de Gestão, Ensino, Pesquisa e Extensão?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-primary">ENVIAR</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Fim do modalgepe -->
                        </form>
                        <?php } ?>
                        <?php
                            }while ($rsgepe = mysqli_fetch_array($qgepe));
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-1">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Inovação Tecnológica</strong></label>
                    </div>
                    <div class="card-body">
                        <?php
                        $sqlit = "select i.descricao as idesc, mi.id, mi.idinovtecnologica, mi.titulo, mi.cargahr, mi.anexo, mi.dthrcadastro, 
                                    mi.flagparecer, mi.parecer, mi.pareceruser, mi.parecerdthr, mi.pontuacao 
                                    from aperfeicoamentoprofissional ap 
                                    inner join medico_inovtecnologica mi on ap.id = mi.idaperfprof 
                                    inner join inovtecnologica i on mi.idinovtecnologica = i.idinovtecnologica  
                                    where ap.id = '$idap';";
                        $qit = mysqli_query($conn, $sqlit) or die(mysqli_error($conn));
                        $nrit = mysqli_num_rows($qit);
                        $rsit = mysqli_fetch_array($qit);
                        if ($nrit > 0) {
                            $fit = "SIM";
                        } else {
                            $fit = "NÃO";
                        }
                        if($nrit > 0){
                            $auxit = 0;
                            do{
                              $auxit++;
                              $itid = $rsit['id'];  
                              $itidinovtecnologica = $rsit['idinovtecnologica'];
                              $chit = '';
                              if($itidinovtecnologica !== null && $itidinovtecnologica !== ''){
                                  switch ($itidinovtecnologica){
                                      case '1': $chit = "Carga Horária"; break;
                                      case '2': $chit = "Carga Horária"; break;
                                  }
                              }
                              $itdesc = $rsit['idesc'];  
                              $ittitulo = $rsit['titulo'];  
                              $itcargahr = $rsit['cargahr'];  
                              $itanexo = $rsit['anexo'];  
                              $itdthrcadastro = $rsit['dthrcadastro'];  
                              $itflagparecer = $rsit['flagparecer'];  
                              if($itflagparecer === '' || $itflagparecer === null){
                                  $flagit = true;
                              }
                              $itparecer = trim($rsit['parecer']);  
                              $itpontuacao = $rsit['pontuacao'];  
                              if($itpontuacao === null || $itpontuacao === ''){
                                  $itpontuacao = 0.00;
                              }
                              $itp += $itpontuacao;
                              $itpontuacaotxt = (string)$itpontuacao;  
                              $itpontuacaotxt = str_replace(".", ",", $itpontuacaotxt);  
                              $itpareceruser = $rsit['pareceruser'];  
                              $itparecerdthr = vemdata($rsit['parecerdthr']);  
                              $itparecerdthr .= ", às ".horaEmin($rsit['parecerdthr']).".";
                        
                              if($auxit > 1){
                        ?>
                        <div class="row">
                            <div class="col-md-12 bg-dark text-white p-2 border text-center mt-4 mb-3 font-weight-bold small align-middle"><i class="fas fa-chevron-circle-right float-left mt-1"></i> &nbsp;Inovação Tecnológica: Atividade <?= $auxit ?>&nbsp; <i class="fas fa-chevron-circle-left float-right mt-1"></i></div>
                        </div>
                        <?php } ?>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Possui atividade a declarar neste item? </b>&nbsp;<?= $fit ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Atividade: </b><?= $itdesc ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b><?= $chit ?>: </b><?= $itcargahr ?></li>
                                </ul>
                            </div>
                            <div class="col-md-9">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Título da atividade: </b><?= $ittitulo ?></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light"><b>Documento Anexo: </b><a class="btn btn-light text-danger" href="../../medico/aperfeicoamento_profissional/<?= $itanexo ?>" target="_blank"><i class="far fa-file-pdf"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                        if($itpareceruser !== '' && $itpareceruser !== null){
                        ?>
                        <div class="card border border mb-4">
                            <div class="card-header bg-light" >
                                <label><strong>Análise realizada</strong></label>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <?php 
                                        if($itflagparecer === '1'){
                                            $itflagparecer = "<label class='text-primary'>Aprovado</label>";
                                        }else{
                                            $itflagparecer = "<label class='text-danger'>Aprovado</label>";
                                        } ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Parecer: </b><?= $itflagparecer ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $itparecer ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Análise realizado por: </b><?= $itpareceruser ?></li>
                                        </ul>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Data e hora do envio: </b><?= $itparecerdthr ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <?php 
                                        if($itpontuacaotxt === '0,00'){
                                            $itpontuacaotxt = "<label class='form-control bg-light text-danger'>$itpontuacaotxt</label>";
                                        }else{
                                            $itpontuacaotxt = "<label class='form-control bg-light text-primary'>$itpontuacaotxt</label>";
                                        } ?>
                                        <ul class="list-group">
                                            <li class="list-group-item bg-light"><b>Pontuação adquirida: </b><?= $itpontuacaotxt ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }else{ ?>
                        <form method="post" action="controller/parecerit.php">
                            <input type="hidden" value="<?= $cpf ?>" name="cpf">
                            <input type="hidden" value="<?= $ibge ?>" name="ibge">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $idap ?>" name="idap">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                            <input type="hidden" value="<?= $itid ?>" name="itid">
                            <input type="hidden" value="<?= $itcargahr ?>" name="ch">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-header" style="background-color: #defff2">
                                        <label><strong>Análise sobre a atividade declarada</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-9">
                                                <div class="col-md-12"><b>Descrição da Análise</b></div>
                                                <div class="col-md-12">
                                                    <textarea style="resize: none; height: 100px;" class="form-control"  id="itparecer" name="itparecer"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="col-md-12"><b>Parecer</b></div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="itflagparecer" id="itflagparecer" value="1">Aprovado</div>
                                                <div class="col-md-12 mt-2"><input type="radio" class="" name="itflagparecer" id="itflagparecer" value="0">Não aprovado</div>
                                            </div>
                                        </div>
                                        <div class="row mb-2 mt-4">
                                            <div class="col-md-8 offset-md-2">
                                                <button type="button" class="shadow border-light btn btn-success" data-toggle="modal" data-target="#modalit<?= $auxit ?>">
                                                    ENVIAR ANÁLISE SOBRE ATIVIDADE DE INOVAÇÃO TECNOLÓGICA
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal modalLongD -->
                        <div class="modal fade" id="modalit<?= $auxit ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Confirmar envio de análise</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Deseja enviar análise sobre atividade de Inovação Tecnológica?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                                <button type="submit" class="btn btn-primary">ENVIAR</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Fim do modalLongD -->    
                        </form>
                        <?php } ?>
                        <?php
                            }while ($rsit = mysqli_fetch_array($qit));
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="ptqc" value="<?= $qcp ?>"> 
        <input type="hidden" id="ptgepe" value="<?= $gepep ?>">
        <input type="hidden" id="ptit" value="<?= $itp ?>">
<!--        <div class="row">
            <div class="col-md-4 offset-sm-4 mt-4">
                <input type="submit" class="btn btn-success p-2 form-control" name="enviaCadastro" value="ENVIAR ANÁLISE" />
                <button type="button" onclick="revisao();" class="shadow btn btn-success form-control" >ENVIAR ANÁLISE</button>
            </div>
        </div>
         Modal 
        <div class="modal fade" id="enviarModal" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content p-1 bg-light">
              <div class="modal-header border-top border-left border-right"  style="background-color: #0055A1;">
                <h5 class="modal-title text-white" id="exampleModalLabel">Confirmação de envio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body border-top border-left border-right">
                  <div class="row">
                      <div class="col-md-12 p-3">
                            <p class="text-primary">Confirma o envio do cadastro?</p>
                      </div>
                  </div>
              </div>
              <div class="modal-footer border">
                  <button type="button" class="btn btn-secondary " data-dismiss="modal">NÃO</button> &nbsp; 
                  <button type="submit" name="enviaCadastro" class="btn btn-success">&nbsp; SIM &nbsp;</button>
              </div>
            </div>
          </div>
        </div>-->
        </form>
        <?php 
        $somapt = $pontuacaoap + $qcp + $gepep + $itp;
//        var_dump($somapt);
//        var_dump($flagld,$flagqc,$flaggepe,$flagit);
        if($flagld === false && $flagqc === false && $flaggepe === false && $flagit === false){ 
            if($somapt >= 50.00){ ?>
                <input type="hidden" id="flags" value="1">
        <?php }else{ ?>
                <input type="hidden" id="flags" value="2">
        <?php }}else{ ?>
                <input type="hidden" id="flags" value="0">
        <?php } ?>
            </div>
            <input type="hidden" id="somapt" value="<?= $somapt ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <br>
    <?php include '../../includes/footer.php'; ?>
    <script src="../../js_agsus/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="addcamps.js"></script>
    <script>
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
        document.getElementById("conteudo").style.display = "inline";
    }, 1000);
    </script>
    <script>
    $(document).ready(function (){
       $('.divLongDuracao').hide();
       $('.divQualiClinica').hide();
       $('.divGesEnsPesExt').hide();
       $('.divInovTec').hide();
       $('#email50Mais').hide();
       $('#emailAbaixo50').hide();
       $('#enviarModal').modal('hide');
       let ptgeral = 0.00;
       if($('#ptld').val() !== null && $('#ptld').val() !== ''){
           let ptld = parseFloat($('#ptld').val());
           ptgeral = ptgeral + ptld;
       }
       if($('#ptqc').val() !== null && $('#ptqc').val() !== ''){
           let ptqc = parseFloat($('#ptqc').val());
           ptgeral = ptgeral + ptqc;
       }
       console.log($('#ptqc').val());
       if($('#ptgepe').val() !== null && $('#ptgepe').val() !== ''){
           let ptgepe = parseFloat($('#ptgepe').val());
           ptgeral = ptgeral + ptgepe;
       }
       console.log($('#ptgepe').val());
       if($('#ptit').val() !== null && $('#ptit').val() !== ''){
           let ptit = parseFloat($('#ptit').val());
           ptgeral = ptgeral + ptit;
       }
       console.log($('#ptit').val());
       if(isNaN(ptgeral)){
           ptgeral = "0,00";
       }
       ptgeral = parseFloat($('#somapt').val());
       ptgeraltxt = ""+ptgeral;
       ptgeraltxt = ptgeraltxt.replace('.',',');
       if(ptgeraltxt.indexOf(',') === -1){
           ptgeraltxt = ptgeraltxt+",00";
       }
       $('#ptgeral').val(ptgeraltxt);
       console.log($("#flags").val());
       if($("#flags").val() === '1'){
           $('#email50Mais').show();
       }else if($("#flags").val() === '2'){
           $('#emailAbaixo50').show();
       }else{
           $('#email50Mais').hide();
           $('#emailAbaixo50').hide();
       }
    });
    $('#rdativ').change(function(){
        let rdativ = $('#rdativ').val();
        if(rdativ === '1'){
            $('.divLongDuracao').show(400);
        }else{
            $('.divLongDuracao').hide(300);
        }
    });
    $('#rdQual').click(function(){
        let rdQual = $('#rdQual').val();
        if(rdQual === '1'){
            $('.divQualiClinica').show(400);
        }else{
            $('.divQualiClinica').hide(300);
        }
    });
    $('#rdGes').click(function(){
        let rdGes = $('#rdGes').val();
        if(rdGes === '1'){
            $('.divGesEnsPesExt').show(400);
        }else{
            $('.divGesEnsPesExt').hide(300);
        }
    });
    $('#rdInov').click(function(){
        let rdInov = $('#rdInov').val();
        if(rdInov === '1'){
            $('.divInovTec').show(400);
        }else{
            $('.divInovTec').hide(300);
        }
    });
    $('#btnLongaDuracao').click(function(){
       let a = 0;
       a = document.querySelectorAll('.divLongDuracao').length;
//       console.log(a);
       addAtvLongDuracao(a);
    });
    $('#btnQualiClinica').click(function(){
       let slQualiClinica = $('#slQualiClinica').val();
       let cargahrQualiClinica = $('#cargahrQualiClinica').val();
       let tituloQualiClinica = $('#tituloQualiClinica').val().trim();
       let anexoQualiClinica = $('#anexoQualiClinica').val();
       if(slQualiClinica === '' || cargahrQualiClinica === '' || tituloQualiClinica === '' || anexoQualiClinica === ''){
           swal({
                title: "Atenção!",
                text: "Preencha os campos da atividade Qualificação Clínica!",
                icon: "warning",
                button: "OK"
            });
            return;
       }
       let a = 0;
       a = document.querySelectorAll('.divQualiClinica').length;
//       console.log(a);
       addQualiClinica(a);
    });
    $('#btnGesEnsPesExt').click(function(){
       let slGesEnsPesExt = $('#slGesEnsPesExt').val();
       let cargahrGesEnsPesExt = $('#cargahrGesEnsPesExt').val();
       let tituloGesEnsPesExt = $('#tituloGesEnsPesExt').val().trim();
       let anexoGesEnsPesExt = $('#anexoGesEnsPesExt').val();
       if(slGesEnsPesExt === '' || cargahrGesEnsPesExt === '' || tituloGesEnsPesExt === '' || anexoGesEnsPesExt === ''){
           swal({
                title: "Atenção!",
                text: "Preencha os campos da atividade Gestão, Ensino, Pesquisa e Extensão!",
                icon: "warning",
                button: "OK"
            });
            return;
       }
       let a = 0;
       a = document.querySelectorAll('.divGesEnsPesExt').length;
//       console.log(a);
       addGesEnsPesExt(a);
    });
    $('#btnInovTec').click(function(){
       let slInovTec = $('#slInovTec').val();
       let cargahrInovTec = $('#cargahrInovTec').val();
       let tituloInovTec = $('#tituloInovTec').val().trim();
       let anexoInovTec = $('#anexoInovTec').val();
       if(slInovTec === '' || cargahrInovTec === '' || tituloInovTec === '' || anexoInovTec === ''){
           swal({
                title: "Atenção!",
                text: "Preencha os campos da atividade Inovação Tecnológica!",
                icon: "warning",
                button: "OK"
            });
            return;
       }
       let a = 0;
       a = document.querySelectorAll('.divInovTec').length;
//       console.log(a);
       addInovTec(a);
    });
    function retiraAtvLongDur(num){
        $('#atvLongDur'+num).remove();
        $('#cargaLongDur'+num).remove();
        $('#anexoLongDur'+num).remove();
        $('#btnLongDur'+num).remove();
    }
    function retiraQualiClinica(num){
        $('#qualiClinica'+num).remove();
        $('#divcargaQualiClinica'+num).remove();
        $('#divtituloQualiClinica'+num).remove();
        $('#divanexoQualiClinica'+num).remove();
        $('#divbtnQualiClinica'+num).remove();
    }
    function retiraGesEnsPesExt(num){
        $('#gesEnsPesExt'+num).remove();
        $('#divcargaGesEnsPesExt'+num).remove();
        $('#divtituloGesEnsPesExt'+num).remove();
        $('#divanexoGesEnsPesExt'+num).remove();
        $('#divbtnGesEnsPesExt'+num).remove();
    }
    function retiraInovTec(num){
        $('#inovTec'+num).remove();
        $('#divcargaInovTec'+num).remove();
        $('#divtituloInovTec'+num).remove();
        $('#divanexoInovTec'+num).remove();
        $('#divbtnInovTec'+num).remove();
    }
    function revisao(){
        let rdativ = $('#rdativ').val();
        let rdQual = $('#rdQual').val();
        let rdGes = $('#rdGes').val();
        let rdInov = $('#rdInov').val();
        let analise = true;
        if(rdativ === '0' && rdQual === '0' && rdGes === '0' && rdInov === '0'){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Ao mennos uma atividade deve ser preenchida!",
                icon: "warning",
                button: "OK"
            });
            $('#rdativ').focus(); return;
        }else{
            analise = true;
        }
        if(rdativ === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Atividade de Longa Duração!",
                icon: "warning",
                button: "OK"
            });
//          alert('Responda a pergunta no item Atividade de Longa Duração');
            $('#rdativ').focus(); return;
        }else{
            analise = true;
        }
        if(rdQual === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Qualificação Clínica!",
                icon: "warning",
                button: "OK"
            });
//            alert('Responda a pergunta no item Qualificação Clínica');
            $('#rdQual').focus(); return;
        }else{
            if(rdQual === '1'){
                let slQualiClinica = $('#slQualiClinica').val();
                let cargahrQualiClinica = $('#cargahrQualiClinica').val();
                let tituloQualiClinica = $('#tituloQualiClinica').val().trim();
                let anexoQualiClinica = $('#anexoQualiClinica').val();
//                console.log(anexoQualiClinica);
                if(slQualiClinica === '' || cargahrQualiClinica === '' || tituloQualiClinica === '' || anexoQualiClinica === ''){
                    analise = false;
                    swal({
                        title: "Atenção!",
                        text: "Preencha os campos no item Qualificação Clínica!",
                        icon: "warning",
                        button: "OK"
                    });
    //                alert('Preencha os campos no item Qualificação Clínica');
                    if(slQualiClinica === ''){
                        $('#slQualiClinica').focus(); return;
                    }
                    if(cargahrQualiClinica === ''){
                        $('#cargahrQualiClinica').focus(); return;
                    }
                    if(tituloQualiClinica === ''){
                        $('#tituloQualiClinica').focus(); return;
                    }
                    if(anexoQualiClinica === ''){
                        $('#anexoQualiClinica').focus(); return;
                    }
                }
            }else{
                analise = true;
            }
        }
        if(rdGes === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Gestão, Ensino, Pesquisa e Extensão!",
                icon: "warning",
                button: "OK"
            });
//            alert('Responda a pergunta no item Gestão, Ensino, Pesquisa e Extensão');
            $('#rdGes').focus(); return;
        }else{
            if(rdGes === '1'){
                let slGesEnsPesExt = $('#slGesEnsPesExt').val();
                let cargahrGesEnsPesExt = $('#cargahrGesEnsPesExt').val();
                let tituloGesEnsPesExt = $('#tituloGesEnsPesExt').val().trim();
                let anexoGesEnsPesExt = $('#anexoGesEnsPesExt').val();
//                console.log(anexoQualiClinica);
                if(slGesEnsPesExt === '' || cargahrGesEnsPesExt === '' || tituloGesEnsPesExt === '' || anexoGesEnsPesExt === ''){
                    analise = false;
                    swal({
                        title: "Atenção!",
                        text: "Preencha os campos no item Gestão, Ensino, Pesquisa e Extensão!",
                        icon: "warning",
                        button: "OK"
                    });
    //                alert('Preencha os campos no item Gestão, Ensino, Pesquisa e Extensão');
                    if(slGesEnsPesExt === ''){
                        $('#slGesEnsPesExt').focus(); return;
                    }
                    if(cargahrGesEnsPesExt === ''){
                        $('#cargahrGesEnsPesExt').focus(); return;
                    }
                    if(tituloGesEnsPesExt === ''){
                        $('#tituloGesEnsPesExt').focus(); return;
                    }
                    if(anexoGesEnsPesExt === ''){
                        $('#anexoGesEnsPesExt').focus(); return;
                    }
                }else{
                    analise = true;
                }
            }
        }
        if(rdInov === ''){
            analise = false;
//            console.log(analise);
            swal({
                title: "Atenção!",
                text: "Responda a pergunta no item Inovação Tecnológica!",
                icon: "warning",
                button: "OK"
            });
//            alert('Responda a pergunta no item Inovação Tecnológica');
            $('#rdInov').focus(); return;
        }else{
            if(rdInov === '1'){
                let slInovTec = $('#slInovTec').val();
                let cargahrInovTec = $('#cargahrInovTec').val();
                let tituloInovTec = $('#tituloInovTec').val().trim();
                let anexoInovTec = $('#anexoInovTec').val();
//                console.log(anexoQualiClinica);
                if(slInovTec === '' || cargahrInovTec === '' || tituloInovTec === '' || anexoInovTec === ''){
                    analise = false;
                    swal({
                        title: "Atenção!",
                        text: "Preencha os campos no item Inovação Tecnológica!",
                        icon: "warning",
                        button: "OK"
                    });
    //                alert('Preencha os campos no item Inovação Tecnológica');
                    if(slInovTec === ''){
                        $('#slInovTec').focus(); return;
                    }
                    if(cargahrInovTec === ''){
                        $('#cargahrInovTec').focus(); return;
                    }
                    if(tituloInovTec === ''){
                        $('#tituloInovTec').focus(); return;
                    }
                    if(anexoInovTec === ''){
                        $('#anexoInovTec').focus(); return;
                    }
                }else{
                    analise = true;
                }
            }
        }
        if(analise === true){
            $('#enviarModal').modal('show');
        }else{
            $('#enviarModal').modal('hide');
        }
//        console.log(analise);
    }
    
    // Selecionar o botão e a imagem da ampulheta
    const btenvsup50 = document.getElementById('btenvsup50');
    const loading1 = document.getElementById('loading1');
    loading1.style.display = 'none';
    // Adicionar um evento de clique ao botão ENVIAR E-MAIL
    btenvsup50.addEventListener('click', function() {
        // Mostrar a imagem da ampulheta
        loading1.style.display = 'block';
        // Simular um atraso de envio de e-mail (somente para fins de demonstração)
        setTimeout(function() {
          // Ocultar o modal após o envio
          $('#modalSup50').modal('hide');
          // Ocultar novamente a imagem da ampulheta após fechar o modal
          loading1.style.display = 'none';
        }, 3000); // 3 segundos simulados de envio
    });
    // Selecionar o botão e a imagem da ampulheta
    const btenvinf50 = document.getElementById('btenvinf50');
    const loading2 = document.getElementById('loading2');
    loading2.style.display = 'none';
    // Adicionar um evento de clique ao botão ENVIAR E-MAIL
    btenvinf50.addEventListener('click', function() {
    // Mostrar a imagem da ampulheta
        loading2.style.display = 'block';
        // Simular um atraso de envio de e-mail (somente para fins de demonstração)
        setTimeout(function() {
          // Ocultar o modal após o envio
          $('#modalInf50').modal('hide');
          // Ocultar novamente a imagem da ampulheta após fechar o modal
          loading2.style.display = 'none';
        }, 3000); // 3 segundos simulados de envio
    });
    </script>
</body>

</html>