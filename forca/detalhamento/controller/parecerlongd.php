<?php
session_start();
include_once './../../../conexao-agsus.php';
include_once './../../../conexao_agsus_2.php';
include_once __DIR__ .'/../../../vendor/autoload.php';
if(!isset($_SESSION['msg'])){
    $_SESSION['msg'] = '';
}
if(!isset($_POST['cpf']) || trim($_POST['cpf']) === ''){
    echo "<script>alert('CPF inexistente.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
if(!isset($_POST['ibge']) || trim($_POST['ibge']) === ''){
    echo "<script>alert('Município inexistente.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
if(!isset($_POST['cnes']) || trim($_POST['cnes']) === ''){
    echo "<script>alert('CNES inexistentes.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
if(!isset($_POST['ine']) || trim($_POST['ine']) === ''){
    echo "<script>alert('INE inexistente.')</script>";
    header('location: ../../derruba_session.php');
    exit();
}
$cpf = $_POST['cpf'];
$ibge = $_POST['ibge'];
$cnes = $_POST['cnes'];
$ine = $_POST['ine'];
$idap = $_POST['idap'];
$ano = $_POST['ano'];
$ciclo = $_POST['ciclo'];
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('d/m/Y');
//$iduser = $_SESSION["idUser"];
$iduser = '2765';
$sqlu = "select * from usuarios where id_user = '$iduser'";
$queryu = mysqli_query($conn2, $sqlu) or die(mysqli_error($conn2));
$rsu = mysqli_fetch_array($queryu);
$user = '';
if($rsu){
    do{
        $user = $rsu['nome_user'];
    }while($rsu = mysqli_fetch_array($queryu));
}
//var_dump($_POST);

if(!isset($_POST['flagparecerap']) || trim($_POST['flagparecerap']) === ''){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Parecer da análise no item Atividade de Longa Duração.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

if($_POST['flagparecerap'] === '0' && trim($_POST['parecerap'])==='' || $_POST['flagparecerap'] === '0' && !isset($_POST['parecerap'])){
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Preencher campo Análise no item Atividade de Longa Duração.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}

$parecerap = '';
if(isset($_POST['parecerap'])){
    $parecerap = trim($_POST['parecerap']);
    $parecerap = str_replace("'", "", $parecerap);
    $parecerap = str_replace("\"", "", $parecerap);
}
$flagparecerap = $_POST['flagparecerap'];
date_default_timezone_set('America/Sao_Paulo');
$dthoje = date('Y-m-d H:i:s');
//var_dump($_POST);
$ap = (new Source\Models\Aperfeicoamentoprofissional())->findById($idap);
//var_dump($ap);
if($ap !== null){
    $flagativlongduracao = $ap->flagativlongduracao;
    $ap->flagparecer = $flagparecerap;
    $ap->parecer = $parecerap;
    $ap->pareceruser = $user;
    $ap->parecerdthr = $dthoje;
    if($flagparecerap === '1' && $flagativlongduracao === '1'){
        $ap->pontuacao = 50.00;
    }else{
        $ap->pontuacao = 0.00;
    }
    $ap->flagterminou = null;
//    var_dump($ap);
    $rsap = $ap->save();
//    var_dump($rsap);
    if($rsap !== null){
        $_SESSION['msg'] = "<h6 class='bg-light rounded text-success p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Análise do item Atividade de Longa Duração gravada.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
        exit();
    }else{
        $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Erro na atualização dos dados.</h6>";
        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
            URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
        exit();
    }
}else{
    $_SESSION['msg'] = "<h6 class='bg-warning border rounded text-dark p-2'>&nbsp;<i class='fas fa-hand-point-right'></i>&nbsp; Cadastro de aperfeiçoamento profisional não encontrado.</h6>";
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;
	URL=\"../index.php?ct=$cpf&ib=$ibge&c=$cnes&i=$ine&a=$ano&ci=$ciclo\"'>"; 
    exit();
}
