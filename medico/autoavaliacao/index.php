<?php
session_start();
require __DIR__ . "/../../source/autoload.php";
include '../../conexao-agsus.php';

if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
if (!isset($_SESSION['cpf'])) {
   header("Location: controller/derruba_session.php"); exit();
}
//var_dump($_SESSION['msg']);
$cpf = $_SESSION['cpf'];
$cpft = str_replace(".", "", $cpf);
$cpft = str_replace(".", "", $cpft);
$cpft = str_replace(".", "", $cpft);
$cpft = str_replace("-", "", $cpft);
//var_dump($cpf);
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('d/m/Y');
$sqlu = "select * from medico where cpf = '$cpft' limit 1";
$queryu = mysqli_query($conn, $sqlu) or die(mysqli_error($conn));
$nrrsu = mysqli_num_rows($queryu);
$rsu = mysqli_fetch_array($queryu);
$medico = $ibge = $cnes = $ine = '';
if($nrrsu > 0){
    do{
        $medico = $rsu['nome'];
        $ibge = $rsu['ibge'];
        $cnes = $rsu['cnes'];
        $ine = $rsu['ine'];
    }while($rsu = mysqli_fetch_array($queryu));
}
$_SESSION['cpft'] = $cpft;
$ciclo = $_SESSION['ciclo'];
$ano = $_SESSION['ano'];
$ac = (new \Source\Models\Anocicloavaliacao())->findAnoCicloAtivo($ano, $ciclo);
$sqlmcp = "select cp.id from medico m inner join competencias_profissionais cp "
        . "on m.cpf = cp.cpf and m.ibge = cp.ibge and m.cnes = cp.cnes and m.ine = cp.ine "
        . " where m.cpf = '$cpft' and m.ibge = '$ibge' and m.cnes = '$cnes' and m.ine = '$ine' "
        . "and cp.ano = '$ano' and cp.ciclo = '$ciclo' and (cp.flaginativo is null or cp.flaginativo <> 1) limit 1";
