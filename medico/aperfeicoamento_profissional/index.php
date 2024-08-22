<?php
session_start();
include '../../conexao_agsus_2.php';
include '../../conexao-agsus.php';
include '../../Controller_agsus/maskCpf.php';
include '../../Controller_agsus/fdatas.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
//var_dump($_SESSION['msg']);
$cpftratado = '00101831161';
$cpf = substr_replace($cpftratado, "-", 9, 0);
$cpf = substr_replace($cpf, ".", 6, 0);
$cpf = substr_replace($cpf, ".", 3, 0);
$medico = 'CAROLINA MILITAO SPAGNOL';
$ibgeO = '352690';
$cnes = '3797902';
$ine = '1587021';
$ano = '2024';
$ciclo = '1';
$_SESSION['cpf'] = $cpftratado;
$_SESSION['nome'] = $medico;
$sql = "select * from municipio m inner join estado e on m.Estado_cod_uf = e.cod_uf "
        . "and m.cod_munc = '$ibgeO'";
$query = mysqli_query($conn2, $sql) or die(mysqli_error($conn2));
$rs = mysqli_fetch_array($query);
$municipioO = $ufO = "";
if($rs){
    do{
        $municipioO = $rs['Municipio'];
        $ufO = $rs['UF'];
    }while ($rs = mysqli_fetch_array($query));
}
$sql2 = "select m.nome, m.admissao, m.cargo, mun.Municipio, e.UF, ivs.descricao, ap.id, 
    ap.dthrcadastro, ap.flagativlongduracao, ap.flagparecer as flagparecerap, ap.pontuacao,
    ap.parecer as parecerap, ap.pareceruser as pareceruserap, ap.parecerdthr as parecerdthrap 
    from medico m inner join aperfeicoamentoprofissional ap on m.cpf = ap.cpf and 
    m.ibge = ap.ibge and m.cnes = ap.cnes and m.ine = ap.ine 
    inner join municipio mun on mun.cod_munc = m.ibge 
    inner join estado e on mun.Estado_cod_uf = e.cod_uf 
    inner join ivs on ivs.idivs = m.fkivs 
    where m.cpf = '$cpftratado' and m.ibge = '$ibgeO' and m.cnes = '$cnes' and m.ine = '$ine'  
    and ap.ano = '$ano' and ap.ciclo='$ciclo';";
$query2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
$nrrs2 = mysqli_num_rows($query2);
$rs2 = mysqli_fetch_array($query2);
$rsld = $rs2;
//var_dump($rsld);
$flagld = $flagqc = $flaggepe = $flagit = false;
$idap = null;
if($rs2){
    do{
        $idap = $rs2['id'];
        $medico = $rs2['nome'];
        $admissao = $rs2['admissao'];
        $cargo = $rs2['cargo'];
        $ivs = $rs2['descricao'];
        $flagald = $rs2['flagativlongduracao'];
        $flagparecerap = $rs2['flagparecerap'];
        //verifica se há parecer negativo para essa a atividade de Longa Duração
        if($flagparecerap === '0'){
            $flagld = true;
        }
        $parecerap = $rs2['parecerap'];
        $pareceruserap = $rs2['pareceruserap'];
        $parecerdthrap = vemdata($rs2['parecerdthrap']);  
        $parecerdthrap .= ", às ".horaEmin($rs2['parecerdthrap']).".";
    }while ($rs2 = mysqli_fetch_array($query2));
}
//verifica se há parecer negativo para essa a atividade Qualificação Clínica
$sqlqc = "select q.descricao as qcdesc, mq.id, mq.titulo, mq.cargahr, mq.anexo, mq.dthrcadastro, 
    mq.flagparecer, mq.parecer, mq.pareceruser, mq.parecerdthr, mq.pontuacao 
    from aperfeicoamentoprofissional ap 
    inner join medico_qualifclinica mq on ap.id = mq.idaperfprof 
    inner join qualifclinica q on mq.idqualifclinica = q.idqualifclinica 
    where ap.id = '$idap';";
