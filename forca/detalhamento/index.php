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
    ap.parecer as parecerap, ap.pareceruser as pareceruserap, ap.parecerdthr as parecerdthrap 
    from medico m inner join aperfeicoamentoprofissional ap on m.cpf = ap.cpf and 
    m.ibge = ap.ibge and m.cnes = ap.cnes and m.ine = ap.ine 
    inner join municipio mun on mun.cod_munc = m.ibge 
    inner join estado e on mun.Estado_cod_uf = e.cod_uf 
    inner join ivs on ivs.idivs = m.fkivs 
    where m.cpf = '$cpf' and m.ibge = '$ibge' and m.cnes = '$cnes' and m.ine = '$ine' "
        . "and ap.ano = '$ano' and ap.ciclo='$ciclo'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$rs = mysqli_fetch_array($query);
$municipioO = $ufO = "";
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
    }while ($rs = mysqli_fetch_array($query));
}
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
                        <div class="card border">
                            <div class="card-header text-white bg-dark">
                                <h5 class="text-white"><b>Comprovante de Aperfeiçoamento Profissional - Formulário Preenchido</b></h5>
                            </div>
                            <div class="card-body">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Dados do Tutor</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Nome</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $medico ?>" id="medico" /></div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>CPF</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cpfmask ?>" id="cpf" /></div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-md-12"><b>Cargo</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cargo ?>" id="cargo" /></div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-md-12"><b>Admissão</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $admissao ?>" id="admissao" /></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Município de Origem</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $municipioO ?>-<?= $ufO ?>" id="medico" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>CNES</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cnes ?>" id="cnes" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>INE</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ine ?>" id="ine" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>IVS</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ivs ?>" id="ivs" /></div>
                            </div>
                        </div>