$qmcp = mysqli_query($conn, $sqlmcp) or die(mysqli_error($conn));
$nrrscp = mysqli_num_rows($qmcp);
$rscp = mysqli_fetch_array($qmcp);
//var_dump($rscp);
$mun = (new \Source\Models\Municipio())->findById($ibge);
$municipio = $mun->Municipio;
$iduf = substr($ibge, 0,2);
$estado = (new Source\Models\Estado())->findById($iduf);
$uf = $estado->UF;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação de Competências</title>
    <link rel="shortcut icon" href="../../img_agsus/iconAdaps.png"/>
    <!-- Link para o CSS do Bootstrap 5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid mt-2 mb-3">
        <div class="row">
            <div class="col-12 col-md-4 mt-4 pl-5"><img src="../../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps"></div>
            <div class="col-12 col-md-8 mt-2">
                <h3 class="mb-2 text-center">INSTRUMENTO - AVALIAÇÃO DE COMPETÊNCIAS</h3>
                <h5 class="mb-2 text-center text-primary">ANO: <?= $ano ?>, <?= $ciclo ?>º CICLO.</h5>
                <div class="mb-2"><p class="text-center">Este instrumento visa avaliar as competências técnicas e transversais
                    do Tutor Médico da AgSUS.</p></div>
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
                            <li class="text-secondary pl-2 pr-2"><a href="./../controller/derruba_session.php" class="btn"><i class="fas fa-sign-out-alt"></i></a></li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="container-fluid mt-1">
            <div class="row">
                <div class="col-12 shadow rounded  ">
                    <div class="row mb-2 mt-2">
                        <div class="col-md-12 pt-2 pb-2">
                    <div class="card mb-2">
                        <div class="card-body">
                            <h4 class="mb-2 text-center">DADOS DO MÉDICO TUTOR</h4>
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
                                        <li class="list-group-item bg-light"><b>Município de Origem: </b><?= $municipio ?>-<?= $uf ?></li>
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
                    <?php
                    if($ac === null){
                    ?>  
                    <div class="card mb-2">
                        <div class="card-body rounded" style="border: 1px solid #4BA439;">
                            <h5 class="m-2 text-center" style="color: #4BA439;"><i class="fas fa-hand-point-right"></i>&nbsp; Prezado médico Tutor, o <?= $ciclo ?>º ciclo do ano <?= $ano ?> não está aberto para esta atividade. &nbsp;<i class="fas fa-hand-point-left"></i></h5>
                        </div>
                    </div>
                    <?php
                    }else{
                    if ($nrrscp > 0) {
                        do {
                            $idcp = $rscp['id'];
                        } while ($rscp = mysqli_fetch_array($qmcp));
//            var_dump($idcp);
                        ?>
                        <form id="avaliacaoForm">
                            <input type="hidden" name="cpf" id="cpf" value="<?= $cpft ?>">
                            <input type="hidden" name="ibge" id="ibge" value="<?= $ibge ?>">
                            <input type="hidden" name="cnes" id="cnes" value="<?= $cnes ?>">
                            <input type="hidden" name="ine" id="ine" value="<?= $ine ?>">
                            <input type="hidden" name="ano" id="ano" value="<?= $ano ?>">
                            <input type="hidden" name="ciclo" id="ciclo" value="<?= $ciclo ?>">
                            <input type="hidden" name="idcp" id="idcp" value="<?= $idcp ?>">
                            <!-- Exemplo de um profissionalismo -->
                            <div id="page1" class="page-content">
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="O profissional demonstra comprometimento com as demandas dos pacientes e de seus familiares, com a comunidade em que está inserido e a sociedade de uma forma ampla, com os princípios éticos balizadores da sua profissão e com sua conduta (pontualidade, capacidade de autocrítica e autogestão).">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">1.0 - PROFISSIONALISMO</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Acolher aqui significa prestar o primeiro atendimento. Esperase que o médico de família atenda às demandas que chegam à unidade de saúde sem negar
                                        acesso aos pacientes que não são da sua área de abrangência, mas que por algum motivo, estão pedindo ajuda naquele local. Prestar o primeiro atendimento e orientar o paciente sobre
                                        onde e como deve buscar atendimento deve ser feito para não deixar o paciente desassistido e desorientado.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">1.1 Acolho e oriento os pacientes que procuram atendimento na Unidade de Saúde.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta1_1" id="pergunta1_1" value="1.1 Acolho e oriento os pacientes que procuram atendimento na Unidade de Saúde.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_1" id="question1_1_1" value="1" >
                                        <label class="form-check-label" for="question1_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_1" id="question1_1_2" value="2">
                                        <label class="form-check-label" for="question1_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_1" id="question1_1_3" value="3">
                                        <label class="form-check-label" for="question1_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_1" id="question1_1_4" value="4">
                                        <label class="form-check-label" for="question1_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question1_1" id="question1_1_5" value="5">
                                        <label class="form-check-label" for="question1_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Comprometer-se com o cuidado dos pacientes significa comprometer-se com sua agenda de atendimento, não desmarcar consultas ou desfazer
                                        combinados deliberadamente e sem um bom motivo. Significa também ser dedicado durante as consultas, buscar identificar os problemas de saúde que o paciente tem, não encaminhar pacientes ao nível secundário ou à emergência sem um motivo plausível.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">1.2 Sou um profissional comprometido com os pacientes.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta1_2" id="pergunta1_2" value="1.2 Sou um profissional comprometido com os pacientes.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_2" id="question1_2_1" value="1" >
                                        <label class="form-check-label" for="question1_2">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_2" id="question1_2_2" value="2">
                                        <label class="form-check-label" for="question1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_2" id="question1_2_3" value="3">
                                        <label class="form-check-label" for="question1_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_2" id="question1_2_4" value="4">
                                        <label class="form-check-label" for="question1_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question1_2" id="question1_2_5" value="5">
                                        <label class="form-check-label" for="question1_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Cumprimentar as pessoas, apresentar-se a todos, chamá-las pelo nome e não por termos como “mãezinha”, “vovó”, “minha querida” ou “meu amor”.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">1.3 Sou cordial com os pacientes e familiares atendidos nesta unidade de Saúde.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta1_3" id="pergunta1_3" value="1.3 Sou cordial com os pacientes e familiares atendidos nesta unidade de Saúde.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_3" id="question1_3_1" value="1" >
                                        <label class="form-check-label" for="question1_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_3" id="question1_3_2" value="2">
                                        <label class="form-check-label" for="question1_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_3" id="question1_3_3" value="3">
                                        <label class="form-check-label" for="question1_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_3" id="question1_3_4" value="4">
                                        <label class="form-check-label" for="question1_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question1_3" id="question1_3_5" value="5">
                                        <label class="form-check-label" for="question1_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Manter uma boa relação com os demais colegas na unidade de saúde passa por cumprimentá-los, chamá-los pelo nome e dirigir-se a todos com o devido respeito">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">1.4 Sou cordial com os colegas de trabalho da Unidade de Saúde.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta1_4" id="pergunta1_4" value="1.4 Sou cordial com os colegas de trabalho da Unidade de Saúde.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_4" id="question1_4_1" value="1" >
                                        <label class="form-check-label" for="question1_4_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_4" id="question1_4_2" value="2">
                                        <label class="form-check-label" for="question1_4_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_4" id="question1_4_3" value="3">
                                        <label class="form-check-label" for="question1_4_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_4" id="question1_4_4" value="4">
                                        <label class="form-check-label" for="question1_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question1_4" id="question1_4_5" value="5">
                                        <label class="form-check-label" for="question1_4_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Não chegar atrasado ao trabalho, não faltar ao trabalho sem justificativa e evitar atrasos entre as consultas. Caso isso aconteça, orientar seus pacientes sobre os atrasos sem sobrecarregar outros colegas da clínica.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">1.5 Realizo meu trabalho com pontualidade e dentro do horário estipulado.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta1_5" id="pergunta1_5" value="1.5 Realizo meu trabalho com pontualidade e dentro do horário estipulado.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_5" id="question1_5_1" value="1" d>
                                        <label class="form-check-label" for="question1_5_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_5" id="question1_5_2" value="2">
                                        <label class="form-check-label" for="question1_5_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_5" id="question1_5_3" value="3">
                                        <label class="form-check-label" for="question1_5_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question1_5" id="question1_5_4" value="4">
                                        <label class="form-check-label" for="question1_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question1_5" id="question1_5_5" value="5">
                                        <label class="form-check-label" for="question1_5_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                </div>
                            </div>
                            <div id="page2" class="page-content" style="display:none;">
                                <!-- Exemplo de uma Comunicação -->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Conceito: O profissional expressa de forma clara e objetiva com o paciente e com a sua equipe, preenche o prontuário adequadamente, sabe lidar com críticas e opiniões divergentes das suas.">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">2.0 - COMUNICAÇÃO</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Não usa jargões médicos, nem trata outras pessoas de forma paternalista, usando linguagem inapropriada. Usar a mesma linguagem para todos os pacientes e profissionais, sempre utilizando palavras claras e simples, é a postura desejável para um médico de família.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">2.1 Utilizo uma linguagem clara e simples para que as pessoas me compreendam.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta2_1" id="pergunta2_1" value="2.1 Utilizo uma linguagem clara e simples para que as pessoas me compreendam.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_1" id="question2_1_1" value="1" >
                                        <label class="form-check-label" for="question2_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_1" id="question2_1_2" value="2">
                                        <label class="form-check-label" for="question2_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_1" id="question2_1_3" value="3">
                                        <label class="form-check-label" for="question2_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_1" id="question2_1_4" value="4">
                                        <label class="form-check-label" for="question2_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question2_1" id="question2_1_5" value="5">
                                        <label class="form-check-label" for="question2_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Escolher o que falar com os demais colegas é importante. Falar sobre pacientes, descrevendo sua impressão técnica sobre a situação e compartilhando suas
                                        principais preocupações, é uma atitude que deve fazer parte de toda discussão de caso na atenção primária. Perguntar o que os outros colegas acham e qual a opinião deles sobre o que
                                        deve ser feito sobre o caso também é muito importante. Por fim, o paciente – maior interessado nisso tudo – também deve ser incluído em todo esse processo.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">2.2 Compartilho com pacientes e colegas minhas preocupações e expectativas sobre o que é possível alcançar com o tratamento proposto em cada caso atendido.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta2_2" id="pergunta2_2" value="2.2 Compartilho com pacientes e colegas minhas preocupações e expectativas sobre o que é possível alcançar com o tratamento proposto em cada caso atendido.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_2" id="question2_2_1" value="1" >
                                        <label class="form-check-label" for="question2_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_2" id="question2_2_2" value="2">
                                        <label class="form-check-label" for="question2_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_2" id="question2_2_3" value="3">
                                        <label class="form-check-label" for="question2_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_2" id="question2_2_4" value="4">
                                        <label class="form-check-label" for="question2_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question2_2" id="question2_2_5" value="5">
                                        <label class="form-check-label" for="question2_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Aqui a resposta virá de outros colegas além do tutor. Registrar as informações tomadas durante uma consulta e as decisões feitas é crucial para o sucesso
                                        do tratamento e evitar danos indesejáveis. Manter um registro claro e abrangente é o que se espera de um médico de família.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">2.3 Registro de informações de pacientes em prontuário de forma clara.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta2_3" id="pergunta2_3" value="2.3 Registro de informações de pacientes em prontuário de forma clara.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_3" id="question2_3_1" value="1" >
                                        <label class="form-check-label" for="question2_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_3" id="question2_3_2" value="2">
                                        <label class="form-check-label" for="question2_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_3" id="question2_3_3" value="3">
                                        <label class="form-check-label" for="question2_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_3" id="question2_3_4" value="4">
                                        <label class="form-check-label" for="question2_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question2_3" id="question2_3_5" value="5">
                                        <label class="form-check-label" for="question2_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Saber dar e receber feedback exige muito amadurecimento da equipe e dos profissionais. Saber informar críticas sem julgar a pessoa, informando sempre
                                        qual é a atitude que gerou incômodo, porque ela deve ser evitada e demonstrar suas possíveis consequências deve fazer parte do roteiro de qualquer reunião de feedback">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">2.4 Sei dar e receber críticas.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta2_4" id="pergunta2_4" value="2.4 Sei dar e receber críticas.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_4" id="question2_4_1" value="1" >
                                        <label class="form-check-label" for="question2_4_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_4" id="question2_4_2" value="2">
                                        <label class="form-check-label" for="question2_4_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_4" id="question2_4_3" value="3">
                                        <label class="form-check-label" for="question2_4_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_4" id="question2_4_4" value="4">
                                        <label class="form-check-label" for="question2_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question2_4" id="question2_4_5" value="5">
                                        <label class="form-check-label" for="question2_4_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Durante discussões de casos de pacientes e mesmo durante reuniões de equipe podem aparecer muitas opiniões conflitantes. Saber ouvi-las, levá-las
                                        em consideração e não as julgar sem dar o devido valor são atitudes esperadas de um médico de família.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">2.5 Julgo as opiniões de outros colegas de forma respeitosa e livre de paixões.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta2_5" id="pergunta2_5" value="2.5 Julgo as opiniões de outros colegas de forma respeitosa e livre de paixões.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_5" id="question2_5_1" value="1" d>
                                        <label class="form-check-label" for="question2_5_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_5" id="question2_5_2" value="2">
                                        <label class="form-check-label" for="question2_5_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_5" id="question2_5_3" value="3">
                                        <label class="form-check-label" for="question2_5_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question2_5" id="question2_5_4" value="4">
                                        <label class="form-check-label" for="question2_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question2_5" id="question2_5_5" value="5">
                                        <label class="form-check-label" for="question2_5_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                </div>
                            </div>
                            <div id="page3" class="page-content" style="display:none;">
                                <!-- Exemplo de uma Liderança -->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Conceito: O profissional propõe soluções e inovações frente aos problemas que surgem na sua prática e gerem conflitos interpessoais na sua equipe.">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">3.0 - LIDERANÇA</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Problemas acontecem todos os dias dentro de uma unidade de saúde na atenção primária. Muitos problemas tornam-se crônicos e são difíceis de mudar. Contudo, uma atitude passiva e resignada frente de um médico de família às dificuldades cotidianas não é desejável. Constatar o problema é fundamental, incomodar-se com ele
                                        também. Mas resignar-se com ele e apenas reclamar da sua existência torna o profissional parte do problema, pois o detectou e não fez nada a respeito. Ser propositivo e tentar encontrar soluções é a atitude que se espera de um médico de família.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">3.1 Proponho soluções para resolver os problemas enfrentados pela equipe de saúde da família e pela Unidade de Saúde.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta3_1" id="pergunta3_1" value="3.1 Proponho soluções para resolver os problemas enfrentados pela equipe de saúde da família e pela Unidade de Saúde.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_1" id="question3_1_1" value="1" >
                                        <label class="form-check-label" for="question3_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_1" id="question3_1_2" value="2">
                                        <label class="form-check-label" for="question3_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_1" id="question3_1_3" value="3">
                                        <label class="form-check-label" for="question3_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_1" id="question3_1_4" value="4">
                                        <label class="form-check-label" for="question3_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question3_1" id="question3_1_5" value="5">
                                        <label class="form-check-label" for="question3_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Quanto mais olhamos para a nossa prática com olhar crítico, mais pensamos que poderíamos fazer melhor ou diferente. Propor inovações para melhorar a
                                        forma como se trabalha é uma atitude esperada que um médico de família atuante apresenta.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">3.2 Proponho inovações no trabalho da Unidade de Saúde para melhorar o cuidado ofertado aos pacientes.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta3_2" id="pergunta3_2" value="3.2 Proponho inovações no trabalho da Unidade de Saúde para melhorar o cuidado ofertado aos pacientes.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_2" id="question3_2_1" value="1" >
                                        <label class="form-check-label" for="question3_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_2" id="question3_2_2" value="2">
                                        <label class="form-check-label" for="question3_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_2" id="question3_2_3" value="3">
                                        <label class="form-check-label" for="question3_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_2" id="question3_2_4" value="4">
                                        <label class="form-check-label" for="question3_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question3_2" id="question3_2_5" value="5">
                                        <label class="form-check-label" for="question3_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Conflitos interpessoais são um problema comum onde o trabalho é realizado em equipe. Muitas vezes esses conflitos não são resolvidos, o que pode
                                        prejudicar o cuidado dos pacientes. Agir ativamente e ser propositivo para resolver conflitos é a atitude esperada de um médico de família.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">3.3 Ajudo a solucionar conflitos interpessoais dentro da Unidade de Saúde.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta3_3" id="pergunta3_3" value="3.3 Ajudo a solucionar conflitos interpessoais dentro da Unidade de Saúde.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_3" id="question3_3_1" value="1" >
                                        <label class="form-check-label" for="question3_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_3" id="question3_3_2" value="2">
                                        <label class="form-check-label" for="question3_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_3" id="question3_3_3" value="3">
                                        <label class="form-check-label" for="question3_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question3_3" id="question3_3_4" value="4">
                                        <label class="form-check-label" for="question3_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question3_3" id="question3_3_5" value="5">
                                        <label class="form-check-label" for="question3_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->

                                </div>
                            </div>
                            <div id="page4" class="page-content" style="display:none;">
                                <!-- Exemplo de uma governança clínica -->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title=" O profissional demonstra habilidade em investigar e avaliar as queixas dos seus pacientes, aplicando as melhores evidências científicas disponíveis e se mostrando propenso
                                        a melhorar letantemente seu cuidado com base na autoavaliação e na aprendizagem ao longo de sua carreira.">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">4.0 - GOVERNANÇA CLÍNICA</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Médicos de família e profissionais da atenção primária são provedores de cuidado a uma população adscrita. Diferentemente de um serviço de emergência,
                                        no qual pacientes devem ser atendidos por problemas agudos de forma pontual, na atenção
                                        primária os pacientes devem ser acompanhados longitudinalmente. É desejável que médicos
                                        de família mantenham o monitoramento desta lista de pacientes, se possível organizada por
                                        perfis de pacientes - grávidas, menores de dois anos, pacientes com tuberculose, pacientes
                                        com multimorbidade, acamados etc.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">4.1 Monitoro listas de pacientes e realizo busca ativa de pacientes em risco.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta4_1" id="pergunta4_1" value="4.1 Monitoro listas de pacientes e realizo busca ativa de pacientes em risco.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_1" id="question4_1_1" value="1" >
                                        <label class="form-check-label" for="question4_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_1" id="question4_1_2" value="2">
                                        <label class="form-check-label" for="question4_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_1" id="question4_1_3" value="3">
                                        <label class="form-check-label" for="question4_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_1" id="question4_1_4" value="4">
                                        <label class="form-check-label" for="question4_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question4_1" id="question4_1_5" value="5">
                                        <label class="form-check-label" for="question4_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Identificar necessidades de saúde dos pacientes que não foram
                                        atendidas é resultado do trabalho de um profissional crítico e preocupado com a qualidade do
                                        que faz e com fazer o melhor pelos pacientes. Identificando estas necessidades não atendidas
                                        em um paciente, um novo estudo e aprendizado pode acontecer, tornando o médico mais apto
                                        para saná-las. Quando estas necessidades são identificadas em uma população de pacientes, é
                                        possível que medidas de melhoria para o atendimento desta população precisem ser tomadas.
                                        Propor medidas de melhoria, sem tomar decisões solitariamente, é uma atitude desejável.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">4.2 Identifico necessidades de saúde dos pacientes que não foram atendidas e proponho melhorias.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta4_2" id="pergunta4_2" value="4.2 Identifico necessidades de saúde dos pacientes que não foram atendidas e proponho melhorias.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_2" id="question4_2_1" value="1" >
                                        <label class="form-check-label" for="question4_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_2" id="question4_2_2" value="2">
                                        <label class="form-check-label" for="question4_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_2" id="question4_2_3" value="3">
                                        <label class="form-check-label" for="question4_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_2" id="question4_2_4" value="4">
                                        <label class="form-check-label" for="question4_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question4_2" id="question4_2_5" value="5">
                                        <label class="form-check-label" for="question4_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Proposições de melhoria são bem-vindas, mas a decisão de
                                        implementar melhorias depende da mobilização e do engajamento de todos os profissionais
                                        envolvidos no processo de trabalho. A tomada de decisões de forma vertical, sem consultar
                                        outros colegas, não é uma atitude desejável. Neste quesito, ser colaborativo e engajar a comunidade é desejável.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">4.3 Mobilizo e engajo colegas de trabalho para ações de melhoria da qualidade do serviço.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta4_3" id="pergunta4_3" value="4.3 Mobilizo e engajo colegas de trabalho para ações de melhoria da qualidade do serviço.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_3" id="question4_3_1" value="1" >
                                        <label class="form-check-label" for="question4_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_3" id="question4_3_2" value="2">
                                        <label class="form-check-label" for="question4_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_3" id="question4_3_3" value="3">
                                        <label class="form-check-label" for="question4_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_3" id="question4_3_4" value="4">
                                        <label class="form-check-label" for="question4_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question4_3" id="question4_3_5" value="5">
                                        <label class="form-check-label" for="question4_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Mostrar-se aberto a receber sugestões e críticas é importante para o crescimento pessoal, para a melhoria do cuidado prestado e para a segurança dos pacientes atendidos.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">4.4 Estou aberto para que outros profissionais discutam e avaliem meu trabalho.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta4_4" id="pergunta4_4" value="4.4 Estou aberto para que outros profissionais discutam e avaliem meu trabalho.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_4" id="question4_4_1" value="1" >
                                        <label class="form-check-label" for="question4_4_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_4" id="question4_4_2" value="2">
                                        <label class="form-check-label" for="question4_4_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_4" id="question4_4_3" value="3">
                                        <label class="form-check-label" for="question4_4_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question4_4" id="question4_4_4" value="4">
                                        <label class="form-check-label" for="question4_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question4_4" id="question4_4_5" value="5">
                                        <label class="form-check-label" for="question4_4_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->

                                </div>
                            </div>
                            <div id="page5" class="page-content" style="display:none;">
                                <!-- Exemplo de uma Advogacia pela saúde -->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Conceito: O profissional reconhece a necessidade e conduz o processo de mobilização da 
                                        comunidade, dos colegas de trabalho e outras instâncias decisórias para que ele consiga um 
                                        maior impacto na melhora da saúde dos seus pacientes.">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">5.0 - ADVOCACIA PELA SAÚDE</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: A maioria das necessidades de saúde podem ser atendidas na 
                                        atenção primária com poucos recursos. Contudo, em muitos casos, faltam recursos mínimos. 
                                        Acomodar-se e resignar-se com a falta de recursos é uma postura indesejada. Reconhecer 
                                        as carências locais e identificar o prejuízo que podem causar ao atendimento dos pacientes é 
                                        uma atitude essencial que todos os médicos de família devem ter. Além disso, devem buscar 
                                        saná-las para fornecer o melhor cuidado possível aos seus pacientes.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">5.1 Busco prover o melhor cuidado possível para cada paciente.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta5_1" id="pergunta5_1" value="5.1 Busco prover o melhor cuidado possível para cada paciente.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_1" id="question5_1_1" value="1" >
                                        <label class="form-check-label" for="question5_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_1" id="question5_1_2" value="2">
                                        <label class="form-check-label" for="question5_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_1" id="question5_1_3" value="3">
                                        <label class="form-check-label" for="question5_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_1" id="question5_1_4" value="4">
                                        <label class="form-check-label" for="question5_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question5_1" id="question5_1_5" value="5">
                                        <label class="form-check-label" for="question5_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Há situações em que é necessário mobilizar outros recursos 
                                        presentes no município para conseguir com que seus pacientes tenham o tratamento necessário. Isso depende de cada situação, de cada cenário de prática e de cada paciente. Contudo, 
                                        resignar-se com as barreiras de acesso a serviços de saúde é uma postura indesejada. Espera-se que o médico de família atue ativamente na busca dos melhores recursos disponíveis 
                                        para o tratamento de seus pacientes. Isso pode significar questionar o sistema de regulação pela priorização do atendimento ou da internação de um paciente, questionar a gestão local 
                                        ou municipal por medicamentos que deveriam estar disponíveis, demandar que os materiais para o trabalho sejam adequados e funcionem adequadamente.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">5.2 Mobilizo instâncias superiores (Distrito Sanitário, Secretaria de Saúde) para solucionar barreiras de acesso a serviços de saúde que meus pacientes necessitam.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta5_2" id="pergunta5_2" value="5.2 Mobilizo instâncias superiores (Distrito Sanitário, Secretaria de Saúde) para solucionar barreiras de acesso a serviços de saúde que meus pacientes necessitam.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_2" id="question5_2_1" value="1" >
                                        <label class="form-check-label" for="question5_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_2" id="question5_2_2" value="2">
                                        <label class="form-check-label" for="question5_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_2" id="question5_2_3" value="3">
                                        <label class="form-check-label" for="question5_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_2" id="question5_2_4" value="4">
                                        <label class="form-check-label" for="question5_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question5_2" id="question5_2_5" value="5">
                                        <label class="form-check-label" for="question5_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Aqui soma-se a necessidade de mobilizar outros colegas e pacientes em prol de uma melhoria para a unidade de saúde e para o atendimento da população">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">5.3 Busco promover mudanças para melhorar a qualidade do serviço.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta5_3" id="pergunta5_3" value="5.3 Busco promover mudanças para melhorar a qualidade do serviço.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_3" id="question5_3_1" value="1" >
                                        <label class="form-check-label" for="question5_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_3" id="question5_3_2" value="2">
                                        <label class="form-check-label" for="question5_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_3" id="question5_3_3" value="3">
                                        <label class="form-check-label" for="question5_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_3" id="question5_3_4" value="4">
                                        <label class="form-check-label" for="question5_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question5_3" id="question5_3_5" value="5">
                                        <label class="form-check-label" for="question5_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Este domínio pertence à governança pela saúde, pois compreender as demandas de saúde dos pacientes é o passo primordial para poder advogar por melhores recursos para atendê-las.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">5.4 Preocupo com os pacientes e seus problemas de saúde, não somente com as doenças que eles têm.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta5_4" id="pergunta5_4" value="5.4 Preocupo com os pacientes e seus problemas de saúde, não somente com as doenças que eles têm.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_4" id="question5_4_1" value="1" >
                                        <label class="form-check-label" for="question5_4_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_4" id="question5_4_2" value="2">
                                        <label class="form-check-label" for="question5_4_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_4" id="question5_4_3" value="3">
                                        <label class="form-check-label" for="question5_4_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question5_4" id="question5_4_4" value="4">
                                        <label class="form-check-label" for="question5_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question5_4" id="question5_4_5" value="5">
                                        <label class="form-check-label" for="question5_4_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->

                                </div>
                            </div>
                            <div id="page6" class="page-content" style="display:none;">
                                <!-- Exemplo de uma DEDICAÇÃO ACADÊMICA -->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Conceito: O profissional busca letantemente o conhecimento acadêmico pertinente à sua 
                                        prática, compartilha o conhecimento adquirido e se mostra interessado em aprender com a 
                                        prática dos colegas de trabalho (conhecimento médico e aplicação).">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">6.0 - DEDICAÇÃO ACADÊMICA</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Atribuição fundamental de qualquer profissional de saúde, não somente de médicos de família.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">6.1 Busco estudar e me manter atualizado.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta6_1" id="pergunta6_1" value="6.1 Busco estudar e me manter atualizado.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_1" id="question6_1_1" value="1" >
                                        <label class="form-check-label" for="question6_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_1" id="question6_1_2" value="2">
                                        <label class="form-check-label" for="question6_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_1" id="question6_1_3" value="3">
                                        <label class="form-check-label" for="question6_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_1" id="question6_1_4" value="4">
                                        <label class="form-check-label" for="question6_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question6_1" id="question6_1_5" value="5">
                                        <label class="form-check-label" for="question6_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Reconhecer que os demais colegas profissionais que atuam na mesma unidade de saúde sempre têm algo a lhe ensinar. Assim como seus pacientes, cuidadores e familiares.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">6.2 Busco aprender coisas novas com outros colegas de trabalho.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta6_2" id="pergunta6_2" value="6.2 Busco aprender coisas novas com outros colegas de trabalho.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_2" id="question6_2_1" value="1" >
                                        <label class="form-check-label" for="question6_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_2" id="question6_2_2" value="2">
                                        <label class="form-check-label" for="question6_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_2" id="question6_2_3" value="3">
                                        <label class="form-check-label" for="question6_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_2" id="question6_2_4" value="4">
                                        <label class="form-check-label" for="question6_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question6_2" id="question6_2_5" value="5">
                                        <label class="form-check-label" for="question6_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Compartilhar conhecimento com os demais colegas faz parte da ideia de letruir uma cultura de aprendizado no ambiente de trabalho. Para tanto é necessária uma atitude ativa do médico de família">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">6.3 Compartilho com colegas algo novo que aprendi e que pode ajudar no cuidado dos pacientes.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta6_3" id="pergunta6_3" value="6.3 Compartilho com colegas algo novo que aprendi e que pode ajudar no cuidado dos pacientes.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_3" id="question6_3_1" value="1" >
                                        <label class="form-check-label" for="question6_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_3" id="question6_3_2" value="2">
                                        <label class="form-check-label" for="question6_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_3" id="question6_3_3" value="3">
                                        <label class="form-check-label" for="question6_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question6_3" id="question6_3_4" value="4">
                                        <label class="form-check-label" for="question6_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question6_3" id="question6_3_5" value="5">
                                        <label class="form-check-label" for="question6_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->

                                </div>
                            </div>
                            <div id="page7" class="page-content" style="display:none;">
                                <!-- Exemplo de uma Colaboração-->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Conceito: O profissional informa e divide conhecimento adequadamente com seus pacientes e colegas de trabalho e compartilha com outros membros da equipe o cuidado com o paciente.">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">7.0 - COLABORAÇÃO</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Se todos os profissionais de uma unidade de saúde estão juntos imbuídos do mesmo propósito de crescer na carreira e melhorar profissionalmente, os pacientes têm muito a ganhar. Ajudar outros colegas a evoluir pode gerar uma cultura de crescimento e aprendizado dentro da clínica que pode beneficiar enormemente os profissionais, 
                                        aumentando a satisfação com o trabalho, diminuindo o estresse e tornando os profissionais mais resilientes às adversidades.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">7.1 Ajudo outros colegas a se desenvolverem profissionalmente.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta7_1" id="pergunta7_1" value="7.1 Ajudo outros colegas a se desenvolverem profissionalmente.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_1" id="question7_1_1" value="1" >
                                        <label class="form-check-label" for="question7_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_1" id="question7_1_2" value="2">
                                        <label class="form-check-label" for="question7_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_1" id="question7_1_3" value="3">
                                        <label class="form-check-label" for="question7_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_1" id="question7_1_4" value="4">
                                        <label class="form-check-label" for="question7_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question7_1" id="question7_1_5" value="5">
                                        <label class="form-check-label" for="question7_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Dividir tarefas depende de conhecer quem são os colegas com quem trabalha, o que eles são capazes de fazer e o que eles fazem de melhor. É importante 
                                        identificar as virtudes dos colegas com quem o médico trabalha, pois eles serão importantes aliados no trabalho.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">7.2 Busco conhecer os colegas de equipe, suas habilidades e competências profissionais para o cuidado dos pacientes.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta7_2" id="pergunta7_2" value="7.2 Busco conhecer os colegas de equipe, suas habilidades e competências profissionais para o cuidado dos pacientes.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_2" id="question7_2_1" value="1" >
                                        <label class="form-check-label" for="question7_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_2" id="question7_2_2" value="2">
                                        <label class="form-check-label" for="question7_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_2" id="question7_2_3" value="3">
                                        <label class="form-check-label" for="question7_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_2" id="question7_2_4" value="4">
                                        <label class="form-check-label" for="question7_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question7_2" id="question7_2_5" value="5">
                                        <label class="form-check-label" for="question7_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Trabalhar sozinho, tomar decisões sozinho, não compartilhar suas decisões são atitudes indesejadas aqui. Quanto mais dividimos nossas ações com outros colegas, quanto mais compartilhamos as decisões, mais protegido o paciente estará de 
                                        possíveis efeitos deletérios de decisões mal tomadas.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">7.3 Compartilho informações importantes para o cuidado de pacientes com colegas e familiares.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta7_3" id="pergunta7_3" value="7.3 Compartilho informações importantes para o cuidado de pacientes com colegas e familiares.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_3" id="question7_3_1" value="1" >
                                        <label class="form-check-label" for="question7_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_3" id="question7_3_2" value="2">
                                        <label class="form-check-label" for="question7_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_3" id="question7_3_3" value="3">
                                        <label class="form-check-label" for="question7_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_3" id="question7_3_4" value="4">
                                        <label class="form-check-label" for="question7_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question7_3" id="question7_3_5" value="5">
                                        <label class="form-check-label" for="question7_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Compartilhar decisões para proteger o paciente. Afinal, por mais bem intencionadas que nossas decisões sejam, sempre podemos incorrer em erros. Dividir 
                                        decisões e compartilhar ideias pode ajudar a mitigar esses efeitos indesejados.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">7.4 Peço a opinião dos pacientes, dos familiares e dos colegas de trabalho sobre as condutas que tomo.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta7_4" id="pergunta7_4" value="7.4 Peço a opinião dos pacientes, dos familiares e dos colegas de trabalho sobre as condutas que tomo.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_4" id="question7_4_1" value="1" >
                                        <label class="form-check-label" for="question7_4_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_4" id="question7_4_2" value="2">
                                        <label class="form-check-label" for="question7_4_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_4" id="question7_4_3" value="3">
                                        <label class="form-check-label" for="question7_4_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_4" id="question7_4_4" value="4">
                                        <label class="form-check-label" for="question7_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question7_4" id="question7_4_5" value="5">
                                        <label class="form-check-label" for="question7_4_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: É desejável que o médico reconheça suas limitações e saiba pedir socorro nos momentos em que não pode dar conta sozinho de cuidar do paciente.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">7.5 Compartilho as decisões sobre o cuidado de meus pacientes com meus colegas de equipe.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta7_5" id="pergunta7_5" value="7.5 Compartilho as decisões sobre o cuidado de meus pacientes com meus colegas de equipe.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_5" id="question7_5_1" value="1" >
                                        <label class="form-check-label" for="question7_5_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_5" id="question7_5_2" value="2">
                                        <label class="form-check-label" for="question7_5_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_5" id="question7_5_3" value="3">
                                        <label class="form-check-label" for="question7_5_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question7_5" id="question7_5_4" value="4">
                                        <label class="form-check-label" for="question7_5_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question7_5" id="question7_5_5" value="5">
                                        <label class="form-check-label" for="question7_5_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                </div>
                            </div>
                            <div id="page8" class="page-content" style="display:none;">
                                <!-- Exemplo de uma Conduta Ética e Respeitosa-->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Conceito: O profissional se compromete com a execução dos princípios, valores, normas éticas e regras de conduta estabelecidas no Código de Ética e Conduta da AgSUS.">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">8.0 - CONDUTA ÉTICA E RESPEITOSA</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="etalhamento da evidência: A comunicação assertiva é a capacidade de expressar pensamentos, sentimentos e opiniões de maneira direta e facilmente compreensível, sem, no entanto, ser agressivo ou desrespeitoso. Tudo de maneira direta, mas respeitosa, sem deixar de 
                                        lado as emoções de quem escuta. Enquanto a comunicação não violenta, por sua vez, é uma estratégia de controle de atitudes e ações que deriva de uma comunicação assertiva. Tem como objetivo o foco na resolução de conflitos, a partir da prática de uma linguagem mais 
                                        efetiva, sem julgamentos. ">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">8.1 Pratico a comunicação assertiva e não violenta ouvindo colegas, gestores e usuários com atenção, e expressando-me de forma clara, empática, honesta e respeitosa.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta8_1" id="pergunta8_1" value="8.1 Pratico a comunicação assertiva e não violenta ouvindo colegas, gestores e usuários com atenção, e expressando-me de forma clara, empática, honesta e respeitosa.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_1" id="question8_1_1" value="1" >
                                        <label class="form-check-label" for="question8_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_1" id="question8_1_2" value="2">
                                        <label class="form-check-label" for="question8_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_1" id="question8_1_3" value="3">
                                        <label class="form-check-label" for="question8_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_1" id="question8_1_4" value="4">
                                        <label class="form-check-label" for="question8_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question8_1" id="question8_1_5" value="5">
                                        <label class="form-check-label" for="question8_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: A importância do feedback como ferramenta de comunicação indispensável para aqueles que querem promover a saúde e bem-estar em seu local de trabalho, pois trabalha os fatores humanos do empregado como a comunicação, sua motivação, 
                                        suas necessidades e a empatia.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">8.2 Dou feedback buscando avaliar assertivamente, elogiar com sinceridade, agradecer e realizar críticas letrutivas.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta8_2" id="pergunta8_2" value="8.2 Dou feedback buscando avaliar assertivamente, elogiar com sinceridade, agradecer e realizar críticas letrutivas.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_2" id="question8_2_1" value="1" >
                                        <label class="form-check-label" for="question8_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_2" id="question8_2_2" value="2">
                                        <label class="form-check-label" for="question8_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_2" id="question8_2_3" value="3">
                                        <label class="form-check-label" for="question8_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_2" id="question8_2_4" value="4">
                                        <label class="form-check-label" for="question8_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question8_2" id="question8_2_5" value="5">
                                        <label class="form-check-label" for="question8_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Um bom diálogo é capaz de resolver conflitos, evitar desentendimentos e expressar seus sentimentos. No ambiente profissional, ele pode ajudar a resolver 
                                        conflitos entre os empregadores, motivar o grupo em busca de um objetivo e tornar as equipes mais produtivas e eficazes.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">8.3 Evito conflitos e busco sempre o diálogo para resolver pacificamente as divergências.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta8_3" id="pergunta8_3" value="8.3 Evito conflitos e busco sempre o diálogo para resolver pacificamente as divergências.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_3" id="question8_3_1" value="1" >
                                        <label class="form-check-label" for="question8_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_3" id="question8_3_2" value="2">
                                        <label class="form-check-label" for="question8_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_3" id="question8_3_3" value="3">
                                        <label class="form-check-label" for="question8_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_3" id="question8_3_4" value="4">
                                        <label class="form-check-label" for="question8_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question8_3" id="question8_3_5" value="5">
                                        <label class="form-check-label" for="question8_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: O trabalho colaborativo ocorre quando os membros da equipe são tratados como iguais e todos têm o direito de contribuir para a causa comum, contribuindo com suas próprias ideias para o desenvolvimento do trabalho em equipe">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">8.4 Atuo de forma colaborativa, compartilhando informações pertinentes e necessárias para o desenvolvimento do trabalho em equipe.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta8_4" id="pergunta8_4" value="8.4 Atuo de forma colaborativa, compartilhando informações pertinentes e necessárias para o desenvolvimento do trabalho em equipe.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_4" id="question8_4_1" value="1" >
                                        <label class="form-check-label" for="question8_4_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_4" id="question8_4_2" value="2">
                                        <label class="form-check-label" for="question8_4_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_4" id="question8_4_3" value="3">
                                        <label class="form-check-label" for="question8_4_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question8_4" id="question8_4_4" value="4">
                                        <label class="form-check-label" for="question8_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question8_4" id="question8_4_5" value="5">
                                        <label class="form-check-label" for="question8_4_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->

                                </div>
                            </div>
                            <div id="page9" class="page-content" style="display:none;">
                                <!-- Exemplo de uma  ADERÊNCIA AO MODELO DE ATENÇÃO-->
                                <div class="mb-4">
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Conceito: O desenvolvimento de um trabalho qualificado na APS passa por conhecer o modelo de atenção à saúde brasileiro declarado por meio de princípios e diretrizes na Política 
                                        Nacional de Atenção Básica (PNAB), bem como a forma de organização do SUS e as responsabilidades dos diferentes níveis de gestão">
                                        <h5 class="text-center py-2 text-white rounded" style="background-color: #4BA439;">9.0 - ADERÊNCIA AO MODELO DE ATENÇÃO</h5>
                                    </span>
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Para realização de um cuidado integral aos indivíduos, famílias e comunidade, é necessário introjetar na prática cotidiana os princípios da universalidade, 
                                        equidade e integralidade e as diretrizes da regionalização e hierarquização, territorialização, população adscrita, cuidado centrado na pessoa; resolutividade; longitudinalidade do cuidado; coordenação do cuidado, coordenação da rede e participação da comunidade.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">9.1 Compreendo o serviço de saúde e meu papel dentro dele buscando atuar segundo os princípios e diretrizes da Política Nacional de Atenção Básica</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta9_1" id="pergunta9_1" value="9.1 Compreendo o serviço de saúde e meu papel dentro dele buscando atuar segundo os princípios e diretrizes da Política Nacional de Atenção Básica">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_1" id="question9_1_1" value="1" >
                                        <label class="form-check-label" for="question9_1_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_1" id="question9_1_2" value="2">
                                        <label class="form-check-label" for="question9_1_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_1" id="question9_1_3" value="3">
                                        <label class="form-check-label" for="question9_1_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_1" id="question9_1_4" value="4">
                                        <label class="form-check-label" for="question9_1_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question9_1" id="question9_1_5" value="5">
                                        <label class="form-check-label" for="question9_1_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: As responsabilidades da gestão municipal abrangem organizar, executar e gerenciar a APS como porta de entrada do SUS, programar as ações de saúde a partir das necessidades da população, organizar o percurso do usuário dentro da rede 
                                        de cuidados, garantir a vinculação e coordenação do cuidado pela APS, manutenção dos registros e cadastros nos sistemas nacionais, financiar, monitorar e avaliar a APS, dar apoio 
                                        às equipes de saúde, garantir recursos materiais, equipamentos e insumos suficientes para o funcionamento das UBS e equipes, garantir acesso aos demais pontos da rede necessário 
                                        para o alcance da resolutividade, entre outros.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">9.2 Compreendo o papel e responsabilidade da gestão municipal na organização da APS.</b></p>
                                    </span>
                                    <input type="hidden" name="pergunta9_2" id="pergunta9_2" value="9.2 Compreendo o papel e responsabilidade da gestão municipal na organização da APS.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_2" id="question9_2_1" value="1" >
                                        <label class="form-check-label" for="question9_2_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_2" id="question9_2_2" value="2">
                                        <label class="form-check-label" for="question9_2_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_2" id="question9_2_3" value="3">
                                        <label class="form-check-label" for="question9_2_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_2" id="question9_2_4" value="4">
                                        <label class="form-check-label" for="question9_2_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question9_2" id="question9_2_5" value="5">
                                        <label class="form-check-label" for="question9_2_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Sistemas de saúde orientados a partir da Atenção Primária à Saúde pressupõem excelência em resultados, que é traduzida pela oferta de serviços de 
                                        saúde efetiva de qualidade à população. Assumir o lugar de porta de entrada preferencial envolve acolher, escutar e oferecer resposta capaz de resolver problemas de saúde ou de 
                                        minimizar danos e sofrimentos ao usuário, responsabilizando-se e coordenando pelo cuidado de forma integral.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">9.3 Exerço minha função tendo a APS como porta de entrada preferencial do SUS.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta9_3" id="pergunta9_3" value="9.3 Exerço minha função tendo a APS como porta de entrada preferencial do SUS.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_3" id="question9_3_1" value="1" >
                                        <label class="form-check-label" for="question9_3_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_3" id="question9_3_2" value="2">
                                        <label class="form-check-label" for="question9_3_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_3" id="question9_3_3" value="3">
                                        <label class="form-check-label" for="question9_3_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_3" id="question9_3_4" value="4">
                                        <label class="form-check-label" for="question9_3_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question9_3" id="question9_3_5" value="5">
                                        <label class="form-check-label" for="question9_3_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->
                                    <!-- perguntas -->
                                    <span
                                        class="text-primary"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="right"
                                        title="Detalhamento da evidência: Organizar a agenda com base nas necessidades de saúde da população contribui para que a ação da equipe seja integrada, multiprofissional e interdisciplinar. Favorece ainda a garantia de continuidade do cuidado, reforçando o vínculo, a responsabilização e a segurança dos usuários. Para tanto recomenda-se que a gestão da agenda 
                                        comporte a oferta programada para grupos específicos, a demanda espontânea (consulta no dia e o primeiro atendimento às urgências;) e para retorno/reavaliação de usuários que não 
                                        fazem parte de ações programáticas.">
                                        <p class="lead py-1 px-2 text-justify fs-6 lh-sm text-dark rounded" style="background-color: #E2EDD9;"><b class="px-2">9.4 Organizo a oferta de cuidado de forma compartilhada com a equipe, buscando assegurar a ampliação do acesso e da atenção à saúde em tempo oportuno aos usuários.</b></p>

                                    </span>
                                    <input type="hidden" name="pergunta9_4" id="pergunta9_4" value="9.4 Organizo a oferta de cuidado de forma compartilhada com a equipe, buscando assegurar a ampliação do acesso e da atenção à saúde em tempo oportuno aos usuários.">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_4" id="question9_4_1" value="1">
                                        <label class="form-check-label" for="question9_4_1">1 - Não atendo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_4" id="question9_4_2" value="2">
                                        <label class="form-check-label" for="question9_4_2">2 - Atendo parcialmente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_4" id="question9_4_3" value="3">
                                        <label class="form-check-label" for="question9_4_3">3 - Atendo satisfatoriamente</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question9_4" id="question9_4_4" value="4">
                                        <label class="form-check-label" for="question9_4_4">4 - Atendo plenamente</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="question9_4" id="question9_4_5" value="5">
                                        <label class="form-check-label" for="question9_4_5">5 - Supero as expectativas</label>
                                    </div>
                                    <!-- fim das perguntas -->

                                </div>
                                <!-- Botão de envio -->
                                <button type="submit" class="btn text-white mb-3" style="background-color: #4BA439;">&nbsp;&nbsp; Enviar Avaliação &nbsp;&nbsp;</button>
                                <!-- Modal -->
                                <!--                <div class="modal fade" id="modalConfirma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header bg-dark">
                                                        <h5 class="modal-title text-white" id="exampleModalLabel">Confirmação de envio</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                      </div>
                                                      <div class="modal-body">
                                                          <p class="text-primary">Deseja enviar o formulário preenchido?</p>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">FECHA</button>
                                                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">ENVIAR</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>-->
                                <div id="resultado" class="mb-4 fs-6"></div>
                            </div>
                            <!-- Paginação -->
                            <nav aria-label="Page navigation example mb-3">
                                <ul class="pagination">
                                    <li class="page-item" id="pg1"><a class="page-link" href="#" onclick="showPage(1)">1</a></li>
                                    <li class="page-item" id="pg2"><a class="page-link" href="#" onclick="showPage(2)">2</a></li>
                                    <li class="page-item" id="pg3"><a class="page-link" href="#" onclick="showPage(3)">3</a></li>
                                    <li class="page-item" id="pg4"><a class="page-link" href="#" onclick="showPage(4)">4</a></li>
                                    <li class="page-item" id="pg5"><a class="page-link" href="#" onclick="showPage(5)">5</a></li>
                                    <li class="page-item" id="pg6"><a class="page-link" href="#" onclick="showPage(6)">6</a></li>
                                    <li class="page-item" id="pg7"><a class="page-link" href="#" onclick="showPage(7)">7</a></li>
                                    <li class="page-item" id="pg8"><a class="page-link" href="#" onclick="showPage(8)">8</a></li>
                                    <li class="page-item" id="pg9"><a class="page-link" href="#" onclick="showPage(9)">9</a></li>
                                    <!-- Adicione os outros links de página até 9 -->
                                </ul>
                            </nav>
                        </form>
                    <?php } else { ?>
                        <div class="card mb-2">
                            <div class="card-body rounded" style="border: 1px solid #4BA439;">
                                <h5 class="m-2 text-center" style="color: #4BA439;"><i class="fas fa-hand-point-right"></i>&nbsp; Prezado médico Tutor, não consta em nossa base de dados a sua participação neste ciclo. &nbsp;<i class="fas fa-hand-point-left"></i></h5>
                            </div>
                        </div>
                    <?php }} ?>
                </div>
            </div>
        </div>
    <?php include './footer.php' ?>
    </div>
    <script src="../../js_agsus/jquery-3.1.1.min.js"></script>
    <!-- Scripts do Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- tratamento dos dados -->
    <script src="envio.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- JavaScript para inicialização dos tooltips -->
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        function showPage(pageNumber) {
            // Esconda todos os conteúdos
            document.querySelectorAll('.page-content').forEach(function(content) {
                content.style.display = 'none';
            });
            
            // Mostre o conteúdo da página clicada
            document.getElementById('page' + pageNumber).style.display = 'block';
            document.getElementById('page' + pageNumber).focus();
        }
    </script>
    <script>
      
    </script>
</body>

</html>