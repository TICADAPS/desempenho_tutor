<?php
session_start();
include './../../conexao-agsus.php';
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
$ine = $_GET['i'];
$ano = $_GET['a'];
$inetratado = str_replace("-", "", $ine);
$inetratado = str_replace(".", "", $inetratado);
$inetratado = str_replace(".", "", $inetratado);
//var_dump($inetratado);
$sql = "select * from medico m inner join desempenho d on m.ine = d.ine and m.ibge = d.ibge"
        . " inner join periodo p on p.idperiodo = d.idperiodo "
        . " left join ivs on idivs = fkivs "
        . " where m.ine = '$inetratado' and ano = '$ano';";
$query = mysqli_query($conn, $sql);
$nrrs = mysqli_num_rows($query);
$rs = mysqli_fetch_array($query);
$rsine = false;
if ($nrrs > 0) {
    $rsine = true;
}
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
        <link rel="shortcut icon" href="./../../img_agsus/iconAdaps.png"/>
        <link href="./../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="./../../css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-12 col-md-4 mt-4 pl-5">
                    <img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 mt-4 ">
                    <h4 class="mb-4 font-weight-bold text-center">Programa de Avaliação de Desempenho do Médico Tutor</h4> 
                    <h4 class="mb-4 font-weight-bold text-center">Evolução da Qualidade Assistencial</h4>
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
                                    <a class="nav-link" href="../eqa/" target="_parent" title="Voltar"><i class="fas fa-arrow-left"></i></a>
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
            <?php
            if ($rsine === true) {
                if ($nrrs == 1) {
                    do {
                        $nome = $rs['nome'];
                        $ibge = $rs['ibge'];
                        $admissao = $rs['admissao'];
                        $cargo = $rs['cargo'];
                        $tipologia = $rs['tipologia'];
                        $uf = $rs['uf'];
                        $municipio = $rs['municipio'];
                        $cnes = $rs['cnes'];
                        $ine = $rs['ine'];
                        if($rs['descricao'] !== null){
                            $ivs = strtoupper($rs['descricao']);
                        }else{
                            $ivs = "";
                        }
                        $datacadastro = $rs['datacadastro'];
                        $ano = $rs['ano'];
                        $periodo = $rs['descricaoperiodo'];
                        $idperiodo = $rs['idperiodo'];
                        $prenatal_consultas = $rs['prenatal_consultas'];
                        $prenatal_consultastext = str_replace(",", "", $prenatal_consultas);
                        $prenatal_consultastext = str_replace(".", ",", $prenatal_consultastext);
                        $prenatal_sifilis_hiv = $rs['prenatal_sifilis_hiv'];
                        $prenatal_sifilis_hivtext = str_replace(",", "", $prenatal_sifilis_hiv);
                        $prenatal_sifilis_hivtext = str_replace(".", ",", $prenatal_sifilis_hivtext);
                        $cobertura_citopatologico = $rs['cobertura_citopatologico'];
                        $cobertura_citopatologicotext = str_replace(",", "", $cobertura_citopatologico);
                        $cobertura_citopatologicotext = str_replace(".", ",", $cobertura_citopatologicotext);
                        $hipertensao = $rs['hipertensao'];
                        $hipertensaotext = str_replace(",", "", $hipertensao);
                        $hipertensaotext = str_replace(".", ",", $hipertensaotext);
                        $diabetes = $rs['diabetes'];
                        $diabetestext = str_replace(",", "", $diabetes);
                        $diabetestext = str_replace(".", ",", $diabetestext);
                        ?>
                            <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3 mb-2">
                                <div class="row p-3">
                                    <div class="col-md-12 mt-3 mb-4">
                                        <div class="row mt-3 mb-2">
                                            <div class="col-md-6 mb-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <!--<label class="font-weight-bold">Nome: </label><label> &nbsp;<?= $nome ?></label>-->
                                                    </div>
                                                </div>
                                               
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="font-weight-bold">Cargo: </label><label> &nbsp;&nbsp;<?= $cargo ?></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="text-info font-weight-bold"><?php echo "Município-UF: $municipio-$uf" ?></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-info font-weight-bold"><?php echo "CNES: $cnes" ?></h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-info font-weight-bold"><?php echo "INE: $ine" ?></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="font-weight-bold">Tipologia: </label><label> &nbsp;&nbsp;<?= $tipologia ?></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="font-weight-bold">IVS: </label><label> &nbsp;&nbsp;<?= $ivs ?></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-info font-weight-bold"><?php echo "Ano: $ano" ?></h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-info font-weight-bold"><?php echo "Período: $periodo" ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="row pl-2 pr-2 mb-2">
                                                        <div class="col-md-12">
                                                            <h5 class="small font-weight-bold">* Sinalização semafórica do alcance (metas) dos indicadores</h5>
                                                            <label class="small text-danger">Obs.: clique nos indicadores a fim de apresentar a sinalização semafórica do alcance da meta definida para o indicador correspondente.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 card-body shadow border rounded secondary divexp1">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <h5 class="small text-justify font-weight-bold">Pré-Natal  (6 consultas)</h5>
                                                                    </div>
                                                                </div>
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
                                                                    <div class="col-md-12">
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width: 20%" class="btn btn-sm bg-gradient-danger text-white"></td>
                                                                                <td style="width: 80%" class="small">< 18%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="width: 20%" class="btn btn-sm bg-gradient-warning text-white"></td>
                                                                                <td style="width: 80%" class="small">>= 18% < 31%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="width: 20%" class="btn btn-sm bg-gradient-success text-white"></td>
                                                                                <td style="width: 80%" class="small">>= 31% < 45%</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="width: 20%" class="btn btn-sm bg-gradient-primary text-white"></td>
                                                                                <td style="width: 80%" class="small">>= 45%</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12 card-body shadow border rounded secondary divexp2">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h5 class="small text-justify font-weight-bold">
                                                                                    Pré-Natal (Sífilis e HIV)</h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label class="small text-justify">
                                                                                    Proporção de gestantes com realização de exames para sífilis e HIV.
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                                                            <div class="col-md-12">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-danger text-white"></td>
                                                                                        <td style="width: 80%" class="small">< 24%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-warning text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 24% < 42%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-success text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 42% < 60%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-primary text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 60%</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 card-body shadow border rounded secondary divexp3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h5 class="small text-justify font-weight-bold">
                                                                                    Cobertura Citopatológico</h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label class="small text-justify">
                                                                                    Proporção de mulheres com coleta de citopatológico na APS.
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                                                            <div class="col-md-12">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-danger text-white"></td>
                                                                                        <td style="width: 80%" class="small">< 16%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-warning text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 16% < 28%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-success text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 28% < 40%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-primary text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 40%</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 card-body shadow border rounded secondary divexp4">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h5 class="small font-weight-bold">Hipertensão (PA Aferida)</h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label class="small text-justify">
                                                                                    Proporção de pessoas com hipertensão, com consulta e pressão arterial aferida no semestre.
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                                                            <div class="col-md-12">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-danger text-white"></td>
                                                                                        <td style="width: 80%" class="small">< 20%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-warning text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 20% < 35%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-success text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 35% < 50%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-primary text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 50%</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">    
                                                            <div class="col-md-12 card-body shadow border rounded secondary divexp5">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h5 class="small font-weight-bold">Diabetes (Hemoglobina Glicada)</h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <label class="small text-justify">
                                                                                    Proporção de pessoas com diabetes, com consulta e hemoglobina glicada solicitada no semestre.
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                                                            <div class="col-md-12">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-danger text-white"></td>
                                                                                        <td style="width: 80%" class="small">< 20%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-warning text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 20% < 35%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-success text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 35% < 50%</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width: 20%" class="btn btn-sm bg-gradient-primary text-white"></td>
                                                                                        <td style="width: 80%" class="small">>= 50%</td>
                                                                                    </tr>
                                                                                </table>
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
                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row pl-2 pr-2 mb-2">
                                                                <div class="col-md-12">
                                                                    <h5 class="small font-weight-bold">* INDICADORES</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 card-body shadow border rounded secondary">
                                                                <div class="row pl-2 pr-2">
                                                                    <div class="col-md-12 divexp1r">
                                                                        <h5 class="small font-weight-bold">Pré-Natal  (6 consultas) - <?= $ano ?> / <?= $periodo ?> <span class="float-right"><?= $prenatal_consultastext ?>%</span></h5>
                                                                    </div>
                                                                </div> 
                                                                <?php
                                                                if ($prenatal_consultas < 18) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp1r">
                                                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?= $prenatal_consultas ?>%" aria-valuenow="<?= $prenatal_consultas ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($prenatal_consultas < 31) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp1r">
                                                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?= $prenatal_consultas ?>%" aria-valuenow="<?= $prenatal_consultas ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($prenatal_consultas < 44) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp1r">
                                                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: <?= $prenatal_consultas ?>%" aria-valuenow="<?= $prenatal_consultas ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp1r">
                                                                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?= $prenatal_consultas ?>%" aria-valuenow="<?= $prenatal_consultas ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="row pl-2 pr-2">
                                                                    <div class="col-md-12 divexp2r">    
                                                                        <h5 class="small font-weight-bold">Pré-Natal (Sífilis e HIV) - <?= $ano ?> / <?= $periodo ?> <span class="float-right"><?= $prenatal_sifilis_hivtext ?>%</span></h5>
                                                                    </div>
                                                                </div> 
                                                                <?php
                                                                if ($prenatal_sifilis_hiv < 24) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp2r">
                                                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?= $prenatal_sifilis_hiv ?>%" aria-valuenow="<?= $prenatal_sifilis_hiv ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($prenatal_sifilis_hiv < 42) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp2r">
                                                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?= $prenatal_sifilis_hiv ?>%" aria-valuenow="<?= $prenatal_sifilis_hiv ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($prenatal_sifilis_hiv < 60) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp2r">
                                                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: <?= $prenatal_sifilis_hiv ?>%" aria-valuenow="<?= $prenatal_sifilis_hiv ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp2r">
                                                                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?= $prenatal_sifilis_hiv ?>%" aria-valuenow="<?= $prenatal_sifilis_hiv ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="row pl-2 pr-2">
                                                                    <div class="col-md-12 divexp3r">
                                                                        <h5 class="small font-weight-bold">Cobertura Citopatológico - <?= $ano ?> / <?= $periodo ?> <span class="float-right"><?= $cobertura_citopatologicotext ?>%</span></h5>
                                                                    </div>
                                                                </div>  
                                                                <?php
                                                                if ($cobertura_citopatologico < 16) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp3r">
                                                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?= $cobertura_citopatologico ?>%" aria-valuenow="<?= $cobertura_citopatologico ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($cobertura_citopatologico < 28) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp3r">
                                                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?= $cobertura_citopatologico ?>%" aria-valuenow="<?= $cobertura_citopatologico ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($cobertura_citopatologico < 40) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp3r">
                                                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: <?= $cobertura_citopatologico ?>%" aria-valuenow="<?= $cobertura_citopatologico ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp3r">
                                                                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?= $cobertura_citopatologico ?>%" aria-valuenow="<?= $cobertura_citopatologico ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="row pl-2 pr-2">
                                                                    <div class="col-md-12 divexp4r">
                                                                        <h5 class="small font-weight-bold">Hipertensão (PA Aferida) - <?= $ano ?> / <?= $periodo ?> <span class="float-right"><?= $hipertensaotext ?>%</span></h5>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                if ($hipertensao < 20) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp4r">
                                                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?= $hipertensao ?>%" aria-valuenow="<?= $hipertensao ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($hipertensao < 35) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp4r">
                                                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?= $hipertensao ?>%" aria-valuenow="<?= $hipertensao ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($hipertensao < 50) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp4r">
                                                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: <?= $hipertensao ?>%" aria-valuenow="<?= $hipertensao ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-4 divexp4r">
                                                                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?= $hipertensao ?>%" aria-valuenow="<?= $hipertensao ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div class="row pl-2 pr-2">
                                                                    <div class="col-md-12 divexp5r">
                                                                        <h5 class="small font-weight-bold">Diabetes (Hemoglobina Glicada) - <?= $ano ?> / <?= $periodo ?> <span class="float-right"><?= $diabetestext ?>%</span></h5>
                                                                    </div>
                                                                </div>   
                                                                <?php
                                                                if ($diabetes < 20) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-2 divexp5r">
                                                                                <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: <?= $diabetes ?>%" aria-valuenow="<?= $diabetes ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($diabetes < 35) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-2 divexp5r">
                                                                                <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: <?= $diabetes ?>%" aria-valuenow="<?= $diabetes ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } elseif ($diabetes < 50) {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-2 divexp5r">
                                                                                <div class="progress-bar bg-gradient-success" role="progressbar" style="width: <?= $diabetes ?>%" aria-valuenow="<?= $diabetes ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <div class="row pl-2 pr-2">
                                                                        <div class="col-md-12">
                                                                            <div class="progress mb-2 divexp5r">
                                                                                <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: <?= $diabetes ?>%" aria-valuenow="<?= $diabetes ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    } while ($rs = mysqli_fetch_array($query));
                } else {
                    $a = 0;
                    $aux = 0;
                    $pn1 = $pn2 = $pn3 = 0;
                    $psh1 = $psh2 = $psh3 = 0;
                    $cc1 = $cc2 = $cc3 = 0;
                    $hi1 = $hi2 = $hi3 = 0;
                    $diab1 = $diab2 = $diab3 = 0;
                    $periodo = array();
                    $idperiodo = array();
                    do {
                        $aux++;
                        $nome = $rs['nome'];
                        $ibge = $rs['ibge'];
                        $admissao = $rs['admissao'];
                        $cargo = $rs['cargo'];
                        $tipologia = $rs['tipologia'];
                        if($rs['descricao'] !== null){
                            $ivs = strtoupper($rs['descricao']);
                        }else{
                            $ivs = "";
                        }
                        $uf = $rs['uf'];
                        $municipio = $rs['municipio'];
                        $cnes = $rs['cnes'];
                        $ine = $rs['ine'];
                        $datacadastro = $rs['datacadastro'];
                        $ano = $rs['ano'];
                        $periodo[$a] = $rs['descricaoperiodo'];
                        $idperiodo[$a] = $rs['idperiodo'];
                        $prenatal_consultas = $rs['prenatal_consultas'];
                        $prenatal_consultastext = str_replace(",", "", $prenatal_consultas);
                        $prenatal_consultastext = str_replace(".", ",", $prenatal_consultastext);
                        $prenatal_sifilis_hiv = $rs['prenatal_sifilis_hiv'];
                        $prenatal_sifilis_hivtext = str_replace(",", "", $prenatal_sifilis_hiv);
                        $prenatal_sifilis_hivtext = str_replace(".", ",", $prenatal_sifilis_hivtext);
                        $cobertura_citopatologico = $rs['cobertura_citopatologico'];
                        $cobertura_citopatologicotext = str_replace(",", "", $cobertura_citopatologico);
                        $cobertura_citopatologicotext = str_replace(".", ",", $cobertura_citopatologicotext);
                        $hipertensao = $rs['hipertensao'];
                        $hipertensaotext = str_replace(",", "", $hipertensao);
                        $hipertensaotext = str_replace(".", ",", $hipertensaotext);
                        $diabetes = $rs['diabetes'];
                        $diabetestext = str_replace(",", "", $diabetes);
                        $diabetestext = str_replace(".", ",", $diabetestext);
                        switch ($aux){
                            case 1 : 
                                $pn1 = (int)$rs['prenatal_consultas']; 
                                $psh1 = (int)$rs['prenatal_sifilis_hiv']; 
                                $cc1 = (int)$rs['cobertura_citopatologico']; 
                                $hi1 = (int)$rs['hipertensao']; 
                                $diab1 = (int)$rs['diabetes']; break;
                            case 2 : 
                                $pn2 = (int)$rs['prenatal_consultas']; 
                                $psh2 = (int)$rs['prenatal_sifilis_hiv']; 
                                $cc2 = (int)$rs['cobertura_citopatologico']; 
                                $hi2 = (int)$rs['hipertensao']; 
                                $diab2 = (int)$rs['diabetes']; break;
                            case 3 : 
                                $pn3 = (int)$rs['prenatal_consultas']; 
                                $psh3 = (int)$rs['prenatal_sifilis_hiv']; 
                                $cc3 = (int)$rs['cobertura_citopatologico']; 
                                $hi3 = (int)$rs['hipertensao']; 
                                $diab3 = (int)$rs['diabetes']; break;
                        }
                        $a++;
                    } while ($rs = mysqli_fetch_array($query));
                    ?>
                        <div class="col-md-12 shadow rounded pt-2 pr-3 pl-3 mb-2">
                            <form >
                                <div class="row p-3">
                                    <div class="col-md-12 mt-3 mb-3">
                                        <div class="row mt-3 mb-4 pl-3">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 ">
                                                        <label class="text-info font-weight-bold">Nome: &nbsp;<?= $nome ?></label>
                                                    </div>                                                  
                                                   
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6 class=" font-weight-bold"><?php echo "Município-UF: $municipio-$uf" ?></h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class=" font-weight-bold"><?php echo "CNES: $cnes" ?></h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="font-weight-bold"><?php echo "INE: $ine" ?></h6>
                                                    </div>
                                                    <div class="col-md-3 ">
                                                        <label class="font-weight-bold">Cargo: </label><label> &nbsp;&nbsp;<?= $cargo ?></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="font-weight-bold">Tipologia: </label><label> &nbsp;&nbsp;<?= $tipologia ?></label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="font-weight-bold">IVS: </label><label class=""> &nbsp;&nbsp;<?= $ivs ?></label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-info font-weight-bold"><?php echo "Ano: $ano" ?></h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="text-info font-weight-bold">
                                                        <?php 
                                                            if($a === 2){
                                                                echo "Períodos: 1º e 2º Quadrimestre";
                                                            }else{
                                                                echo "Períodos: 1º, 2º e 3º Quadrimestre";
                                                            }
                                                        ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <!-- Bar Chart -->
                                                <div class="card shadow mb-4 divexp1r">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Pré-Natal (6 consultas)</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart-bar">
                                                            <canvas id="myBarPrenatal"></canvas>
                                                        </div>
                                                        <div class="row mt-3 pr-2 pl-2">
                                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
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
                                                                    <div class="col-md-12">
                                                                        <label class="small text-justify font-weight-bold text-primary">
                                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">< 18%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 18% < 31%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 31% < 45%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 45%</label>
                                                                            </div>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- Bar Chart -->
                                                <div class="card shadow mb-4 divexp2r">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Pré-Natal (Sífilis e HIV)</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart-bar">
                                                            <canvas id="myBarChartSifilis"></canvas>
                                                        </div>
                                                        <div class="row mt-3 pr-2 pl-2">
                                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
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
                                                                    <div class="col-md-12">
                                                                        <label class="small text-justify font-weight-bold text-primary">
                                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">< 24%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 24% < 42%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 42% < 60%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 60%</label>
                                                                            </div>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- Bar Chart -->
                                                <div class="card shadow mb-4 divexp3r">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Cobertura Citopatológico</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart-bar">
                                                            <canvas id="myBarChartCitopatologico"></canvas>
                                                        </div>
                                                        <div class="row mt-3 pr-2 pl-2">
                                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
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
                                                                    <div class="col-md-12">
                                                                        <label class="small text-justify font-weight-bold text-primary">
                                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">< 16%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 16% < 28%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 28% < 40%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 40%</label>
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
                                        <div class="row mt-3 pr-2 pl-2">
                                            <div class="col-md-6">
                                                <!-- Bar Chart -->
                                                <div class="card shadow mb-4 divexp4r">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Hipertensão (PA Aferida)</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart-bar">
                                                            <canvas id="myBarChartHipertensao"></canvas>
                                                        </div>
                                                        <div class="row mt-3 pr-2 pl-2">
                                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
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
                                                                    <div class="col-md-12">
                                                                        <label class="small text-justify font-weight-bold text-primary">
                                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">< 20%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 20% < 35%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 35% < 50%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 50%</label>
                                                                            </div>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Bar Chart -->
                                                <div class="card shadow mb-4 divexp5r">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Diabetes (Hemoglobina Glicada)</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart-bar">
                                                            <canvas id="myBarChartDiabetes"></canvas>
                                                        </div>
                                                        <div class="row mt-3 pr-2 pl-2">
                                                            <div class="col-md-12 border rounded pr-3 pl-3 pt-2">
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
                                                                    <div class="col-md-12">
                                                                        <label class="small text-justify font-weight-bold text-primary">
                                                                            * Sinalização semafórica do alcance (metas) dos indicadores
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-danger rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">< 20%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-warning rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 20% < 35%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-success rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 35% < 50%</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-1 mt-1">
                                                                                <div class="bg-gradient-primary rounded" style="width: 20px; height: 20px;"></div>
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <label class="small text-justify">>= 50%</label>
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
                            </form>
                        </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-12 shadow rounded pt-2 mb-2">
                    <div class="p-3">
                        <div class="mt-3 mb-3 pl-4 pr-4">
                            <div class="row mt-5 mb-5 mr-2 ml-2 pt-5 pb-5 pl-2 pr-2">
                                <div class="col-md-12">
                                    <p>Prezado(a) Tutor(a) Médico(a),</p>
                                    <p class="text-justify text-dark font-weight-bolder">
                                        Não foi identificado registros de produção no período consultado.
                                    </p>
                                    <p class="text-justify">
                                    Gostaria de enfatizar a importância de um dos requisitos para a participação no Programa de Avaliação de Desempenho é a vinculação do(a) 
                                    médico(a) tutor(a) a
                                    uma Equipe de Saúde da Família. É fundamental que os profissionais médicos estejam devidamente registrados no CNES e vinculados a um INE, 
                                    assegurando a precisa identificação de suas atividades nas equipes. Isso não apenas garante a correta avaliação dos indicadores, 
                                    mas também assegura sua participação integral no programa.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
        </div>
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
        <!-- Bootstrap core JavaScript-->
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
<!--        <script src="js/demo/chart-bar-prenatal-1q.js"></script>
        <script src="js/demo/chart-bar-prenatal-sifilis.js"></script>
        <script src="js/demo/chart-bar-citopatologico.js"></script>
        <script src="js/demo/chart-bar-hipertensao.js"></script>
        <script src="js/demo/chart-bar-diabetes.js"></script>-->
        <script>
            $(function () {
               $('.dropdown-toggle').dropdown();
            }); 
            $(document).on('click', '.dropdown-toggle ', function (e) {
               e.stopPropagation();
            });
            
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
            //Gráficos + de 1 quadrimestre - formatação
            // Set new default font family and font color to mimic Bootstrap's default styling
            Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#858796';

            function number_format(number, decimals, dec_point, thousands_sep) {
              // *     example: number_format(1234.56, 2, ',', ' ');
              // *     return: '1 234,56'
              number = (number + '').replace(',', '').replace(' ', '');
              var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                  var k = Math.pow(10, prec);
                  return '' + Math.round(n * k) / k;
                };
              // Fix for IE parseFloat(0.55).toFixed(0) = 0;
              s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
              if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
              }
              if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
              }
              return s.join(dec);
            }
            
            // myBarPrenatal
            var ctx = document.getElementById("myBarPrenatal");
            var myBarPrenatal = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($pn1 < 18) { echo "#d10e0e"; }elseif($pn1 < 31){ echo "#e6b20b"; }elseif($pn1 < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($pn2 < 18) { echo "#d10e0e"; }elseif($pn2 < 31){ echo "#e6b20b"; }elseif($pn2 < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($pn3 < 18) { echo "#d10e0e"; }elseif($pn3 < 31){ echo "#e6b20b"; }elseif($pn3 < 45){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($pn1 < 18) { echo "#ba0a0a"; }elseif($pn1 < 31){ echo "#d2a208"; }elseif($pn1 < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($pn2 < 18) { echo "#ba0a0a"; }elseif($pn2 < 31){ echo "#d2a208"; }elseif($pn2 < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($pn3 < 18) { echo "#ba0a0a"; }elseif($pn3 < 31){ echo "#d2a208"; }elseif($pn3 < 45){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $pn1; ?>,<?php echo $pn2; ?>,<?php echo $pn3; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // myBarChartSifilis
            var ctx = document.getElementById("myBarChartSifilis");
            var myBarChartSifilis = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($psh1 < 24) { echo "#d10e0e"; }elseif($psh1 < 42){ echo "#e6b20b"; }elseif($psh1 < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($psh2 < 24) { echo "#d10e0e"; }elseif($psh2 < 42){ echo "#e6b20b"; }elseif($psh2 < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($psh3 < 24) { echo "#d10e0e"; }elseif($psh3 < 42){ echo "#e6b20b"; }elseif($psh3 < 60){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($psh1 < 24) { echo "#ba0a0a"; }elseif($psh1 < 42){ echo "#d2a208"; }elseif($psh1 < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($psh2 < 24) { echo "#ba0a0a"; }elseif($psh2 < 42){ echo "#d2a208"; }elseif($psh2 < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($psh3 < 24) { echo "#ba0a0a"; }elseif($psh3 < 42){ echo "#d2a208"; }elseif($psh3 < 60){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $psh1; ?>,<?php echo $psh2; ?>,<?php echo $psh3; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // myBarChartCitopatologico
            var ctx = document.getElementById("myBarChartCitopatologico");
            var myBarChartCitopatologico = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($cc1 < 16) { echo "#d10e0e"; }elseif($cc1 < 28){ echo "#e6b20b"; }elseif($cc1 < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($cc2 < 16) { echo "#d10e0e"; }elseif($cc2 < 28){ echo "#e6b20b"; }elseif($cc2 < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($cc3 < 16) { echo "#d10e0e"; }elseif($cc3 < 28){ echo "#e6b20b"; }elseif($cc3 < 40){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($cc1 < 16) { echo "#ba0a0a"; }elseif($cc1 < 28){ echo "#d2a208"; }elseif($cc1 < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($cc2 < 16) { echo "#ba0a0a"; }elseif($cc2 < 28){ echo "#d2a208"; }elseif($cc2 < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($cc3 < 16) { echo "#ba0a0a"; }elseif($cc3 < 28){ echo "#d2a208"; }elseif($cc3 < 40){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $cc1; ?>,<?php echo $cc2; ?>,<?php echo $cc3; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // myBarChartHipertensao
            var ctx = document.getElementById("myBarChartHipertensao");
            var myBarChartHipertensao = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($hi1 < 20) { echo "#d10e0e"; }elseif($hi1 < 35){ echo "#e6b20b"; }elseif($hi1 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($hi2 < 20) { echo "#d10e0e"; }elseif($hi2 < 35){ echo "#e6b20b"; }elseif($hi2 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($hi3 < 20) { echo "#d10e0e"; }elseif($hi3 < 35){ echo "#e6b20b"; }elseif($hi3 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($hi1 < 20) { echo "#ba0a0a"; }elseif($hi1 < 35){ echo "#d2a208"; }elseif($hi1 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($hi2 < 20) { echo "#ba0a0a"; }elseif($hi2 < 35){ echo "#d2a208"; }elseif($hi2 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($hi3 < 20) { echo "#ba0a0a"; }elseif($hi3 < 35){ echo "#d2a208"; }elseif($hi3 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $hi1; ?>,<?php echo $hi2; ?>,<?php echo $hi3; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
            });
            
            // myBarChartDiabetes
            var ctx = document.getElementById("myBarChartDiabetes");
            var myBarChartDiabetes = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ["1º Quadrim.", "2º Quadrim.", "3º Quadrim."],
                datasets: [{
                  label: "Proporção",
                  backgroundColor: [
                    '<?php if($diab1 < 20) { echo "#d10e0e"; }elseif($diab1 < 35){ echo "#e6b20b"; }elseif($diab1 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>', 
                    '<?php if($diab2 < 20) { echo "#d10e0e"; }elseif($diab2 < 35){ echo "#e6b20b"; }elseif($diab2 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>',
                    '<?php if($diab3 < 20) { echo "#d10e0e"; }elseif($diab3 < 35){ echo "#e6b20b"; }elseif($diab3 < 50){ echo "#35cf55"; }else{ echo "#5479e4"; } ?>'],
                  hoverBackgroundColor: [
                    '<?php if($diab1 < 20) { echo "#ba0a0a"; }elseif($diab1 < 35){ echo "#d2a208"; }elseif($diab1 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>', 
                    '<?php if($diab2 < 20) { echo "#ba0a0a"; }elseif($diab2 < 35){ echo "#d2a208"; }elseif($diab2 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>',
                    '<?php if($diab3 < 20) { echo "#ba0a0a"; }elseif($diab3 < 35){ echo "#d2a208"; }elseif($diab3 < 50){ echo "#15b436"; }else{ echo "#325cd4"; } ?>'],
                  borderColor: "#5c5f68",
                  data: [<?php echo $diab1; ?>,<?php echo $diab2; ?>,<?php echo $diab3; ?>]
                }]
              },
              options: {
                maintainAspectRatio: false,
                layout: {
                  padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                  }
                },
                scales: {
                  xAxes: [{
                    time: {
                      unit: 'month'
                    },
                    gridLines: {
                      display: false,
                      drawBorder: false
                    },
                    ticks: {
                      maxTicksLimit: 6
                    },
                    maxBarThickness: 40
                  }],
                  yAxes: [{
                    ticks: {
                      min: 0,
                      max: 100,
                      maxTicksLimit: 10,
                      padding: 10,
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                        return number_format(value) + "%";
                      }
                    },
                    gridLines: {
                      color: "rgb(234, 236, 244)",
                      zeroLineColor: "rgb(234, 236, 244)",
                      drawBorder: false,
                      borderDash: [2],
                      zeroLineBorderDash: [2]
                    }
                  }]
                },
                legend: {
                  display: false
                },
                tooltips: {
                  titleMarginBottom: 10,
                  titleFontColor: '#6e707e',
                  titleFontSize: 14,
                  backgroundColor: "rgb(255,255,255)",
                  bodyFontColor: "#858796",
                  borderColor: '#dddfeb',
                  borderWidth: 1,
                  xPadding: 15,
                  yPadding: 15,
                  displayColors: false,
                  caretPadding: 10,
                  callbacks: {
                    label: function(tooltipItem, chart) {
                      var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                      return datasetLabel + ': ' + number_format(tooltipItem.yLabel,2,',','.') + "%";
                    }
                  }
                }
              }
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