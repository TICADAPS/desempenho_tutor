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
$cpf = $_SESSION['cpf'];
$cpftratado = $cpf;
//var_dump($cpftratado);
$cpf = substr_replace($cpftratado, "-", 9, 0);
$cpf = substr_replace($cpf, ".", 6, 0);
$cpf = substr_replace($cpf, ".", 3, 0);
$medico = $_SESSION['nome'];
$ibgeO = $_SESSION['ibgeO'];
$cnes = $_SESSION['cnes'];
$ine = $_SESSION['ine'];
$ano = $_SESSION['ano'];
$ciclo = $_SESSION['ciclo'];
$sqlano = "select * from anoacicloavaliacao where ano = '$ano' and ciclo = '$ciclo' limit 1";
$queryano = mysqli_query($conn, $sqlano) or die(mysqli_error($conn));
$rsano1 = mysqli_fetch_array($queryano);
$rsano = $rsano1;
if($rsano1 !== null){
    do{
        $ciclodescricao = $rsano1['descricao'];
        $flaganociclo = $rsano1['flagativo'];
    }while ($rsano1 = mysqli_fetch_array($queryano));
}
//var_dump($ciclodescricao,$flaganociclo);
$pontuacaoap = $qcp = $gepep = $itp = 0;
$pontexpap = $qcpexp = $gepepexp = $itpexp = 0;
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
    ap.parecer as parecerap, ap.pareceruser as pareceruserap, ap.parecerdthr as parecerdthrap, ap.flagup, ap.flagterminou 
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
$flagterminouap = '';
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
        if($flagald === '1'){
            $pontexpap = 50.00;
        }
        $parecerap = $rs2['parecerap'];
        $flagupap = $rs2['flagup'];
        $flagterminouap = $rs2['flagterminou'];
        $pareceruserap = $rs2['pareceruserap'];
        $parecerdthrap = vemdata($rs2['parecerdthrap']);  
        $parecerdthrap .= ", às ".horaEmin($rs2['parecerdthrap']).".";
    }while ($rs2 = mysqli_fetch_array($query2));
}
//verifica se há parecer negativo para essa a atividade Qualificação Clínica
$sqlqc = "select q.descricao as qcdesc, mq.id, mq.idqualifclinica, mq.titulo, mq.cargahr, mq.anexo, mq.dthrcadastro, 
    mq.flagparecer, mq.parecer, mq.pareceruser, mq.parecerdthr, mq.pontuacao, mq.flagup 
    from aperfeicoamentoprofissional ap 
    inner join medico_qualifclinica mq on ap.id = mq.idaperfprof 
    inner join qualifclinica q on mq.idqualifclinica = q.idqualifclinica 
    where ap.id = '$idap';";
$qqc = mysqli_query($conn, $sqlqc) or die(mysqli_error($conn));
$nrqc = mysqli_num_rows($qqc);
$rsqc = mysqli_fetch_array($qqc);
//verifica se há parecer negativo para essa a atividade Gestão, Ensino, Pesquisa e Extensão
$sqlgepe = "select g.descricao as gdesc, mg.id, mg.idgesenspesext, mg.titulo, mg.cargahr, mg.anexo, mg.dthrcadastro, 
    mg.flagparecer, mg.parecer, mg.pareceruser, mg.parecerdthr,mg.pontuacao, mg.flagup 
    from aperfeicoamentoprofissional ap 
    inner join medico_gesenspesext mg on ap.id = mg.idaperfprof 
    inner join gesenspesext g on mg.idgesenspesext = g.idgesenspesext  
    where ap.id ='$idap';";
