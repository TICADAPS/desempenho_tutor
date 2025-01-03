<?php
session_start();
//if(!isset($_SESSION['cpfgestor']) || $_SESSION['cpfgestor'] === '' || $_SESSION['cpfgestor'] === null){
//    header("Location: derruba_session.php");
//}
//if(!isset($_SESSION['NomeGestor']) || $_SESSION['NomeGestor'] === '' || $_SESSION['NomeGestor'] === null){
//    header("Location: derruba_session.php");
//}
//if(!isset($_SESSION['ibge']) || $_SESSION['ibge'] === '' || $_SESSION['ibge'] === null){
//    header("Location: derruba_session.php");
//}
//$NomeGestor = $_SESSION['NomeGestor'];
//$ibge = $_SESSION['ibge'];
$NomeGestor = 'Ricardo Lima Amaral';
date_default_timezone_set('America/Sao_Paulo');
$datahoje = date('d/m/Y');
$ibge = '290390';
$ide = substr($ibge, 0,2);
$pide = [
    ':id' => $ide
];

include_once '../recursos_online/api/v1/config.php';
include_once '../recursos_online/api/libs/Database.php';
include_once '../Controller_agsus/maskCpf.php';
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
    <link rel="shortcut icon" href="./../img_agsus/iconAdaps.png"/>
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
                <img src="../img_agsus/Logo_400x200.png" class="img-fluid" alt="logoAdaps" width="250" title="Logo Adaps">
            </div>
            <div class="col-12 col-md-8 mt-4 ">
                <h4 class="mb-4 font-weight-bold text-center">Programa Médicos pelo Brasil (PMpB)</h4>
                <h4 class="mb-4 font-weight-bold text-center">Gestor do Município <?= $mun ?>-<?= $uf ?></h4>
            </div>
        </div>
        <div class="mt-4 text-right text-muted lead small"><b>Usuário: </b><?= $NomeGestor ?>, Brasília-DF, <?= $datahoje ?>.</div>
        <div class="row p-2">
            <div class="col-md-12 shadow rounded pr-1 pl-1">
                <div class="row p-3">
                    <div class="col-md-12 mt-1 mb-1">
                        <fieldset class="form-group border pr-1 pl-1">
                            <legend class="w-auto pr-2 pl-2"><h5>Município <?= $mun ?>-<?= $uf ?></h5></legend>
                            <div class="m-3 row p-2">
                                <div class="col-md-12 mb-2">
                                    <h6>Menu de opções:</h6>
                                </div>
                                <div class="col-md-4">
                                    <a href="agenda/" class="shadow-sm btn btn-outline-secondary ">Agenda das tutorias</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="eqa/" class="shadow-sm btn btn-outline-secondary ">Programa de Avaliação de Desempenho <br> Médico Tutor</a>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br><br>
    <?php include '../includes/footer.php' ?>
    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>