<!--                        <hr class="mt-4">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Pontuação dos itens aprovados</b></div>
                                <div class="col-md-12"><input type="text" class="form-control bg-light font-weight-bold text-primary" disabled="disabled" id="ptgeral" /></div>
                            </div>
                            <div class="col-md-6" id="email50Mais">
                                <div class="col-md-12"><b>Enviar E-Mail para o Médico - igual ou superior a 50 pontos.</b></div>
                                <div class="col-md-12"><button type="button" class="shadow-sm border-light btn btn-warning form-control" ><i class="fas fa-mail-bulk"></i>&nbsp; Igual ou superior a 50 pontos</button></div>
                            </div>
                            <div class="col-md-6" id="emailAbaixo50">
                                <div class="col-md-12"><b>Enviar E-Mail para o Médico - abaixo de 50 pontos</b></div>
                                <div class="col-md-12"><button type="button" class="shadow-sm border-light btn btn-warning form-control" ><i class="fas fa-mail-bulk"></i>&nbsp; Abaixo de 50 pontos</button></div>
                            </div>
                        </div>
                        <hr>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-1">
                    <div class="card-header bg-secondary text-white" >
                        <label><strong>Análise realizada - Pontuação</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Pontuação dos itens aprovados</b></div>
                                <div class="col-md-12"><input type="text" class="form-control bg-light font-weight-bold text-primary" disabled="disabled" id="ptgeral" /></div>
                            </div>
                            <div class="col-md-6" id="email50Mais">
                                <div class="col-md-12"><b>Enviar E-Mail para o Médico - igual ou superior a 50 pontos.</b></div>
                                <div class="col-md-12"><button type="button" class="shadow-sm border-light btn btn-warning form-control" ><i class="fas fa-mail-bulk"></i>&nbsp; Igual ou superior a 50 pontos</button></div>
                            </div>
                            <div class="col-md-6" id="emailAbaixo50">
                                <div class="col-md-12"><b>Enviar E-Mail para o Médico - abaixo de 50 pontos</b></div>
                                <div class="col-md-12"><button type="button" class="shadow-sm border-light btn btn-warning form-control" ><i class="fas fa-mail-bulk"></i>&nbsp; Abaixo de 50 pontos</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Atividade de Longa Duração</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração?</b></div>
                                <?php
                                if($flagald === '1'){
                                    $fald = "SIM";
                                }else{
                                    $fald = "NÃO";
                                }
                                ?>
                                <div class="col-md-6"><input type="text" class="form-control" disabled="disabled" value="<?= $fald ?>" id="fald" /></div>
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
                                        <div class="col-md-12"><b>Parecer</b></div>
                                        <div class="col-md-12">
                                            <?php if($flagparecerap === '1'){ ?>
                                                <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="Aprovado" id="pareceruserap1" />
                                            <?php }else{ ?>
                                                <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="Não aprovado" id="pareceruserap2" />
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12"><b>Descrição da Análise</b></div>
                                        <div class="col-md-12">
                                            <textarea style="resize: none; height: 100px;" class="form-control bg-light" disabled="disabled" id="parecerap"><?= $parecerap ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12"><b>Análise realizado por:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $pareceruserap ?>" id="pareceruserap" />
                                        </div>
                                        <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $parecerdthrap ?>" id="parecerdthrap" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                        <div class="col-md-12">
                                            <?php if($pontuacaoaptxt === '0,00'){ ?>
                                            <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $pontuacaoaptxt ?>" id="pontuacaoaptxt1" />    
                                            <?php }else{ ?>
                                            <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $pontuacaoaptxt ?>" id="pontuacaoaptxt2" />
                                            <?php } ?>
                                        </div>
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
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Qualificação Clínica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <?php
                                $sqlqc = "select q.descricao as qcdesc, mq.id, mq.titulo, mq.cargahr, mq.anexo, mq.dthrcadastro, 
                                    mq.flagparecer, mq.parecer, mq.pareceruser, mq.parecerdthr, mq.pontuacao 
                                    from aperfeicoamentoprofissional ap 
                                    inner join medico_qualifclinica mq on ap.id = mq.idaperfprof 
                                    inner join qualifclinica q on mq.idqualifclinica = q.idqualifclinica 
                                    where ap.id = '$idap';";
                                $qqc = mysqli_query($conn, $sqlqc) or die(mysqli_error($conn));
                                $nrqc = mysqli_num_rows($qqc);
                                $rsqc = mysqli_fetch_array($qqc);
                                ?>
                                    <?php
                                    if($nrqc > 0){
                                        $fqc = "SIM";
                                    }else{
                                        $fqc = "NÃO";
                                    }
                                    ?>
                                <div class="col-md-3"><input type="text" class="form-control" disabled="disabled" value="<?= $fqc ?>" id="fqc" /></div> 
                            </div>
                        </div>
                        <?php
                        if($nrqc > 0){
                            $auxqc = 0;
                            do{
                              $auxqc++;
                              $qcid = $rsqc['id'];  
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
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <textarea class="form-control" style="resize: none;" disabled="disabled" id="qcdesc"><?= $qcdesc ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $qccargahr ?>"  /></div>
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $qctitulo ?>" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Documento Anexo</b></div>
                                <div class="col-md-12"><a class="btn btn-light text-danger" href="../../medico/aperfeicoamento_profissional/<?= $qcanexo ?>" target="_blank"><i class="far fa-file-pdf"></i></a></div>
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
                                        <div class="col-md-12"><b>Parecer</b></div>
                                        <div class="col-md-12">
                                            <?php if($qcflagparecer === '1'){ ?>
                                                <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="Aprovado" id="qcflagparecer1" />
                                            <?php }else{ ?>
                                                <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="Não aprovado" id="qcflagparecer2" />
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12"><b>Descrição da Análise</b></div>
                                        <div class="col-md-12">
                                            <textarea style="resize: none; height: 100px;" class="form-control bg-light" disabled="disabled" id="qcparecer"><?= $qcparecer ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12"><b>Análise realizado por:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $qcpareceruser ?>" id="qcpareceruser" />
                                        </div>
                                        <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $qcparecerdthr ?>" id="qcparecerdthr" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                        <div class="col-md-12">
                                            <?php if($qcpontuacaotxt === '0,00'){ ?>
                                            <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $qcpontuacaotxt ?>" id="qcpontuacaotxt1" />    
                                            <?php }else{ ?>
                                            <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $qcpontuacaotxt ?>" id="qcpontuacaotxt2" />
                                            <?php } ?>
                                        </div>
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
                        <hr>
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
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Gestão, Ensino, Pesquisa e Extensão</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <?php
                                $sqlgepe = "select g.descricao as gdesc, mg.id, mg.titulo, mg.cargahr, mg.anexo, mg.dthrcadastro, 
                                    mg.flagparecer, mg.parecer, mg.pareceruser, mg.parecerdthr,mg.pontuacao 
                                    from aperfeicoamentoprofissional ap 
                                    inner join medico_gesenspesext mg on ap.id = mg.idaperfprof 
                                    inner join gesenspesext g on mg.idgesenspesext = g.idgesenspesext  
                                    where ap.id ='$idap';";
                                $qgepe = mysqli_query($conn, $sqlgepe) or die(mysqli_error($conn));
                                $nrgepe = mysqli_num_rows($qgepe);
                                $rsgepe = mysqli_fetch_array($qgepe);
                                ?>
                                    <?php
                                    if($nrgepe > 0){
                                        $fgepe = "SIM";
                                    }else{
                                        $fgepe = "NÃO";
                                    }
                                    ?>
                                <div class="col-md-3"><input type="text" class="form-control" disabled="disabled" value="<?= $fgepe ?>" id="fgepe" /></div> 
                            </div>
                        </div>
                        <?php
                        if($nrgepe > 0){
                            $auxgepe = 0;
                            do{
                              $auxgepe++;
                              $gepeid = $rsgepe['id'];  
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
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <textarea class="form-control" style="resize: none;" disabled="disabled" id="qcdesc"><?= $gepedesc ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $gepecargahr ?>"  /></div>
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $gepetitulo ?>" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Documento Anexo</b></div>
                                <div class="col-md-12"><a class="btn btn-light text-danger" href="../../medico/aperfeicoamento_profissional/<?= $gepeanexo ?>" target="_blank"><i class="far fa-file-pdf"></i></a></div>
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
                                        <div class="col-md-12"><b>Parecer</b></div>
                                        <div class="col-md-12">
                                            <?php if($gepeflagparecer === '1'){ ?>
                                                <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="Aprovado" id="gepeflagparecer1" />
                                            <?php }else{ ?>
                                                <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="Não aprovado" id="gepeflagparecer2" />
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12"><b>Descrição da Análise</b></div>
                                        <div class="col-md-12">
                                            <textarea style="resize: none; height: 100px;" class="form-control bg-light" disabled="disabled" id="gepeparecer"><?= $gepeparecer ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12"><b>Análise realizado por:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $gepepareceruser ?>" id="gepepareceruser"/>
                                        </div>
                                        <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $gepeparecerdthr ?>" id="gepeparecerdthr" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                        <div class="col-md-12">
                                            <?php if($gepepontuacaotxt === '0,00'){ ?>
                                            <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $gepepontuacaotxt ?>" id="gepepontuacaotxt1" />    
                                            <?php }else{ ?>
                                            <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $gepepontuacaotxt ?>" id="gepepontuacaotxt2" />
                                            <?php } ?>
                                        </div>
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
                        <hr>
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
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Inovação Tecnológica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <?php
                                $sqlit = "select i.descricao as idesc, mi.id, mi.titulo, mi.cargahr, mi.anexo, mi.dthrcadastro, 
                                    mi.flagparecer, mi.parecer, mi.pareceruser, mi.parecerdthr, mi.pontuacao 
                                    from aperfeicoamentoprofissional ap 
                                    inner join medico_inovtecnologica mi on ap.id = mi.idaperfprof 
                                    inner join inovtecnologica i on mi.idinovtecnologica = i.idinovtecnologica  
                                    where ap.id = '$idap';";
                                $qit = mysqli_query($conn, $sqlit) or die(mysqli_error($conn));
                                $nrit = mysqli_num_rows($qit);
                                $rsit = mysqli_fetch_array($qit);
                                ?>
                                    <?php
                                    if($nrit > 0){
                                        $fit = "SIM";
                                    }else{
                                        $fit = "NÃO";
                                    }
                                    ?>
                                <div class="col-md-3"><input type="text" class="form-control" disabled="disabled" value="<?= $fit ?>" id="fgepe" /></div> 
                            </div>
                        </div>
                        <?php
                        if($nrit > 0){
                            $auxit = 0;
                            do{
                              $auxit++;
                              $itid = $rsit['id'];  
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
                        ?>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <textarea style="resize: none; height: 100px;" class="form-control" disabled="disabled" id="qcdesc" ><?= $itdesc ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $itcargahr ?>"  /></div>
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ittitulo ?>" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Documento Anexo</b></div>
                                <div class="col-md-12"><a class="btn btn-light text-danger" href="../../medico/aperfeicoamento_profissional/<?= $itanexo ?>" target="_blank"><i class="far fa-file-pdf"></i></a></div>
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
                                        <div class="col-md-12"><b>Parecer</b></div>
                                        <div class="col-md-12">
                                            <?php if($itflagparecer === '1'){ ?>
                                                <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="Aprovado" id="itflagparecer1" />
                                            <?php }else{ ?>
                                                <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="Não aprovado" id="itflagparecer2" />
                                            <?php } ?>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12"><b>Descrição da Análise</b></div>
                                        <div class="col-md-12">
                                            <textaarea style="resize: none;" class="form-control bg-light" disabled="disabled" id="itdesc" ><?= $itparecer ?></textaarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12"><b>Análise realizado por:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $itpareceruser ?>" id="itdesc" />
                                        </div>
                                        <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $itparecerdthr ?>" id="itdesc" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                        <div class="col-md-12">
                                            <?php if($itpontuacaotxt === '0,00'){ ?>
                                            <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $itpontuacaotxt ?>" id="itpontuacaotxt1" />    
                                            <?php }else{ ?>
                                            <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $itpontuacaotxt ?>" id="itpontuacaotxt2" />
                                            <?php } ?>
                                        </div>
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
                        <hr>
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
    </script>
</body>

</html>