$qgepe = mysqli_query($conn, $sqlgepe) or die(mysqli_error($conn));
$nrgepe = mysqli_num_rows($qgepe);
$rsgepe = mysqli_fetch_array($qgepe);
//verifica se há parecer negativo para essa a atividade Inovação Tecnológica
$sqlit = "select i.descricao as idesc, mi.id, mi.idinovtecnologica, mi.titulo, mi.cargahr, mi.anexo, mi.dthrcadastro, 
    mi.flagparecer, mi.parecer, mi.pareceruser, mi.parecerdthr, mi.pontuacao , mi.flagup 
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
    <style>
        #cardptgp{
            width:300px;
            height: 120px;
            position: fixed;
            top: -350px;
            left: 2%;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-2 mb-3">
        <div class="row">
            <div class="col-12 col-md-4 mt-4 pl-5">
                <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 mt-5">
                <h4 class="mb-4 font-weight-bold text-left">Médico Tutor &nbsp;|&nbsp; Comprovante de Aperfeiçoamento Profissional</h4>
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
                            <li class="text-secondary pl-2 pr-2"><a href="./derruba_session.php" class="btn"><i class="fas fa-sign-out-alt"></i></a></li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="container-fluid mt-1">
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
            <div class="row ">
                <div class="col-12 shadow rounded  ">
                    <div class="row mb-2 mt-2">
                        <div class="col-md-12 pt-2 pb-2">
                            <div class="card border-0">
                                <div class="card-header text-white bg-dark">
                                    <h5 class="text-white"><b>Cadastro do Comprovante de Aperfeiçoamento Profissional</b></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-1">
                                        <div class="col-md-12">
                                            <div class="card border-1 ">
                                                <div class="card-header text-white bg-dark">
                                                    <label><strong>Período avaliativo</strong></label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-1">
                                                        <div class="col-md-6 offset-md-3 text-center">
                                                            <ul class="list-group ">
                                                                <li class="list-group-item bg-light"><label class=""><b>Ano: </b><?= $ano ?></label>
                                                                    <br><b><?= $ciclo ?>º Ciclo: </b><?= $ciclodescricao ?>
                                                                    <?php if($flagterminouap === '1'){ ?>
                                                                    <br><br><label class="text-danger h6"><i class="fas fa-chevron-circle-right float-left mt-1"></i>&nbsp;&nbsp; Análise Finalizada &nbsp;&nbsp;<i class="fas fa-chevron-circle-left float-right mt-1"></i></label><br>
                                                                    <?php } ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-12">
                                            <div class="card border-1 ">
                                                <div class="card-header text-white bg-dark">
                                                    <label><strong>Dados Pessoais</strong></label>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-2">
                                                        <div class="col-md-8">
                                                            <ul class="list-group">
                                                                <li class="list-group-item bg-light"><b>Nome: </b><?= $medico ?></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <ul class="list-group">
                                                                <li class="list-group-item bg-light"><b>CPF: </b><?= $cpf ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <ul class="list-group">
                                                                <li class="list-group-item bg-light"><b>Município de Origem: </b><?= $municipioO ?>-<?= $ufO ?></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item bg-light"><b>CNES: </b><?= $cnes ?></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group">
                                                                <li class="list-group-item bg-light"><b>INE: </b><?= $ine ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($flaganociclo !== '1') { ?>
                                    <div class="row mb-3 mt-2">
                                        <div class="col-md-12">
                                            <div class="card border-1 ">
                                                <div class="card-body bg-warning">
                                                    <h5 class="text-dark font-weight-bold text-center"><i class="fas fa-hand-point-right"></i>&nbsp; O ciclo não está aberto &nbsp;<i class="fas fa-hand-point-left"></i></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                    
                                    <?php }else{ 
                                    if ($rsano !== null) {
                                        if ($nrrs2 > 0) {
                                            ?>
                                            <div class="row mb-1">
                                                <div class="col-12">
                                                    <div class="card border-1">
                                                        <div class="card-header bg-dark text-white" >
                                                            <label><strong>Análise realizada - Pontuação Geral</strong></label>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row mb-2">
                                                                <div class="col-md-6">
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item bg-light"><b>Expectativa de Pontuação dos itens entregues: </b>&nbsp;<label class="text-primary" id="ptexpec"></label></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item bg-light"><b>Pontuação dos itens aprovados: </b>&nbsp;<label class="text-primary" id="ptgeral"></label></li>
                                                                    </ul>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php
//                        var_dump($nrrs2);
                                        if ($nrrs2 === 0 && $flaganociclo === '1') {
                                            ?>
                                            <form method="post" enctype="multipart/form-data" action="controller/rcb.php">
                                                <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                <input type="hidden" value="<?= $ine ?>" name="ine">
                                                <input type="hidden" value="<?= $ano ?>" name="ano">
                                                <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                                                <div class="row mb-1">
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
                                                                    <div class="col-md-9 divLongDuracao mt-2">
                                                                        <div class="col-md-12"><b>Informação</b></div>
                                                                        <div class="col-md-12"><input type="text" value="Crédito de 50 pontos por estar realizando curso de longa duração." disabled="disabled" class="form-control" id="infold" /></div>
                                                                    </div>
                                                                    <div class="col-md-3 divLongDuracao mt-2">
                                                                        <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                        <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontold" /></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
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
                                                                    <div class="col-md-9">
                                                                        <div class="col-md-12"><b>Atividade</b></div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control" id="slQualiClinica" name="slQualiClinica">
                                                                                <option value="">[--SELECIONE--]</option>
                                                                                <?php
                                                                                $sqlqualifcli = "select idqualifclinica as idq, descricao as descq from qualifclinica";
                                                                                $qqualifcli = mysqli_query($conn, $sqlqualifcli) or die(mysqli_error($conn));
                                                                                $rsqualifcli = mysqli_fetch_array($qqualifcli);
                                                                                if ($rsqualifcli !== null) {
                                                                                    do {
                                                                                        $idq = $rsqualifcli['idq'];
                                                                                        $descq = $rsqualifcli['descq'];
                                                                                        ?>
                                                                                        <option value="<?= $idq ?>"><?= $descq ?></option>
                                                                                        <?php
                                                                                    } while ($rsqualifcli = mysqli_fetch_array($qqualifcli));
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12" id="qcch"><b>Carga Horária</b></div>
                                                                        <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrQualiClinica" name="cargahrQualiClinica" /></div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="col-md-12"><b>Informação</b></div>
                                                                        <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infoqc" /></div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                        <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontoqc" /></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12"><b>Título da atividade</b></div>
                                                                        <div class="col-md-12"><input type="text" class="form-control" id="tituloQualiClinica" name="tituloQualiClinica" /></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp;   * Favor juntar os documentos em um único arquivo PDF.</small></div>
                                                                        <div class="col-md-12"><input type="file" class="form-control" id="anexoQualiClinica" name="anexoQualiClinica" /></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divQualiClinica">
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12"><b>Quantidade de novas atividades</b></div>
                                                                        <div class="col-md-12"><input type="number" class="form-control" min="1" id="qtdatvqc" name="qtdatvqc" /></div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12">&nbsp;</div>    
                                                                        <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnQualiClinica" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divQualiClinica">
                                                                    <div class="col-md-12 pl-5">
                                                                        <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Digite o número de atividades a serem preenchidas.</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divQualiClinica" id="divQualiClinica1"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
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
                                                                            <select class="form-control" id="rdGes" name="rdGes">
                                                                                <option value="">[--SELECIONE--]</option>
                                                                                <option value="1">SIM</option>
                                                                                <option value="0">NÃO</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divGesEnsPesExt">
                                                                    <div class="col-md-9">
                                                                        <div class="col-md-12"><b>Atividade</b></div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control" id="slGesEnsPesExt" name="slGesEnsPesExt">
                                                                                <option value="">[--SELECIONE--]</option>
                                                                                <?php
                                                                                $sqlgesenspesext = "select idgesenspesext as idg, descricao as descg from gesenspesext";
                                                                                $qgesenspesext = mysqli_query($conn, $sqlgesenspesext) or die(mysqli_error($conn));
                                                                                $rsgesenspesext = mysqli_fetch_array($qgesenspesext);
                                                                                if ($rsgesenspesext !== null) {
                                                                                    do {
                                                                                        $idg = $rsgesenspesext['idg'];
                                                                                        $descg = $rsgesenspesext['descg'];
                                                                                        ?>
                                                                                        <option value="<?= $idg ?>"><?= $descg ?></option>
                                                                                        <?php
                                                                                    } while ($rsgesenspesext = mysqli_fetch_array($qgesenspesext));
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12" id="gepech"><b>Carga Horária</b></div>
                                                                        <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrGesEnsPesExt" name="cargahrGesEnsPesExt" /></div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="col-md-12"><b>Informação</b></div>
                                                                        <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infogepe" /></div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                        <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontogepe" /></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12"><b>Título da atividade</b></div>
                                                                        <div class="col-md-12"><input type="text" class="form-control" id="tituloGesEnsPesExt" name="tituloGesEnsPesExt" /></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp;   * Favor juntar os documentos em um único arquivo PDF.</small></div>
                                                                        <div class="col-md-12"><input type="file" class="form-control" id="anexoGesEnsPesExt" name="anexoGesEnsPesExt" /></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divGesEnsPesExt">
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12"><b>Quantidade de novas atividades</b></div>
                                                                        <div class="col-md-12"><input type="number" class="form-control" min="1" id="qtdatvgepe" name="qtdatvgepe" /></div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12">&nbsp;</div>
                                                                        <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnGesEnsPesExt" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divGesEnsPesExt">
                                                                    <div class="col-md-12 pl-5">
                                                                        <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Digite o número de atividades a serem preenchidas.</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divGesEnsPesExt" id="divGesEnsPesExt1"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
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
                                                                    <div class="col-md-9">
                                                                        <div class="col-md-12"><b>Atividade</b></div>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control" id="slInovTec" name="slInovTec">
                                                                                <option value="">[--SELECIONE--]</option>
                                                                                <?php
                                                                                $sqlinovtecnologica = "select idinovtecnologica as idi, descricao as desci from inovtecnologica";
                                                                                $qinovtecnologica = mysqli_query($conn, $sqlinovtecnologica) or die(mysqli_error($conn));
                                                                                $rsinovtecnologica = mysqli_fetch_array($qinovtecnologica);
                                                                                if ($rsinovtecnologica !== null) {
                                                                                    do {
                                                                                        $idi = $rsinovtecnologica['idi'];
                                                                                        $desci = $rsinovtecnologica['desci'];
                                                                                        ?>
                                                                                        <option value="<?= $idi ?>"><?= $desci ?></option>
                                                                                        <?php
                                                                                    } while ($rsinovtecnologica = mysqli_fetch_array($qinovtecnologica));
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12"><b>Carga Horária</b></div>
                                                                        <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrInovTec" name="cargahrInovTec" /></div>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="col-md-12"><b>Informação</b></div>
                                                                        <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infoit" /></div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                        <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontoit" /></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12"><b>Título da atividade</b></div>
                                                                        <div class="col-md-12"><input type="text" class="form-control" id="tituloInovTec" name="tituloInovTec" /></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp;   * Favor juntar os documentos em um único arquivo PDF.</small></div>
                                                                        <div class="col-md-12"><input type="file" class="form-control" id="anexoInovTec" name="anexoInovTec" /></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divInovTec">
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12"><b>Quantidade de novas atividades</b></div>
                                                                        <div class="col-md-12"><input type="number" class="form-control" min="1" id="qtdatvit" name="qtdatvit" /></div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="col-md-12">&nbsp;</div>    
                                                                        <div class="col-md-12"><button type="button" class="btn btn-primary" id="btnInovTec" ><i class="fas fa-plus-circle"></i> ADD ATIVIDADES</button></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divInovTec">
                                                                    <div class="col-md-12 pl-5">
                                                                        <label class="text-info"><small><i class="fas fa-hand-point-up"></i> &nbsp;Digite o número de atividades a serem preenchidas.</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-2 divInovTec" id="divInovTec1"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-6 mt-4">
                                                        <button type="button" class="shadow btn btn-warning form-control" data-toggle="modal" data-target="#modalptexp" onclick="montantePontos();">PONTUAÇÃO ESTIMADA</button>
                                                    </div>
                                                    <div class="col-md-6 mt-4">
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
                                        } else { ?>
                                            <div class="row mb-1">
                                                <div class="col-12">
                                                    <div class="card border-1 ">
                                                        <div class="card-header text-white" style="background-color: #0055A1;">
                                                            <label><strong>Atividade de Longa Duração</strong></label>
                                                        </div>      
                                                        <div class="card-body">
                                                            <?php
                                                            if ($rsld) {
                                                                do {
                                                                    $idld = $rsld['id'];
                                                                    $flagald = $rsld['flagativlongduracao'];
                                                                    $flagparecerap = $rsld['flagparecerap'];
                                                                    //verifica se há parecer negativo para essa a atividade de Longa Duração
                                                                    if ($flagparecerap !== null) {
                                                                        $flagld = true;
                                                                    }
                                                                    $pontuacaoap = $rsld['pontuacao'];
                                                                    if ($pontuacaoap === null || $pontuacaoap === '') {
                                                                        $pontuacaoap = 0.00;
                                                                    }
                                                                    $pontuacaoaptxt = (string) $pontuacaoap;
                                                                    $pontuacaoaptxt = str_replace(".", ",", $pontuacaoaptxt);
                                                                    $flagupap = $rsld['flagup'];
                                                                    if($flagupap === null){
                                                                        $flagupap = '';
                                                                    }
                                                                    $parecerap = $rsld['parecerap'];
                                                                    $flagterminouap = $rsld['flagterminou'];
                                                                    $pareceruserap = $rsld['pareceruserap'];
                                                                    $parecerdthrap = vemdata($rsld['parecerdthrap']);
                                                                    $parecerdthrap .= ", às " . horaEmin($rsld['parecerdthrap']) . ".";
                                                                    ?>
                                                                    <div class="row mb-1">
                                                                        <div class="col-md-12">
                                                                            <?php
                                                                            if ($flagald === '1') {
                                                                                $fald = "<label class='text-primary'>SIM</label>";
                                                                            } else {
                                                                                $fald = "<label class='text-danger'>NÃO</label>";
                                                                            }
                                                                            ?>
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item bg-light"><b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração?: </b>&nbsp;<?= $fald ?></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <?php if ($flagald === '1') { ?>
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item bg-light"><b>Pontuação pretendida: </b>&nbsp;50,00</li>
                                                                            </ul>
                                                                            <?php } else { ?>
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item bg-light"><b>Pontuação pretendida: </b>&nbsp;0,00</li>
                                                                            </ul>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php if ($flagld === true) { ?>
                                                                        <div class="row mb-1">
                                                                            <div class="col-md-12">
                                                                                <div class="card border border">
                                                                                    <?php
                                                                                    if ($flagparecerap === '1') {
                                                                                        $apparecer = "<label class='text-primary'>Aprovado</label>";
                                                                                        ?>
                                                                                        <div class="card-header bg-light">
                                                                                            <label><strong>Análise realizada</strong></label>
                                                                                        </div> 
                                                                                        <?php
                                                                                    } else {
                                                                                        $apparecer = "<label class='text-danger'>Não aprovado</label>";
                                                                                        ?>
                                                                                        <div class="card-header" style="background-color: #fcec89;">
                                                                                            <label><strong>Análise realizada</strong></label>
                                                                                        </div> 
                                                                                    <?php } ?>
                                                                                    <div class="card-body">
                                                                                        <div class="row mb-2">
                                                                                            <div class="col-md-12">
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Parecer: </b><?= $apparecer ?></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $parecerap ?></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Data e hora do envio: </b><label><?= $parecerdthrap ?></label></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <?php
                                                                                                if ($pontuacaoaptxt === '0,00') {
                                                                                                    $pontoaptxt = "<label class='text-danger'>$pontuacaoaptxt</label>";
                                                                                                } else {
                                                                                                    $pontoaptxt = "<label class='text-primary'>$pontuacaoaptxt</label>";
                                                                                                }
                                                                                                ?>
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Pontuação adquirida: </b> <?= $pontoaptxt ?></li>
                                                                                                </ul>
                                                                                                <input type="hidden" id="ptld" value="<?= $pontuacaoap ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>   
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($flagparecerap === '0' && $flagupap === '0' && $flagterminouap !== '1') { ?>
                                                                            <form method="post" enctype="multipart/form-data" action="controller/rcbld.php">
                                                                                <input type="hidden" value="<?= $idld ?>" name="idld">
                                                                                <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                                                <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                                                <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                                                <input type="hidden" value="<?= $ine ?>" name="ine">
                                                                                <input type="hidden" value="<?= $ano ?>" name="ano">
                                                                                <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                                                                                <div class="row mb-1">
                                                                                    <div class="col-12">
                                                                                        <div class="card border-1">
                                                                                            <div class="card-header text-white" style="background-color: #590d97;">
                                                                                                <label><strong>Atividade de Longa Duração - Atualização/Correção</strong></label>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <div class="row mb-2">
                                                                                                    <div class="col-md-12">
                                                                                                        <div class="col-md-12"><b>Declaro que fui autorizado pela Agência para a realização de curso de longa duração?</b></div>
                                                                                                        <div class="col-md-6">
                                                                                                            <select class="form-control " id="rdativup" name="rdativ">
                                                                                                                <option value="">[--SELECIONE--]</option>
                                                                                                                <option value="1">SIM</option>
                                                                                                                <option value="0">NÃO</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-9 divLongDuracao mt-2">
                                                                                                        <div class="col-md-12"><b>Informação</b></div>
                                                                                                        <div class="col-md-12"><input type="text" value="Crédito de 50 pontos por estar realizando curso de longa duração." disabled="disabled" class="form-control" id="infoldup" /></div>
                                                                                                    </div>
                                                                                                    <div class="col-md-3 divLongDuracao mt-2">
                                                                                                        <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                                                        <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontoldup" /></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-6 offset-md-3 mt-4">
                                                                                                        <button type="button" class="shadow btn btn-outline-success form-control" data-toggle="modal" data-target="#modalLD<?= $idld ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
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
                                                                            <?php } } else { ?>
                                                                            <div class="row mt-3">
                                                                                <div class="col-md-12">
                                                                                    <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                                                                                </div>
                                                                            </div>
                                                                            <?php }
                                                                        } while ($rsld = mysqli_fetch_array($query2));
                                                                    } else {
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
                                            if ($nrqc > 0) {
                                                $fqc = "SIM";
                                            } else {
                                                $fqc = "NÃO";
                                            }
                                            ?>
                                            <div class="row mb-1">
                                                <div class="col-12">
                                                    <div class="card border-1 ">
                                                        <div class="card-header text-white" style="background-color: #0055A1;">
                                                            <label><strong>Qualificação Clínica</strong></label>
                                                        </div> 
                                                        <div class="card-body">
                                                            <?php
                                                            if ($nrqc > 0) {
                                                                if ($rsqc) {
                                                                    $auxqc = 0;
                                                                    do {
                                                                        $flagupqc = $rsqc['flagup'];
                                                                        if ($flagupqc !== null && $flagupqc === '1') {
                                                                            continue;
                                                                        }
                                                                        $auxqc++;
                                                                        $qcid = $rsqc['id'];
                                                                        $qcidqualifclinica = $rsqc['idqualifclinica'];
                                                                        $chqc = '';
                                                                        if ($qcidqualifclinica !== null && $qcidqualifclinica !== '') {
                                                                            if ($qcidqualifclinica === '3') {
                                                                                $chqc = 'Conforme CME';
                                                                            } else {
                                                                                $chqc = 'Carga Horária';
                                                                            }
                                                                        }
                                                                        $qcdesc = $rsqc['qcdesc'];
                                                                        $qctitulo = $rsqc['titulo'];
                                                                        $qccargahr = $rsqc['cargahr'];
                                                                        $qcpt = $qccargahr;
                                                                        if($qccargahr !== null && $qccargahr !== ''){
                                                                            $qcpexp += floatval($qccargahr);
                                                                        }
                                                                        $qcanexo = $rsqc['anexo'];
                                                                        $qcflagparecer = $rsqc['flagparecer'];
                                                                        if ($qcflagparecer !== '' && $qcflagparecer !== null) {
                                                                            $flagqc = true;
                                                                        } else {
                                                                            $flagqc = false;
                                                                        }
                                                                        $qcpontuacao = $rsqc['pontuacao'];
                                                                        if ($qcpontuacao === null || $qcpontuacao === '') {
                                                                            $qcpontuacao = 0.00;
                                                                        }
                                                                        $qcp += $qcpontuacao;
                                                                        $qcpontuacaotxt = (string) $qcpontuacao;
                                                                        $qcpontuacaotxt = str_replace(".", ",", $qcpontuacaotxt);
                                                                        $qdthrcadastro = $rsqc['dthrcadastro'];
                                                                        $qcparecer = trim($rsqc['parecer']);
                                                                        $qcpareceruser = $rsqc['pareceruser'];
                                                                        $qcparecerdthr = vemdata($rsqc['parecerdthr']);
                                                                        $qcparecerdthr .= ", às " . horaEmin($rsqc['parecerdthr']) . ".";
                                                                        ?>
                                                                        <?php
                                                                        if ($auxqc > 1) {
                                                                            ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12 bg-dark text-white p-2 border text-center mt-4 mb-3 font-weight-bold small align-middle"><i class="fas fa-chevron-circle-right float-left mt-1"></i> &nbsp;Qualificação Clínica: Atividade <?= $auxqc ?>&nbsp; <i class="fas fa-chevron-circle-left float-right mt-1"></i></div>
                                                                            </div>
                    <?php } ?>
                                                                        <div class="row mb-1">
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
                                                                            <div class="col-md-9">
                                                                                <ul class="list-group">
                                                                                    <li class="list-group-item bg-light"><b>Pontuação pretendida: </b>&nbsp;<?= $qcpt ?>,00</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($flagqc === true) { ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="card border mb-1">
                                                                                        <?php if ($qcflagparecer === '1') { ?>
                                                                                            <div class="card-header bg-light">
                                                                                                <label><strong>Análise realizada</strong></label>
                                                                                            </div>
                                                                                        <?php } else { ?>
                                                                                            <div class="card-header" style="background-color: #fcec89;">
                                                                                                <label><strong>Análise realizada</strong></label>
                                                                                            </div>
                                                                                                    <?php } ?>
                                                                                        <div class="card-body">
                                                                                            <div class="row mb-2">
                                                                                                <div class="col-md-12">
                                                                                                    <?php
                                                                                                    if ($qcflagparecer === '1') {
                                                                                                        $parecerqc = "<label class='text-primary'>Aprovado</label>";
                                                                                                    } else {
                                                                                                        $parecerqc = "<label class='text-danger'>Não aprovado</label>";
                                                                                                    }
                                                                                                    ?>
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Parecer: </b><?= $parecerqc ?></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $qcparecer ?></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Data e hora do envio: </b><label><?= $qcparecerdthr ?></label></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <?php
                                                                                                    if ($qcpontuacaotxt === '0,00') {
                                                                                                        $qcponttxt = "<label class='text-danger'>$qcpontuacaotxt</label>";
                                                                                                    } else {
                                                                                                        $qcponttxt = "<label class='text-primary'>$qcpontuacaotxt</label>";
                                                                                                    }
                                                                                                    ?>
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Pontuação adquirida: </b> <?= $qcponttxt ?></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php if ($qcflagparecer === '0' && $flagupqc === '0' && $flagterminouap !== '1') { ?>
                                                                                <form method="post" enctype="multipart/form-data" action="controller/rcbqc.php">
                                                                                    <input type="hidden" value="<?= $qcid ?>" name="qcid">
                                                                                    <input type="hidden" value="<?= $idap ?>" name="idap">
                                                                                    <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                                                    <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                                                    <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                                                    <input type="hidden" value="<?= $ine ?>" name="ine">
                                                                                    <input type="hidden" value="<?= $ano ?>" name="ano">
                                                                                    <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                                                                                    <div class="row mb-1">
                                                                                        <div class="col-12">
                                                                                            <div class="card border-1">
                                                                                                <div class="card-header text-white" style="background-color: #590d97;">
                                                                                                    <label><strong>Qualificação Clínica - Atualização/Correção</strong></label>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <div class="row mb-2">
                                                                                                        <div class="col-md-8">
                                                                                                            <div class="col-md-12"><b>Atividade</b></div>
                                                                                                            <div class="col-md-12">
                                                                                                                <select class="form-control" id="slQualiClinicaup<?= $auxqc ?>" name="slQualiClinica" onchange="changeQualiClinicaup(<?= $auxqc ?>);">
                                                                                                                    <option value="">[--SELECIONE--]</option>
                                                                                                                    <?php
                                                                                                                    $sqlqualifcli = "select idqualifclinica as idq, descricao as descq from qualifclinica";
                                                                                                                    $qqualifcli = mysqli_query($conn, $sqlqualifcli) or die(mysqli_error($conn));
                                                                                                                    $rsqualifcli = mysqli_fetch_array($qqualifcli);
                                                                                                                    if ($rsqualifcli !== null) {
                                                                                                                        do {
                                                                                                                            $idq = $rsqualifcli['idq'];
                                                                                                                            $descq = $rsqualifcli['descq'];
                                                                                                                            ?>
                                                                                                                            <option value="<?= $idq ?>"><?= $descq ?></option>
                                                                                                                            <?php
                                                                                                                        } while ($rsqualifcli = mysqli_fetch_array($qqualifcli));
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-4">
                                                                                                            <div class="col-md-12" id="qcup<?= $auxqc ?>"><b>Carga Horária</b></div>
                                                                                                            <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrQualiClinicaup<?= $auxqc ?>" name="cargahrQualiClinica" onchange="changeChQualiClinicaup(<?= $auxqc ?>);"/></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-8">
                                                                                                            <div class="col-md-12"><b>Informação</b></div>
                                                                                                            <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infoqcup<?= $auxqc ?>" /></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-4">
                                                                                                            <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                                                            <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontoqcup<?= $auxqc ?>" /></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="col-md-12"><b>Título da atividade</b></div>
                                                                                                            <div class="col-md-12"><input type="text" class="form-control" id="tituloQualiClinica" name="tituloQualiClinica" /></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp;   * Favor juntar os documentos em um único arquivo PDF.</small></div>
                                                                                                            <div class="col-md-12"><input type="file" class="form-control" id="anexoQualiClinica" name="anexoQualiClinica" /></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6 offset-md-3 mt-4">
                                                                                                            <button type="button" class="shadow btn btn-outline-success form-control" data-toggle="modal" data-target="#modalQC<?= $qcid ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
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
                                                                            <?php }
                                                                        } else { ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } while ($rsqc = mysqli_fetch_array($qqc));
                                                                }
                                                            } else {
//                var_dump($nrqc);
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
        if ($nrgepe > 0) {
            $fgepe = "SIM";
        } else {
            $fgepe = "NÃO";
        }
        ?>
                                            <div class="row mb-1">
                                                <div class="col-12">
                                                    <div class="card border-1 ">
                                                        <div class="card-header text-white" style="background-color: #0055A1;">
                                                            <label><strong>Gestão, Ensino, Pesquisa e Extensão</strong></label>
                                                        </div>   
                                                        <div class="card-body">
                                                            <?php
                                                            if ($nrgepe > 0) {
                                                                if ($rsgepe) {
                                                                    $auxgepe = 0;
                                                                    do {
                                                                        $flagupgepe = $rsgepe['flagup'];
                                                                        if ($flagupgepe !== null && $flagupgepe === '1') {
                                                                            continue;
                                                                        }
                                                                        $auxgepe++;
                                                                        $gepeid = $rsgepe['id'];
                                                                        $gepeidgesenspesext = $rsgepe['idgesenspesext'];
                                                                        $chgepe = $gepept = '';
                                                                        if ($gepeidgesenspesext !== null && $gepeidgesenspesext !== '') {
                                                                            switch ($gepeidgesenspesext) {
                                                                                case '1': $chgepe = 'Carga Horária';
                                                                                    $gepepexp += floatval(1 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(1 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '2': $chgepe = 'Carga Horária';
                                                                                    $gepepexp += floatval(1 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(1 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '3': $chgepe = 'Quantidade de Publicações';
                                                                                    $gepepexp += floatval(15 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(15 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '4': $chgepe = 'Quantidade de Publicações';
                                                                                    $gepepexp += floatval(5 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(5 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '5': $chgepe = 'Quantidade de Publicações';
                                                                                    $gepepexp += floatval(15 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(15 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '6': $chgepe = 'Quantidade de Publicações';
                                                                                    $gepepexp += floatval(10 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(10 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '7': $chgepe = 'Quantidade de Participação';
                                                                                    $gepepexp += floatval(5 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(5 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '8': $chgepe = 'Quantidade de Participação';
                                                                                    $gepepexp += floatval(3 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(3 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '9': $chgepe = 'Quantidade de Participação';
                                                                                    $gepepexp += floatval(5 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(5 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                                case '10': $chgepe = 'Quantidade de Horas de Atividade';
                                                                                    $gepepexp += floatval(1 * floatval($rsgepe['cargahr']));
                                                                                    $gepept = floatval(1 * floatval($rsgepe['cargahr']));
                                                                                    break;
                                                                            }
                                                                        }
                                                                        $gepedesc = $rsgepe['gdesc'];
                                                                        $gepetitulo = $rsgepe['titulo'];
                                                                        $gepecargahr = $rsgepe['cargahr'];
                                                                        $gepeanexo = $rsgepe['anexo'];
                                                                        $gepedthrcadastro = $rsgepe['dthrcadastro'];
                                                                        $gepeflagparecer = $rsgepe['flagparecer'];
                                                                        if ($gepeflagparecer !== '' && $gepeflagparecer !== null) {
                                                                            $flaggepe = true;
                                                                        } else {
                                                                            $flaggepe = false;
                                                                        }
                                                                        $gepepontuacao = $rsgepe['pontuacao'];
                                                                        if ($gepepontuacao === null || $gepepontuacao === '') {
                                                                            $gepepontuacao = 0.00;
                                                                        }
                                                                        $gepep += $gepepontuacao;
                                                                        $gepepontuacaotxt = (string) $gepepontuacao;
                                                                        $gepepontuacaotxt = str_replace(".", ",", $gepepontuacaotxt);
                                                                        $gepeparecer = trim($rsgepe['parecer']);
                                                                        $gepepareceruser = $rsgepe['pareceruser'];
                                                                        $gepeparecerdthr = vemdata($rsgepe['parecerdthr']);
                                                                        $gepeparecerdthr .= ", às " . horaEmin($rsgepe['parecerdthr']) . ".";
                                                                        ?>
                    <?php
                    if ($auxgepe > 1) {
                        ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12 bg-dark text-white p-2 border text-center mt-4 mb-3 font-weight-bold small align-middle"><i class="fas fa-chevron-circle-right float-left mt-1"></i> &nbsp;Gestão, Ensino, Pesquisa e Extensão: Atividade <?= $auxgepe ?>&nbsp; <i class="fas fa-chevron-circle-left float-right mt-1"></i></div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="row mb-1">
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
                                                                            <div class="col-md-9">
                                                                                <ul class="list-group">
                                                                                    <li class="list-group-item bg-light"><b>Pontuação pretendida: </b>&nbsp;<?= $gepept ?>,00</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($flaggepe === true) { ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="card border mb-1">
                                                                                        <?php if ($gepeflagparecer === '1') { ?>
                                                                                            <div class="card-header bg-light">
                                                                                                <label><strong>Análise realizada</strong></label>
                                                                                            </div>
                                                                                        <?php } else { ?>
                                                                                            <div class="card-header" style="background-color: #fcec89;">
                                                                                                <label><strong>Análise realizada</strong></label>
                                                                                            </div>
                                                                                        <?php } ?>

                                                                                        <div class="card-body">
                                                                                            <div class="row mb-2">
                                                                                                <div class="col-md-12">
                                                                                                    <?php
                                                                                                    if ($gepeflagparecer === '1') {
                                                                                                        $parecergp = "<label class='text-primary'>Aprovado</label>";
                                                                                                    } else {
                                                                                                        $parecergp = "<label class='text-danger'>Não aprovado</label>";
                                                                                                    }
                                                                                                    ?>
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Parecer: </b><?= $parecergp ?></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $gepeparecer ?></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Data e hora do envio: </b><label><?= $gepeparecerdthr ?></label></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <?php
                                                                                                    if ($gepepontuacaotxt === '0,00') {
                                                                                                        $gepeponttxt = "<label class='text-danger'>$gepepontuacaotxt</label>";
                                                                                                    } else {
                                                                                                        $gepeponttxt = "<label class='text-primary'>$gepepontuacaotxt</label>";
                                                                                                    }
                                                                                                    ?>
                                                                                                    <ul class="list-group">
                                                                                                        <li class="list-group-item bg-light"><b>Pontuação adquirida: </b> <?= $gepeponttxt ?></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php if ($gepeflagparecer === '0' && $flagupgepe === '0' && $flagterminouap !== '1') { ?>
                                                                                <form method="post" enctype="multipart/form-data" action="controller/rcbgepe.php">
                                                                                    <input type="hidden" name="gepeid" value="<?= $gepeid ?>">
                                                                                    <input type="hidden" name="idap" value="<?= $idap ?>">
                                                                                    <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                                                    <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                                                    <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                                                    <input type="hidden" value="<?= $ine ?>" name="ine">
                                                                                    <input type="hidden" value="<?= $ano ?>" name="ano">
                                                                                    <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                                                                                    <div class="row mb-1">
                                                                                        <div class="col-12">
                                                                                            <div class="card border-1">
                                                                                                <div class="card-header text-white" style="background-color: #590d97;">
                                                                                                    <label><strong>Gestão, Ensino, Pesquisa e Extensão - Atualização/Correção</strong></label>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <div class="row mb-2">
                                                                                                        <div class="col-md-8">
                                                                                                            <div class="col-md-12"><b>Atividade</b></div>
                                                                                                            <div class="col-md-12">
                                                                                                                <select class="form-control" id="slGesEnsPesExtup<?= $auxgepe ?>" name="slGesEnsPesExt" onchange="changeGesEnsPesExtup(<?= $auxgepe ?>);">
                                                                                                                    <option value="">[--SELECIONE--]</option>
                                                                                                                    <?php
                                                                                                                    $sqlgesenspesext = "select idgesenspesext as idg, descricao as descg from gesenspesext";
                                                                                                                    $qgesenspesext = mysqli_query($conn, $sqlgesenspesext) or die(mysqli_error($conn));
                                                                                                                    $rsgesenspesext = mysqli_fetch_array($qgesenspesext);
                                                                                                                    if ($rsgesenspesext !== null) {
                                                                                                                        do {
                                                                                                                            $idg = $rsgesenspesext['idg'];
                                                                                                                            $descg = $rsgesenspesext['descg'];
                                                                                                                            ?>
                                                                                                                            <option value="<?= $idg ?>"><?= $descg ?></option>
                                                                                                                            <?php
                                                                                                                        } while ($rsgesenspesext = mysqli_fetch_array($qgesenspesext));
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-4">
                                                                                                            <div class="col-md-12" id="gepechup<?= $auxgepe ?>"><b>Carga Horária</b></div>
                                                                                                            <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrGesEnsPesExtup<?= $auxgepe ?>" name="cargahrGesEnsPesExt" onchange="changecargahrGesEnsPesExtup(<?= $auxgepe ?>);" /></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-8">
                                                                                                            <div class="col-md-12"><b>Informação</b></div>
                                                                                                            <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infogepeup<?= $auxgepe ?>" /></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-4">
                                                                                                            <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                                                            <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontogepeup<?= $auxgepe ?>" /></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="col-md-12"><b>Título da atividade</b></div>
                                                                                                            <div class="col-md-12"><input type="text" class="form-control" id="tituloGesEnsPesExt" name="tituloGesEnsPesExt" /></div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp;   * Favor juntar os documentos em um único arquivo PDF.</small></div>
                                                                                                            <div class="col-md-12"><input type="file" class="form-control" id="anexoGesEnsPesExt" name="anexoGesEnsPesExt" /></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6 offset-md-3 mt-4">
                                                                                                            <button type="button" class="shadow btn btn-outline-success form-control" data-toggle="modal" data-target="#modalGepe<?= $gepeid ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
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
                                                                            <?php }
                                                                        } else { ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } while ($rsgepe = mysqli_fetch_array($qgepe));
                                                                }
                                                            } else {
                                                                ?>
                                                                <div class="row mb-3 mt-2">
                                                                    <div class="col-md-12">
                                                                        <p class="text-info font-weight-bold text-center">*** Nenhuma atividade inserida ***</p>
                                                                    </div>
                                                                </div>          
                                                                <?php }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($nrit > 0) {
                                                $fit = "SIM";
                                            } else {
                                                $fit = "NÃO";
                                            }
                                            ?>
                                            <div class="row mb-1">
                                                <div class="col-12">
                                                    <div class="card border-1 ">
                                                        <div class="card-header text-white" style="background-color: #0055A1;">
                                                            <label><strong>Inovação Tecnológica</strong></label>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php
//                                                          var_dump($nrit, $rsit);
                                                            if ($nrit > 0) {
                                                                if ($rsit) {
                                                                    $auxit = 0;
                                                                    do {
                                                                        $flagupit = $rsit['flagup'];
                                                                        if ($flagupit !== null && $flagupit === '1') {
                                                                            continue;
                                                                        }
                                                                        $auxit++;
                                                                        $itid = $rsit['id'];
                                                                        $itidinovtecnologica = $rsit['idinovtecnologica'];
                                                                        $chit = $itpt = '';
                                                                        if ($itidinovtecnologica !== null && $itidinovtecnologica !== '') {
                                                                            switch ($itidinovtecnologica) {
                                                                                case '1': $chit = "Carga Horária";
                                                                                    break;
                                                                                case '2': $chit = "Carga Horária";
                                                                                    break;
                                                                            }
                                                                        }
                                                                        $itdesc = $rsit['idesc'];
                                                                        $ittitulo = $rsit['titulo'];
                                                                        $itcargahr = $rsit['cargahr'];
                                                                        $itpt = $rsit['cargahr'];
                                                                        if($itcargahr !== null && $itcargahr !== ''){
                                                                            $itpexp += floatval($itcargahr);
                                                                        }
                                                                        $itanexo = $rsit['anexo'];
                                                                        $itdthrcadastro = $rsit['dthrcadastro'];
                                                                        $itflagparecer = $rsit['flagparecer'];
                                                                        if ($itflagparecer !== '' && $itflagparecer !== null) {
                                                                            $flagit = true;
                                                                        } else {
                                                                            $flagit = false;
                                                                        }
                                                                        $itparecer = trim($rsit['parecer']);
                                                                        $itpontuacao = $rsit['pontuacao'];
                                                                        if ($itpontuacao === null || $itpontuacao === '') {
                                                                            $itpontuacao = 0.00;
                                                                        }
                                                                        $itp += $itpontuacao;
                                                                        $itpontuacaotxt = (string) $itpontuacao;
                                                                        $itpontuacaotxt = str_replace(".", ",", $itpontuacaotxt);
                                                                        $itpareceruser = $rsit['pareceruser'];
                                                                        $itparecerdthr = vemdata($rsit['parecerdthr']);
                                                                        $itparecerdthr .= ", às " . horaEmin($rsit['parecerdthr']) . ".";
                                                                        ?>
                                                                                    <?php
                                                                                    if ($auxit > 1) {
                                                                                        ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12 bg-dark text-white p-2 border text-center mt-4 mb-3 font-weight-bold small align-middle"><i class="fas fa-chevron-circle-right float-left mt-1"></i> &nbsp;Inovação Tecnológica: Atividade <?= $auxit ?>&nbsp; <i class="fas fa-chevron-circle-left float-right mt-1"></i></div>
                                                                            </div>
                    <?php } ?>
                                                                        <div class="row mb-1">
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
                                                                            <div class="col-md-9">
                                                                                <ul class="list-group">
                                                                                    <li class="list-group-item bg-light"><b>Pontuação pretendida: </b>&nbsp;<?= $itpt ?>,00</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($flagit === true) { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="card border mb-1">
                                                                                <?php if ($itflagparecer === '1') { ?>
                                                                                    <div class="card-header bg-light">
                                                                                        <label><strong>Análise realizada</strong></label>
                                                                                    </div>
                                                                                <?php } else { ?>
                                                                                    <div class="card-header" style="background-color: #fcec89;">
                                                                                        <label><strong>Análise realizada</strong></label>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                    <div class="card-body">
                                                                                        <div class="row mb-2">
                                                                                            <div class="col-md-12">
                                                                                            <?php
                                                                                            if ($itflagparecer === '1') {
                                                                                                $parecerit = "<label class='text-primary'>Aprovado</label>";
                                                                                            } else {
                                                                                                $parecerit = "<label class='text-danger'>Não aprovado</label>";
                                                                                            }
                                                                                            ?>
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Parecer: </b><?= $parecerit ?></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Descrição da Análise: </b><?= $itparecer ?></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Data e hora do envio: </b><label><?= $itparecerdthr ?></label></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                            <?php
                                                                                            if ($itpontuacaotxt === '0,00') {
                                                                                                $itponttxt = "<label class='text-danger'>$itpontuacaotxt</label>";
                                                                                            } else {
                                                                                                $itponttxt = "<label class='text-primary'>$itpontuacaotxt</label>";
                                                                                            }
                                                                                            ?>
                                                                                                <ul class="list-group">
                                                                                                    <li class="list-group-item bg-light"><b>Pontuação adquirida: </b> <?= $itponttxt ?></li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($itflagparecer === '0' && $flagupit === '0' && $flagterminouap !== '1') { ?>
                                                                        <form method="post" enctype="multipart/form-data" action="controller/rcbit.php">
                                                                            <input type="hidden" name="idap" value="<?= $idap ?>">
                                                                            <input type="hidden" name="itid" value="<?= $itid ?>">
                                                                            <input type="hidden" value="<?= $cpftratado ?>" name="cpf">
                                                                            <input type="hidden" value="<?= $ibgeO ?>" name="ibgeO">
                                                                            <input type="hidden" value="<?= $cnes ?>" name="cnes">
                                                                            <input type="hidden" value="<?= $ine ?>" name="ine">
                                                                            <input type="hidden" value="<?= $ano ?>" name="ano">
                                                                            <input type="hidden" value="<?= $ciclo ?>" name="ciclo">
                                                                        <div class="row mb-1">
                                                                            <div class="col-12">
                                                                                <div class="card border-1">
                                                                                    <div class="card-header text-white" style="background-color: #590d97;">
                                                                                        <label><strong>Inovação Tecnológica - Atualização/Correção</strong></label>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <div class="row mb-2">
                                                                                            <div class="col-md-8">
                                                                                                <div class="col-md-12"><b>Atividade</b></div>
                                                                                                <div class="col-md-12">
                                                                                                    <select class="form-control" id="slInovTecup<?= $auxit ?>" name="slInovTec" onchange="changeInovTecup(<?= $auxit ?>)">
                                                                                                        <option value="">[--SELECIONE--]</option>
                                                                                                    <?php
                                                                                                    $sqlinovtecnologica = "select idinovtecnologica as idi, descricao as desci from inovtecnologica";
                                                                                                    $qinovtecnologica = mysqli_query($conn, $sqlinovtecnologica) or die(mysqli_error($conn));
                                                                                                    $rsinovtecnologica = mysqli_fetch_array($qinovtecnologica);
                                                                                                    if ($rsinovtecnologica !== null) {
                                                                                                        do {
                                                                                                            $idi = $rsinovtecnologica['idi'];
                                                                                                            $desci = $rsinovtecnologica['desci'];
                                                                                                    ?>
                                                                                                        <option value="<?= $idi ?>"><?= $desci ?></option>
                                                                                                    <?php
                                                                                                        } while ($rsinovtecnologica = mysqli_fetch_array($qinovtecnologica));
                                                                                                    }
                                                                                                    ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="col-md-12"><b>Carga Horária</b></div>
                                                                                                <div class="col-md-12"><input type="number" class="form-control" min="1" id="cargahrInovTecup<?= $auxit ?>" name="cargahrInovTec" onchange="changeChInovTecup(<?= $auxit ?>)"/></div>
                                                                                            </div>
                                                                                            <div class="col-md-8">
                                                                                                <div class="col-md-12"><b>Informação</b></div>
                                                                                                <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infoitup<?= $auxit ?>" /></div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="col-md-12"><b>Pontuação Estimada</b></div>
                                                                                                <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontoitup<?= $auxit ?>" /></div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div class="col-md-12"><b>Título da atividade</b></div>
                                                                                                <div class="col-md-12"><input type="text" class="form-control" id="tituloInovTec" name="tituloInovTec" /></div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp;   * Favor juntar os documentos em um único arquivo PDF.</small></div>
                                                                                                <div class="col-md-12"><input type="file" class="form-control" id="anexoInovTec" name="anexoInovTec" /></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 offset-md-3 mt-4">
                                                                                                <button type="button" class="shadow btn btn-outline-success form-control" data-toggle="modal" data-target="#modalIT<?= $itid ?>">ENVIAR ATIVIDADE CORRIGIDA</button>
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
                                                                        <?php }
                                                                        } else { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h6 class="text-info pl-3"><i class="fas fa-hand-point-right"></i> Análise em andamento...</h6>   
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        }
                                                                    } while ($rsit = mysqli_fetch_array($qit));
                                                                }
                                                            } else {
                                                                ?>
                                                                <div class="row mb-3 mt-2">
                                                                    <div class="col-md-12">
                                                                        <p class="text-info font-weight-bold text-center">*** Nenhuma atividade inserida ***</p>
                                                                    </div>
                                                                </div>     
                                                        <?php }
                                                    } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $somapt = $pontuacaoap + $qcp + $gepep + $itp; ?>
                            <?php $somaptexp = $pontexpap + $qcpexp + $gepepexp + $itpexp; ?>
                            <input type="hidden" id="somapt" value="<?= $somapt ?>">
                            <input type="hidden" id="somaptexp" value="<?= $somaptexp ?>">
                            <input type="hidden" id="sumptexp">
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body text-center text-primary">
                                    O ano <?= $ano ?> e o ciclo <?= $ciclo ?> não foi aberto.
                                </div>
                            </div>   
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade mb-3" id="modalptexp"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title" id="exampleModalLabel">Total da Pontuação Inserida</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div id="ptexp" class="h6"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
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
       $('#modalptexp').modal('hide');
       let ptgeral = 0.00;
       if($('#ptld').val() !== null && $('#ptld').val() !== ''){
           let ptld = parseFloat($('#ptld').val());
       }
       if($('#ptqc').val() !== null && $('#ptqc').val() !== ''){
           let ptqc = parseFloat($('#ptqc').val());
       }
//       console.log($('#ptqc').val());
       if($('#ptgepe').val() !== null && $('#ptgepe').val() !== ''){
           let ptgepe = parseFloat($('#ptgepe').val());
       }
//       console.log($('#ptgepe').val());
       if($('#ptit').val() !== null && $('#ptit').val() !== ''){
           let ptit = parseFloat($('#ptit').val());
       }
//       console.log($('#ptit').val());
       if($('#somaptexp').val() !== null && $('#somaptexp').val() !== '' && $('#somaptexp').val() > 0){
            ptgeral = parseFloat($('#somapt').val());
            let ptgeraltxt = ""+ptgeral;
            ptgeraltxt = ptgeraltxt.replace('.',',');
            if(ptgeraltxt.indexOf(',') === -1){
                ptgeraltxt = ptgeraltxt+",00";
            }
            $('#ptgeral').html(ptgeraltxt);
            let ptgeralexp = $('#somaptexp').val();
            let ptgeralexptxt = ""+ptgeralexp;
            ptgeralexptxt = ptgeralexptxt.replace('.',',');
            if(ptgeralexptxt.indexOf(',') === -1){
                ptgeralexptxt = ptgeralexptxt+",00";
            }
            $('#ptexpec').html(ptgeralexptxt);
       }
    });
    $('#rdativ').change(function(){
        let rdativ = $('#rdativ').val();
        if(rdativ === '1'){
            $("#pontold").val("50,00");
            $('.divLongDuracao').show(400);
        }else{
            $("#pontold").val("");
            $('.divLongDuracao').hide(300);
        }
    });
    $('#rdativup').change(function(){
        let rdativup = $('#rdativup').val();
        if(rdativup === '1'){
            $("#pontoldup").val("50,00");
            $('.divLongDuracao').show(400);
        }else{
            $("#pontoldup").val("");
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
//       a = document.querySelectorAll('.divQualiClinica').length;
       a = $("#qtdatvqc").val();
//       console.log(a);
       if(a !== '0' && a !== ''){
           addQualiClinica(a);
       }
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
//       a = document.querySelectorAll('.divGesEnsPesExt').length;
       a = $("#qtdatvgepe").val();
//       console.log(a);
       if(a !== '0' && a !== ''){
           addGesEnsPesExt(a);
       }
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
//       a = document.querySelectorAll('.divInovTec').length;
       a = $("#qtdatvit").val();
//       console.log(a);
       if(a !== '0' && a !== ''){
           addInovTec(a);
       }
    });
    function retiraAtvLongDur(num){
        $('#atvLongDur'+num).remove();
        $('#cargaLongDur'+num).remove();
        $('#anexoLongDur'+num).remove();
        $('#btnLongDur'+num).remove();
        $('#divinfoLongDur'+num).remove();
        $('#divpontoLongDur'+num).remove();
    }
    function retiraQualiClinica(num){
        $('#qualiClinica'+num).remove();
        $('#divcargaQualiClinica'+num).remove();
        $('#divtituloQualiClinica'+num).remove();
        $('#divanexoQualiClinica'+num).remove();
        $('#divbtnQualiClinica'+num).remove();
        $('#divinfoQualiClinica'+num).remove();
        $('#divpontoQualiClinica'+num).remove();
    }
    function retiraGesEnsPesExt(num){
        $('#gesEnsPesExt'+num).remove();
        $('#divcargaGesEnsPesExt'+num).remove();
        $('#divtituloGesEnsPesExt'+num).remove();
        $('#divanexoGesEnsPesExt'+num).remove();
        $('#divbtnGesEnsPesExt'+num).remove();
        $('#divinfoGesEnsPesExt'+num).remove();
        $('#divpontoGesEnsPesExt'+num).remove();
    }
    function retiraInovTec(num){
        $('#inovTec'+num).remove();
        $('#divcargaInovTec'+num).remove();
        $('#divtituloInovTec'+num).remove();
        $('#divanexoInovTec'+num).remove();
        $('#divbtnInovTec'+num).remove();
        $('#divinfoInovTec'+num).remove();
        $('#divpontoInovTec'+num).remove();
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
    $("#slGesEnsPesExt").change(function(){
       let slgepe =  $("#slGesEnsPesExt").val();
       $('#cargahrGesEnsPesExt').val(null);  
       $("#pontogepe").val(null);
       if(slgepe !== ""){
           switch(slgepe){
               case '1': $("#gepech").html('');
                   $("#gepech").html('<b>Carga Horária</b>'); 
                   $("#infogepe").val('1 crédito por hora de curso.');
                   break;
               case '2': $("#gepech").html('');
                   $("#gepech").html('<b>Carga Horária</b>'); 
                   $("#infogepe").val('1 crédito por hora de evento.');
                   break;
               case '3': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Publicações</b>'); 
                   $("#infogepe").val('15 créditos por publicação.');
                   break;
               case '4': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Publicações</b>'); 
                   $("#infogepe").val('5 créditos por publicação.');
                   break;
               case '5': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Publicações</b>'); 
                   $("#infogepe").val('15 créditos por publicação.');
                   break;
               case '6': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Publicações</b>'); 
                   $("#infogepe").val('10 créditos por publicação.');
                   break;
               case '7': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Participação</b>'); 
                   $("#infogepe").val('5 créditos por participação.');
                   break;
               case '8': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Participação</b>'); 
                   $("#infogepe").val('3 créditos por participação.');
                   break;
               case '9': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Participação</b>'); 
                   $("#infogepe").val('5 créditos por participação.');
                   break;
               case '10': $("#gepech").html('');
                   $("#gepech").html('<b>Quantidade de Horas de Atividade</b>'); 
                   $("#infogepe").val('1 créditos por hora de atividade.');
                   break;
               
           }
       }
    });
    $('#cargahrGesEnsPesExt').change(function(){
        let slgepe = $("#slGesEnsPesExt").val();
        if(slgepe !== ''){
            let chgepe = parseFloat($('#cargahrGesEnsPesExt').val());
            let pontos = 0.00;
            switch(slgepe){
                case '1': pontos = chgepe; break;
                case '2': pontos = chgepe; break;
                case '3': pontos = 15.00 * chgepe; break;
                case '4': pontos = 5.00 * chgepe; break;
                case '5': pontos = 15.00 * chgepe; break;
                case '6': pontos = 10.00 * chgepe; break;
                case '7': pontos = 5.00 * chgepe; break;
                case '8': pontos = 3.00 * chgepe; break;
                case '9': pontos = 5.00 * chgepe; break;
                case '10': pontos = chgepe; break;
            }
            let pontostxt = ""+pontos;
            pontostxt = pontostxt.replace(".",",");
            if(pontostxt.indexOf(',') === -1){
                pontostxt = pontostxt+',00';
            }
            $("#pontogepe").val(pontostxt);
        }
        if(slgepe !== ""){
            switch(slgepe){
                case '1': $("#infogepe").val('1 crédito por hora de curso.');
                    break;
                case '2': $("#infogepe").val('1 crédito por hora de evento.');
                    break;
                case '3': $("#infogepe").val('15 créditos por publicação.');
                    break;
                case '4': $("#infogepe").val('5 créditos por publicação.');
                    break;
                case '5': $("#infogepe").val('15 créditos por publicação.');
                    break;
                case '6': $("#infogepe").val('10 créditos por publicação.');
                    break;
                case '7': $("#infogepe").val('5 créditos por participação.');
                    break;
                case '8': $("#infogepe").val('3 créditos por participação.');
                    break;
                case '9': $("#infogepe").val('5 créditos por participação.');
                    break;
                case '10': $("#infogepe").val('1 créditos por hora de atividade.');
                    break;

            }
        }
    });
    function changeGesEnsPesExtup(a){
        let slgepeup =  $("#slGesEnsPesExtup"+a).val();
        if(slgepeup !== ""){
            switch(slgepeup){
                case '1': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Carga Horária</b>'); 
                    $("#infogepeup"+a).val('1 crédito por hora de curso.');
                    break;
                case '2': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Carga Horária</b>'); 
                    $("#infogepeup"+a).val('1 crédito por hora de evento.');
                    break;
                case '3': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepeup"+a).val('15 créditos por publicação.');
                    break;
                case '4': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepeup"+a).val('5 créditos por publicação.');
                    break;
                case '5': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepeup"+a).val('15 créditos por publicação.');
                    break;
                case '6': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepeup"+a).val('10 créditos por publicação.');
                    break;
                case '7': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Participação</b>'); 
                    $("#infogepeup"+a).val('5 créditos por participação.');
                    break;
                case '8': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Participação</b>'); 
                    $("#infogepeup"+a).val('3 créditos por participação.');
                    break;
                case '9': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Participação</b>'); 
                    $("#infogepeup"+a).val('5 créditos por participação.');
                    break;
                case '10': $("#gepechup"+a).html('');
                    $("#gepechup"+a).html('<b>Quantidade de Horas de Atividade</b>'); 
                    $("#infogepeup"+a).val('1 créditos por hora de atividade.');
                    break;
            }
        }
    }
    function changecargahrGesEnsPesExtup(a){
        let slgepeup = $("#slGesEnsPesExtup"+a).val();
        if(slgepeup !== ''){
            let chgepe = parseFloat($('#cargahrGesEnsPesExtup'+a).val());
            let pontos = 0.00;
            switch(slgepeup){
                case '1': pontos = chgepe; break;
                case '2': pontos = chgepe; break;
                case '3': pontos = 15.00 * chgepe; break;
                case '4': pontos = 5.00 * chgepe; break;
                case '5': pontos = 15.00 * chgepe; break;
                case '6': pontos = 10.00 * chgepe; break;
                case '7': pontos = 5.00 * chgepe; break;
                case '8': pontos = 3.00 * chgepe; break;
                case '9': pontos = 5.00 * chgepe; break;
                case '10': pontos = chgepe; break;
            }
            let pontostxt = ""+pontos;
            pontostxt = pontostxt.replace(".",",");
            if(pontostxt.indexOf(',') === -1){
                pontostxt = pontostxt+',00';
            }
            $("#pontogepeup"+a).val(pontostxt);
            if(slgepeup !== ""){
                switch(slgepeup){
                    case '1': $("#infogepeup"+a).val('1 crédito por hora de curso.');
                        break;
                    case '2': $("#infogepeup"+a).val('1 crédito por hora de evento.');
                        break;
                    case '3': $("#infogepeup"+a).val('15 créditos por publicação.');
                        break;
                    case '4': $("#infogepeup"+a).val('5 créditos por publicação.');
                        break;
                    case '5': $("#infogepeup"+a).val('15 créditos por publicação.');
                        break;
                    case '6': $("#infogepeup"+a).val('10 créditos por publicação.');
                        break;
                    case '7': $("#infogepeup"+a).val('5 créditos por participação.');
                        break;
                    case '8': $("#infogepeup"+a).val('3 créditos por participação.');
                        break;
                    case '9': $("#infogepeup"+a).val('5 créditos por participação.');
                        break;
                    case '10': $("#infogepeup"+a).val('1 créditos por hora de atividade.');
                        break;
                }
            }
        }
    }
    function slgepeall(a){
//      console.log("entrou no slgepeall");
        $('#cargahrGesEnsPesExt'+a).val(null);  
        $("#pontogepe"+a).val(null);
        let slgepe =  $("#slGesEnsPesExt"+a).val();
        if(slgepe !== ""){
            switch(slgepe){
                case '1': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Carga Horária</b>'); 
                    $("#infogepe"+a).val('1 crédito por hora de curso.');
                    break;
                case '2': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Carga Horária</b>'); 
                    $("#infogepe"+a).val('1 crédito por hora de evento.');
                    break;
                case '3': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepe"+a).val('15 créditos por publicação.');
                    break;
                case '4': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepe"+a).val('5 créditos por publicação.');
                    break;
                case '5': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepe"+a).val('15 créditos por publicação.');
                    break;
                case '6': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Publicações</b>'); 
                    $("#infogepe"+a).val('10 créditos por publicação.');
                    break;
                case '7': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Participação</b>'); 
                    $("#infogepe"+a).val('5 créditos por participação.');
                    break;
                case '8': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Participação</b>'); 
                    $("#infogepe"+a).val('3 créditos por participação.');
                    break;
                case '9': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Participação</b>'); 
                    $("#infogepe"+a).val('5 créditos por participação.');
                    break;
                case '10': $("#gepech"+a).html('');
                    $("#gepech"+a).html('<b>Quantidade de Horas de Atividade</b>'); 
                    $("#infogepe"+a).val('1 créditos por hora de atividade.');
                    break;
            }
        }
    }
    function chgepeall(a){ 
        let slgepe = $("#slGesEnsPesExt"+a).val();
        if(slgepe !== ""){
            switch(slgepe){
                case '1': $("#infogepe"+a).val('1 crédito por hora de curso.');
                    break;
                case '2': $("#infogepe"+a).val('1 crédito por hora de evento.');
                    break;
                case '3': $("#infogepe"+a).val('15 créditos por publicação.');
                    break;
                case '4': $("#infogepe"+a).val('5 créditos por publicação.');
                    break;
                case '5': $("#infogepe"+a).val('15 créditos por publicação.');
                    break;
                case '6': $("#infogepe"+a).val('10 créditos por publicação.');
                    break;
                case '7': $("#infogepe"+a).val('5 créditos por participação.');
                    break;
                case '8': $("#infogepe"+a).val('3 créditos por participação.');
                    break;
                case '9': $("#infogepe"+a).val('5 créditos por participação.');
                    break;
                case '10': $("#infogepe"+a).val('1 créditos por hora de atividade.');
                    break;
            }
        }
        if(slgepe !== ''){
            let chgepe = parseFloat($('#cargahrGesEnsPesExt'+a).val());
            let pontos = 0.00;
            switch(slgepe){
                case '1': pontos = chgepe; break;
                case '2': pontos = chgepe; break;
                case '3': pontos = 15.00 * chgepe; break;
                case '4': pontos = 5.00 * chgepe; break;
                case '5': pontos = 15.00 * chgepe; break;
                case '6': pontos = 10.00 * chgepe; break;
                case '7': pontos = 5.00 * chgepe; break;
                case '8': pontos = 3.00 * chgepe; break;
                case '9': pontos = 5.00 * chgepe; break;
                case '10': pontos = chgepe; break;
            }
            let pontostxt = ""+pontos;
            pontostxt.replace(".",",");
            if(pontostxt.indexOf(',') === -1){
                pontostxt = pontostxt+',00';
            }
            $("#pontogepe"+a).val(pontostxt);
            if(slgepe !== ""){
                switch(slgepe){
                    case '1':$("#infogepe"+a).val('1 crédito por hora de curso.');
                        break;
                    case '2': $("#infogepe"+a).val('1 crédito por hora de evento.');
                        break;
                    case '3': $("#infogepe"+a).val('15 créditos por publicação.');
                        break;
                    case '4': $("#infogepe"+a).val('5 créditos por publicação.');
                        break;
                    case '5': $("#infogepe"+a).val('15 créditos por publicação.');
                        break;
                    case '6': $("#infogepe"+a).val('10 créditos por publicação.');
                        break;
                    case '7': $("#infogepe"+a).val('5 créditos por participação.');
                        break;
                    case '8': $("#infogepe"+a).val('3 créditos por participação.');
                        break;
                    case '9': $("#infogepe"+a).val('5 créditos por participação.');
                        break;
                    case '10': $("#infogepe"+a).val('1 créditos por hora de atividade.');
                        break;
                }
            }
        }
    }
    $("#slQualiClinica").change(function(){
       $('#cargahrQualiClinica').val(null);
       $("#pontoqc").val(null);
       let slqc = $("#slQualiClinica").val();
       if(slqc !== ''){
           if(slqc === '3'){
               $("#qcch").html('');
               $("#qcch").html('<b>Conforme CME</b>');
               $("#infoqc").val('Créditos conforme documento de emissão de CME do respectivo sistema.');
           }else{
               $("#qcch").html('');
               $("#qcch").html('<b>Carga Horária</b>');
               $("#infoqc").val('1 crédito por hora de curso/evento.');
           }
       }
    });
    $('#cargahrQualiClinica').change(function(){
        let cgqc = $('#cargahrQualiClinica').val();
        $("#pontoqc").val(cgqc+',00');
    });
    function changeQualiClinicaup(a){
        $('#cargahrQualiClinicaup'+a).val(null);
        $("#pontoqcup"+a).val(null);
        let slqcup = $("#slQualiClinicaup"+a).val();
        if(slqcup !== ''){
            if(slqcup === '3'){
                $("#qcup"+a).html('');
                $("#qcup"+a).html('<b>Conforme CME</b>');
                $("#infoqcup"+a).val('Créditos conforme documento de emissão de CME do respectivo sistema.');
            }else{
                $("#qcup"+a).html('');
                $("#qcup"+a).html('<b>Carga Horária</b>');
                $("#infoqcup"+a).val('1 crédito por hora de curso/evento.');
            }
        }
    }
    function changeChQualiClinicaup(a){
        let cgqc = $('#cargahrQualiClinicaup'+a).val();
        $("#pontoqcup"+a).val(cgqc+',00');
        let slqcup = $("#slQualiClinicaup"+a).val();
        if(slqcup !== ''){
            if(slqcup === '3'){
                $("#infoqcup"+a).val('Créditos conforme documento de emissão de CME do respectivo sistema.');
            }else{
                $("#infoqcup"+a).val('1 crédito por hora de curso/evento.');
            }
        }
        slqcup = $("#slQualiClinicaup"+a).val();
        if(slqcup !== ''){
            if(slqcup === '3'){
                $("#infoqcup"+a).val('Créditos conforme documento de emissão de CME do respectivo sistema.');
            }else{
                $("#infoqcup"+a).val('1 crédito por hora de curso/evento.');
            }
        }
    }
    function slqcall(a){
//      console.log("entrou no slqcall");
        $('#cargahrQualiClinica'+a).val(null);
        $("#pontoqc"+a).val(null);
        let slqc = $("#slQualiClinica"+a).val();
        if(slqc !== ''){
            if(slqc === '3'){
                $("#qcch"+a).html('');
                $("#qcch"+a).html('<b>Conforme CME</b>');
                $("#infoqc"+a).val('Créditos conforme documento de emissão de CME do respectivo sistema.');
            }else{
                $("#qcch"+a).html('');
                $("#qcch"+a).html('<b>Carga Horária</b>');
                $("#infoqc"+a).val('1 crédito por hora de curso/evento.');
            }
        }
    }
    function chqcall(a){
        let slqc = $("#slQualiClinica"+a).val();
        if(slqc !== ''){
            if(slqc === '3'){
                $("#infoqc"+a).val('Créditos conforme documento de emissão de CME do respectivo sistema.');
            }else{
                $("#infoqc"+a).val('1 crédito por hora de curso/evento.');
            }
        }
        let chqc = $('#cargahrQualiClinica'+a).val();
        $("#pontoqc"+a).val(chqc+',00');
    }
    $("#slInovTec").change(function(){
       $('#cargahrInovTec').val(null);
       $("#pontoit").val(null);
       let slit = $("#slInovTec").val();
       if(slit !== ''){
           if(slit === '1'){
               $("#infoit").val('1 crédito por hora de evento.');
           }else{
               $("#infoit").val('1 crédito por hora de atividade.');
           }
       }
    });
    $('#cargahrInovTec').change(function(){
        let cgit = $('#cargahrInovTec').val();
        $("#pontoit").val(cgit+',00');
    });
    function changeInovTecup(a){
        let slit = $("#slInovTecup"+a).val();
        if(slit !== ''){
            if(slit === '1'){
                $("#infoitup"+a).val('1 crédito por hora de evento.');
            }else{
                $("#infoitup"+a).val('1 crédito por hora de atividade.');
            }
        }
    }
    function changeChInovTecup(a){
        let cgit = $('#cargahrInovTecup'+a).val();
        $("#pontoitup"+a).val(cgit+',00');
        let slit = $("#slInovTecup"+a).val();
        if(slit !== ''){
            if(slit === '1'){
                $("#infoitup"+a).val('1 crédito por hora de evento.');
            }else{
                $("#infoitup"+a).val('1 crédito por hora de atividade.');
            }
        }
    }
    function slitall(a){
//      console.log("entrou no slitall");
        $('#cargahrInovTec'+a).val(null);
        $("#pontoit"+a).val(null);
        let slit = $("#slInovTec"+a).val();
        if(slit !== ''){
            if(slit === '1'){
                $("#infoit"+a).val('1 crédito por hora de evento.');
            }else{
                $("#infoit"+a).val('1 crédito por hora de atividade.');
            }
        }
    }
    function chitall(a){
        let slit = $("#slInovTec"+a).val();
        if(slit !== ''){
            if(slit === '1'){
                $("#infoit"+a).val('1 crédito por hora de evento.');
            }else{
                $("#infoit"+a).val('1 crédito por hora de atividade.');
            }
        }
        let cgit = $('#cargahrInovTec'+a).val();
        $("#pontoit"+a).val(cgit+',00');
    }
    function montantePontos(){
         var soma = 0;
    
        $("input[id^='ponto']").each(function() {
            var valor = $(this).val();

            // Substituir vírgula por ponto e converter para float
            valor = parseFloat(valor.replace(',', '.'));

            // Verificar se o valor é um número, não é NaN, é maior que zero e não é nulo
            if (!isNaN(valor) && valor > 0) {
                soma += valor;
            }
        });

        console.log("Soma total:", soma);
        let somatxt = ""+soma;
        somatxt = somatxt.replace(".",",");
        if(somatxt.indexOf(",") === -1){
            somatxt += ",00";
        }
        $("#ptexp").html("Total da pontuação estimada:  <label class='text-primary'>&nbsp;" + somatxt+"</label>");
    }
    </script>
</body>

</html>