$qqc = mysqli_query($conn, $sqlqc) or die(mysqli_error($conn));
$nrqc = mysqli_num_rows($qqc);
$rsqc = mysqli_fetch_array($qqc);
//verifica se há parecer negativo para essa a atividade Gestão, Ensino, Pesquisa e Extensão
$sqlgepe = "select g.descricao as gdesc, mg.id, mg.titulo, mg.cargahr, mg.anexo, mg.dthrcadastro, 
    mg.flagparecer, mg.parecer, mg.pareceruser, mg.parecerdthr,mg.pontuacao 
    from aperfeicoamentoprofissional ap 
    inner join medico_gesenspesext mg on ap.id = mg.idaperfprof 
    inner join gesenspesext g on mg.idgesenspesext = g.idgesenspesext  
    where ap.id ='$idap';";
$qgepe = mysqli_query($conn, $sqlgepe) or die(mysqli_error($conn));
$nrgepe = mysqli_num_rows($qgepe);
$rsgepe = mysqli_fetch_array($qgepe);
//verifica se há parecer negativo para essa a atividade Inovação Tecnológica
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
                        <div class="card border-0">
                            <div class="card-header text-white bg-dark">
                                <h5 class="text-white"><b>Cadastro do Comprovante de Aperfeiçoamento Profissional</b></h5>
                            </div>
                            <div class="card-body">
        <div class="row mb-4 mt-2">
            <div class="col-md-12">
                <div class="card border-1 ">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Período avaliativo</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Ano</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ano ?>" id="ano" name="ano" /></div>
                            </div>
                            <div class="col-md-3">
                                <div class="col-md-12"><b>Ciclo</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $ciclo ?>" id="ciclo" name="ciclo" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-1 ">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Dados Pessoais</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Nome</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $medico ?>" id="medico" /></div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>CPF</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" value="<?= $cpf ?>" id="cpf" /></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
//                        var_dump($nrrs2);
        if($nrrs2 === 0){
        ?>
        <form method="post" enctype="multipart/form-data" action="controller/rcb.php">
            <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
            <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
            <input type="hidden" value="<?= $cnes ?>" name="cnes">
            <input type="hidden" value="<?= $ine ?>" name="ine">
            <input type="hidden" value="<?= $ano ?>" name="ano">
            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-1 ">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Atividade de Longa Duração</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração?</b></div>
                                <div class="col-md-6">
                                    <select class="form-control " id="rdativ" name="rdativ">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Qualificação Clínica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <div class="col-md-3">
                                    <select class="form-control " id="rdQual" name="rdQual">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <select class="form-control" id="slQualiClinica" name="slQualiClinica">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlqualifcli = "select idqualifclinica as idq, descricao as descq from qualifclinica";
                                        $qqualifcli = mysqli_query($conn, $sqlqualifcli) or die(mysqli_error($conn));
                                        $rsqualifcli = mysqli_fetch_array($qqualifcli);
                                        if($rsqualifcli !== null){
                                            do{ 
                                                $idq = $rsqualifcli['idq'];
                                                $descq = $rsqualifcli['descq'];
                                                ?>
                                                <option value="<?= $idq ?>"><?= $descq ?></option>
                                        <?php    
                                            }while ($rsqualifcli = mysqli_fetch_array($qqualifcli));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrQualiClinica" name="cargahrQualiClinica" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" id="tituloQualiClinica" name="tituloQualiClinica" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Anexar documento</b></div>
                                <div class="col-md-12"><input type="file" class="form-control" id="anexoQualiClinica" name="anexoQualiClinica" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica">
                            <div class="col-md-6">
                                <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnQualiClinica" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica">
                            <div class="col-md-12 pl-5">
                                <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Clique conforme o número de atividades a serem preenchidas.</small>
                            </div>
                        </div>
                        <div class="row mb-2 divQualiClinica" id="divQualiClinica1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-1 ">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Gestão, Ensino, Pesquisa e Extensão</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <div class="col-md-3">
                                    <select class="form-control " id="rdGes" name="rdGes">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <select class="form-control" id="slGesEnsPesExt" name="slGesEnsPesExt">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlgesenspesext = "select idgesenspesext as idg, descricao as descg from gesenspesext";
                                        $qgesenspesext = mysqli_query($conn, $sqlgesenspesext) or die(mysqli_error($conn));
                                        $rsgesenspesext = mysqli_fetch_array($qgesenspesext);
                                        if($rsgesenspesext !== null){
                                            do{ 
                                                $idg = $rsgesenspesext['idg'];
                                                $descg = $rsgesenspesext['descg'];
                                                ?>
                                                <option value="<?= $idg ?>"><?= $descg ?></option>
                                        <?php    
                                            }while ($rsgesenspesext = mysqli_fetch_array($qgesenspesext));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrGesEnsPesExt" name="cargahrGesEnsPesExt" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" id="tituloGesEnsPesExt" name="tituloGesEnsPesExt" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Anexar documento</b></div>
                                <div class="col-md-12"><input type="file" class="form-control" id="anexoGesEnsPesExt" name="anexoGesEnsPesExt" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt">
                            <div class="col-md-6">
                                <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnGesEnsPesExt" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt">
                            <div class="col-md-12 pl-5">
                                <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Clique conforme o número de atividades a serem preenchidas.</small>
                            </div>
                        </div>
                        <div class="row mb-2 divGesEnsPesExt" id="divGesEnsPesExt1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-1 ">
                    <div class="card-header text-white" style="background-color: #0055A1;">
                        <label><strong>Inovação Tecnológica</strong></label>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                <div class="col-md-3">
                                    <select class="form-control " id="rdInov" name="rdInov">
                                        <option value="">[--SELECIONE--]</option>
                                        <option value="1">SIM</option>
                                        <option value="0">NÃO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec">
                            <div class="col-md-8">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <select class="form-control" id="slInovTec" name="slInovTec">
                                        <option value="">[--SELECIONE--]</option>
                                        <?php
                                        $sqlinovtecnologica = "select idinovtecnologica as idi, descricao as desci from inovtecnologica";
                                        $qinovtecnologica = mysqli_query($conn, $sqlinovtecnologica) or die(mysqli_error($conn));
                                        $rsinovtecnologica = mysqli_fetch_array($qinovtecnologica);
                                        if($rsinovtecnologica !== null){
                                            do{ 
                                                $idi = $rsinovtecnologica['idi'];
                                                $desci = $rsinovtecnologica['desci'];
                                                ?>
                                                <option value="<?= $idi ?>"><?= $desci ?></option>
                                        <?php    
                                            }while ($rsinovtecnologica = mysqli_fetch_array($qinovtecnologica));
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12"><b>Carga Horária</b></div>
                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrInovTec" name="cargahrInovTec" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Título da atividade</b></div>
                                <div class="col-md-12"><input type="text" class="form-control" id="tituloInovTec" name="tituloInovTec" /></div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12"><b>Anexar documento</b></div>
                                <div class="col-md-12"><input type="file" class="form-control" id="anexoInovTec" name="anexoInovTec" /></div>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec">
                            <div class="col-md-6">
                                <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnInovTec" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec">
                            <div class="col-md-12 pl-5">
                                <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Clique conforme o número de atividades a serem preenchidas.</small>
                            </div>
                        </div>
                        <div class="row mb-2 divInovTec" id="divInovTec1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 offset-sm-4 mt-4">
                <!--<input type="submit" class="btn btn-success p-2 form-control" name="enviaCadastro" value="ENVIAR FORMULÁRIO" />-->
                <button type="button" onclick="revisao();" class="shadow btn btn-success form-control" >ENVIAR FORMULÁRIO</button>
            </div>
        </div>
        <!-- Modal -->
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
        </div>
        </form>
        <?php 
        }else{ 
//            var_dump($nrrs2);
        ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-1 ">
                        <div class="card-header text-white" style="background-color: #0055A1;">
                            <label><strong>Atividade de Longa Duração</strong></label>
                        </div>      
                        <div class="card-body">
        <?php
            if($rsld){
                    do{
                        $idld = $rsld['id'];
                        $flagald = $rsld['flagativlongduracao'];
                        $flagparecerap = $rsld['flagparecerap'];
                        //verifica se há parecer negativo para essa a atividade de Longa Duração
                        if($flagparecerap !== null){
                            $flagld = true;
                        }
                        $parecerap = $rsld['parecerap'];
                        $pareceruserap = $rsld['pareceruserap'];
                        $parecerdthrap = vemdata($rsld['parecerdthrap']);  
                        $parecerdthrap .= ", às ".horaEmin($rsld['parecerdthrap']).".";
        ?>
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
                        <?php if($flagld === true){ ?>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border border">
                                    <div class="card-header" style="background-color: #fcec89;">
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $parecerdthrap ?>" id="parecerdthrap" />
                                                </div>
                                            </div>
<!--                                            <div class="col-md-6">
                                                <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                                <div class="col-md-12">
                                                    <?php // if($pontuacaoaptxt === '0,00'){ ?>
                                                    <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $pontuacaoaptxt ?>" id="pontuacaoaptxt1" />    
                                                    <?php // }else{ ?>
                                                    <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $pontuacaoaptxt ?>" id="pontuacaoaptxt2" />
                                                    <?php // } ?>
                                                </div>
                                                <input type="hidden" id="ptld" value="<?= $pontuacaoap ?>">
                                            </div>-->
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
            <?php   if($flagparecerap === '0'){ ?>
                        <form method="post" enctype="multipart/form-data" action="controller/rcbld.php">
                            <input type="hidden" value="<?= $idld ?>" name="idld">
                            <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                            <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-1">
                                    <div class="card-header" style="background-color: #fdd77e;">
                                        <label><strong>Atividade de Longa Duração - Atualização/Correção</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <div class="col-md-12"><b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração?</b></div>
                                                <div class="col-md-6">
                                                    <select class="form-control " id="rdativ" name="rdativ">
                                                        <option value="">[--SELECIONE--]</option>
                                                        <option value="1">SIM</option>
                                                        <option value="0">NÃO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3 mt-4">
                                                <button type="button" class="shadow btn btn-success form-control" data-toggle="modal" data-target="#modalLD<?= $idld ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalLD<?= $idld ?>" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php   }}else{ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                        </div>
                    </div>
            <?php  }}while ($rsld = mysqli_fetch_array($query2));               
                } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            if($nrqc > 0){
                $fqc = "SIM";
            }else{
                $fqc = "NÃO";
            }
            ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-1 ">
                        <div class="card-header text-white" style="background-color: #0055A1;">
                            <label><strong>Qualificação Clínica</strong></label>
                        </div> 
                        <div class="card-body">
            <?php
            if($nrqc > 0){ 
                if($rsqc){
                    $auxqc = 0;
                    do {
                        $auxqc++;
                        $qcid = $rsqc['id'];
                        $qcdesc = $rsqc['qcdesc'];
                        $qctitulo = $rsqc['titulo'];
                        $qccargahr = $rsqc['cargahr'];
                        $qcanexo = $rsqc['anexo'];
                        $qcflagparecer = $rsqc['flagparecer'];
                        if ($qcflagparecer !== '' && $qcflagparecer !== null) {
                            $flagqc = true;
                        }
                        $qdthrcadastro = $rsqc['dthrcadastro'];
                        $qcparecer = trim($rsqc['parecer']);
                        $qcpareceruser = $rsqc['pareceruser'];
                        $qcparecerdthr = vemdata($rsqc['parecerdthr']);
                        $qcparecerdthr .= ", às " . horaEmin($rsqc['parecerdthr']) . ".";
            ?>
                            <hr>
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
                        <?php if($flagqc === true){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border border mb-4">
                                    <?php if($qcflagparecer === '1'){ ?>
                                    <div class="card-header bg-light">
                                        <label><strong>Análise realizada</strong></label>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="card-header" style="background-color: #fcec89;">
                                        <label><strong>Análise realizada</strong></label>
                                    </div>
                                    <?php } ?>
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $qcparecerdthr ?>" id="qcparecerdthr" />
                                                </div>
                                            </div>
                    <!--                        <div class="col-md-6">
                                                <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                                <div class="col-md-12">
                                                    <?php // if($qcpontuacaotxt === '0,00'){ ?>
                                                    <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $qcpontuacaotxt ?>" id="qcpontuacaotxt1" />    
                                                    <?php // }else{ ?>
                                                    <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $qcpontuacaotxt ?>" id="qcpontuacaotxt2" />
                                                    <?php // } ?>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php   
                    if($qcflagparecer === '0'){
            ?>
                        <form method="post" enctype="multipart/form-data" action="controller/rcbqc.php">
                            <input type="hidden" value="<?= $qcid ?>" name="qcid">
                            <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                            <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-1">
                                    <div class="card-header" style="background-color: #fdd77e;">
                                        <label><strong>Qualificação Clínica - Atualização/Correção</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                                <div class="col-md-3">
                                                    <select class="form-control " id="rdQual" name="rdQual">
                                                        <option value="">[--SELECIONE--]</option>
                                                        <option value="1">SIM</option>
                                                        <option value="0">NÃO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-8">
                                                <div class="col-md-12"><b>Atividade</b></div>
                                                <div class="col-md-12">
                                                    <select class="form-control" id="slQualiClinica" name="slQualiClinica">
                                                        <option value="">[--SELECIONE--]</option>
                                                        <?php
                                                        $sqlqualifcli = "select idqualifclinica as idq, descricao as descq from qualifclinica";
                                                        $qqualifcli = mysqli_query($conn, $sqlqualifcli) or die(mysqli_error($conn));
                                                        $rsqualifcli = mysqli_fetch_array($qqualifcli);
                                                        if($rsqualifcli !== null){
                                                            do{ 
                                                                $idq = $rsqualifcli['idq'];
                                                                $descq = $rsqualifcli['descq'];
                                                                ?>
                                                                <option value="<?= $idq ?>"><?= $descq ?></option>
                                                        <?php    
                                                            }while ($rsqualifcli = mysqli_fetch_array($qqualifcli));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12"><b>Carga Horária</b></div>
                                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrQualiClinica" name="cargahrQualiClinica" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Título da atividade</b></div>
                                                <div class="col-md-12"><input type="text" class="form-control" id="tituloQualiClinica" name="tituloQualiClinica" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Anexar documento</b></div>
                                                <div class="col-md-12"><input type="file" class="form-control" id="anexoQualiClinica" name="anexoQualiClinica" /></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3 mt-4">
                                                <button type="button" class="shadow btn btn-success form-control" data-toggle="modal" data-target="#modalQC<?= $qcid ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalQC<?= $qcid ?>" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
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
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
            <?php }}else{ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                        </div>
                    </div>
            <?php }}while ($rsqc = mysqli_fetch_array($qqc));
                }
            }else{
                var_dump($nrqc);
            ?>
                        <div class="row mb-3 mt-2">
                            <div class="col-md-12">
                                <p class="text-info font-weight-bold text-center">*** Nenhuma atividade inserida ***</p>
                            </div>
                        </div> 
            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            if($nrgepe > 0){
                $fgepe = "SIM";
            }else{
                $fgepe = "NÃO";
            }
            ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-1 ">
                        <div class="card-header text-white" style="background-color: #0055A1;">
                            <label><strong>Gestão, Ensino, Pesquisa e Extensão</strong></label>
                        </div>   
                        <div class="card-body">
            <?php
            if($nrgepe > 0){ 
                if($rsgepe){
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
                        if($gepeflagparecer !== '' && $gepeflagparecer !== null){
                            $flaggepe = true;
                        }
                        $gepeparecer = trim($rsgepe['parecer']); 
                        $gepepareceruser = $rsgepe['pareceruser'];  
                        $gepeparecerdthr = vemdata($rsgepe['parecerdthr']);  
                        $gepeparecerdthr .= ", às ".horaEmin($rsgepe['parecerdthr']).".";
            ?>
                            <hr>
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
                        <?php if($flaggepe === true){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border border mb-4">
                                    <?php if($gepeflagparecer === '1'){ ?>
                                    <div class="card-header bg-light">
                                        <label><strong>Análise realizada</strong></label>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="card-header" style="background-color: #fcec89;">
                                        <label><strong>Análise realizada</strong></label>
                                    </div>
                                    <?php } ?>
                                    
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $gepeparecerdthr ?>" id="gepeparecerdthr" />
                                                </div>
                                            </div>
                    <!--                        <div class="col-md-6">
                                                <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                                <div class="col-md-12">
                                                    <?php // if($gepepontuacaotxt === '0,00'){ ?>
                                                    <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $gepepontuacaotxt ?>" id="gepepontuacaotxt1" />    
                                                    <?php // }else{ ?>
                                                    <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $gepepontuacaotxt ?>" id="gepepontuacaotxt2" />
                                                    <?php // } ?>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
            <?php  if($gepeflagparecer === '0'){ ?>
                        <form method="post" enctype="multipart/form-data" action="controller/rcbgepe.php">
                            <input type="hidden" name="$gepeid" value="<?= $gepeid ?>">
                            <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                            <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-1">
                                    <div class="card-header" style="background-color: #fdd77e;">
                                        <label><strong>Gestão, Ensino, Pesquisa e Extensão - Atualização/Correção</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                                <div class="col-md-3">
                                                    <select class="form-control " id="rdGes" name="rdGes">
                                                        <option value="">[--SELECIONE--]</option>
                                                        <option value="1">SIM</option>
                                                        <option value="0">NÃO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-8">
                                                <div class="col-md-12"><b>Atividade</b></div>
                                                <div class="col-md-12">
                                                    <select class="form-control" id="slGesEnsPesExt" name="slGesEnsPesExt">
                                                        <option value="">[--SELECIONE--]</option>
                                                        <?php
                                                        $sqlgesenspesext = "select idgesenspesext as idg, descricao as descg from gesenspesext";
                                                        $qgesenspesext = mysqli_query($conn, $sqlgesenspesext) or die(mysqli_error($conn));
                                                        $rsgesenspesext = mysqli_fetch_array($qgesenspesext);
                                                        if($rsgesenspesext !== null){
                                                            do{ 
                                                                $idg = $rsgesenspesext['idg'];
                                                                $descg = $rsgesenspesext['descg'];
                                                                ?>
                                                                <option value="<?= $idg ?>"><?= $descg ?></option>
                                                        <?php    
                                                            }while ($rsgesenspesext = mysqli_fetch_array($qgesenspesext));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12"><b>Carga Horária</b></div>
                                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrGesEnsPesExt" name="cargahrGesEnsPesExt" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Título da atividade</b></div>
                                                <div class="col-md-12"><input type="text" class="form-control" id="tituloGesEnsPesExt" name="tituloGesEnsPesExt" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Anexar documento</b></div>
                                                <div class="col-md-12"><input type="file" class="form-control" id="anexoGesEnsPesExt" name="anexoGesEnsPesExt" /></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3 mt-4">
                                                <button type="button" class="shadow btn btn-success form-control" data-toggle="modal" data-target="#modalGepe<?= $gepeid ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalGepe<?= $gepeid ?>" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
            <?php }}else{ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                        </div>
                    </div>
            <?php }}while ($rsgepe = mysqli_fetch_array($qgepe));
                }
            }else{ 
            ?>
                        <div class="row mb-3 mt-2">
                            <div class="col-md-12">
                                <p class="text-info font-weight-bold text-center">*** Nenhuma atividade inserida ***</p>
                            </div>
                        </div>          
            <?php
                } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            if($nrit > 0){
                $fit = "SIM";
            }else{
                $fit = "NÃO";
            }
            ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-1 ">
                        <div class="card-header text-white" style="background-color: #0055A1;">
                            <label><strong>Inovação Tecnológica</strong></label>
                        </div>
                        <div class="card-body">
            <?php
//                        var_dump($nrit, $rsit);
            if($nrit > 0){ 
                if($rsit){
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
                        if($itflagparecer !== '' && $itflagparecer !== null){
                            $flagit = true;
                        }
                        $itparecer = trim($rsit['parecer']);
                        $itpareceruser = $rsit['pareceruser'];  
                        $itparecerdthr = vemdata($rsit['parecerdthr']);  
                        $itparecerdthr .= ", às ".horaEmin($rsit['parecerdthr']).".";
            ?>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="col-md-12"><b>Atividade</b></div>
                                <div class="col-md-12">
                                    <textarea class="form-control" style="resize: none;" disabled="disabled" id="qcdesc" ><?= $itdesc ?></textarea>
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
                        <?php if($flagit === true){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border border mb-4">
                                    <?php if($itflagparecer === '1'){ ?>
                                    <div class="card-header bg-light">
                                        <label><strong>Análise realizada</strong></label>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="card-header" style="background-color: #fcec89;">
                                        <label><strong>Análise realizada</strong></label>
                                    </div>
                                    <?php } ?>
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
                                                    <textarea style="resize: none; height: 100px;" class="form-control bg-light" disabled="disabled" id="itdesc" ><?= $itparecer ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Análise realizado por:</b></div>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $itpareceruser ?>" id="itdesc" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Data e hora do envio:</b></div>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control bg-light" disabled="disabled" value="<?= $itparecerdthr ?>" id="itdesc" />
                                                </div>
                                            </div>
                    <!--                        <div class="col-md-6">
                                                <div class="col-md-12 mt-4"><b>Pontuação adquirida:</b></div>
                                                <div class="col-md-12">
                                                    <?php // if($itpontuacaotxt === '0,00'){ ?>
                                                    <input type="text" class="form-control bg-light text-danger" disabled="disabled" value="<?= $itpontuacaotxt ?>" id="itpontuacaotxt1" />    
                                                    <?php // }else{ ?>
                                                    <input type="text" class="form-control bg-light text-primary" disabled="disabled" value="<?= $itpontuacaotxt ?>" id="itpontuacaotxt2" />
                                                    <?php // } ?>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php if($itflagparecer === '0'){ ?>
                        <form method="post" enctype="multipart/form-data" action="controller/rcbit.php">
                            <input type="hidden" name="idit" value="<?= $itid ?>">
                            <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                            <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                            <input type="hidden" value="<?= $ine ?>" name="ine">
                            <input type="hidden" value="<?= $ano ?>" name="ano">
                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-1">
                                    <div class="card-header" style="background-color: #fdd77e;">
                                        <label><strong>Inovação Tecnológica - Atualização/Correção</strong></label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <div class="col-md-12"><b>Possui atividade a declarar neste item?</b></div>
                                                <div class="col-md-3">
                                                    <select class="form-control " id="rdInov" name="rdInov">
                                                        <option value="">[--SELECIONE--]</option>
                                                        <option value="1">SIM</option>
                                                        <option value="0">NÃO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-8">
                                                <div class="col-md-12"><b>Atividade</b></div>
                                                <div class="col-md-12">
                                                    <select class="form-control" id="slInovTec" name="slInovTec">
                                                        <option value="">[--SELECIONE--]</option>
                                                        <?php
                                                        $sqlinovtecnologica = "select idinovtecnologica as idi, descricao as desci from inovtecnologica";
                                                        $qinovtecnologica = mysqli_query($conn, $sqlinovtecnologica) or die(mysqli_error($conn));
                                                        $rsinovtecnologica = mysqli_fetch_array($qinovtecnologica);
                                                        if($rsinovtecnologica !== null){
                                                            do{ 
                                                                $idi = $rsinovtecnologica['idi'];
                                                                $desci = $rsinovtecnologica['desci'];
                                                                ?>
                                                                <option value="<?= $idi ?>"><?= $desci ?></option>
                                                        <?php    
                                                            }while ($rsinovtecnologica = mysqli_fetch_array($qinovtecnologica));
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="col-md-12"><b>Carga Horária</b></div>
                                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrInovTec" name="cargahrInovTec" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Título da atividade</b></div>
                                                <div class="col-md-12"><input type="text" class="form-control" id="tituloInovTec" name="tituloInovTec" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-12"><b>Anexar documento</b></div>
                                                <div class="col-md-12"><input type="file" class="form-control" id="anexoInovTec" name="anexoInovTec" /></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 offset-md-3 mt-4">
                                                <button type="button" class="shadow btn btn-success form-control" data-toggle="modal" data-target="#modalIT<?= $itid ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalIT<?= $itid ?>" tabindex="-1" aria-labelledby="enviarModal" aria-hidden="true">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
            <?php }}else{ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                        </div>
                    </div>
            <?php }}while ($rsit = mysqli_fetch_array($qit));
                }
            }else{ 
            ?>
                        <div class="row mb-3 mt-2">
                            <div class="col-md-12">
                                <p class="text-info font-weight-bold text-center">*** Nenhuma atividade inserida ***</p>
                            </div>
                        </div>     
        <?php }}?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
            </div>
        </div>
        </div>
    </div>
    <br>
    <?php include './footer.php' ?>
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
       $('#enviarModal').modal('hide');
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